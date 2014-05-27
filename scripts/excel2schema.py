#!python3
# -*- coding: utf8 -*-

import re
from collections import OrderedDict

phpFile = r"..\api\app\database\migrations\2014_05_21_131000_create_tables.php"

fielddata = """1	id	int	Additional district ID		No	-	Calculated	Role 1	additional_districts
2	district_id	int	District					Role 1	additional_districts
3	project_id	int	Project ID		No	-	Calculated	Role 1	additional_districts
1	id	int	Control ID		Yes	-	Calculated	Role 7	audits_inspections
2	year	int	Control Year	dropdown	Yes			Role 7	audits_inspections
3	type_control	int	Control type	dropdown	Yes			Role 7	audits_inspections
4	user_id	int	Control Officer	dropdown	Yes			Role 7	audits_inspections
5	date_control	date	Date of control		Yes			Role 7	audits_inspections
6	date_report_sent	date	Date report sendt		Yes			Role 7	audits_inspections
7	recommendations	varchar (2000)	Recommendations		Yes			Role 7	audits_inspections
8	follow_up	varchar (255)	Follow up		Yes			Role 7	audits_inspections
9	date_deadline	date	Company Deadline to verify that the deviations have been corrected		Yes			Role 7	audits_inspections
10	date_submitted	date	Date when NEMA receives information from the company		Yes			Role 7	audits_inspections
11	date_closing_letter	date	Date when NEMA closes the control		Yes			Role 7	audits_inspections
90	remarks	varchar (2000)	Remarks		Yes			Role 7	audits_inspections
13	project_id	int	Project ID		No			Role 7	audits_inspections
1	Id	int	Category ID		No	-	Calculated	Role 8	categories
1	Id	int	Code ID		No	-	Calculated	Role 8	codes
1	id	int	DocumentID		No	-	Calculated	Role 1	documents
2	date_submitted	date	Date of submission		Yes			Role 1	documents
1	id	int	District ID		No	-	Calculated	Role 8	districts
3	sub_final	int	Final submission	dropdown	Yes			Role 3	documents
4	sub_copy_no	int	No. of copies submitted		Yes			Role 1	documents
5	title	varchar (255)	Document title		Yes			Role 1	documents
6	type	int	Type of document	dropdown	Yes			Role 1	documents
2	description1	varchar (255)	Description1					Role 8	codes
7	number	int	Listed number		Yes			Role 1	documents
8	code	varchar (255)	Document code		Yes	-	Calculated	Role 1	documents
9	consultent	varchar (255)	Consulting team for PB & TOR		Yes			Role 1	documents
10	ded_copy_no	int	No. of to copies DED/D-EMC		Yes			Role 1	documents
11	date_sent_ded	date	Date sent to DED/D-EMC		Yes			Role 1	documents
12	eiac_copy_no	int	No. of copies to EIAC		Yes			Role 1	documents
13	date_copies_eiac	date	Date copies sent to EIAC		Yes			Role 1	documents
3	description2	varchar (255)	Description2					Role 8	codes
14	date_next_appointment	date	Date of next appointment		Yes			Role 1	documents
15	date_sent_from_dep	date	Date sent to EIAC from the dep.secretary		Yes			Role 1	documents
16	date_sent_eiao	date	Date sent to the EIAO		Yes			Role 2	documents
17	folio_no	varchar (255)	File and foliono.		Yes			Role 1	documents
1	id	int	ID of EIA&Permits		Yes	-	Calculated	Role 1	eias_permits
2	project_id	int	Project ID		No			Role 1	eias_permits
3	teamleader_id	int	Teamleder	dropdown	Yes			Role 1	eias_permits
4	cost	int	Cost of the proposed development		Yes			Role 1	eias_permits
5	status	int	Status	dropdown	Yes	-	Calculated	Role 1	eias_permits
1	id	int	Hearing ID		No	-	Calculated	Role 3	hearings
6	user_id	int	The Officers assigned	dropdown	Yes			Role 2	eias_permits
7	inspection_recommended	int	Inspection before approval?	dropdown	Yes			Role 3	eias_permits
8	date_inspection	date	Date of inspection date		Yes			Role 3	eias_permits
9	officer_recommend	varchar (2000)	Recommendations by EIAO		Yes			Role 3	eias_permits
10	fee	decimal	Expected fees		Yes			Role 3	eias_permits
11	date_sent_ded_approval	date	Date sent for approval		Yes			Role 3	eias_permits
5	date_expected	date	Date expected for comments		Yes			Role 3	hearings
12	decision	int	Decision taken	dropdown	Yes			Role 5	eias_permits
13	date_decision	date	Date for decision		Yes			Role 5	eias_permits
14	date_fee_notification	date	Date for fee notification		Yes			Role 4	eias_permits
2	district	varchar (255)	District					Role 8	districts
15	date_fee_payed	date	Date invoice is payed		Yes			Role 4	eias_permits
3	hasc	varchar (255)	ISO		No			Role 8	districts
4	iso	int	HASC		No			Role 8	districts
16	fee_receipt_no	varchar (255)	Fee receipt number		Yes			Role 4	eias_permits
17	designation	int	Designation of the one who signed	dropdown	Yes			Role 5	eias_permits
1	id	int	Organisation ID		Yes	-	Calculated	Role 1	organisations
1	id	int	Practitioner certificate ID		No	-	Calculated	Role 6	practitioner_certificates
2	lead_agency	int	Lead agencies	dropdown				Role 3	hearings
3	district_id	int	Local governments	dropdown				Role 3	hearings
4	date_dispatched	date	Date dispatched					Role 3	hearings
2	practitioner_id	int	Practitioner ID		No	-	Calculated	Role 6	practitioner_certificates
6	date_received	date	Date received comments					Role 1	hearings
7	recommendations	varchar (2000)	Summarized recommendations					Role 3	hearings
90	remarks	varchar (2000)	Remarks					Role 3	hearings
10	document_id	int	Document ID					Role 3	hearings
100	soft_deletion	internal	Delete control?		No			Role 7	audits_inspections
4	date_of_entry	date	Date of entry 		Yes	-	Calculated	Role 6	practitioner_certificates
2	tin	int	TIN		Yes			Role 1	organisations
18	conclusion	int	Conclusion (PB/Tor accepted)	dropdown	Yes			Role 5	documents
19	eia_permit_id	int	EIA		No			Role 1	documents
3	organisation_name	varchar (255)	Organisation name		Yes			Role 1	organisations
21	control_id	int	Control ID		No			Role 1	documents
90	remarks	varchar (2000)	Remarks		Yes			Role 1	documents
18	date_certificate	date	Date on the certificate		Yes			Role 5	eias_permits
19	certificate_no	int	Certificate number		Yes			Role 5	eias_permits
20	date_cancelled	date	Certificate cancelled date		Yes			Role 5	eias_permits
4	visiting_address	varchar (255)	Visiting address		Yes			Role 1	organisations
100	soft_deletion	internal	Delete document?		No			Role 1	documents
7	number	int	Listed number		No	-	Calculated	Role 6	practitioner_certificates
3	year	int	Year issued	dropdown				Role 6	practitioner_certificates
8	cert_no	varchar (255)	Certificate number		Yes	-	Calculated	Role 6	practitioner_certificates
5	is_approved	bool	Approved  					Role 6	practitioner_certificates
90	remarks	varchar (2000)	Remarks		Yes			Role 5	eias_permits
6	cert_type	int	Type of certificate	dropdown				Role 6	practitioner_certificates
1	id	int	Practitioner ID		Yes	-	Calculated	Role 6	practitioners
100	soft_deletion	internal	Delete Eia or permit?		No			Role 5	eias_permits
1	id	int	ProjectID		Yes	-	Calculated	Role 1	projects
100	soft_deletion	internal	Delete hearing?		No			Role 3	hearings
9	conditions	int	Conditions	dropdown				Role 6	practitioner_certificates
5	box_no	int	PO Box		Yes			Role 1	organisations
1	id	int	TeammemberID		No	-	Calculated	Role 1	team_members
6	city	varchar (255)	City		Yes			Role 1	organisations
2	person	varchar (255)	Name of the practitioner (person)					Role 6	practitioners
7	phone	varchar (255)	Phone		Yes			Role 1	organisations
8	fax	varchar (255)	Fax		Yes			Role 1	organisations
3	tin	int	TIN					Role 6	practitioners
9	email	varchar (255)	Email		Yes			Role 1	organisations
10	contact_person	varchar (255)	Contact person		Yes			Role 1	organisations
90	remarks	varchar (2000)	Remarks		Yes			Role 1	organisations
100	soft_deletion	internal	Delete organisation?		No			Role 1	organisations
10	is_cancelled	bool	Certificate cancelled?					Role 6	practitioner_certificates
4	organisation_name	varchar (255)	Organisation name					Role 6	practitioners
5	visiting_address	varchar (255)	Visiting address					Role 6	practitioners
90	remarks	varchar (2000)	Remarks					Role 6	practitioner_certificates
6	box_no	int	PO Box					Role 6	practitioners
2	title	varchar (255)	Project title		Yes			Role 1	projects
7	city	varchar (255)	City					Role 6	practitioners
8	phone	varchar (255)	Phone					Role 6	practitioners
3	category_id	int	Category of project	dropdown	Yes			Role 1	projects
4	location	varchar (255)	Location name		Yes			Role 1	projects
5	description	varchar (255)	Address		Yes			Role 1	projects
6	district_id	int	District	dropdown	Yes			Role 1	projects
9	fax	varchar (255)	Fax					Role 6	practitioners
8	longitude	decimal	Longitude and latitude		Yes			Role 1	projects
9	latitude	decimal	-		No			Role 1	projects
10	has_industrial_waste_water	bool	Discharge of industrial waste water?		Yes			Role 1	projects
11	grade	int	Grade	dropdown	Yes			Role 7	projects
3	eia_permit_id	int	Name of the EIA&Permit to the team member		No	-	Calculated	Role 1	team_members
2	practitioner_id	int	Team members	dropdown				Role 1	team_members
1	id	int	User Id		No	-	Calculated	Role 8	users
10	email	varchar (255)	Email					Role 6	practitioners
11	qualifications	varchar (2000)	Qualifications					Role 6	practitioners
12	expertise	varchar (2000)	Expertise					Role 6	practitioners
2	initials	varchar (255)	Initials					Role 8	users
90	remarks	varchar (2000)	Remarks					Role 6	practitioners
100	soft_deletion	internal	Delete practitionares?		No			Role 6	practitioners
3	full_name	varchar (255)	Full name					Role 8	users
4	job_position_code	varchar (255)	Job position code					Role 8	users
5	fips	varchar (255)	FIPS		No			Role 8	districts
12	organisation_id	int	Organisation ID		Yes			Role 1	projects
90	remarks	varchar (2000)	Remarks		Yes			Role 1	projects
6	region	varchar (255)	Region					Role 8	districts
100	soft_deletion	internal	Delete project?		No			Role 1	projects
5	job_position_name	int	Job position name	dropdown				Role 8	users
100	soft_deletion	internal	Delete district?		No			Role 8	districts
100	soft_deletion	internal	Delete certificate?		No			Role 6	practitioner_certificates
4	value1	int	Value1					Role 8	codes
6	email	varchar (255)	email					Role 8	users
7	password	varchar (255)	Password					Role 8	users
5	dropdown_list	varchar (255)	Drop down list					Role 8	codes
99	is_passive	bool	Is the user passive?					Role 8	users
99	is_passive	bool	Not use the code any more?					Role 8	codes
2	description_short	varchar (255)	Short description					Role 8	categories
100	soft_deletion	internal	Not use this user any more?		No			Role 8	users
3	description_long	varchar (2000)	Long description					Role 8	categories
4	consequence	int	Consequence	dropdown				Role 8	categories
99	is_passive	bool	Not use this category any more?					Role 8	categories
110	timestamp	internal	-		No			Role 7	audits_inspections
110	timestamp	internal	-		No			Role 1	documents
110	timestamp	internal	-		No			Role 5	eias_permits
110	timestamp	internal	-		No			Role 3	hearings
110	timestamp	internal	-		No			Role 1	organisations
110	timestamp	internal	-		No			Role 6	practitioners
110	timestamp	internal	-		No			Role 1	projects
110	timestamp	internal	-		No			Role 8	districts
110	timestamp	internal	-		No			Role 6	practitioner_certificates
110	timestamp	internal	-		No			Role 8	users"""


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
		order, fieldname, datatype, caption, fieldtype, visible, mandatory, inputtype, role = field		
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
	order, fieldname, datatype, caption, fieldtype, visible, mandatory, inputtype, role, tablename = field.split("\t")
	tablename = tablename.lower()
	fieldname = fieldname.lower()
	datatype = datatype.lower()	
	if fieldname == "id":
		foreignIds[foreignIdFromMainId(tablename)] = tablename	
	order = int(order)
	if tablename not in tables:
		tables[tablename] = []
	tables[tablename].append([order, fieldname, datatype, caption, fieldtype, visible, mandatory, inputtype, role])
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