#!python3
# -*- coding: utf8 -*-

import re
from collections import OrderedDict

phpFile = r"..\api\app\database\migrations\2014_05_21_131000_create_tables.php"

fielddata = """1	id	int	No	Additional district ID	-		-	Calculated	Role 1	additional_districts
2	district_id	int		District	Textbox				Role 1	additional_districts
3	project_id	int	No	Project ID	-		-	Calculated	Role 1	additional_districts
1	id	int	Yes	Control ID	Textbox		-	Calculated	Role 7	audits_inspections
2	year	int	Yes	Control Year	Dropdown	year			Role 7	audits_inspections
3	type_control	int	Yes	Control type	Dropdown				Role 7	audits_inspections
4	user_id	int	Yes	Control Officer	Dropdown	users			Role 7	audits_inspections
5	date_control	date	Yes	Date of control	Textbox				Role 7	audits_inspections
6	date_report_sent	date	Yes	Date report sendt	Textbox				Role 7	audits_inspections
7	recommendations	varchar (2000)	Yes	Recommendations	Textarea				Role 7	audits_inspections
8	follow_up	varchar (255)	Yes	Follow up	Textbox				Role 7	audits_inspections
9	date_deadline	date	Yes	Company Deadline to verify that the deviations have been corrected	Textbox				Role 7	audits_inspections
10	date_submitted	date	Yes	Date when NEMA receives information from the company	Textbox				Role 7	audits_inspections
11	date_closing_letter	date	Yes	Date when NEMA closes the control	Textbox				Role 7	audits_inspections
90	remarks	varchar (2000)	Yes	Remarks	Textarea				Role 7	audits_inspections
13	project_id	int	No	Project ID	-		-		Role 7	audits_inspections
1	id	int	No	Category ID	-		-	Calculated	Role 8	categories
1	id	int	No	Code ID	-		-	Calculated	Role 8	codes
1	id	int	No	DocumentID	-		-	Calculated	Role 1	documents
2	date_submitted	date	Yes	Date of submission	Textbox				Role 1	documents
1	id	int	No	District ID	-		-	Calculated	Role 8	districts
3	sub_final	int	Yes	Final submission	Dropdown	yes/no			Role 3	documents
4	sub_copy_no	int	Yes	No. of copies submitted	Textbox				Role 1	documents
5	title	varchar (255)	Yes	Document title	Textbox				Role 1	documents
6	type	int	Yes	Type of document	Dropdown				Role 1	documents
2	description1	varchar (255)		Description1	Textbox				Role 8	codes
7	number	int	Yes	Listed number					Role 1	documents
8	code	varchar (255)	Yes	Document code	Textbox		-	Calculated	Role 1	documents
9	consultent	varchar (255)	Yes	Consulting team for PB & TOR	Textbox				Role 1	documents
10	ded_copy_no	int	Yes	No. of to copies DED/D-EMC	Textbox				Role 1	documents
11	date_sent_ded	date	Yes	Date sent to DED/D-EMC	Textbox				Role 1	documents
12	eiac_copy_no	int	Yes	No. of copies to EIAC	Textbox				Role 1	documents
13	date_copies_eiac	date	Yes	Date copies sent to EIAC	Textbox				Role 1	documents
3	description2	varchar (255)		Description2	Textbox				Role 8	codes
14	date_next_appointment	date	Yes	Date of next appointment	Textbox				Role 1	documents
15	date_sent_from_dep	date	Yes	Date sent to EIAC from the dep.secretary	Textbox				Role 1	documents
16	date_sent_eiao	date	Yes	Date sent to the EIAO	Textbox				Role 2	documents
17	folio_no	varchar (255)	Yes	File and foliono.	Textbox				Role 1	documents
1	id	int	Yes	ID of EIA&Permits	Textbox		-	Calculated	Role 1	eias_permits
2	project_id	int	No	Project ID	-		-		Role 1	eias_permits
3	teamleader_id	int	Yes	Teamleder	Dropdown	practitioner			Role 1	eias_permits
4	cost	int	Yes	Cost of the proposed development	Textbox				Role 1	eias_permits
5	status	int	Yes	Status	Dropdown	eia_status	-	Calculated	Role 1	eias_permits
1	id	int	No	Hearing ID	-		-	Calculated	Role 3	hearings
6	user_id	int	Yes	The Officers assigned	Dropdown	users			Role 2	eias_permits
7	inspection_recommended	int	Yes	Inspection before approval?	Dropdown	yes/no			Role 3	eias_permits
8	date_inspection	date	Yes	Date of inspection date	Textbox				Role 3	eias_permits
9	officer_recommend	varchar (2000)	Yes	Recommendations by EIAO	Textarea				Role 3	eias_permits
10	fee	decimal	Yes	Expected fees	Textbox				Role 3	eias_permits
11	date_sent_ded_approval	date	Yes	Date sent for approval	Textbox				Role 3	eias_permits
5	date_expected	date	Yes	Date expected for comments	Textbox				Role 3	hearings
12	decision	int	Yes	Decision taken	Dropdown	decision			Role 5	eias_permits
13	date_decision	date	Yes	Date for decision	Textbox				Role 5	eias_permits
14	date_fee_notification	date	Yes	Date for fee notification	Textbox				Role 4	eias_permits
2	district	varchar (255)		District	Textbox				Role 8	districts
15	date_fee_payed	date	Yes	Date invoice is payed	Textbox				Role 4	eias_permits
3	hasc	varchar (255)	No	ISO	-		-		Role 8	districts
4	iso	int	No	HASC	-		-		Role 8	districts
16	fee_receipt_no	varchar (255)	Yes	Fee receipt number	Textbox				Role 4	eias_permits
17	designation	int	Yes	Designation of the one who signed	Dropdown	users			Role 5	eias_permits
1	id	int	Yes	Organisation ID	Textbox		-	Calculated	Role 1	organisations
1	id	int	No	Practitioner certificate ID	-		-	Calculated	Role 6	practitioner_certificates
2	lead_agency	int		Lead agencies	Dropdown				Role 3	hearings
3	district_id	int		Local governments	Dropdown	districts			Role 3	hearings
4	date_dispatched	date		Date dispatched	Textbox				Role 3	hearings
2	practitioner_id	int	No	Practitioner ID	-		-	Calculated	Role 6	practitioner_certificates
6	date_received	date		Date received comments	Textbox				Role 1	hearings
7	recommendations	varchar (2000)		Summarized recommendations	Textarea				Role 3	hearings
90	remarks	varchar (2000)		Remarks	Textarea				Role 3	hearings
10	document_id	int		Document ID					Role 3	hearings
100	soft_deletion	internal	No	Delete control?	-		-		Role 7	audits_inspections
4	date_of_entry	date	Yes	Date of entry 	Textbox		-	Calculated	Role 6	practitioner_certificates
2	tin	int	Yes	TIN	Textbox				Role 1	organisations
18	conclusion	int	Yes	Conclusion (PB/Tor accepted)	Dropdown				Role 5	documents
19	eia_permit_id	int	No	EIA	-		-		Role 1	documents
3	organisation_name	varchar (255)	Yes	Organisation name	Textbox				Role 1	organisations
21	control_id	int	No	Control ID	-		-		Role 1	documents
90	remarks	varchar (2000)	Yes	Remarks	Textarea				Role 1	documents
18	date_certificate	date	Yes	Date on the certificate	Textbox				Role 5	eias_permits
19	certificate_no	int	Yes	Certificate number	Textbox				Role 5	eias_permits
20	date_cancelled	date	Yes	Certificate cancelled date	Textbox				Role 5	eias_permits
4	visiting_address	varchar (255)	Yes	Visiting address	Textbox				Role 1	organisations
100	soft_deletion	internal	No	Delete document?	-		-		Role 1	documents
7	number	int	No	Listed number	-		-	Calculated	Role 6	practitioner_certificates
3	year	int		Year issued	Dropdown	year			Role 6	practitioner_certificates
8	cert_no	varchar (255)	Yes	Certificate number	Textbox		-	Calculated	Role 6	practitioner_certificates
5	is_approved	bool		Approved  					Role 6	practitioner_certificates
90	remarks	varchar (2000)	Yes	Remarks	Textarea				Role 5	eias_permits
6	cert_type	int		Type of certificate	Dropdown	practitioner_certificate			Role 6	practitioner_certificates
1	id	int	Yes	Practitioner ID	Textbox		-	Calculated	Role 6	practitioners
100	soft_deletion	internal	No	Delete Eia or permit?	-		-		Role 5	eias_permits
1	id	int	Yes	ProjectID	Textbox		-	Calculated	Role 1	projects
100	soft_deletion	internal	No	Delete hearing?	-		-		Role 3	hearings
9	conditions	int		Conditions	Dropdown				Role 6	practitioner_certificates
5	box_no	int	Yes	PO Box					Role 1	organisations
1	id	int	No	TeammemberID	-		-	Calculated	Role 1	team_members
6	city	varchar (255)	Yes	City	Textbox				Role 1	organisations
2	person	varchar (255)		Name of the practitioner (person)	Textbox				Role 6	practitioners
7	phone	varchar (255)	Yes	Phone	Textbox				Role 1	organisations
8	fax	varchar (255)	Yes	Fax	Textbox				Role 1	organisations
3	tin	int		TIN					Role 6	practitioners
9	email	varchar (255)	Yes	Email	Textbox				Role 1	organisations
10	contact_person	varchar (255)	Yes	Contact person	Textbox				Role 1	organisations
90	remarks	varchar (2000)	Yes	Remarks	Textarea				Role 1	organisations
100	soft_deletion	internal	No	Delete organisation?	-		-		Role 1	organisations
10	is_cancelled	bool		Certificate cancelled?					Role 6	practitioner_certificates
4	organisation_name	varchar (255)		Organisation name	Textbox				Role 6	practitioners
5	visiting_address	varchar (255)		Visiting address	Textbox				Role 6	practitioners
90	remarks	varchar (2000)		Remarks	Textarea				Role 6	practitioner_certificates
6	box_no	int		PO Box					Role 6	practitioners
2	title	varchar (255)	Yes	Project title	Textbox				Role 1	projects
7	city	varchar (255)		City	Textbox				Role 6	practitioners
8	phone	varchar (255)		Phone	Textbox				Role 6	practitioners
3	category_id	int	Yes	Category of project	Dropdown	categories			Role 1	projects
4	location	varchar (255)	Yes	Location name	Textbox				Role 1	projects
5	description	varchar (255)	Yes	Address	Textbox				Role 1	projects
6	district_id	int	Yes	District	Dropdown	districts			Role 1	projects
9	fax	varchar (255)		Fax	Textbox				Role 6	practitioners
8	longitude	decimal	Yes	Longitude	Textbox				Role 1	projects
9	latitude	decimal	Yes	Latitude	Textbox				Role 1	projects
10	has_industrial_waste_water	bool	Yes	Discharge of industrial waste water?					Role 1	projects
11	grade	int	Yes	Grade	Dropdown				Role 7	projects
3	eia_permit_id	int	No	Name of the EIA&Permit to the team member	-		-	Calculated	Role 1	team_members
2	practitioner_id	int		Team members	Dropdown	practitioners			Role 1	team_members
1	id	int	No	User Id	-		-	Calculated	Role 8	users
10	email	varchar (255)		Email	Textbox				Role 6	practitioners
11	qualifications	varchar (2000)		Qualifications	Textarea				Role 6	practitioners
12	expertise	varchar (2000)		Expertise	Textarea				Role 6	practitioners
2	initials	varchar (255)		Initials	Textbox				Role 8	users
90	remarks	varchar (2000)		Remarks	Textarea				Role 6	practitioners
100	soft_deletion	internal	No	Delete practitionares?	-		-		Role 6	practitioners
3	full_name	varchar (255)		Full name	Textbox				Role 8	users
4	job_position_code	varchar (255)		Job position code	Textbox				Role 8	users
5	fips	varchar (255)	No	FIPS	-		-		Role 8	districts
12	organisation_id	int	Yes	Organisation ID					Role 1	projects
90	remarks	varchar (2000)	Yes	Remarks	Textarea				Role 1	projects
6	region	varchar (255)		Region	Textbox				Role 8	districts
100	soft_deletion	internal	No	Delete project?	-		-		Role 1	projects
5	job_position_name	int		Job position name	Dropdown	job_position			Role 8	users
100	soft_deletion	internal	No	Delete district?	-		-		Role 8	districts
100	soft_deletion	internal	No	Delete certificate?	-		-		Role 6	practitioner_certificates
4	value1	int		Value1					Role 8	codes
6	email	varchar (255)		email	Textbox				Role 8	users
7	password	varchar (255)	No	Password	Textbox				Role 8	users
5	dropdown_list	varchar (255)		Drop down list	Textbox				Role 8	codes
99	is_passive	bool		Is the user passive?					Role 8	users
99	is_passive	bool		Not use the code any more?					Role 8	codes
2	description_short	varchar (255)		Short description	Textbox				Role 8	categories
100	soft_deletion	internal	No	Not use this user any more?	-		-		Role 8	users
3	description_long	varchar (2000)		Long description	Textarea				Role 8	categories
4	consequence	int		Consequence	Dropdown	consequence			Role 8	categories
99	is_passive	bool		Not use this category any more?					Role 8	categories
110	timestamp	internal	No	-	-		-		Role 7	audits_inspections
110	timestamp	internal	No	-	-		-		Role 1	documents
110	timestamp	internal	No	-	-		-		Role 5	eias_permits
110	timestamp	internal	No	-	-		-		Role 3	hearings
110	timestamp	internal	No	-	-		-		Role 1	organisations
110	timestamp	internal	No	-	-		-		Role 6	practitioners
110	timestamp	internal	No	-	-		-		Role 1	projects
110	timestamp	internal	No	-	-		-		Role 8	districts
110	timestamp	internal	No	-	-		-		Role 6	practitioner_certificates
110	timestamp	internal	No	-	-		-		Role 8	users"""


