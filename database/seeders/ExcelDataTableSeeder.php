<?php

// info begin
// Generated by script 2015-11-11 16:46:31, 
// based on file "N:\Felles\Forurensning\2. Internasjonalt arbeid\2012. Uganda\Kravspek\Tabeller\Supporting tables version 1.31.xlsx".
// info end

use Illuminate\Database\Seeder;
use \App\LeadAgency;
use \App\Category;
use \App\Code;
use \App\District;

class ExcelDataTableSeeder extends Seeder {
 
    public function run()
    {
        //DB::table('users')->truncate();
        //DB::table('assigned_roles')->truncate();
        //DB::table('permission_role')->truncate();    		
    		//DB::table('permissions')->truncate();        
        //DB::table('roles')->truncate();
        
        DB::table('lead_agencies')->truncate();
        //DB::table('categories')->truncate();
        //DB::table('codes')->truncate();
        //DB::table('districts')->truncate();
        //DB::table('practitioner_certificates')->truncate();
        //DB::table('practitioners')->truncate();
        //DB::table('organisations')->truncate();
        //DB::table('projects')->truncate();
        //DB::table('additional_districts')->truncate();

        
        //$permission1 = Permission::create(array('name' => 'Rettighet 1', 'display_name' => 'Rettighet 1'));
        //$permission2 = Permission::create(array('name' => 'Rettighet 2', 'display_name' => 'Rettighet 2'));
        //$role1->attachPermission($permission1);
        //$role2->attachPermission($permission1);
        //$role2->attachPermission($permission2);


        // seed begin
$leadagency1 = LeadAgency::create(array(
  'short_name' => "UWA" ,
	'long_name' => "Uganda Wildlife Authority"             
));

$leadagency2 = LeadAgency::create(array(
  'short_name' => "CAA" ,
	'long_name' => "Civil Aviation Authority"             
));

$leadagency3 = LeadAgency::create(array(
  'short_name' => "UCC" ,
	'long_name' => "Uganda Communications Commission"             
));

$leadagency4 = LeadAgency::create(array(
  'short_name' => "UNRA" ,
	'long_name' => "Uganda National Roads Authority"             
));

$leadagency5 = LeadAgency::create(array(
  'short_name' => "DWRM" ,
	'long_name' => "Directorate of Water Resources Management"             
));

$leadagency6 = LeadAgency::create(array(
  'short_name' => "NWSC" ,
	'long_name' => "National Water and Sewerage Coorporation"             
));

$leadagency7 = LeadAgency::create(array(
  'short_name' => "DLG" ,
	'long_name' => "District Local Government"             
));

$leadagency8 = LeadAgency::create(array(
  'short_name' => "Municipality" ,
	'long_name' => "Municipality"             
));

$leadagency9 = LeadAgency::create(array(
  'short_name' => "KCCA" ,
	'long_name' => "Kampala Capital City Authority"             
));

$leadagency10 = LeadAgency::create(array(
  'short_name' => "URA" ,
	'long_name' => "Uganda Revenue Authority"             
));

$leadagency11 = LeadAgency::create(array(
  'short_name' => "MoLHUD" ,
	'long_name' => "Ministry of Lands, Housing and Urban Development"             
));

$leadagency12 = LeadAgency::create(array(
  'short_name' => "MAAIF" ,
	'long_name' => "Ministry of Agriculture, Animal Industry and Fisheries"             
));

$leadagency13 = LeadAgency::create(array(
  'short_name' => "PAU" ,
	'long_name' => "Petroleum Authority of Uganda"             
));

$leadagency14 = LeadAgency::create(array(
  'short_name' => "UNBS" ,
	'long_name' => "Uganda National Bureau of Standards"             
));

$leadagency15 = LeadAgency::create(array(
  'short_name' => "ERA" ,
	'long_name' => "Electricity Regulatory Authority"             
));

$leadagency16 = LeadAgency::create(array(
  'short_name' => "NARO" ,
	'long_name' => "National Agricultural Research Organisation"             
));

$leadagency17 = LeadAgency::create(array(
  'short_name' => "UNCST" ,
	'long_name' => "Uganda National Council of Science and Technology"             
));

$leadagency18 = LeadAgency::create(array(
  'short_name' => "NDA" ,
	'long_name' => "National Drug Authority"             
));

$leadagency19 = LeadAgency::create(array(
  'short_name' => "AEC" ,
	'long_name' => "Atomic Energy Council"             
));

$leadagency20 = LeadAgency::create(array(
  'short_name' => "UBOS" ,
	'long_name' => "Uganda Bureau of Statistics"             
));

$leadagency21 = LeadAgency::create(array(
  'short_name' => "UNMA" ,
	'long_name' => "Uganda National Meteorological Authority"             
));

$leadagency22 = LeadAgency::create(array(
  'short_name' => "UIA" ,
	'long_name' => "Uganda Investment Authority"             
));

$leadagency23 = LeadAgency::create(array(
  'short_name' => "NFA" ,
	'long_name' => "National Forestry Authority"             
));

// seed end

/*

$organisation1 = Organisation::create(array(
	'name' => "Organisasjon nummer uno" ,
	'visiting_address' => 'Sandhaugen 1',
	'box_no' => 12345 ,	
	'city' => "Oslo" ,
	'contact_person' => "Jostein Skaar"	
	,'updated_by' => 'Import'
	,'created_by' => 'Import'
));

$organisation2 = Organisation::create(array(
	'name' => "Organisasjon nummer doss" ,
	'visiting_address' => 'Hauglandsplass 13',
	'box_no' => 23456 ,	
	'city' => "Bergen" ,
	'contact_person' => "Jostein Skaar"	
	,'updated_by' => 'Import'
	,'created_by' => 'Import'
));

$organisation3 = Organisation::create(array(
	'name' => "Organisasjon nummer drei" ,
	'visiting_address' => 'Gategate 19',
	'box_no' => 34567 ,	
	'city' => "Kristiansand" ,
	'contact_person' => "Jostein Skaar"	
	,'updated_by' => 'Import'
	,'created_by' => 'Import'
));

$project1 = Project::create(array(
	'title' => "Prosjet nummer ein",
	'organisation_id' => $organisation2->id,
	'category_id' =>  $category3->id,	
	'district_id' => $district111->id,
	'location' => "Lokasjon uno",
	'has_industrial_waste_water' => $code41->id
	,'updated_by' => 'Import'
	,'created_by' => 'Import'
));

$project2 = Project::create(array(
	'title' => "Prosjet nummer two",
	'organisation_id' => $organisation1->id,
	'category_id' =>  $category6->id,	
	'district_id' => $district3->id,
	'location' => "Lokasjon dos",
	'has_industrial_waste_water' => $code41->id
	,'updated_by' => 'Import'
	,'created_by' => 'Import'
));

$project3 = Project::create(array(
	'title' => "Prosjet nummer tress",
	'organisation_id' => $organisation1->id,
	'category_id' =>  $category8->id,	
	'district_id' => $district11->id,
	'location' => "Lokasjon tress",
	'has_industrial_waste_water' => $code41->id
	,'updated_by' => 'Import'
	,'created_by' => 'Import'
));

$project4 = Project::create(array(
	'title' => "Prosjet nummer fjers",
	'organisation_id' => $organisation1->id,
	'category_id' =>  $category9->id,	
	'district_id' => $district11->id,
	'location' => "Lokasjon firr",
	'has_industrial_waste_water' => $code40->id
	,'updated_by' => 'Import'
	,'created_by' => 'Import'
));

*/
    }

}