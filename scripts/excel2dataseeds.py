#!python3
# -*- coding: utf8 -*-

import os, openpyxl, re, glob
from collections import OrderedDict
from datetime import datetime
phpFile = r"..\api\database\seeds\ExcelDataTableSeeder.php"

tableFilePattern = r"N:\Felles\Forurensning\2. Internasjonalt arbeid\2012. Uganda\Kravspek\Tabeller\Supporting tables version*.xlsx"                   
#tableFilePattern = r"C:\Dropbox\Deling\Nema\Supporting tables version*.xlsx"                  




tablesData = OrderedDict()
#tablesData["users"] = "User"
#tablesData["districts"] = "District"
#tablesData["codes"] = "Code"
tablesData["categories"] = "Category"
#tablesData["practitioners"] = "Practitioner"
#tablesData["practitioner_certificates"] = "PractitionerCertificate"
#tablesData["lead_agencies"] = "LeadAgency"
#tablesData["roles"] = "Role"

notIncrements = ["codes", "categories"];

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
  if columnName == 'cert_type':
    if value == "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS": return 1
    if value == "CERTIFIED ENVIRONMENTAL AUDITORS": return 2
    print("Lookup value for %s. No hit for value=%s." % (columnName, value))
  return 0

def isNumber(s):
    try:
        float(s)
        return True
    except ValueError:
        return False

ignoreColumns = ['is_deleted', 'soft_deletion']
ignoreInTable = {'users':'roles'}
connectionInfo = OrderedDict()
connectionInfo['users'] = ['roles']
passwordColumn = 'password'
lookupColumns = []
dateColumns = ['date_of_entry']
relationshipColumns = {'practitioner_id':'$practitioner%s->id'}

def getColumnSeed(tableName, columnName, value):

  if columnName == 'id' and tableName not in notIncrements: return  
  if columnName in ignoreColumns: return
  if tableName in ignoreInTable and columnName in ignoreInTable[tableName]: return
  if columnName == passwordColumn:
    if not value:
      value = "crazypassword12234335"
    return "'%s' => Hash::make('%s')" % (columnName, value)
  if columnName in lookupColumns:
    value = getLookupValue(columnName, value)   
  if not value: return
  if columnName in dateColumns:
      value = value.strftime("%Y-%m-%d")
  if columnName in relationshipColumns:
    value = relationshipColumns[columnName]%value
  if isNumber(value) or columnName in relationshipColumns:
    return """'%s' => %s """ % (columnName, value)
  return """'%s' => "%s" """ % (columnName, value)

def getConnectionSeed(tableName, columnName, value, seedVariableName):  
  if tableName in connectionInfo and columnName in connectionInfo[tableName] and value:   
    connectionSeedTemplate = "$%s->attachRole($role%s);"
    connectionSeeds = []
    for roleId in str(value).split(";"):
      connectionSeeds.append(connectionSeedTemplate % (seedVariableName, roleId))
    return "\n".join(connectionSeeds)
  return None

def getSeedVariableName(entityName, coordinate, rowsOffset):
  rowNumber = int(re.sub('[A-Z]*', '', coordinate))
  return "%s%d" % (entityName.lower(), rowNumber-(rowsOffset+1))

def replaceInFile(filePath, searchBegin, searchEnd, replace):
  with open(filePath, "r", encoding="utf8") as file:
    oldcontent = file.read()
  content = re.sub("%s[\S\s]*%s" % (searchBegin, searchEnd), "%s\n%s%s" % (searchBegin, replace, searchEnd), oldcontent)  
  if content == oldcontent:
    return False    
  open(r"C:\Temp\comp_old.txt",'w').write(oldcontent)
  open(r"C:\Temp\comp_new.txt", 'w').write(content)
  with open(filePath, "w", encoding="utf8") as file:
    file.write(content)
  return True   

seedTemplate = """$%s = %s::create(array(
  %s            
));"""

tableFile = glob.glob(tableFilePattern)[-1]
print("Reading from file %s" % tableFile)
wb = openpyxl.load_workbook(filename = tableFile, data_only=True)
seeds = []
connectionSeeds = [] 
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
      seedVariableName = getSeedVariableName(entityName, column.coordinate, rowsOffset) 
      columnName = dbColumnsInfo[getColumnLetterFromCoordinate(column.coordinate)]      
      columnSeed = getColumnSeed(tableName, columnName, column.value)
      if columnSeed:
        columnSeeds.append(columnSeed)
      connectionSeed = getConnectionSeed(tableName, columnName, column.value, seedVariableName)
      if connectionSeed:
        connectionSeeds.append(connectionSeed)
    seed = seedTemplate % (seedVariableName, entityName, ",\n\t".join(columnSeeds))
    seeds.append(seed)    
seeds.extend(connectionSeeds)
    
allSeeds = ""
for seed in seeds:
  allSeeds += (seed + "\n\n")
#print (allSeeds)

generationInfo = """// Generated by script %s, \n// based on file "%s".\n""" %(datetime.now().strftime("%Y-%m-%d %H:%M:%S"), tableFile.replace("\\", "\\\\"))

hasChanges = replaceInFile(phpFile, "// seed begin", "// seed end", allSeeds)
if not hasChanges:
  print("Nothing changed.")
  exit()
replaceInFile(phpFile, "// info begin", "// info end", generationInfo)