def createSchemaLineForField(fieldname, datatype, foreignIds):	
	if fieldname == 'id':
		return "$table->increments('id');"	
	if fieldname in foreignIds:
		refTablename = foreignIds[fieldname]		
		return "$table->integer('%s')->unsigned()->nullable(); " % (fieldname) + "\n\t$table->foreign('%s')->references('id')->on('%s');" % (fieldname, refTablename)
	if 'varchar' in datatype:
		match = re.match("varchar \(([0-9]*)\)", datatype)		
		size = 255
		if match:						
			size = int(match.groups()[0])
		return "$table->string('%s', %d)->nullable();" % (fieldname, size)		
	if datatype == 'int' or datatype == 'dropdown':
		return "$table->integer('%s')->unsigned()->nullable();" % (fieldname)
	if datatype == 'date':
		return "$table->date('%s')->nullable();" % (fieldname)
	if datatype == 'bool':		
		return "$table->boolean('%s')->default(false)->nullable();" % (fieldname)
	if datatype == 'decimal':		
		return "$table->decimal('%s', 24, 6)->nullable();" % (fieldname)
	if datatype == 'point':
		return "Spatial data not supported yet"
	if datatype == 'internal' and fieldname == 'timestamp':
		return "$table->timestamps();"
	if datatype == 'internal' and fieldname == 'soft_deletion':
		return "$table->softDeletes();"
	return "MISSING " + fieldname

