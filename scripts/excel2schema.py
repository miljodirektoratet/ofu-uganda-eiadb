#!python3
# -*- coding: utf8 -*-

# IMPORTANT:
# openpyxl crashed when opening files with tables.
# I had to edit parse_font() in python directory\Lib\site-packages\openpyxl\reader\style.py.
# Added following line: if 'extend' in font: del font['extend']

import os, openpyxl, re, glob
from collections import OrderedDict
from datetime import datetime

phpFile = r"..\api\app\database\migrations\2014_06_03_No1_create_tables.php"

oldHeaderSignature = "A10=Sortering,B10=dB fields,C10=Data type,D10=Shown in application,E10=Application fields,F10=Field type,G10=Drop-down list,H10=Mandatory,I10=Input,J10=Roles,K10=Table,L10=Tabletype,M10=Comments,"
fieldFilePattern = r"N:\Felles\Forurensning\2. Internasjonalt arbeid\2012. Uganda\Kravspek\Databasefields*.xlsx"

doPrintModelInfo = False

def checkForChangesInHeader(headerRow):
	headerSignature = ""	
	for column in headerRow:			
		if not column.value: continue
		headerSignature += "%s=%s,"%(column.coordinate, column.value)		
	if headerSignature != oldHeaderSignature:
		print("Something has changed in the column headers. Do check old vs new:")
		print(oldHeaderSignature)
		print(headerSignature)
		exit()

def createSchemaLineForField(fieldname, datatype, foreignIds):	
	if fieldname == 'id':
		return ["$table->increments('id');"]	
	if fieldname in foreignIds:
		refTablename = foreignIds[fieldname]		
		return ["$table->integer('%s')->unsigned()->nullable(); " % (fieldname), 
			"$table->foreign('%s')->references('id')->on('%s');" % (fieldname, refTablename)]
	if 'varchar' in datatype:
		match = re.match("varchar \(([0-9]*)\)", datatype)		
		size = 255
		if match:						
			size = int(match.groups()[0])
		return ["$table->string('%s', %d)->nullable();" % (fieldname, size)]
	if datatype == 'int' or datatype == 'dropdown':
		return ["$table->integer('%s')->unsigned()->nullable();" % (fieldname)]
	if datatype == 'date':
		return ["$table->date('%s')->nullable();" % (fieldname)]
	if datatype == 'bool':		
		return ["$table->boolean('%s')->default(false)->nullable();" % (fieldname)]
	if datatype == 'decimal':		
		return ["$table->decimal('%s', 24, 6)->nullable();" % (fieldname)]
	if datatype == 'point':
		return ["MISSING Spatial data not supported yet"]
	if datatype == 'internal' and fieldname == 'timestamp':
		return ["$table->string('created_by', 255)->nullable();",
			"$table->string('updated_by', 255)->nullable();",
			"$table->timestamps();"]
	if datatype == 'internal' and fieldname == 'soft_deletion':
		return ["$table->softDeletes();"]
	return ["MISSING " + fieldname]

def createSchema(tablename, fields, foreignIds):
	schemaUp = "Schema::create('%s', function(Blueprint $table)\n" % (tablename)
	schemaUp += "{\n"
	for field in fields:
		order, fieldname, datatype, visible, caption, fieldtype, valuelist, mandatory, inputtype, role = field		
		for tempSchemaUp in createSchemaLineForField(fieldname, datatype, foreignIds):
			schemaUp += "\t" + tempSchemaUp + "\n"	
	schemaUp += "});\n"
	schemaDown = "\t" + "Schema::dropIfExists('%s', function(Blueprint $table){});" % (tablename)
	return schemaUp, schemaDown

def replaceInFile(filePath, searchBegin, searchEnd, replace):
	with open(filePath, "r", encoding="utf8") as file:
		oldcontent = file.read()
	content = re.sub("%s[\S\s]*%s" % (searchBegin, searchEnd), "%s\n%s%s" % (searchBegin, replace, searchEnd), oldcontent)	
	if content == oldcontent:
		return False		
	with open(filePath, "w", encoding="utf8") as file:
		file.write(content)
	return True

def foreignIdFromMainId(tablename):
	if tablename == "eias_permits":
		return "eia_permit_id"
	if tablename == "categories":
		return "category_id"			
	if tablename == "audits_inspections":
		return "audit_inspection_id"		
	return tablename[:-1] + "_id"

def printModelInfo(tablename, fields):
	notFillable = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at', 'practitioner_id']
	hidden = []
	fillable = []
	for field in fields:
		order, fieldname, datatype, visible, caption, fieldtype, valuelist, mandatory, inputtype, role = field
		if fieldname in notFillable: continue
		if datatype == 'internal' and fieldname == 'timestamp': continue					
		if datatype == 'internal' and fieldname == 'soft_deletion':
			hidden.append('deleted_at')
			continue
		fillable.append(fieldname)

	print("// " + tablename)
	phpFillable = "// protected $fillable = array('%s');" % ("','".join(fillable))
	print(phpFillable)	
	if hidden:
		phpHidden = "// protected $hidden = array('%s');" % ("','".join(hidden))	
		print(phpHidden)
	print("")

#	//protected $guarded = array('id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at');
#	protected $fillable = array('person', 'organisation_name');
    #protected $hidden = array('deleted_at'); 



fieldFile = glob.glob(fieldFilePattern)[-1]
print("Reading from file %s" % fieldFile)
wb = openpyxl.load_workbook(filename = fieldFile, data_only=True)
dataSheet = wb.get_sheet_by_name("Fields")

checkForChangesInHeader(dataSheet.rows[9])

ignore = []#['users']
foreignIds = {}
tables = OrderedDict()

for row in dataSheet.rows[10:]:		
	columnValues = [column.value for column in row[:11]]
	if not row[1].value: continue # Ignore row if missing column name
	
	order, fieldname, datatype, visible, caption, fieldtype, valuelist, mandatory, inputtype, role, tablename = list(columnValues)
	tablename = tablename.lower()
	fieldname = fieldname.lower()
	datatype = datatype.lower()	
	if fieldname == "id":
		foreignIds[foreignIdFromMainId(tablename)] = tablename	
	order = int(order)
	if tablename not in tables:
		tables[tablename] = []
	tables[tablename].append([order, fieldname, datatype, visible, caption, fieldtype, valuelist, mandatory, inputtype, role])
	tables[tablename].sort()		

tablesUp = ""
tablesDown = ""
for tablename in tables:
	fields = tables[tablename]
	schemaUp, schemaDown = createSchema(tablename, fields, foreignIds)
	if "MISSING" in schemaUp:
		print(schemaUp)
		exit()		
	if tablename in ignore: 
		print("Ignore: ", tablename)
		print(schemaUp)
		continue		
	tablesUp += schemaUp + "\n\n"
	tablesDown += schemaDown + "\n"
	if doPrintModelInfo:
		printModelInfo(tablename, fields)	

generationInfo = """// Generated by script %s, \n// based on file "%s".\n""" %(datetime.now().strftime("%Y-%m-%d %H:%M:%S"), fieldFile.replace("\\", "\\\\"))

hasChanges = replaceInFile(phpFile, "// up begin", "// up end", tablesUp)
if not hasChanges:
	print("Nothing changed.")
	exit()
replaceInFile(phpFile, "// down begin", "// down end", tablesDown)
replaceInFile(phpFile, "// info begin", "// info end", generationInfo)
#print(tablesUp)
#print(tablesDown)

print("Created migration for %d tables" % (len(tables)-len(ignore)))
print("Following tables where ignored: %s" % (",".join(ignore)))