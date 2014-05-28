#!python3
# -*- coding: utf8 -*-

import os, openpyxl, re, glob
from collections import OrderedDict
from datetime import datetime

phpFile = r"..\api\app\database\\seeds\ExcelDataTableSeeder.php"

tableFilePattern = r"N:\Felles\Forurensning\2. Internasjonalt arbeid\2012. Uganda\Kravspek\Tabeller\Supporting tables version*.xlsx"
tablesData = OrderedDict()
tablesData["users"] = "User"
tablesData["districts"] = "District"
tablesData["codes"] = "Code"
tablesData["categories"] = "Category"
tablesData["practitioners"] = "Practitioner"
tablesData["practitioner_certificates"] = "PractitionerCertificate"

def getDbColumnsInfo(dataSheet, headerRowIndex):
	dbColumnsInfo = {}
	for headerColumn in dataSheet.rows[headerRowIndex]:
		columnLetter = getColumnLetterFromCoordinate(headerColumn.coordinate)
		fieldName = headerColumn.value
		dbColumnsInfo[columnLetter] = fieldName
	return dbColumnsInfo

def getColumnLetterFromCoordinate(coordinate):
	return re.sub('[0-9]*', '', coordinate)

def getLookupValue(columnName, value):
	if not value: return
	if columnName == 'x':
		return 123

def isNumber(s):
    try:
        float(s)
        return True
    except ValueError:
        return False

ignoreColumns = ['id', 'is_deleted']
passwordColumn = 'password'
lookupColumns = []
dateColumns = ['date_of_entry']

def getColumnSeed(columnName, value):
	if columnName in ignoreColumns: return	
	if columnName == passwordColumn:
		return "'%s' => Hash::make('%s')" % (columnName, 'password')
	if columnName in lookupColumns:
		value = getLookupValue(columnName, value)		
	if not value: return
	if columnName in dateColumns:
			value = value.strftime("%Y-%m-%d")			
	if isNumber(value):
		return """'%s' => %s """ % (columnName, value)
	return """'%s' => "%s" """ % (columnName, value)

def getSeedVariableName(entityName, coordinate, rowsOffset):
	rowNumber = int(re.sub('[A-Z]*', '', coordinate))
	return "%s%d" % (entityName.lower(), rowNumber-(rowsOffset+1))

def replaceInFile(filePath, searchBegin, searchEnd, replace):
	with open(filePath, "r", encoding="utf8") as file:
		content = file.read()
	content = re.sub("%s[\S\s]*%s" % (searchBegin, searchEnd), "%s\n%s%s" % (searchBegin, replace, searchEnd), content)	
	with open(filePath, "w", encoding="utf8") as file:
		file.write(content)

seedTemplate = """$%s = %s::create(array(
  %s            
));"""

tableFile = glob.glob(tableFilePattern)[-1]
print("Reading from file %s" % tableFile)
wb = openpyxl.load_workbook(filename = tableFile, data_only=True)
seeds = []
for tableName in tablesData:	
	print("Creating seeds for %s" % tableName)
	entityName = tablesData[tableName]
	
	dataSheet = wb.get_sheet_by_name(tableName)	
	if not dataSheet:
		print("Wrong name?", tableName)
		exit()
	rowsOffset = 0
	dbColumnsInfo = getDbColumnsInfo(dataSheet, rowsOffset)
		
	for row in dataSheet.rows[1:]:
		columnSeeds = []		
		for column in row:			
			columnName = dbColumnsInfo[getColumnLetterFromCoordinate(column.coordinate)]			
			columnSeed = getColumnSeed(columnName, column.value)
			if columnSeed:
				columnSeeds.append(columnSeed)				
		seed = seedTemplate % (getSeedVariableName(entityName, column.coordinate, rowsOffset), entityName, ",\n\t".join(columnSeeds))
		seeds.append(seed)		
		
allSeeds = ""
for seed in seeds:
	allSeeds += (seed + "\n\n")
#print (allSeeds)
replaceInFile(phpFile, "// seed begin", "// seed end", allSeeds)