def createSchema(tablename, fields, foreignIds):
	schemaUp = "Schema::create('%s', function(Blueprint $table)\n" % (tablename)
	schemaUp += "{\n"
	for field in fields:
		order, fieldname, datatype, visible, caption, fieldtype, valuelist, mandatory, inputtype, role = field		
		schemaUp += "\t" + createSchemaLineForField(fieldname, datatype, foreignIds) + "\n"	
	schemaUp += "});\n"
	schemaDown = "\t" + "Schema::dropIfExists('%s', function(Blueprint $table){});" % (tablename)
	return schemaUp, schemaDown

def replaceInFile(filePath, searchBegin, searchEnd, replace):
	with open(filePath, "r", encoding="utf8") as file:
		content = file.read()
	content = re.sub("%s[\S\s]*%s" % (searchBegin, searchEnd), "%s\n%s%s" % (searchBegin, replace, searchEnd), content)	
	with open(filePath, "w", encoding="utf8") as file:
		file.write(content)

def foreignIdFromMainId(tablename):
	if tablename == "eias_permits":
		return "eia_permit_id"
	if tablename == "categories":
		return "category_id"			
	if tablename == "audits_inspections":
		return "audit_inspection_id"		
	return tablename[:-1] + "_id"

ignore = ['users']

foreignIds = {}

tables = OrderedDict()
for field in fielddata.split("\n"):		
	order, fieldname, datatype, visible, caption, fieldtype, valuelist, mandatory, inputtype, role, tablename = field.split("\t")
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

replaceInFile(phpFile, "// up begin", "// up end", tablesUp)
replaceInFile(phpFile, "// down begin", "// down end", tablesDown)
#print(tablesUp)
#print(tablesDown)

print("Created migration for %d tables" % (len(tables)))
print("Following tables where ignored: %s" % (",".join(ignore)))