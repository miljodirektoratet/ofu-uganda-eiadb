<?php
 
class ExcelDataTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('assigned_roles')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();        
        DB::table('categories')->truncate();
        DB::table('codes')->truncate();
        DB::table('districts')->truncate();
        DB::table('practitioner_certificates')->truncate();
        DB::table('practitioners')->truncate();

        $role1 = Role::create(array('name' => 'Rolle 1'));
        $role2 = Role::create(array('name' => 'Rolle 2'));

        $permission1 = Permission::create(array('name' => 'Rettighet 1', 'display_name' => 'Rettighet 1'));
        $permission2 = Permission::create(array('name' => 'Rettighet 2', 'display_name' => 'Rettighet 2'));

        $role1->attachPermission($permission1);
        $role2->attachPermission($permission1);
        $role2->attachPermission($permission2);

        $user0a = User::create(array(
            'initials' => 'josska',
            'full_name' => 'Jostein Skaar',
            'job_position_code' => 'Mjød',
            'job_position_name' => 'Software Developer',
            'email' => 'jostein.skaar@miljodir.no',
            'password' => Hash::make('jostein')            
        ));

        $user0b = User::create(array(
            'initials' => 'chrhau',
            'full_name' => 'Christian Haugland',
            'job_position_code' => 'Mjød',
            'job_position_name' => 'Prince of Excel',
            'email' => 'christian.haugland@miljodir.no',
            'password' => Hash::make('christian')            
        ));

        $user0c = User::create(array(
            'initials' => 'torfin',
            'full_name' => 'Torstein Finnesand',
            'job_position_code' => 'Mjød',
            'job_position_name' => 'King of Excel',
            'email' => 'torstein.finnesand@miljodir.no',
            'password' => Hash::make('torstein')            
        ));



        // seed begin
$user1 = User::create(array(
  'initials' => "awinyi" ,
	'full_name' => "Alex Winyi" ,
	'job_position_code' => "EIAO" ,
	'job_position_name' => "Evironmental Impact Assessment Officer" ,
	'email' => "awinyi@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user2 = User::create(array(
  'initials' => "bbirungi" ,
	'full_name' => "Bonny Birungi" ,
	'job_position_code' => "DS" ,
	'job_position_name' => "Departmental Secretary" ,
	'email' => "kbirungi@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user3 = User::create(array(
  'initials' => "dlufafa" ,
	'full_name' => "Dick Lufafa" ,
	'job_position_code' => "EAMO-1" ,
	'job_position_name' => "Environmental Audits Monitoring Officer" ,
	'email' => "dlufafa@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user4 = User::create(array(
  'initials' => "enidt" ,
	'full_name' => "Enid Turyahikayo" ,
	'job_position_code' => "EAMO" ,
	'job_position_name' => "Environmental Audits and Monitoring Officer" ,
	'email' => "enidt@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user5 = User::create(array(
  'initials' => "fbagoora" ,
	'full_name' => "Festus Bagoora" ,
	'job_position_code' => "NRM(S&L)" ,
	'job_position_name' => "Natural Resources Management Specialist (Soils & Land Use)" ,
	'email' => "fbagoora@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user6 = User::create(array(
  'initials' => "fogwal" ,
	'full_name' => "Francis Ogwal" ,
	'job_position_code' => "NRM(B&R)" ,
	'job_position_name' => "Natural Resources Management Specialist (Bio/Range Lands)" ,
	'email' => "fogwal@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user7 = User::create(array(
  'initials' => "fonyai" ,
	'full_name' => "Fred Onyai" ,
	'job_position_code' => "IMES" ,
	'job_position_name' => "Internal Monitoring and Evaluation Specialist" ,
	'email' => "fonyai@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user8 = User::create(array(
  'initials' => "gkitutu" ,
	'full_name' => "Goreti K. Kitutu" ,
	'job_position_code' => "EISS" ,
	'job_position_name' => "Environmental Information Systems Specialist" ,
	'email' => "gkitutu@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user9 = User::create(array(
  'initials' => "glubega" ,
	'full_name' => "Lubega George" ,
	'job_position_code' => "NRM(Aq)" ,
	'job_position_name' => "Natural Resources Management Specialist (Aquatic)" ,
	'email' => "glubega@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user10 = User::create(array(
  'initials' => "gsawula" ,
	'full_name' => "Gerald Sawula" ,
	'job_position_code' => "DED" ,
	'job_position_name' => "Deputy Executive Director" ,
	'email' => "gsawula@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user11 = User::create(array(
  'initials' => "hnamara" ,
	'full_name' => "Harriet Namara" ,
	'job_position_code' => "EIAA" ,
	'job_position_name' => "Environmental Impact Assessment Assistant" ,
	'email' => "hnamara@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user12 = User::create(array(
  'initials' => "iintujju" ,
	'full_name' => "Isaac I.G. Ntujju" ,
	'job_position_code' => "SEI" ,
	'job_position_name' => "Senior Environmental Inspector" ,
	'email' => "iigntujju@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user13 = User::create(array(
  'initials' => "inamuleme" ,
	'full_name' => "Namuleme Immaculate" ,
	'job_position_code' => "EAIMA" ,
	'job_position_name' => "Environmental Assessment and Information Monitoring Assistant " ,
	'email' => "inamuleme@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user14 = User::create(array(
  'initials' => "jkagoda" ,
	'full_name' => "Joy Kagoda" ,
	'job_position_code' => "SPS" ,
	'job_position_name' => "Senior Personal Secretary ED" ,
	'email' => "jkagoda@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user15 = User::create(array(
  'initials' => "jkutesakwe" ,
	'full_name' => "Jeniffer Kutesakwe" ,
	'job_position_code' => "LT" ,
	'job_position_name' => "Laboratory Technician" ,
	'email' => "jkutesakwe@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user16 = User::create(array(
  'initials' => "maanyu" ,
	'full_name' => "Aanyu Margaret" ,
	'job_position_code' => "EIAC" ,
	'job_position_name' => "Environmental Impact Assesment Coordinator" ,
	'email' => "maanyu@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user17 = User::create(array(
  'initials' => "mmubangizi" ,
	'full_name' => "Matia Mubangizi" ,
	'job_position_code' => "EAA" ,
	'job_position_name' => "Environmental Audits Assistant" ,
	'email' => "mmubangizi@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user18 = User::create(array(
  'initials' => "naisha" ,
	'full_name' => "Nakanwaji Aisha" ,
	'job_position_code' => "RA" ,
	'job_position_name' => "Registry Assistant" ,
	'email' => "naisha@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user19 = User::create(array(
  'initials' => "nallimadi" ,
	'full_name' => "Nancy Allimadi" ,
	'job_position_code' => "EI" ,
	'job_position_name' => "Environmental Inspector" ,
	'email' => "nallimadi@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user20 = User::create(array(
  'initials' => "nobbo" ,
	'full_name' => "Obbo Naome" ,
	'job_position_code' => "EIAO" ,
	'job_position_name' => "Environmental Impact Assessment officer" ,
	'email' => "nobbo@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user21 = User::create(array(
  'initials' => "pkato" ,
	'full_name' => "Phillip Kato" ,
	'job_position_code' => "NA" ,
	'job_position_name' => "Network Administrator" ,
	'email' => "pkato@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user22 = User::create(array(
  'initials' => "pnsereko" ,
	'full_name' => "Patience Nsereko" ,
	'job_position_code' => "EMO" ,
	'job_position_name' => "Environmental Monitoring Officer-Oil & Gas" ,
	'email' => "pnsereko@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user23 = User::create(array(
  'initials' => "rmugambwa" ,
	'full_name' => "Richard Mugambwa" ,
	'job_position_code' => "PM-MSW" ,
	'job_position_name' => "Project Manager-Municipal Solid Waste" ,
	'email' => "rmugambwa@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user24 = User::create(array(
  'initials' => "rnamara" ,
	'full_name' => "Namara Rhona" ,
	'job_position_code' => "SPS" ,
	'job_position_name' => "Senior Personal Assistant DED" ,
	'email' => "rnamara@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user25 = User::create(array(
  'initials' => "tkiwanuka" ,
	'full_name' => "Tonny Kiwanuka" ,
	'job_position_code' => "EIAA" ,
	'job_position_name' => "Environmental Impact Assessment Assistant" ,
	'email' => "tkiwanuma@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user26 = User::create(array(
  'initials' => "tokurut" ,
	'full_name' => "Tom O. Okurut" ,
	'job_position_code' => "ED" ,
	'job_position_name' => "Executive Director" ,
	'email' => "tokurut@nemaug.org" ,
	'password' => Hash::make('password')            
));

$user27 = User::create(array(
  'initials' => "wayazika" ,
	'full_name' => "Waiswa Ayazika" ,
	'job_position_code' => "DEMC" ,
	'job_position_name' => "Director Environmental Monitoring and Compliance" ,
	'email' => "wayazika@nemaug.org" ,
	'password' => Hash::make('password')            
));

$district1 = District::create(array(
  'district' => "Abim" ,
	'hasc' => "UG.AI" ,
	'iso' => 317 ,
	'fips' => "UGB6" ,
	'region' => "N"             
));

$district2 = District::create(array(
  'district' => "Adjumani" ,
	'hasc' => "UG.AD" ,
	'iso' => 301 ,
	'fips' => "UG98" ,
	'region' => "N"             
));

$district3 = District::create(array(
  'district' => "Agago" ,
	'hasc' => "UG.AG" ,
	'fips' => "UGE3" ,
	'region' => "N"             
));

$district4 = District::create(array(
  'district' => "Alebtong" ,
	'hasc' => "UG.AL" ,
	'fips' => "UGE4" ,
	'region' => "N"             
));

$district5 = District::create(array(
  'district' => "Amolatar" ,
	'hasc' => "UG.AT" ,
	'iso' => 314 ,
	'fips' => "UGB7" ,
	'region' => "N"             
));

$district6 = District::create(array(
  'district' => "Amudat" ,
	'hasc' => "UG.AZ" ,
	'fips' => "UGE5" ,
	'region' => "N"             
));

$district7 = District::create(array(
  'district' => "Amuria" ,
	'hasc' => "UG.AM" ,
	'iso' => 216 ,
	'fips' => "UGB8" ,
	'region' => "E"             
));

$district8 = District::create(array(
  'district' => "Amuru" ,
	'hasc' => "UG.AY" ,
	'iso' => 319 ,
	'fips' => "UGB9" ,
	'region' => "N"             
));

$district9 = District::create(array(
  'district' => "Apac" ,
	'hasc' => "UG.AQ" ,
	'iso' => 302 ,
	'fips' => "UG99" ,
	'region' => "N"             
));

$district10 = District::create(array(
  'district' => "Arua" ,
	'hasc' => "UG.AX" ,
	'iso' => 303 ,
	'fips' => "UGA1" ,
	'region' => "N"             
));

$district11 = District::create(array(
  'district' => "Budaka" ,
	'hasc' => "UG.BD" ,
	'iso' => 217 ,
	'fips' => "UGC1" ,
	'region' => "E"             
));

$district12 = District::create(array(
  'district' => "Bududa" ,
	'hasc' => "UG.BA" ,
	'iso' => 223 ,
	'fips' => "UGC2" ,
	'region' => "E"             
));

$district13 = District::create(array(
  'district' => "Bugiri" ,
	'hasc' => "UG.BI" ,
	'iso' => 201 ,
	'fips' => "UG66" ,
	'region' => "E"             
));

$district14 = District::create(array(
  'district' => "Buhweju" ,
	'hasc' => "UG.BH" ,
	'fips' => "UGE6" ,
	'region' => "W"             
));

$district15 = District::create(array(
  'district' => "Buikwe" ,
	'hasc' => "UG.BZ" ,
	'fips' => "UGE7" ,
	'region' => "C"             
));

$district16 = District::create(array(
  'district' => "Bukedea" ,
	'hasc' => "UG.BE" ,
	'iso' => 224 ,
	'fips' => "UGC3" ,
	'region' => "E"             
));

$district17 = District::create(array(
  'district' => "Bukomansimbi" ,
	'hasc' => "UG.BM" ,
	'fips' => "UGE8" ,
	'region' => "C"             
));

$district18 = District::create(array(
  'district' => "Bukwa" ,
	'hasc' => "UG.BW" ,
	'iso' => 218 ,
	'fips' => "UGC4" ,
	'region' => "E"             
));

$district19 = District::create(array(
  'district' => "Bulambuli" ,
	'hasc' => "UG.BB" ,
	'fips' => "UGE9" ,
	'region' => "E"             
));

$district20 = District::create(array(
  'district' => "Buliisa" ,
	'hasc' => "UG.BL" ,
	'iso' => 419 ,
	'fips' => "UGC5" ,
	'region' => "W"             
));

$district21 = District::create(array(
  'district' => "Bundibugyo" ,
	'hasc' => "UG.BX" ,
	'iso' => 401 ,
	'fips' => "UG28" ,
	'region' => "W"             
));

$district22 = District::create(array(
  'district' => "Bushenyi" ,
	'hasc' => "UG.BC" ,
	'iso' => 402 ,
	'fips' => "UG29" ,
	'region' => "W"             
));

$district23 = District::create(array(
  'district' => "Busia" ,
	'hasc' => "UG.BU" ,
	'iso' => 202 ,
	'fips' => "UG67" ,
	'region' => "E"             
));

$district24 = District::create(array(
  'district' => "Butaleja" ,
	'hasc' => "UG.BJ" ,
	'iso' => 219 ,
	'fips' => "UGC6" ,
	'region' => "E"             
));

$district25 = District::create(array(
  'district' => "Butambala" ,
	'hasc' => "UG.BT" ,
	'fips' => "UGF1" ,
	'region' => "C"             
));

$district26 = District::create(array(
  'district' => "Buvuma" ,
	'hasc' => "UG.BV" ,
	'fips' => "UGF2" ,
	'region' => "C"             
));

$district27 = District::create(array(
  'district' => "Buyende" ,
	'hasc' => "UG.BY" ,
	'fips' => "UGF3" ,
	'region' => "E"             
));

$district28 = District::create(array(
  'district' => "Dokolo" ,
	'hasc' => "UG.DO" ,
	'iso' => 318 ,
	'fips' => "UGC7" ,
	'region' => "N"             
));

$district29 = District::create(array(
  'district' => "Gomba" ,
	'hasc' => "UG.GM" ,
	'fips' => "UGF4" ,
	'region' => "C"             
));

$district30 = District::create(array(
  'district' => "Gulu" ,
	'hasc' => "UG.GL" ,
	'iso' => 304 ,
	'fips' => "UGA2" ,
	'region' => "N"             
));

$district31 = District::create(array(
  'district' => "Hoima" ,
	'hasc' => "UG.HO" ,
	'iso' => 403 ,
	'fips' => "UG31" ,
	'region' => "W"             
));

$district32 = District::create(array(
  'district' => "Ibanda" ,
	'hasc' => "UG.IB" ,
	'iso' => 416 ,
	'fips' => "UGC8" ,
	'region' => "W"             
));

$district33 = District::create(array(
  'district' => "Iganga" ,
	'hasc' => "UG.IC" ,
	'iso' => 203 ,
	'fips' => "UGA3" ,
	'region' => "E"             
));

$district34 = District::create(array(
  'district' => "Isingiro" ,
	'hasc' => "UG.NG" ,
	'iso' => 417 ,
	'fips' => "UGC9" ,
	'region' => "W"             
));

$district35 = District::create(array(
  'district' => "Jinja" ,
	'hasc' => "UG.JI" ,
	'iso' => 204 ,
	'fips' => "UG33" ,
	'region' => "E"             
));

$district36 = District::create(array(
  'district' => "Kaabong" ,
	'hasc' => "UG.AB" ,
	'iso' => 315 ,
	'fips' => "UGD1" ,
	'region' => "N"             
));

$district37 = District::create(array(
  'district' => "Kabale" ,
	'hasc' => "UG.KA" ,
	'iso' => 404 ,
	'fips' => "UG34" ,
	'region' => "W"             
));

$district38 = District::create(array(
  'district' => "Kabarole" ,
	'hasc' => "UG.BR" ,
	'iso' => 405 ,
	'fips' => "UG79" ,
	'region' => "W"             
));

$district39 = District::create(array(
  'district' => "Kaberamaido" ,
	'hasc' => "UG.KD" ,
	'iso' => 213 ,
	'fips' => "UG80" ,
	'region' => "E"             
));

$district40 = District::create(array(
  'district' => "Kalangala" ,
	'hasc' => "UG.KN" ,
	'iso' => 101 ,
	'fips' => "UG36" ,
	'region' => "C"             
));

$district41 = District::create(array(
  'district' => "Kaliro" ,
	'hasc' => "UG.RO" ,
	'iso' => 220 ,
	'fips' => "UGD2" ,
	'region' => "E"             
));

$district42 = District::create(array(
  'district' => "Kalungu" ,
	'hasc' => "UG.QA" ,
	'fips' => "UGF5" ,
	'region' => "C"             
));

$district43 = District::create(array(
  'district' => "Kampala" ,
	'hasc' => "UG.KM" ,
	'iso' => 102 ,
	'fips' => "UG37" ,
	'region' => "C"             
));

$district44 = District::create(array(
  'district' => "Kamuli" ,
	'hasc' => "UG.QU" ,
	'iso' => 205 ,
	'fips' => "UGA4" ,
	'region' => "E"             
));

$district45 = District::create(array(
  'district' => "Kamwenge" ,
	'hasc' => "UG.KE" ,
	'iso' => 413 ,
	'fips' => "UG81" ,
	'region' => "W"             
));

$district46 = District::create(array(
  'district' => "Kanungu" ,
	'hasc' => "UG.UU" ,
	'iso' => 414 ,
	'fips' => "UG82" ,
	'region' => "W"             
));

$district47 = District::create(array(
  'district' => "Kapchorwa" ,
	'hasc' => "UG.QP" ,
	'iso' => 206 ,
	'fips' => "UGA5" ,
	'region' => "E"             
));

$district48 = District::create(array(
  'district' => "Kasese" ,
	'hasc' => "UG.KS" ,
	'iso' => 406 ,
	'fips' => "UG40" ,
	'region' => "W"             
));

$district49 = District::create(array(
  'district' => "Katakwi" ,
	'hasc' => "UG.KK" ,
	'iso' => 207 ,
	'fips' => "UGA6" ,
	'region' => "E"             
));

$district50 = District::create(array(
  'district' => "Kayunga" ,
	'hasc' => "UG.KY" ,
	'iso' => 112 ,
	'fips' => "UG83" ,
	'region' => "C"             
));

$district51 = District::create(array(
  'district' => "Kibaale" ,
	'hasc' => "UG.KI" ,
	'iso' => 407 ,
	'fips' => "UG41" ,
	'region' => "W"             
));

$district52 = District::create(array(
  'district' => "Kiboga" ,
	'hasc' => "UG.QO" ,
	'iso' => 103 ,
	'fips' => "UG42" ,
	'region' => "C"             
));

$district53 = District::create(array(
  'district' => "Kibuku" ,
	'hasc' => "UG.QB" ,
	'fips' => "UGF6" ,
	'region' => "E"             
));

$district54 = District::create(array(
  'district' => "Kiruhura" ,
	'hasc' => "UG.KH" ,
	'iso' => 418 ,
	'fips' => "UGD3" ,
	'region' => "W"             
));

$district55 = District::create(array(
  'district' => "Kiryandongo" ,
	'hasc' => "UG.QD" ,
	'fips' => "UGF7" ,
	'region' => "W"             
));

$district56 = District::create(array(
  'district' => "Kisoro" ,
	'hasc' => "UG.KR" ,
	'iso' => 408 ,
	'fips' => "UG43" ,
	'region' => "W"             
));

$district57 = District::create(array(
  'district' => "Kitgum" ,
	'hasc' => "UG.QT" ,
	'iso' => 305 ,
	'fips' => "UG84" ,
	'region' => "N"             
));

$district58 = District::create(array(
  'district' => "Koboko" ,
	'hasc' => "UG.OK" ,
	'iso' => 316 ,
	'fips' => "UGD4" ,
	'region' => "N"             
));

$district59 = District::create(array(
  'district' => "Kole" ,
	'hasc' => "UG.QL" ,
	'fips' => "UGF8" ,
	'region' => "N"             
));

$district60 = District::create(array(
  'district' => "Kotido" ,
	'hasc' => "UG.KF" ,
	'iso' => 306 ,
	'fips' => "UGA7" ,
	'region' => "N"             
));

$district61 = District::create(array(
  'district' => "Kumi" ,
	'hasc' => "UG.QM" ,
	'iso' => 208 ,
	'fips' => "UG46" ,
	'region' => "E"             
));

$district62 = District::create(array(
  'district' => "Kween" ,
	'hasc' => "UG.QW" ,
	'fips' => "UGF9" ,
	'region' => "E"             
));

$district63 = District::create(array(
  'district' => "Kyankwanzi" ,
	'hasc' => "UG.QZ" ,
	'fips' => "UGG1" ,
	'region' => "C"             
));

$district64 = District::create(array(
  'district' => "Kyegegwa" ,
	'hasc' => "UG.QG" ,
	'fips' => "UGG2" ,
	'region' => "W"             
));

$district65 = District::create(array(
  'district' => "Kyenjojo" ,
	'hasc' => "UG.QJ" ,
	'iso' => 415 ,
	'fips' => "UG85" ,
	'region' => "W"             
));

$district66 = District::create(array(
  'district' => "Lamwo" ,
	'hasc' => "UG.LM" ,
	'fips' => "UGG3" ,
	'region' => "N"             
));

$district67 = District::create(array(
  'district' => "Lira" ,
	'hasc' => "UG.LL" ,
	'iso' => 307 ,
	'fips' => "UGA8" ,
	'region' => "N"             
));

$district68 = District::create(array(
  'district' => "Luuka" ,
	'hasc' => "UG.LK" ,
	'fips' => "UGG4" ,
	'region' => "E"             
));

$district69 = District::create(array(
  'district' => "Luweero" ,
	'hasc' => "UG.LW" ,
	'iso' => 104 ,
	'fips' => "UGA9" ,
	'region' => "C"             
));

$district70 = District::create(array(
  'district' => "Lwengo" ,
	'hasc' => "UG.LE" ,
	'fips' => "UGG5" ,
	'region' => "C"             
));

$district71 = District::create(array(
  'district' => "Lyantonde" ,
	'hasc' => "UG.LY" ,
	'iso' => 116 ,
	'fips' => "UGD5" ,
	'region' => "C"             
));

$district72 = District::create(array(
  'district' => "Manafwa" ,
	'hasc' => "UG.MW" ,
	'iso' => 221 ,
	'fips' => "UGD6" ,
	'region' => "E"             
));

$district73 = District::create(array(
  'district' => "Masaka" ,
	'hasc' => "UG.MQ" ,
	'iso' => 105 ,
	'fips' => "UG71" ,
	'region' => "C"             
));

$district74 = District::create(array(
  'district' => "Masindi" ,
	'hasc' => "UG.MZ" ,
	'iso' => 409 ,
	'fips' => "UG50" ,
	'region' => "W"             
));

$district75 = District::create(array(
  'district' => "Mayuge" ,
	'hasc' => "UG.MG" ,
	'iso' => 214 ,
	'fips' => "UG86" ,
	'region' => "E"             
));

$district76 = District::create(array(
  'district' => "Mbale" ,
	'hasc' => "UG.ME" ,
	'iso' => 209 ,
	'fips' => "UGB1" ,
	'region' => "E"             
));

$district77 = District::create(array(
  'district' => "Mbarara" ,
	'hasc' => "UG.RR" ,
	'iso' => 410 ,
	'fips' => "UGB2" ,
	'region' => "W"             
));

$district78 = District::create(array(
  'district' => "Mitooma" ,
	'hasc' => "UG.MM" ,
	'fips' => "UGG6" ,
	'region' => "W"             
));

$district79 = District::create(array(
  'district' => "Mityana" ,
	'hasc' => "UG.TY" ,
	'iso' => 114 ,
	'fips' => "UGD8" ,
	'region' => "C"             
));

$district80 = District::create(array(
  'district' => "Moroto" ,
	'hasc' => "UG.MX" ,
	'iso' => 308 ,
	'fips' => "UG88" ,
	'region' => "N"             
));

$district81 = District::create(array(
  'district' => "Moyo" ,
	'hasc' => "UG.MY" ,
	'iso' => 309 ,
	'fips' => "UGB3" ,
	'region' => "N"             
));

$district82 = District::create(array(
  'district' => "Mpigi" ,
	'hasc' => "UG.MJ" ,
	'iso' => 106 ,
	'fips' => "UG89" ,
	'region' => "C"             
));

$district83 = District::create(array(
  'district' => "Mubende" ,
	'hasc' => "UG.MD" ,
	'iso' => 107 ,
	'fips' => "UGB4" ,
	'region' => "C"             
));

$district84 = District::create(array(
  'district' => "Mukono" ,
	'hasc' => "UG.MV" ,
	'iso' => 108 ,
	'fips' => "UG90" ,
	'region' => "C"             
));

$district85 = District::create(array(
  'district' => "Nakapiripirit" ,
	'hasc' => "UG.NI" ,
	'iso' => 311 ,
	'fips' => "UG91" ,
	'region' => "N"             
));

$district86 = District::create(array(
  'district' => "Nakaseke" ,
	'hasc' => "UG.NK" ,
	'iso' => 115 ,
	'fips' => "UGD9" ,
	'region' => "C"             
));

$district87 = District::create(array(
  'district' => "Nakasongola" ,
	'hasc' => "UG.NA" ,
	'iso' => 109 ,
	'fips' => "UG73" ,
	'region' => "C"             
));

$district88 = District::create(array(
  'district' => "Namayingo" ,
	'hasc' => "UG.NY" ,
	'fips' => "UGG7" ,
	'region' => "E"             
));

$district89 = District::create(array(
  'district' => "Namutumba" ,
	'hasc' => "UG.BK" ,
	'iso' => 222 ,
	'fips' => "UGE1" ,
	'region' => "E"             
));

$district90 = District::create(array(
  'district' => "Napak" ,
	'hasc' => "UG.NQ" ,
	'fips' => "UGG8" ,
	'region' => "N"             
));

$district91 = District::create(array(
  'district' => "Nebbi" ,
	'hasc' => "UG.NB" ,
	'iso' => 310 ,
	'fips' => "UG58" ,
	'region' => "N"             
));

$district92 = District::create(array(
  'district' => "Ngora" ,
	'hasc' => "UG.NR" ,
	'fips' => "UGG9" ,
	'region' => "E"             
));

$district93 = District::create(array(
  'district' => "Ntoroko" ,
	'hasc' => "UG.NO" ,
	'fips' => "UGH1" ,
	'region' => "W"             
));

$district94 = District::create(array(
  'district' => "Ntungamo" ,
	'hasc' => "UG.NT" ,
	'iso' => 411 ,
	'fips' => "UG59" ,
	'region' => "W"             
));

$district95 = District::create(array(
  'district' => "Nwoya" ,
	'hasc' => "UG.NW" ,
	'fips' => "UGH2" ,
	'region' => "N"             
));

$district96 = District::create(array(
  'district' => "Maracha" ,
	'hasc' => "UG.MH" ,
	'iso' => 320 ,
	'fips' => "UGD7" ,
	'region' => "N"             
));

$district97 = District::create(array(
  'district' => "Otuke" ,
	'hasc' => "UG.OT" ,
	'fips' => "UGH3" ,
	'region' => "N"             
));

$district98 = District::create(array(
  'district' => "Oyam" ,
	'hasc' => "UG.OY" ,
	'iso' => 321 ,
	'fips' => "UGE2" ,
	'region' => "N"             
));

$district99 = District::create(array(
  'district' => "Pader" ,
	'hasc' => "UG.PR" ,
	'iso' => 312 ,
	'fips' => "UG92" ,
	'region' => "N"             
));

$district100 = District::create(array(
  'district' => "Pallisa" ,
	'hasc' => "UG.PS" ,
	'iso' => 210 ,
	'fips' => "UGB5" ,
	'region' => "E"             
));

$district101 = District::create(array(
  'district' => "Rakai" ,
	'hasc' => "UG.RI" ,
	'iso' => 110 ,
	'fips' => "UG61" ,
	'region' => "C"             
));

$district102 = District::create(array(
  'district' => "Rubirizi" ,
	'hasc' => "UG.RZ" ,
	'fips' => "UGH4" ,
	'region' => "W"             
));

$district103 = District::create(array(
  'district' => "Rukungiri" ,
	'hasc' => "UG.RK" ,
	'iso' => 412 ,
	'fips' => "UG93" ,
	'region' => "W"             
));

$district104 = District::create(array(
  'district' => "Sembabule" ,
	'hasc' => "UG.SE" ,
	'iso' => 111 ,
	'fips' => "UG74" ,
	'region' => "C"             
));

$district105 = District::create(array(
  'district' => "Serere" ,
	'hasc' => "UG.SX" ,
	'fips' => "UGH5" ,
	'region' => "E"             
));

$district106 = District::create(array(
  'district' => "Sheema" ,
	'hasc' => "UG.SH" ,
	'fips' => "UGH6" ,
	'region' => "W"             
));

$district107 = District::create(array(
  'district' => "Sironko" ,
	'hasc' => "UG.SK" ,
	'iso' => 215 ,
	'fips' => "UG94" ,
	'region' => "E"             
));

$district108 = District::create(array(
  'district' => "Soroti" ,
	'hasc' => "UG.ST" ,
	'iso' => 211 ,
	'fips' => "UG95" ,
	'region' => "E"             
));

$district109 = District::create(array(
  'district' => "Tororo" ,
	'hasc' => "UG.TR" ,
	'iso' => 212 ,
	'fips' => "UG76" ,
	'region' => "E"             
));

$district110 = District::create(array(
  'district' => "Wakiso" ,
	'hasc' => "UG.WA" ,
	'iso' => 113 ,
	'fips' => "UG96" ,
	'region' => "C"             
));

$district111 = District::create(array(
  'district' => "Yumbe" ,
	'hasc' => "UG.YU" ,
	'iso' => 313 ,
	'fips' => "UG97" ,
	'region' => "N"             
));

$district112 = District::create(array(
  'district' => "Zombo" ,
	'hasc' => "UG.ZO" ,
	'fips' => "UGH7" ,
	'region' => "N"             
));

$code1 = Code::create(array(
  'description1' => "Approved" ,
	'dropdown_list' => "decision"             
));

$code2 = Code::create(array(
  'description1' => "Rejected" ,
	'dropdown_list' => "decision"             
));

$code3 = Code::create(array(
  'description1' => "Disregarded" ,
	'dropdown_list' => "decision"             
));

$code4 = Code::create(array(
  'description1' => "Re-submitted" ,
	'dropdown_list' => "submission"             
));

$code5 = Code::create(array(
  'description1' => "Final submission" ,
	'dropdown_list' => "submission"             
));

$code6 = Code::create(array(
  'description1' => "Considered for EIA" ,
	'dropdown_list' => "consequence"             
));

$code7 = Code::create(array(
  'description1' => "Likely exemptet from EIA" ,
	'dropdown_list' => "consequence"             
));

$code8 = Code::create(array(
  'description1' => "PB" ,
	'description2' => "Project Briefs" ,
	'value1' => 21 ,
	'dropdown_list' => "project_type"             
));

$code9 = Code::create(array(
  'description1' => "EIATOR" ,
	'description2' => "TORs for EIA" ,
	'value1' => 14 ,
	'dropdown_list' => "project_type"             
));

$code10 = Code::create(array(
  'description1' => "EIA" ,
	'description2' => "EIA Reports" ,
	'value1' => 30 ,
	'dropdown_list' => "project_type"             
));

$code11 = Code::create(array(
  'description1' => "EATOR" ,
	'description2' => "TOR for EA" ,
	'value1' => 14             
));

$code12 = Code::create(array(
  'description1' => "EA" ,
	'description2' => "Audit Reports" ,
	'value1' => 21             
));

$code13 = Code::create(array(
  'description1' => "App. forms" ,
	'description2' => "Application forms"             
));

$code14 = Code::create(array(
  'description1' => "Other"             
));

$code15 = Code::create(array(
  'description1' => "PB received" ,
	'dropdown_list' => "eia_status"             
));

$code16 = Code::create(array(
  'description1' => "PB sent to DED" ,
	'dropdown_list' => "eia_status"             
));

$code17 = Code::create(array(
  'description1' => "PB sent to EIAC" ,
	'dropdown_list' => "eia_status"             
));

$code18 = Code::create(array(
  'description1' => "PB assigned" ,
	'dropdown_list' => "eia_status"             
));

$code19 = Code::create(array(
  'description1' => "PB sent to LA" ,
	'dropdown_list' => "eia_status"             
));

$code20 = Code::create(array(
  'description1' => "PB conclusion" ,
	'dropdown_list' => "eia_status"             
));

$code21 = Code::create(array(
  'description1' => "TOR received" ,
	'dropdown_list' => "eia_status"             
));

$code22 = Code::create(array(
  'description1' => "TOR sent to DED" ,
	'dropdown_list' => "eia_status"             
));

$code23 = Code::create(array(
  'description1' => "TOR sent to EIAC" ,
	'dropdown_list' => "eia_status"             
));

$code24 = Code::create(array(
  'description1' => "TOR assigned" ,
	'dropdown_list' => "eia_status"             
));

$code25 = Code::create(array(
  'description1' => "TOR sent to LA" ,
	'dropdown_list' => "eia_status"             
));

$code26 = Code::create(array(
  'description1' => "TOR conclusion" ,
	'dropdown_list' => "eia_status"             
));

$code27 = Code::create(array(
  'description1' => "EIS received" ,
	'dropdown_list' => "eia_status"             
));

$code28 = Code::create(array(
  'description1' => "EIS sent to DED" ,
	'dropdown_list' => "eia_status"             
));

$code29 = Code::create(array(
  'description1' => "EIS sent to EIAC" ,
	'dropdown_list' => "eia_status"             
));

$code30 = Code::create(array(
  'description1' => "EIS assigned" ,
	'dropdown_list' => "eia_status"             
));

$code31 = Code::create(array(
  'description1' => "EIS sent to LA" ,
	'dropdown_list' => "eia_status"             
));

$code32 = Code::create(array(
  'description1' => "Project Recomondations ready" ,
	'dropdown_list' => "eia_status"             
));

$code33 = Code::create(array(
  'description1' => "Project Decision" ,
	'dropdown_list' => "eia_status"             
));

$code34 = Code::create(array(
  'description1' => "Invoiced" ,
	'dropdown_list' => "eia_status"             
));

$code35 = Code::create(array(
  'description1' => "Invoice paid" ,
	'dropdown_list' => "eia_status"             
));

$code36 = Code::create(array(
  'description1' => "Cert. issued" ,
	'dropdown_list' => "eia_status"             
));

$code37 = Code::create(array(
  'description1' => "Cert. cancelled" ,
	'dropdown_list' => "eia_status"             
));

$category1 = Category::create(array(
  'Id' => 1 ,
	'description_long' => " Education Facility" ,
	'consequence' => "Considered for EIA"             
));

$category2 = Category::create(array(
  'Id' => 2 ,
	'description_long' => " Energy Production / Distribution" ,
	'consequence' => "Considered for EIA"             
));

$category3 = Category::create(array(
  'Id' => 3 ,
	'description_long' => " Fuel Station" ,
	'consequence' => "Considered for EIA"             
));

$category4 = Category::create(array(
  'Id' => 4 ,
	'description_long' => " Information & Communications Technology" ,
	'consequence' => "Considered for EIA"             
));

$category5 = Category::create(array(
  'Id' => 5 ,
	'description_long' => " Infrastructure - Roads, Housing, Renovations" ,
	'consequence' => "Considered for EIA"             
));

$category6 = Category::create(array(
  'Id' => 6 ,
	'description_long' => " Land-Use Change, Forestry, Agriculture, Livestock" ,
	'consequence' => "Considered for EIA"             
));

$category7 = Category::create(array(
  'Id' => 7 ,
	'description_long' => " Minerals, Mining, Quarry" ,
	'consequence' => "Considered for EIA"             
));

$category8 = Category::create(array(
  'Id' => 8 ,
	'description_long' => " Miscellaneous Assessments - Policy, Plan, Programme" ,
	'consequence' => "Considered for EIA"             
));

$category9 = Category::create(array(
  'Id' => 9 ,
	'description_long' => " Oil and Gas" ,
	'consequence' => "Considered for EIA"             
));

$category10 = Category::create(array(
  'Id' => 10 ,
	'description_long' => " Pest, Vector, Disease Control" ,
	'consequence' => "Considered for EIA"             
));

$category11 = Category::create(array(
  'Id' => 11 ,
	'description_long' => " Processing, Manufacturing Industry" ,
	'consequence' => "Considered for EIA"             
));

$category12 = Category::create(array(
  'Id' => 12 ,
	'description_long' => " Waste Management and Infrastructure" ,
	'consequence' => "Considered for EIA"             
));

$category13 = Category::create(array(
  'Id' => 13 ,
	'description_long' => " Water Supply Systems and Sanitation" ,
	'consequence' => "Considered for EIA"             
));

$category14 = Category::create(array(
  'Id' => 14 ,
	'description_long' => " Water Resources, Wetlands, Fisheries Management" ,
	'consequence' => "Considered for EIA"             
));

$category15 = Category::create(array(
  'Id' => 15 ,
	'description_long' => " Wildlife, Hotels, Leisure, Tourism Facility" ,
	'consequence' => "Considered for EIA"             
));

$category16 = Category::create(array(
  'Id' => 16 ,
	'description_long' => "Clearing and farm construction for individual subsistence smal farms" ,
	'consequence' => "Likely exemptet from EIA"             
));

$category17 = Category::create(array(
  'Id' => 17 ,
	'description_long' => "Construction or repair of individual houses" ,
	'consequence' => "Likely exemptet from EIA"             
));

$category18 = Category::create(array(
  'Id' => 18 ,
	'description_long' => "Minor land use changes in area with slopes less than 20 % including housing construction" ,
	'consequence' => "Likely exemptet from EIA"             
));

$category19 = Category::create(array(
  'Id' => 19 ,
	'description_long' => "Information collection (scientific or educational) exept if it involves use of chemicals or endangered species or alien materials" ,
	'consequence' => "Likely exemptet from EIA"             
));

$category20 = Category::create(array(
  'Id' => 20 ,
	'description_long' => "Transfer of ownership of land or related facilities so long as the general character of the area is not changed" ,
	'consequence' => "Likely exemptet from EIA"             
));

$category21 = Category::create(array(
  'Id' => 21 ,
	'description_long' => "Environmental enforcement actions" ,
	'consequence' => "Likely exemptet from EIA"             
));

$category22 = Category::create(array(
  'Id' => 22 ,
	'description_long' => "Emergency repairs to facilities within the character of its surroundings" ,
	'consequence' => "Likely exemptet from EIA"             
));

$practitioner1 = Practitioner::create(array(
  'person' => "Mr. Advan MBABAZI " ,
	'organisation_name' => "Advann Uganda Limited" ,
	'visiting_address' => "Nsambya-Avemaria, Off Kevina Road" ,
	'box_no' => "P.O. Box 1539 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0784992264 and 0704323993" ,
	'email' => " madvan.m@gmail.com ; advannuganda@gmail.com " ,
	'qualifications' => "B. Environmental Science " ,
	'expertise' => "Fuel Stations, Communication Masts, Waste Management, Mining Projects,"             
));

$practitioner2 = Practitioner::create(array(
  'person' => "Eng. Lammeck KAJUBI" ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712 403357 and 0782580480" ,
	'email' => " l.kajubi@awe-engineers.com " ,
	'qualifications' => "MEngSc. Environmental Engineering; BSc. Agricultural Engineering (Soil & Water)" ,
	'expertise' => "Air Pollution Engineering; Wastewater Engineering; Solid waste; Hydropower, Medical Waste, Noise Pollution; Cleaner Production; Risk Assessment; Occupational Safety & Health; Clean Development Mechanism (CDM); GIS; Strategic Environmental Assessment .  "             
));

$practitioner3 = Practitioner::create(array(
  'person' => "Mr. Herbert Mpagi KALIBALA" ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772496451" ,
	'email' => "  h.kalibbala@awe-ngineers.com " ,
	'qualifications' => "MSc. Civil Engineering, BSc. Civil Engineering" ,
	'expertise' => "Hydropower, Sanitation, Water Quality Management & Pollution Control; Designing Water & Wastewater Treatment Systems, roads and highways, Hydrology and Hydrogeology, Geotechnical Surveys. "             
));

$practitioner4 = Practitioner::create(array(
  'person' => "Dr. Isa KABENGE" ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772377172" ,
	'email' => "  i.kabenge@awe-engineers.com;isakabenge@gmail.com " ,
	'qualifications' => "PhD. Biological Systems Engineering, Master of Agricultural Engineering, BSc. Agricultural Engineering" ,
	'expertise' => "Water/Waste Water and Sanitation, GIS, Hydrological  Analysis and Surveys, Irrigation schemes, Hydro power, Soil Conservation, Strategic environmental Assessments, Air quality and EMS"             
));

$practitioner5 = Practitioner::create(array(
  'person' => "Ms. Pamela. K. TASHOBYA " ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0414 268466" ,
	'email' => " mail@awe-engineers.com " ,
	'qualifications' => "MSc. Development Management; BA. Environmental Management  " ,
	'expertise' => "Social Impact Assessment; Waste Management; Public & Occupational Health Risk Assessment."             
));

$practitioner6 = Practitioner::create(array(
  'person' => "Ms. Faith MUGERWA" ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782716542" ,
	'email' => " faithmugerwa@yahoo.co.uk " ,
	'qualifications' => "BA Sociology, " ,
	'expertise' => "Social Impact Assessment (SIA), Resettlement Action Plan (RAP) Social Planning, Sociology of Health, Urban Planning "             
));

$practitioner7 = Practitioner::create(array(
  'person' => "Mr. Ben David OYEN" ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772196033 and 0700945694" ,
	'email' => " oyenben@yahoo.com ; oyen.ben@gmail.com " ,
	'qualifications' => "BSc. In Environmental Engineering and Management" ,
	'expertise' => "Cleaner Production, Occupational Health and Safety Site Remediation, Environmental Monitoring &Analysis; and Structural Engineering Designs of Waste Management Systems"             
));

$practitioner8 = Practitioner::create(array(
  'person' => "MS. Ritah NABAGALLA" ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772693630 and 0704154674" ,
	'email' => " ritahnabaggala@yahoo.com ; r.nabaggala@awe-engineers.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Social Impact Assessment, Ressettlement Action Plans, Environmental Sensitisation,"             
));

$practitioner9 = Practitioner::create(array(
  'person' => "Eng. Lammeck KAJUBI" ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712 403357 and 0782580480" ,
	'email' => " l.kajubi@awe-engineers.com " ,
	'qualifications' => "MEngSc. Environmental Engineering; BSc. Agricultural Engineering (Soil & Water)" ,
	'expertise' => "Air Pollution Engineering; Wastewater Engineering; Solid waste; Hydropower, Medical Waste, Noise Pollution; Cleaner Production; Risk Assessment; Occupational Health & Safety; Clean Development Mechanism (CDM); GIS; Strategic Environmental Assessment. "             
));

$practitioner10 = Practitioner::create(array(
  'person' => "Mr. Herbert Mpagi KALIBALA" ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772496451" ,
	'email' => "   h.kalibbala@awe-ngineers.com " ,
	'qualifications' => "MSc. Civil Engineering, BSc. Civil Engineering" ,
	'expertise' => "Hydropower, Sanitation, Water Quality Management & Pollution Control; Designing Water & Wastewater Treatment Systems, Roads and Highways, Hydrology and Hydrogeology, Strategic Environmental Assessment Geotechnical Surveys. "             
));

$practitioner11 = Practitioner::create(array(
  'person' => "Dr. Isa KABENGE" ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772377172" ,
	'email' => "  isakabenge@gmail.com ; i.kabenge@awe-engineers.com " ,
	'qualifications' => "PhD. Biological Systems Engineering, Master of Agricultural Engineering, BSc. Agricultural Engineering" ,
	'expertise' => "Water/Waste Water and Sanitation, GIS, Hydrological  Analysis and Surveys, Irrigation schemes, Hydro power, Soil Conservation, Strategic environmental Assessments, Air quality and EMS"             
));

$practitioner12 = Practitioner::create(array(
  'person' => "Ms. Pamela. K. TASHOBYA " ,
	'organisation_name' => "Air, Water Earth (AWE) Ltd." ,
	'visiting_address' => "27, Binayomba Road, Bugolobi" ,
	'box_no' => "P.O. Box 22428" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0414 268466" ,
	'email' => " mail@awe-engineers.com " ,
	'qualifications' => "MSc. Development Management; BA. Environmental Management  " ,
	'expertise' => "Strategic and Environmental and Social Impact Assessment, Waste Management, Public and Ocupational Health Risk Assessments"             
));

$practitioner13 = Practitioner::create(array(
  'person' => "Mr. Alex KAGODA " ,
	'organisation_name' => "Arc Design Ltd" ,
	'visiting_address' => "Plot 85, Buganda Road; " ,
	'box_no' => "P.O. Box 22946" ,
	'city' => "Kampala" ,
	'phone' => "Mob: 0774 404052" ,
	'email' => " kagodalex@gmail.com " ,
	'qualifications' => "BSc. Industrial Chemistry" ,
	'expertise' => "Occupational Health and Safety; Environmental Pollution Assessment"             
));

$practitioner14 = Practitioner::create(array(
  'person' => "Mr. Dismas Jacob ONGWEN" ,
	'organisation_name' => "Archio- Heritage Consultancy " ,
	'box_no' => "P.O. Box 33334" ,
	'city' => "Kampala" ,
	'phone' => "Tel:0772970991" ,
	'email' => " dis3ongwen@gmail.com " ,
	'qualifications' => "M. Phil in Archaeology, BA.  History/Philosophy" ,
	'expertise' => "Archiological and Physical Culture,"             
));

$practitioner15 = Practitioner::create(array(
  'person' => "Mr. Robert Charles AGUMA" ,
	'organisation_name' => "ASRDEM  Ltd." ,
	'box_no' => "P.O. Box 22609" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772-380340" ,
	'email' => " robertaguma@yahoo.com " ,
	'qualifications' => "MSc. GIS & Earth Observation (Forestry for Sustainable Development)" ,
	'expertise' => "Agriculture and Forestry; Natural Resource Management; Environmental Management; Waste Management "             
));

$practitioner16 = Practitioner::create(array(
  'person' => "Mr. Robert Charles AGUMA" ,
	'organisation_name' => "ASRDEM  Ltd." ,
	'box_no' => "P.O. Box 22609" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772-380340" ,
	'email' => " robertaguma@yahoo.com" ,
	'qualifications' => "MSc. GIS & Earth Observation (Forestry for Sustainable Development)  BSc. Forestry." ,
	'expertise' => "Forestry, Tourism, Mining, Energy, and Water Resources auditing,"             
));

$practitioner17 = Practitioner::create(array(
  'person' => "Mr. Edgar D. Kamugasha MUGISHA " ,
	'organisation_name' => "Atacama Consulting, " ,
	'visiting_address' => "Plot 23 Gloucester Avenue" ,
	'box_no' => "P.O. Box 12130 " ,
	'city' => "Kyambogo, " ,
	'phone' => "Tel: 0752-998545 (Mobile) OR 0751-090752 (Office)" ,
	'email' => " edgarmugisha@atacama.co.ug ; edgarmugisha@yahoo.com  " ,
	'qualifications' => "MSc. Environmental Assessment & Management; BSc. Environmental Management" ,
	'expertise' => "Environmental Management Systems (ISO 14001) and Auditing; Occupational Health and Safety; Climate Change Services (Emissions Reduction and Carbon Trading); Oil & Gas, Natural Resource Management; Cleaner Production Assessments; Waste Management; Land Use Planning; and Sustainable Tourism. "             
));

$practitioner18 = Practitioner::create(array(
  'person' => "Ms. Juliana KEIRUNGI" ,
	'organisation_name' => "Atacama Consulting, " ,
	'visiting_address' => "Plot 23 Gloucester Avenue" ,
	'box_no' => "P.O. Box 12130" ,
	'city' => "Kyambogo," ,
	'phone' => "Tel: 0701-553642 (Mobile)  OR 0751-090752 (Office)   " ,
	'email' => "  keirungi@yahoo.com ; julianakeirungi@atacama.co.ug   " ,
	'qualifications' => "MSc. Environmental Science; BScH. Environmental Science" ,
	'expertise' => "Industrial and Municipal Wastewater Management; Wastewater Treatment Plant Design; Community Based Natural Resource Management; Zoology; Resource Economics; Mine Assessments."             
));

$practitioner19 = Practitioner::create(array(
  'person' => "Mr. Edgar D. Kamugasha MUGISHA" ,
	'organisation_name' => "Atacama Consulting, " ,
	'visiting_address' => "Plot 23 Gloucester Avenue" ,
	'box_no' => "P.O. Box 12130 " ,
	'city' => "Kyambogo, " ,
	'phone' => "Tel: 0752-998545 (Mobile) OR  0751-090752 (Office)" ,
	'email' => " edgarmugisha@yahoo.com ; edgarmugisha@atacama.co.ug" ,
	'qualifications' => "MSc. Environmental Assessment & Management; BSc. Environmental Management" ,
	'expertise' => "Environmental Management Systems (ISO 14001) and Auditing; Occupational Health and Safety; Climate Change Services (Emissions Reduction and Carbon Trading); Natural Resource Mgt. Cleaner Production Assessments; Waste Management; Land Use Planning; and Sustainable Tourism"             
));

$practitioner20 = Practitioner::create(array(
  'person' => "Ms. Juliana KEIRUNGI " ,
	'organisation_name' => "Atacama Consulting, " ,
	'visiting_address' => "Plot 23 Gloucester Avenue" ,
	'box_no' => "P.O. Box 12130 " ,
	'city' => "Kyambogo," ,
	'phone' => "Tel: 0701-553642 (Mobile)  OR 0751-090752 (Office) " ,
	'email' => "  keirungi@yahoo.com ; julianakeirungi@atacama.co.ug   " ,
	'qualifications' => "MSc. Environmental Science ; BScH. Environmental Science ; " ,
	'expertise' => "Mining, Highway/ Road Developments, Renewable Energy, Oil and Gas, Biofuels Development, Water & Sanitation Projects, Waste Management , Industrial and Municipal Wastewater Management  "             
));

$practitioner21 = Practitioner::create(array(
  'person' => "Ms. Olive TURYAMUREEBA" ,
	'organisation_name' => "Atek Projects (U) Ltd " ,
	'visiting_address' => "UMA Show Grounds, Bell Building Unit 3, Plot 28-29 Coronation Street" ,
	'box_no' => "P.O. Box 5211 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712635230; 414692920" ,
	'email' => " turyamureba@yahoo.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Waste Management; Aquatic and Water Resources Management; Wetland Resources Management; Land-Use Planning and Management; "             
));

$practitioner22 = Practitioner::create(array(
  'person' => "Ms. Olive TURYAMUREEBA" ,
	'organisation_name' => "Atek Projects (U) Ltd " ,
	'visiting_address' => "UMA Show Grounds, Bell Building Unit 3, Plot 28-29 Coronation Street" ,
	'box_no' => "P.O. Box 5211 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712635230; 414692920" ,
	'email' => " turyamureba@yahoo.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Environmental Auditing; Waste Management; Aquatic and Water Resources Management; Wetland Resources Management;"             
));

$practitioner23 = Practitioner::create(array(
  'person' => "Ms. Juliet Kintu NANSIKOMBI " ,
	'organisation_name' => "Bimco Consult Ltd" ,
	'box_no' => "P.O. Box 75383" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256 771 400485/ 701400485 " ,
	'email' => " julie.kintn@uaia.ug  ; Juliek.nansikombi@gmail.com " ,
	'qualifications' => "MSc. Conservation Biology; " ,
	'expertise' => "Ecology, Biodiversity Studies, Ornithology, Agricultural Developments, Food Processing and Manufacturing, Eco Technology Projects, telecommunication masts"             
));

$practitioner24 = Practitioner::create(array(
  'person' => "Mr. Joshua Kaliba KATALIMULINGO" ,
	'organisation_name' => "BIMCO Consult Ltd" ,
	'visiting_address' => "Plot 17 Kakungulu Road Ntinda" ,
	'box_no' => "P.O. Box 75383" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256774260204" ,
	'email' => " joshkaliba@yahoo.com ; joshkaliba@gmail.com" ,
	'qualifications' => "Bachelor of Environmental Science Technology and Management" ,
	'expertise' => "Occupational Health and safety, Environmental Processing Technology, Water and Waste water treatment, Environmental Quality Management"             
));

$practitioner25 = Practitioner::create(array(
  'person' => "Mr. Moses OTIM " ,
	'organisation_name' => "Bimco Consult Ltd" ,
	'visiting_address' => "(off Luthuli Avenue), Plot 23 B, Bandali Rise" ,
	'box_no' => "P.O. Box 35209" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256-256 312 114891; Mobile: 0701-912870; 0392 944844" ,
	'email' => " bimco@bimco.co.ug  ; m_otim@hotmail.com  ;  teepgis@yahoo.com " ,
	'qualifications' => "MSc. Geo information Science & Earth Observation; MSc. Educational & Training Systems Design;" ,
	'expertise' => "Industry Development Planning, Waste Management, OSH & Environmental Management Systems; Mineral Resources Evaluation, Metallurgy & Environmental Geology; Water Resources and Water Quality Assessment, Eco-hydrology; Spatial Analysis & Modelling, Oil and Gas exploration and developments, downstream petroleum developments, Hydropower projects"             
));

$practitioner26 = Practitioner::create(array(
  'person' => "Ms. Hanifah N. LUBEGA" ,
	'organisation_name' => "Bimco Consult Ltd" ,
	'box_no' => "P.O. Box 35209" ,
	'city' => "Kampala" ,
	'phone' => "Mobile: 0783655211 and 0704642827" ,
	'email' => " ls_hanny@yahoo.com " ,
	'qualifications' => "B.Eng. Environmental Engineering." ,
	'expertise' => "Occupational Health and Safety, Industrial Developments, Environmental Engineering Systems, Energy Developments, Water Resources and Waste Water Treatment Projects, Cleaner Production Assessments and Clean Development Mechanisms"             
));

$practitioner27 = Practitioner::create(array(
  'person' => "Juliet Kintu NANSIKOMBI" ,
	'organisation_name' => "BIMCO Consult Ltd" ,
	'visiting_address' => "Plot 17 Kakungulu Road Ntinda" ,
	'box_no' => "P.O. Box 75383" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256 771 400485/ 701400485 " ,
	'email' => " jnansie@yahoo.com; ; Juliet.nansikombi@gmail.com" ,
	'qualifications' => "MSc. Conservation Biology; BSc Botany & Zoology" ,
	'expertise' => "Ecology, Biodiversity Studies, Ornithology"             
));

$practitioner28 = Practitioner::create(array(
  'person' => "Mr. Joshua Kaliba KATALIMULINGO" ,
	'organisation_name' => "BIMCO Consult Ltd" ,
	'visiting_address' => "Plot 17 Kakungulu Road Ntinda" ,
	'box_no' => "P.O. Box 75383" ,
	'city' => "Kampala" ,
	'phone' => "Mob:  +256774260204" ,
	'email' => " joshkaliba@yahoo.com & joshkaliba@gmail.com " ,
	'qualifications' => "Bachelor of Environmental Science Technology and Management" ,
	'expertise' => "Occupational Health and safety, Environmental Processing Technology, Water and Waste water treatment, Environmental Quality Management"             
));

$practitioner29 = Practitioner::create(array(
  'person' => "Mr. Moses OTIM " ,
	'organisation_name' => "Bimco Consult Ltd" ,
	'visiting_address' => "(off Luthuli Avenue), Plot 23 B, Bandali Rise" ,
	'box_no' => "P.O. Box 35209" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256-256 312 114891 Mobile:  0701-912870; 0392 944844" ,
	'email' => " bimco@bimco.co.ug  ; m_otim@hotmail.com  ;  teepgis@yahoo.com " ,
	'qualifications' => "MSc. Geo information Science & Earth Observation; MSc. Educational & Training Systems Design;" ,
	'expertise' => "Industrial developments; Environmental Management Systems; Energy and Telecommunications Projects; Mineral Resources Evaluation; Metallurgy; Water Resources and Quality Assessment; Spatial Analysis and Environmental Modelling; Hydropower projects and facilities, energy audits, downstream petroleum facilities"             
));

$practitioner30 = Practitioner::create(array(
  'person' => "Ms. Hanifah N. LUBEGA" ,
	'organisation_name' => "Bimco Consult Ltd" ,
	'box_no' => "P.O. Box 35209" ,
	'city' => "Kampala" ,
	'phone' => "Mobile: 0783655211 and 0704642827" ,
	'email' => " ls_hanny@yahoo.com " ,
	'qualifications' => "B.Eng. Environmental Engineering." ,
	'expertise' => "Occupational Health and Safety, Industrial Developments, Environmental Engineering Systems, Energy Developments, Water Resources and Waste Water Treatment Projects, Cleaner Production Assessments and Clean Development Mechanisms"             
));

$practitioner31 = Practitioner::create(array(
  'person' => "Ms. Apophia ATUKUNDA" ,
	'organisation_name' => "Chantalle Solutions" ,
	'visiting_address' => "Plot 1272, Nsambya-Ggaba Road," ,
	'box_no' => "P.O. Box 23020" ,
	'city' => "Kampala" ,
	'phone' => "Mobile:  0702 98 71 14; Office:   0414 53 21 92" ,
	'email' => "   apophiaa@yahoo.co.uk" ,
	'qualifications' => "MSc. Agriculture (Agroforestry);BSc. Forestry" ,
	'expertise' => "Protected Area Management; Biodiversity Conservation, Forestry Management, Agricultural Development Projects"             
));

$practitioner32 = Practitioner::create(array(
  'person' => "Ms. Patricia ONEGA" ,
	'organisation_name' => "COWI Uganda Ltd." ,
	'visiting_address' => "Crusader House, 2nd Floor, Plot No. 3, Portal Avenue " ,
	'box_no' => "P.O. Box 10591" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782922422" ,
	'email' => " pao@cowi.co.ug ; pattyonega@yahoo.co.uk" ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Infrastructural Assessments and Social Impact Assessments"             
));

$practitioner33 = Practitioner::create(array(
  'person' => "Dr. Rose MUGIDDE" ,
	'organisation_name' => "COWI Uganda Ltd." ,
	'visiting_address' => "Crusader House, 2nd Floor, Plot No. 3, Portal Avenue " ,
	'box_no' => "P.O. Box 10591" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256 775 739538" ,
	'email' => " mugidde@yahoo.com " ,
	'qualifications' => "PhD. (Biology); BSc. Zoology (Wildlife and Ecology)" ,
	'expertise' => "Toxicology, Aquatic environments’ evaluation, GIS, water resources, and water quality monitoring & evaluation"             
));

$practitioner34 = Practitioner::create(array(
  'person' => "Mr. Bernard OCHOLA" ,
	'organisation_name' => "COWI Uganda Ltd." ,
	'visiting_address' => "Crusader House, 2nd Floor, Plot No. 3, Portal Avenue " ,
	'box_no' => "P.O. Box 10591" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0414 343 045  Mob: 0772660279" ,
	'email' => " benochola2003@yahoo.com " ,
	'qualifications' => "BA. Social Sciences – Sociology and Social Administration" ,
	'expertise' => "Social Impact Assessments and Resettlement Action Planning  "             
));

$practitioner35 = Practitioner::create(array(
  'person' => "Dr. Muhammad NTALE" ,
	'organisation_name' => "Department of Chemistry " ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0414540992, Mob: 0392967223" ,
	'email' => " muhntale@yahoo.co.uk " ,
	'qualifications' => "PhD In Analytical Chemistry, MSc. (Analytical Chemistry), BSc. (Chemistry) " ,
	'expertise' => "Environmental Auditing, Environmental Chemistry, Solid waste management and Cleaner Production"             
));

$practitioner36 = Practitioner::create(array(
  'person' => "Dr.  Charles B. NIWAGABA " ,
	'organisation_name' => "Department of Civil Engineering" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: Office: 0414-543152; Mobile:      0772-335477" ,
	'email' => "  cniwagaba@tech.mak.ac.ug ; cbniwagaba@yahoo.co.uk " ,
	'qualifications' => "PhD. in Environmental Engineering; MSc. Environmental Engineering; BSc. Civil Engineering." ,
	'expertise' => "Water and waste water Management; Civil Works and Construction; and Road works."             
));

$practitioner37 = Practitioner::create(array(
  'person' => "Dr. Paul Kijobo MUSALI" ,
	'organisation_name' => "Department of Geography" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062 " ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256 772 491083; Mob : 0772 347854; Tel: : 0414 530686 ; " ,
	'email' => " rogo966@yahoo.co.uk ; muspal@arts.mak.ac.ug   " ,
	'qualifications' => "PhD.  Natural Resource Management; BA. Geography" ,
	'expertise' => "Natural Resource Assessment, Land-use Planning/ Agriculture, Infrastructural Development, Biodiversity Planning, Waste Management Socio-Economic Assessments, Housing & Estate Development."             
));

$practitioner38 = Practitioner::create(array(
  'person' => "Dr. Paul Kijobo MUSALI" ,
	'organisation_name' => "Department of Geography" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062 " ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256 772 491083" ,
	'email' => " rogo966@yahoo.co.uk ; muspal@arts.mak.ac.ug   " ,
	'qualifications' => "PhD.  Natural Resource Management; BA. Geography" ,
	'expertise' => "Natural Resource Assessment, Land-use Planning/ Agriculture, Infrastructural Development, Biodiversity Planning, Waste Management Socio-Economic Assessments, Housing & Estate Development."             
));

$practitioner39 = Practitioner::create(array(
  'person' => "Dr. Andrew MUWANGA" ,
	'organisation_name' => "Department of Geology" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062" ,
	'city' => "Kampala" ,
	'phone' => "Tel: Office: 0414-541258;    Mob: 0712 803 362 " ,
	'email' => " amuwanga@sci.mak.ac.ug  " ,
	'qualifications' => "PhD. Environmental Geology; BSc. Geology & Chemistry" ,
	'expertise' => "Geology; Mining; Hydrogeological Projects; Stone Quarrying; Water Quality Assessment & Monitoring; Assessment of natural hazards (e.g. landslides)"             
));

$practitioner40 = Practitioner::create(array(
  'person' => "Dr. Andrew MUWANGA" ,
	'organisation_name' => "Department of Geology" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: Office: 0414-541258; Mob: 0712 803 362" ,
	'email' => " amuwanga@sci.mak.ac.ug " ,
	'qualifications' => "PhD. Environmental Geology; MSc. Engineering Geology; BSc. Geology Chemistry" ,
	'expertise' => "Mining, Oil and Gas Exploration; Natural Disasters, Hydrogeoloy, Water Pollution, Environmental Restoration"             
));

$practitioner41 = Practitioner::create(array(
  'person' => "Ms. Esther Kalule NANFUKA " ,
	'organisation_name' => "Department of Social Work & Social Administration" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 484265" ,
	'email' => " nanfuka@ss.mak.ac.ug  ; esthernanfuka@yahoo.com" ,
	'qualifications' => "Master of Arts in Social Sector Planning and Management, " ,
	'expertise' => "Social Impact  Assessment ; Socio-Economic Assessment "             
));

$practitioner42 = Practitioner::create(array(
  'person' => "Ms. Esther Kalule NANFUKA " ,
	'organisation_name' => "Department of Social Work & Social Administration" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 484265" ,
	'email' => "  nanfuka@ss.mak.ac.ug  &    esthernanfuka@yahoo.com" ,
	'qualifications' => "Master of Arts in Social Sector Planning and Management, " ,
	'expertise' => "Sociological studies, socio-economic audits, socio-anthropological and social health audits"             
));

$practitioner43 = Practitioner::create(array(
  'person' => "Mr. Amos MAFIGIRI" ,
	'organisation_name' => "Eco & Partner Consult Ltd" ,
	'box_no' => "P.O. Box 23989" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256-782677442" ,
	'email' => " amos@ecopartner.co.ug " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Waste Management, Environmental Management Systems ISO 14001:2004, General Environmental Management"             
));

$practitioner44 = Practitioner::create(array(
  'person' => "Mr. David SERUGGA" ,
	'organisation_name' => "Eco & Partner Consult Ltd" ,
	'box_no' => "P.O. Box 23989 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0755 929223" ,
	'email' => " david@ecopartner.co.ug ; dserugga@yahoo.com" ,
	'qualifications' => "Msc. Environment & Natural Resources," ,
	'expertise' => "Soil & Wetland management; Natural resources management, Telecommunications infrastructure, Petroleum products’ depots & retail outlets, and Waste Management"             
));

$practitioner45 = Practitioner::create(array(
  'person' => "Mr. Eddie LUYIMA" ,
	'organisation_name' => "Eco & Partner Consult Ltd" ,
	'visiting_address' => "Plot No. 57 Naguru Drive, Naguru Hill" ,
	'box_no' => "P.O. Box 23989" ,
	'city' => "Kampala" ,
	'phone' => "Tel: + 256 312 291830 (Office);  + 256 772 669601 (Mob)" ,
	'email' => " eddie@ecopartner.co.ug  ;     ecopart@africamail.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Environmental Management Systems based on ISO 14001 series; Occupational Health and Safety Management Systems based on OHSAS/ISO 18001; Quality Management Systems; Oil and Gas for both Upstream and downstream; Mining & quarrying; Telecommunications; Industrial and Solid Waste Management; Cleaner Production; Air quality and noise monitoring and modelling; Socio-Economic assessments."             
));

$practitioner46 = Practitioner::create(array(
  'person' => "Mr. Francis LUGEMWA " ,
	'organisation_name' => "Eco & Partner Consult Ltd" ,
	'visiting_address' => "Plot No. 57 Naguru Drive, Naguru Hill" ,
	'box_no' => "P.O. Box 23989" ,
	'city' => "Kampala" ,
	'phone' => "Tel: + 256 312 291830 (Office);  + 256 772 438609 (Mob)" ,
	'email' => " fralu5@yahoo.com   ;    ecopart@africamail.com" ,
	'qualifications' => "BA. Education; " ,
	'expertise' => "Socio-Economic Impact Assessment; Geomorphology "             
));

$practitioner47 = Practitioner::create(array(
  'person' => "Mr. Eddie LUYIMA" ,
	'organisation_name' => "Eco & Partner Consult Ltd" ,
	'visiting_address' => "Plot No. 57 Naguru Drive, Naguru Hill" ,
	'box_no' => "P.O. Box 23989" ,
	'city' => "Kampala" ,
	'phone' => "Tel: + 256 312 291830 (Office); + 256 772 669601 (Mob)" ,
	'email' => " eddie@ecopartner.co.ug  ;     ecopart@africamail.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Industrial and Solid Waste Management; Air quality and noise monitoring and modelling; Mining & quarrying; Cleaner Production; Environmental Management Systems based on ISO 14001 series; Occupational Health and Safety Management Systems based on OHSAS/ISO 18001; Quality Management Systems; Oil and Gas for both Upstream and downstream; Telecommunications."             
));

$practitioner48 = Practitioner::create(array(
  'person' => "Mr. Francis LUGEMWA " ,
	'organisation_name' => "Eco & Partner Consult Ltd" ,
	'visiting_address' => "Plot No. 57 Naguru Drive, Naguru Hill" ,
	'box_no' => "P.O. Box 23989" ,
	'city' => "Kampala" ,
	'phone' => "Tel: + 256 312 291830 (Office); + 256 772 438609 (Mob)" ,
	'email' => " fralu5@yahoo.com   ;    ecopart@africamail.com " ,
	'qualifications' => "BA. Education; PGD-EIA " ,
	'expertise' => "Socio-Impact Audits; "             
));

$practitioner49 = Practitioner::create(array(
  'person' => "Ms. Phionah SASIRA" ,
	'organisation_name' => "Eco Innovations International Ltd" ,
	'visiting_address' => "Postal office Building Kampala Road, " ,
	'box_no' => "P.O. Box 35289 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256 712235427" ,
	'email' => " sfionah@yahoo.com" ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Evaluation of Fuel Dispensing Facilities, Quarry Sites, Telecommunication Facilities and Agricultural facilities."             
));

$practitioner50 = Practitioner::create(array(
  'person' => "Ms. Phionah SASIRA" ,
	'organisation_name' => "Eco Innovations International Ltd" ,
	'visiting_address' => "Postal office Building Kampala Road, " ,
	'box_no' => "P.O. Box 35289 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256 712235427" ,
	'email' => " sfionah@yahoo.com" ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Environment performance and evaluation of fuel dispensing facilities, quarry sites, telecommunication facilities and established Infrastructural establishments."             
));

$practitioner51 = Practitioner::create(array(
  'person' => "Dr. James OKOT - OKUMU" ,
	'organisation_name' => "Ecotech Consulting Environmental Management Firm Ltd." ,
	'box_no' => "P.O. Box 16569" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 411 460" ,
	'email' => " jokotokumu@yahoo.com; jokotokumu@muienr.mak.ac.ug " ,
	'qualifications' => "PhD. Environmental Science; BSc. Chemistry & Biochemistry" ,
	'expertise' => "Water Resources Management; Pollution Management; Cleaner Production; Environmental Chemistry"             
));

$practitioner52 = Practitioner::create(array(
  'person' => "Dr. James OKOT - OKUMU" ,
	'organisation_name' => "Ecotech Consulting Environmental Management Firm Ltd." ,
	'box_no' => "P.O. Box 16569 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 411 460" ,
	'email' => " jokotokumu@yahoo.com ; jokotokumu@muienr.mak.ac.ug " ,
	'qualifications' => "PhD. Environmental Science; BSc. Chemistry & Biochemistry" ,
	'expertise' => "Water Resources Management; Pollution Management; Cleaner Production; Environmental Chemistry"             
));

$practitioner53 = Practitioner::create(array(
  'person' => "Mr. Charles MUTEMO" ,
	'organisation_name' => "Envicom" ,
	'visiting_address' => "Jinja" ,
	'box_no' => "P.O. Box 893" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256772315061" ,
	'email' => " mutemocharles@yahoo.com " ,
	'qualifications' => "MSc. Environment and Natural resources;BA. Geography; PgD. Education" ,
	'expertise' => "Transport & Works Infrastructure, Suitability Analysis in Agriculture, and Land-use & Resource Assessment. "             
));

$practitioner54 = Practitioner::create(array(
  'person' => "Mr. Anthony ORYADA" ,
	'organisation_name' => "Enviro-Care & Management Ltd" ,
	'visiting_address' => "Plot 9 Dewinton Road" ,
	'box_no' => "P.O. Box 35204" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782 070457; 702070457" ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Waste Management, Pollution Assessment ; General Environment Management"             
));

$practitioner55 = Practitioner::create(array(
  'person' => "Mr. Ananias Ammar BAZIRA" ,
	'organisation_name' => "Enviro-Care & Management Ltd" ,
	'visiting_address' => "Plot 9 Dewinton Road" ,
	'box_no' => "P.O. Box 35204" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0792 243512 OR 0703 500056" ,
	'email' => " bazianan@gmail.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Waste management; Energy management; Civil works and Construction; General Environmental Management "             
));

$practitioner56 = Practitioner::create(array(
  'person' => "Mr. Martin ARYAGARUKA" ,
	'organisation_name' => "Enviro-Care & Management Ltd" ,
	'box_no' => "P.O. Box 971 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: Office: 0414257323; Mob:  0772523728" ,
	'email' => " aryagaruka2000@yahoo.com" ,
	'qualifications' => "Master of Natural Resource Management, Bachelor of Science" ,
	'expertise' => "Natural Resource Management(Social Economic Information),Energy Management, Cleaner Production, Environmental Management Systems"             
));

$practitioner57 = Practitioner::create(array(
  'person' => "Mr. Danson ASIIMWE" ,
	'organisation_name' => "Enviro-Care & Management Ltd" ,
	'visiting_address' => "Total deluxe house, Plot 29/33 Jinja Road" ,
	'box_no' => "P.O. Box 70360" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256774755954" ,
	'email' => " richdanson@yahoo.com " ,
	'qualifications' => "MSc. Water and Environmental Management; Bachelor of Environmental Science" ,
	'expertise' => "Water Resources Management, Water Quality Analysis And Assessment, Pollution Analysis and Management (Waste Water and Solid Waste), ISO 14001 and Environmental Management Systems."             
));

$practitioner58 = Practitioner::create(array(
  'person' => "Mr. Danson ASIIMWE" ,
	'organisation_name' => "Enviro-Care & Management Ltd" ,
	'visiting_address' => "Total deluxe house, Plot 29/33 Jinja Road" ,
	'box_no' => "P.O. Box 70360" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256774755954" ,
	'email' => " richdanson@yahoo.com " ,
	'qualifications' => "MSc. Water & Environmental Management, Bachelor of Environmental Science," ,
	'expertise' => "Environmental Management Systems; Hydrology and Water quality assessment, pollution analysis and control, waste management, Occupational Health and Safety"             
));

$practitioner59 = Practitioner::create(array(
  'person' => "Mr. Martin ARYAGARUKA" ,
	'organisation_name' => "Enviro-Care & Management Ltd" ,
	'box_no' => "P.O. Box 971 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: Office: 0414257323         Mob:  0772523728" ,
	'email' => "  aryagaruka2000@yahoo.com" ,
	'qualifications' => "Master of Natural Resource Management, Bachelor of Science" ,
	'expertise' => "Natural Resource Management(Social Economic Information),Energy Management, Cleaner Production, Environmental Management Systems"             
));

$practitioner60 = Practitioner::create(array(
  'person' => "Ms. Anita KIGONYA" ,
	'organisation_name' => "Environment & Development Action Consult" ,
	'visiting_address' => "Equatorial House, Kampala Road" ,
	'box_no' => "P.O. BOX 31211" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 422 877" ,
	'email' => " endasug@yahoo.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Land Resources; Water & Sanitation; Chemical Management; Energy Management."             
));

$practitioner61 = Practitioner::create(array(
  'person' => "Ms. Anita KIGONYA" ,
	'organisation_name' => "Environment & Development Action Consult" ,
	'visiting_address' => "Equatorial House, Kampala Road" ,
	'box_no' => "P.O. BOX 31211" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 422 877" ,
	'email' => "endasug@yahoo.com" ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Land Resources; Water & Sanitation; Chemical Management; Energy Management."             
));

$practitioner62 = Practitioner::create(array(
  'person' => "Mr. Moses Kitimbo  KAGODA " ,
	'organisation_name' => "Environmental Assessment Consult Ltd. (EACL)" ,
	'visiting_address' => "Kisozi House Close, Plot 8, Kyagwe Road" ,
	'box_no' => "P.O. BOX 3128 " ,
	'city' => "Kampala" ,
	'phone' => "Tel :     0772 434155" ,
	'email' => "eacl@infocom.co.ug " ,
	'qualifications' => "MSc. Environmental & Resource Assessment; BSc. Botany & Zoology " ,
	'expertise' => "Botanical / Zoological Assessments, fisheries Resources management, Water resources, Wetland Assessment, Waste management "             
));

$practitioner63 = Practitioner::create(array(
  'person' => "Mr. Moses Kitimbo  KAGODA " ,
	'organisation_name' => "Environmental Assessment Consult Ltd. (EACL)" ,
	'visiting_address' => "Kisozi House Close, Plot 8, Kyagwe Road" ,
	'box_no' => "P.O. BOX 3128 " ,
	'city' => "Kampala" ,
	'phone' => "Tel :      0772 434155" ,
	'email' => "eacl@infocom.co.ug " ,
	'qualifications' => "MSc. Environmental & Resource Assessment; BSc. Botany & Zoology" ,
	'expertise' => "Cleaner Production, Botany, Zoology, Fisheries, Water Resources, Wetland Assessment"             
));

$practitioner64 = Practitioner::create(array(
  'person' => "Mr. Moses ERIATU" ,
	'organisation_name' => "Environmental Planning and Management Consults, " ,
	'box_no' => "P.O. Box 34939  " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772360689 / 0702 255314" ,
	'email' => " eriatumoses2000@yahoo.com " ,
	'qualifications' => "Masters in Management Studies, PgD. Integrated Rural Planning. " ,
	'expertise' => "Rural Development Planning; Energy Management; Social Impacts Assessments; Occupational Health & Safety"             
));

$practitioner65 = Practitioner::create(array(
  'person' => "Mr. Moses ERIATU" ,
	'organisation_name' => "Environmental Planning and Management Consults, " ,
	'box_no' => "P.O. Box 34939  " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772360689 & 702255314" ,
	'email' => " eriatumoses2000@yahoo.com " ,
	'qualifications' => "Masters in Management Studies, PgD. Integrated Rural Planning. " ,
	'expertise' => "Social Impact Audits, Energy Management, Occupational Health and Safety and Waste Management."             
));

$practitioner66 = Practitioner::create(array(
  'person' => "Dr. John C. SSEMPEBWA" ,
	'organisation_name' => "Environpower (U) ltd" ,
	'visiting_address' => "Mukono" ,
	'box_no' => "P.O. Box 575" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772963074 and 0704663074" ,
	'email' => " jssemps@musph.ac.ug ; environpower@gmail.com" ,
	'qualifications' => "PhD. EnvironmentalToxicology; MSc. Water Resources Management BSc. Botany & Zoology" ,
	'expertise' => "Health Risk/Impacts  Evaluation; Hazardous Material Management & Emergency Response; Waste Water Treatment Systems; Water Quality Surveillance; Fisheries Management; Occupational Safety and Health; Post-Contamination Site Remediation; Solid Waste Management; Pollution Control and Waste Management."             
));

$practitioner67 = Practitioner::create(array(
  'person' => "Prof. Hannington ORYEM-ORIGA" ,
	'organisation_name' => "Faculty of Science, Department of Botany" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 624932" ,
	'email' => " H; yem; iga@botany.mak.ac.ug " ,
	'qualifications' => "PhD. Ecophysiology; MSc. Plant Physiology; BSc. Botany, Zoology & Chemistry" ,
	'expertise' => "Environmental Pollution, Pollution control, Phytostabilization &, Phytoremediation, Ecological Studies; and Generally Biophysical Assessment  "             
));

$practitioner68 = Practitioner::create(array(
  'person' => "Prof. Hannington ORYEM-ORIGA" ,
	'organisation_name' => "Faculty of Science, Department of Botany" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7062" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 624932" ,
	'email' => "h; yem-; iga@botany.mak.ac.ug " ,
	'qualifications' => "PhD. Ecophysiology; MSc. Plant Physiology; BSc. Botany, Zoology & Chemistry" ,
	'expertise' => "Environmental Pollution, Pollution control, Phytostabilization &, Phytoremediation, Ecological Studies; and Generally Biophysical Assessment  and Auditing"             
));

$practitioner69 = Practitioner::create(array(
  'person' => "Mr. Amadra ORI-OKIDO" ,
	'organisation_name' => "Geo-Information Communication Ltd" ,
	'box_no' => "P.O. Box 2944" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 445011" ,
	'email' => " amadra@gic.co.ug " ,
	'qualifications' => "MSc. Geographic Information Systems for Rural Applications; BSc.Natural Resources & Environmental Studies" ,
	'expertise' => "Computer-Based analysis on Land Cover/Land Use change; Decision Support System Applications"             
));

$practitioner70 = Practitioner::create(array(
  'person' => "Mr. David Nelson NKUUTU" ,
	'organisation_name' => "Geo-Taxon Consults" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 28973" ,
	'city' => "Kampala" ,
	'phone' => "Tel.     0772 488 621;  0712 488621 " ,
	'email' => " dn_nkuutu@yahoo.com " ,
	'qualifications' => "BSc. Forestry" ,
	'expertise' => "Ecology, Forest & Plantations, Management;  Land-use Planning & Mapping; Resource Assessment and Geographical Mapping.  "             
));

$practitioner71 = Practitioner::create(array(
  'person' => "Dr. Paul SSEGAWA " ,
	'organisation_name' => "Geo-Taxon Consults" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 28973 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256- (0) 772 411469" ,
	'email' => " paulssegawa@yahoo.com " ,
	'qualifications' => "PhD in Plant Ecology and Ethnobotany; MSc. Environment and Natural Resource Management; BSc. Forestry " ,
	'expertise' => "Terrestrial Ecology; Biodiversity Studies; Plant Taxonomy "             
));

$practitioner72 = Practitioner::create(array(
  'person' => "Mr. David Nelson NKUUTU" ,
	'organisation_name' => "Geo-Taxon Consults" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 28973 " ,
	'city' => "Kampala" ,
	'phone' => "Tel.      0772 488 621;  712488621" ,
	'email' => " dn_nkuutu@yahoo.com " ,
	'qualifications' => "BSc. Forestry" ,
	'expertise' => "Ecology, Forest & Plantations, Management; Land-use Planning & Mapping; Resource Assessment and Geographical Mapping.  "             
));

$practitioner73 = Practitioner::create(array(
  'person' => "Dr. Paul SSEGAWA " ,
	'organisation_name' => "Geo-Taxon Consults" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 28973 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256- (0) 772 411469" ,
	'email' => "   paulssegawa@yahoo.com  " ,
	'qualifications' => "PhD in Conservation Biology; MSc. Environment and Natural Resource; BSc. Forestry" ,
	'expertise' => "Terrestrial Ecology; Biodiversity Studies; Plant Taxonomy"             
));

$practitioner74 = Practitioner::create(array(
  'person' => "Mr. Happy Peter MURWANYI" ,
	'organisation_name' => "Gissat Environment Associates (www.gissatconsult.com)" ,
	'box_no' => "P.O. Box 21598" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256774829579" ,
	'email' => " happy_peter@yahoo.com " ,
	'qualifications' => "BSc. Environmental Science" ,
	'expertise' => "Waste management, socio-economic assessment and occupational Health and safety"             
));

$practitioner75 = Practitioner::create(array(
  'person' => "Ms. Harriet N. MUJUNI" ,
	'organisation_name' => "Gissat Environment Associates (www.gissatconsult.com)" ,
	'visiting_address' => "Plot 3334 UDC Close, Muyenga" ,
	'box_no' => "P.O. Box 21598" ,
	'city' => "Kampala" ,
	'phone' => "Office Tel/Fax: 0414 267 070; Cell: 0772 403796; 0712 403796; 0702 403 796" ,
	'email' => " info@gissat.co.ug  ; harriet.mujuni@gmail.com  " ,
	'qualifications' => "Bachelor of Laws (LL.B.)" ,
	'expertise' => "Environmental Law & Compliance; Strategic Environmental Assessments; Environmental & Social Impact Assessments; Resettlement & Rehabilitation; Conflict Resolution (Natural Resources); Cleaner Production; Health Impact Assessments "             
));

$practitioner76 = Practitioner::create(array(
  'person' => "Ms. Harriet N. MUJUNI" ,
	'organisation_name' => "Gissat Environment Associates (www.gissatconsult.com)" ,
	'visiting_address' => "Plot 3334 UDC Close, Muyenga" ,
	'box_no' => "P.O. Box 21598" ,
	'city' => "Kampala" ,
	'phone' => "Office Tel/Fax: 0414 267 070; Cell: 0772 403796; 0712 403796; 0702 403 796" ,
	'email' => " info@gissat.co.ug  ; harriet.mujuni@gmail.com  " ,
	'qualifications' => "Bachelor of Laws (LL.B.)" ,
	'expertise' => "Environmental Law & Compliance; Land use Management & Planning; Social, Strategic & Economic Impact Evaluation; Environment & Development Monitoring; Cleaner Production"             
));

$practitioner77 = Practitioner::create(array(
  'person' => "Mr. Moses Mugimba MUHUMUZA " ,
	'organisation_name' => "Green Impact & Development Services (GIDS) Consults Ltd " ,
	'box_no' => "P.O. Box 12211 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 077 332108/ +256 312515083 " ,
	'email' => " mmugim@gmail.com ; muhumuza.moses.m@greenimpactco.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Waste Management; Eco-Tourism Impact Analysis; Environmental Standards Conformity; Work and Public Health and Safety; Energy Management"             
));

$practitioner78 = Practitioner::create(array(
  'person' => "Mr. Moses Mugimba MUHUMUZA " ,
	'organisation_name' => "Green Impact & Development Services (GIDS) Consults Ltd " ,
	'box_no' => "P.O. Box 12211 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 077 332108/ +256 312515083 " ,
	'email' => " mmugim@gmail.com ; muhumuza.moses.m@greenimpactco.com" ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Waste Management; Eco-Tourism Impact Analysis; Environmental Standards Conformity; Work and Public Health and Safety; Energy Management"             
));

$practitioner79 = Practitioner::create(array(
  'person' => "Dr. Bob Humphrey OGWANG" ,
	'organisation_name' => "Greenbelt Consult Ltd." ,
	'visiting_address' => "Colline House, 3rd Floor, Nile Av. " ,
	'box_no' => "P.O. Box 24854" ,
	'city' => "Kampala" ,
	'phone' => "Tel: Office: 0414-346426; Mob: 0772-841264" ,
	'email' => " bogwang@greenbelt.co.ug " ,
	'qualifications' => "PhD. Natural Resource Management; MSc. Agriculture; BSc. Agriculture." ,
	'expertise' => "Natural Resource Management; Energy infrastructure;  Telecommunications; Agriculture and Waste Management "             
));

$practitioner80 = Practitioner::create(array(
  'person' => "Dr. Bob Humphrey OGWANG" ,
	'organisation_name' => "Greenbelt Consult Ltd." ,
	'visiting_address' => "Colline House, 3rd Floor, Nile Av. " ,
	'box_no' => "P.O. Box 24854" ,
	'city' => "Kampala" ,
	'phone' => "Tel: Office: 0414-346426; Mob: 0772-841264" ,
	'email' => " bogwang@greenbelt.co.ug " ,
	'qualifications' => "PhD. Natural Resource Management; MSc. Agriculture; BSc. Agriculture." ,
	'expertise' => "Roads, Hydro Power, Agriculture, Natural Resources, Quarries and Building Construction"             
));

$practitioner81 = Practitioner::create(array(
  'person' => "Mr. Brian MUHIMBURA " ,
	'organisation_name' => "Greenlife  Enviro Consult (U)Ltd" ,
	'visiting_address' => "Plot 13 Luthuli Avenue," ,
	'box_no' => "P.O. Box 29397" ,
	'city' => "Bugolobi" ,
	'phone' => "Tel: 0774202151 and 0705484210" ,
	'email' => " muhii86@yahoo.com " ,
	'qualifications' => "Bachelor of Environmental Science" ,
	'expertise' => "Waste management, Energy resources, Ecosystem assessments and Industrial processes/cleaner production."             
));

$practitioner82 = Practitioner::create(array(
  'person' => "Mr. Abdallah MUNUBI " ,
	'organisation_name' => "Heboco Consult Ltd" ,
	'visiting_address' => "Uganda House" ,
	'box_no' => "P.O. Box 3451" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256776485230," ,
	'email' => "hecoboconsult@gmail.com ; munubibob@yahoo.com  " ,
	'qualifications' => "MSc. Environmental Management and Development, BSc. Environmental Management " ,
	'expertise' => "Wetland ecology and Management, Environmental Economics, Environmental Health and Sanitation, Forest Management, Waste Management and Infrastructural Assessment"             
));

$practitioner83 = Practitioner::create(array(
  'person' => "Mr. Abdallah MUNUBI " ,
	'organisation_name' => "Heboco Consult Ltd" ,
	'visiting_address' => "Uganda House," ,
	'box_no' => "P.O. Box 3451" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256776485230" ,
	'email' => "hecoboconsult@gmail.com &    munubibob@yahoo.com " ,
	'qualifications' => "MSc. In Environmental Management, BSc. In Environment Management" ,
	'expertise' => "Wetland Ecology and Management, Environmental Economics, Environmental Health and Sanitation, Waste Management and Infrastructural Assessment"             
));

$practitioner84 = Practitioner::create(array(
  'person' => "Mr. Peter ISAMAT " ,
	'organisation_name' => "ICL" ,
	'box_no' => "P.O. Box 5229" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 409 564 " ,
	'email' => " isamatpeter@yahoo.co.uk " ,
	'qualifications' => "BA. Social Sciences " ,
	'expertise' => "Socio-Economic Assessments; Environmental Management Systems. "             
));

$practitioner85 = Practitioner::create(array(
  'person' => "Mr. Peter ISAMAT " ,
	'organisation_name' => "ICL" ,
	'box_no' => "P.O. Box 5229" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 409 564 " ,
	'email' => " isamatpeter@yahoo.co.uk" ,
	'qualifications' => "BA. Social Sciences " ,
	'expertise' => "Cleaner Production; Socio-Economic Audits; Environmental Management Systems Audits; Integrated Environmental and Quality Management Systems and Integrated Audits"             
));

$practitioner86 = Practitioner::create(array(
  'person' => "Mr. Hilary BAKAMWESIGA" ,
	'organisation_name' => "Institute of Environment & Natural Resources" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7298 " ,
	'city' => "Kampala" ,
	'email' => " hbakamwesiga@yahoo.com " ,
	'qualifications' => "MSc. Environmental Science;" ,
	'expertise' => "Biodiversity Inventory, Analysis and Mapping; Wetlands Management and Conservation; Waste and Pollution Assessment. "             
));

$practitioner87 = Practitioner::create(array(
  'person' => "Prof. Frank KANSIIME" ,
	'organisation_name' => "Institute of Environment & Natural Resources" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7298" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 506520 and 0752506520" ,
	'email' => " fkansiime@muienr.mak.ac.ug ; fkansiime@gmail.com " ,
	'qualifications' => "PhD. Environmental Ecotechnology; MSc. Environmental / Sanitary Engineering; MSc Applied Environmental Microbiology; BSc. Education (Biology, & Chemistry)" ,
	'expertise' => "Environmental Ecotechnology, Environmental Systems Analysis, Assessments & Monitoring , Use of Ecological Principles to solve Environmental Problems, Waste Management"             
));

$practitioner88 = Practitioner::create(array(
  'person' => "Prof. Frank KANSIIME" ,
	'organisation_name' => "Institute of Environment & Natural Resources" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7298" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 506520 and 0752506520" ,
	'email' => " fkansiime@gmail.com  ; fkansiime@muienr.mak.ac.ug " ,
	'qualifications' => "PhD. Environmental Ecotechnology; MSc. Environmental / Sanitary Engineering; MSc Applied Environmental Microbiology; BSc. Education (Biology, & Chemistry)" ,
	'expertise' => "Environmental Ecotechnology, Environmental Systems Analysis, Assessments & Monitoring , Use of Ecological Principles to solve Environmental Problems, Waste Management"             
));

$practitioner89 = Practitioner::create(array(
  'person' => "Mr. Richard Mugambe KIBIRANGO " ,
	'organisation_name' => "Institute of Public Health" ,
	'visiting_address' => "Makerere University" ,
	'box_no' => "P.O. Box 7072 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712 381346 and 0774 116280" ,
	'email' => " rkmugambe@yahoo.com " ,
	'qualifications' => "MSc. Environmental Technology; Bachelor of Environmental Health Sciences" ,
	'expertise' => "Waste water and Waste management Technologies; Environmental Health; Renewable Energy Technology and applications"             
));

$practitioner90 = Practitioner::create(array(
  'person' => "Mr. Dennis KAMOGA" ,
	'organisation_name' => "Jera" ,
	'box_no' => "P.O. Box 27901" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256712212006" ,
	'email' => " denniskamoga@yahoo.com " ,
	'qualifications' => "MSc. In Botany; BSc. In Ethrobotany" ,
	'expertise' => "Biodiversity Assessments, Terrestrial/Restoration Ecology, Plant use and Community Development (Ethrobotany / Ethro-Ecology)"             
));

$practitioner91 = Practitioner::create(array(
  'person' => "Mr. John Bosco LUBEGA" ,
	'organisation_name' => "KATS Consult" ,
	'visiting_address' => "Buganda Road, 666/ G, " ,
	'box_no' => "P.O. Box 504 " ,
	'city' => "Kampala" ,
	'phone' => "Office : 0312 108449 ; " ,
	'email' => " rocagric@gmail.com  " ,
	'qualifications' => "BSc. Geology/Chemistry " ,
	'expertise' => "Geological Assessments, Waste management,  "             
));

$practitioner92 = Practitioner::create(array(
  'person' => "Dr. Balla TURYAHUMURA" ,
	'organisation_name' => "KATS Consult" ,
	'visiting_address' => "Buganda Road, 666/ G, " ,
	'box_no' => "P.O. Box 504 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: Mob :   0772 470785 ;  Office : 0312 108449 ; " ,
	'email' => " ballakats@gmail.com  " ,
	'qualifications' => "PhD. Technical Sciences; MSc. Chemical Engineering/Plastics Technology" ,
	'expertise' => "Chemical & Process Industries, Enterprises using chemicals, institutions and others such as Waste Disposal Facilities."             
));

$practitioner93 = Practitioner::create(array(
  'person' => "Dr. Balla TURYAHUMURA" ,
	'organisation_name' => "KATS Consult" ,
	'visiting_address' => "Buganda Road, 666/ G, " ,
	'box_no' => "P.O. Box 504 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: Mob :   0772 470785 ; Office : 0312 108449 ; " ,
	'email' => "  ballakats@gmail.com  " ,
	'qualifications' => "PhD. Technical Sciences; MSc. Chemical Engineering/Plastics Technology" ,
	'expertise' => "Chemical & Process Industries, Enterprises using Chemicals, Institutions and Others such as Waste Disposal Facilities."             
));

$practitioner94 = Practitioner::create(array(
  'person' => "Ms. Mary Clemence Mugabe NDEKEZI " ,
	'organisation_name' => "KOM Consulting Engineers & Planners" ,
	'box_no' => "P.O. Box 33959 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256 (0) 772 464 440 " ,
	'email' => " mnmugabe@yahoo.com " ,
	'qualifications' => "MA. Gender Studies; " ,
	'expertise' => "Environmental Impact Assessment of Physical Environment;  Social/Gender Impact Assessment "             
));

$practitioner95 = Practitioner::create(array(
  'person' => "Eng. Priscilla NAKIBONEKA" ,
	'organisation_name' => "M/S Sanitation and Environmental Consult" ,
	'box_no' => "P.O. Box 2364 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772499336" ,
	'email' => " pnakiboneka@gmail.com  " ,
	'qualifications' => "BSc. Civil Engineering" ,
	'expertise' => "Civil & Infrastructural developments, Waste-water Engineering, Solid Waste and Health-care Waste Management, water and Sanitation assessment"             
));

$practitioner96 = Practitioner::create(array(
  'person' => "Ms. Janet Shabaan MBAKA" ,
	'organisation_name' => "MSTIU Consults" ,
	'box_no' => "P.O. Box 29871" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256 772 854103 " ,
	'email' => " janet.shaban@gmail.com  " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Telecom Projects; Fuel Stations; Stone Quarries, Remote sensing, Land use planning, Occupational Health and Safety, GIS and Waste management,"             
));

$practitioner97 = Practitioner::create(array(
  'person' => "Ms. Janet Shabaan Mbaka " ,
	'organisation_name' => "MSTIU Consults" ,
	'box_no' => "P.O. Box 29871" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256 772 854103 " ,
	'email' => " janet.shaban@gmail.com  " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Land use planning, Waste management, Occupational Health and Safety, GIS and Remote sensing"             
));

$practitioner98 = Practitioner::create(array(
  'person' => "Mr. Paul Katya MUBIRU" ,
	'organisation_name' => "Multi-Build Uganda" ,
	'box_no' => "P.O. Box 11782 " ,
	'city' => "Kampala" ,
	'phone' => "Tel:0772481855" ,
	'email' => " mubirukatya@yahoo.com " ,
	'qualifications' => "BSc. Environmental Management" ,
	'expertise' => "Solid Waste Management, Protected Area/ Wildlife use, Planning, Telecommunication Masts Industrial Pollution."             
));

$practitioner99 = Practitioner::create(array(
  'person' => "Mr. Paul Buyerah MUSAMALI" ,
	'organisation_name' => "National Forestry Authority" ,
	'box_no' => "P.O. Box 70863" ,
	'city' => "Kampala" ,
	'phone' => "Tel. : Mob : 0772 466569 Office : 0414 230365    " ,
	'email' => "paulm@nfa.; g.ug " ,
	'qualifications' => "MSc. Environment Science; " ,
	'expertise' => "Natural Resource Planning & management; Integrated environment  and Water management; Solid waste management"             
));

$practitioner100 = Practitioner::create(array(
  'person' => "Dr. Swidiq MUGERWA" ,
	'organisation_name' => "National Livestock Resources Institute " ,
	'box_no' => "P.O. Box 96 " ,
	'city' => "Tororo" ,
	'phone' => "Tel: + 256 782660295" ,
	'email' => " swidiqk@yahoo.com " ,
	'qualifications' => "BSc. Agriculture" ,
	'expertise' => "Ecology, Biodiversity Conservation, Animal Environment Interaction Social and Economic Environmental Impacts, Environmental Ecotechnology, Agriculture Development Projects, Construction projects and water resources management"             
));

$practitioner101 = Practitioner::create(array(
  'person' => "Dr. Festus Kibiri BAGOORA" ,
	'organisation_name' => "Nature-RIDD (U) Ltd" ,
	'visiting_address' => "Lower Estate Kyambogo, Plot 12 Devon Avenue" ,
	'box_no' => "P.O. Box 26598" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 551340" ,
	'email' => " fbago; a@gmail.com" ,
	'qualifications' => "PHD in Environmental science, Bachelor of Arts and Diploma in Education" ,
	'expertise' => "Ecosystems impacts & restoration, land evaluation & land use planning, soils & Geomorphological assessments, Disaster/hazards Management, Boundary-layer climatology & Remote sensing of the environment, and climate & climate change impact evaluation"             
));

$practitioner102 = Practitioner::create(array(
  'person' => "Mr. Lameck MUWANGA" ,
	'organisation_name' => "Nature-RIDD (U) Ltd" ,
	'visiting_address' => "Lower Estate Kyambogo, Plot 12 Devon Avenue" ,
	'box_no' => "P.O. Box 26598" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0773258681 and 0702161914" ,
	'email' => " lamecksug316@yahoo.co.uk " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Social Impact Assessment, Eco-tourism Impact Analysis, Telecommunication"             
));

$practitioner103 = Practitioner::create(array(
  'person' => "Dr. Festus Kibiri BAGOORA" ,
	'organisation_name' => "Nature-RIDD (U) Ltd" ,
	'visiting_address' => "Lower Estate Kyambogo, Plot 12 Devon Avenue" ,
	'box_no' => "P.O. Box 26598" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 551340" ,
	'email' => " fbago; a@gmail.com" ,
	'qualifications' => "PHD in Environmental science, Bachelor of Arts and Diploma in Education" ,
	'expertise' => "Ecosystems impacts & restoration, land evaluation & land use planning, soils & Geomorphological assessments, Disaster/hazards Management, Boundary-layer climatology & Remote sensing of the environment, and climate & climate change impact evaluation"             
));

$practitioner104 = Practitioner::create(array(
  'person' => "Eng. Edward Mike NDAWULA" ,
	'organisation_name' => "Nek Consults Limited (www.nekconsults.com)" ,
	'visiting_address' => "Block 2, Suite B5, NHCC Estate Wandegeya" ,
	'box_no' => "P.O. Box 23949" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256 752740664" ,
	'email' => " ndawula@nekconsults.com " ,
	'qualifications' => "BSc. Electrical Engineering" ,
	'expertise' => "Energy and Hydropower projects, Electronic waste and materials management, Electrical Engineering"             
));

$practitioner105 = Practitioner::create(array(
  'person' => "Ms. Christine NANKUBUGE" ,
	'organisation_name' => "Nek Consults Limited (www.nekconsults.com)" ,
	'visiting_address' => "Block 2, Suite B5, NHCC Estate Wandegeya" ,
	'box_no' => "P.O. Box 23949" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256772447388" ,
	'email' => " cnankubuge@yahoo.com " ,
	'qualifications' => "Master of Social Sector Planning and Management, B.A in Social Work and Social Administration" ,
	'expertise' => "Social impact Assessments, Environmental Impact Assessments, Social Policy Analysis, Gender Mainstreaming, Project planning and management"             
));

$practitioner106 = Practitioner::create(array(
  'person' => "Mr. Nelson OMAGOR " ,
	'organisation_name' => "Nelson and Associates Environment Consultants " ,
	'visiting_address' => "Hot Springs Restaurant Building, Plot 27 Clement Hill Road" ,
	'box_no' => "P.O. Box 4066 " ,
	'city' => "Kampala" ,
	'phone' => " Mob: 0772 458903 / 0701-458903 Tel. Office: 0414 382924" ,
	'email' => " nelsonomag; @gmail.com  " ,
	'qualifications' => "MSc. Plant Taxonomy; BSc. Botany & Zoology " ,
	'expertise' => "EIAs for: Roads; Communication Masts; Wetland Wise Use and Management; Fuel Stations; Building & Construction Projects; Dams and Hydro Power Projects; Mining Projects; Agricultural Projects; EMS (ISO 14001) and ISO 19011 for QMS; Social Impact Assessment, including Preparation of Resettlement Action Plans.  "             
));

$practitioner107 = Practitioner::create(array(
  'person' => "Mr. Nelson OMAGOR " ,
	'organisation_name' => "Nelson and Associates Environment Consultants " ,
	'visiting_address' => "Hot Springs Restaurant Building, Plot 27 Clement Hill Road" ,
	'box_no' => "P.O. Box 4066 " ,
	'city' => "Kampala" ,
	'phone' => "Tel. Office:   0414 382924   Mob:            0772 458903 / 0701-458903 " ,
	'email' => " nelsonomag; @gmail.com  " ,
	'qualifications' => "MSc. (Botany); BSc. Botany & Zoology " ,
	'expertise' => "Auditing of Construction Infrastructure (Dams, Roads, Housing & Bridges); Communication Facilities; Agricultural Projects; Fuel Stations; Industrial Settings  "             
));

$practitioner108 = Practitioner::create(array(
  'person' => "Eng. Michael DAKA" ,
	'organisation_name' => "NEWPLAN Ltd." ,
	'visiting_address' => "Consulting Engineers & Planners, Crusader House, 1st Floor, Plot No. 3, Portal Avenue" ,
	'box_no' => "P.O. Box 7544 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782819688" ,
	'email' => " daka@newplan.ug ; Daka.michael@gmail.com " ,
	'qualifications' => "MSc. Engineering (Infrastructure); BSc. Engineering(Civil) " ,
	'expertise' => "General civil engineering, Transport(roads and highways), hydropower, Resettlement Action plans, ISO 9001:2008 QMS, Dams, Occupational Health and Safety, climate change, Risk assessment"             
));

$practitioner109 = Practitioner::create(array(
  'person' => "Mr. Omino. Joseph OTEU  " ,
	'organisation_name' => "NEWPLAN Ltd." ,
	'visiting_address' => "Consulting Engineers & Planners, Crusader House, 1st Floor, Plot No. 3, Portal Avenue" ,
	'box_no' => "P.O. Box 7544 " ,
	'city' => "Kampala" ,
	'phone' => "Tel :0701426637 / 0772446637" ,
	'email' => "joseph@newplan.ug" ,
	'qualifications' => "BSc. In Environment Management" ,
	'expertise' => "Hydro Power Plants, Road construction, Communication Masts, Oil and Gas Project Assessments"             
));

$practitioner110 = Practitioner::create(array(
  'person' => "Ms. Jane MUGANO" ,
	'organisation_name' => "NEWPLAN Ltd." ,
	'visiting_address' => "1st Flloor, Crusader House" ,
	'box_no' => "P.O. Box 7544 " ,
	'city' => "Kampala" ,
	'phone' => "Mobile: 0772551078" ,
	'email' => " jane@newplan.ug " ,
	'qualifications' => "BA. Social Work and Social Administration" ,
	'expertise' => "Social Impacts Assessment and Social  Sector  Planning"             
));

$practitioner111 = Practitioner::create(array(
  'person' => "Ms. Jovah NDYABAREMA" ,
	'organisation_name' => "NEWPLAN Ltd." ,
	'visiting_address' => "Consulting Engineers & Planners, Crusader House, 1st Floor, Plot No. 3, Portal Avenue" ,
	'box_no' => "P.O. Box 7544 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0414-34024/5; Mob : 0782 440942" ,
	'email' => " jovah.ndyabarema@gmail.com  " ,
	'qualifications' => "MSc. Water & Environment Management. BSc. Botany & Zoology; Dip. Sustainable Agric. & Environment" ,
	'expertise' => "Environmental sanitation; Agricultural Environment; Integrated Water Resources Mgt; Solid Waste Management; Vertebrate Zoology, Entomology and Parasitology; Occupational Health and Safety, Policy and Institutional Review/Reform,   Resettlement Action Plans & implementation, Environmental & Social Monitoring during construction"             
));

$practitioner112 = Practitioner::create(array(
  'person' => "Mr. Lawrence Omulen" ,
	'organisation_name' => "NEWPLAN Ltd." ,
	'visiting_address' => "Consulting Engineers & Planners, Crusader House, 1st Floor, Plot No. 3, Portal Avenue" ,
	'box_no' => "P.O. Box 7544 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772-780000,  0414-34024/5" ,
	'qualifications' => "MBA Business Administration; MSc. Energy Management; BA. Political Science and Social Administration." ,
	'expertise' => "Energy Management"             
));

$practitioner113 = Practitioner::create(array(
  'person' => "Ms. Josephine AURUGA " ,
	'organisation_name' => "Nova Consult (U) Ltd" ,
	'visiting_address' => "Mandela National Stadium, Northern Wing, Suit 1-1-2" ,
	'box_no' => "P.O. Box 33649" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782 924 408 / 0772 385183" ,
	'email' => " aurugajoe@yahoo.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Natural Resource Management; Pollution and Waste Management; Social Impact Evaluation; "             
));

$practitioner114 = Practitioner::create(array(
  'person' => "Mr. Oscar MASABA" ,
	'organisation_name' => "Nova Consult (U) Ltd" ,
	'visiting_address' => "Mandela National Stadium, Northern Wing, Suit 1-1-2" ,
	'box_no' => "P.O. Box 33649" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0773285012" ,
	'email' => " mabz_0s@yahoo.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Natural Resources Management, Pollution and Solid Waste management and Socio Impact Evaluation"             
));

$practitioner115 = Practitioner::create(array(
  'person' => "Ms. Josephine AURUGA " ,
	'organisation_name' => "Nova Consult (U) Ltd" ,
	'visiting_address' => "Mandela National Stadium, Northern Wing, Suit 1-1-2" ,
	'box_no' => "P.O. Box 33649" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782 924 408 / 0772 385183" ,
	'email' => " aurugajoe@yahoo.com" ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Pollution and Waste Management; Socio-Economic Impact Audits; "             
));

$practitioner116 = Practitioner::create(array(
  'person' => "Ms. Comfort  Zacia DRADRI" ,
	'organisation_name' => "NUDEIL" ,
	'visiting_address' => "Plot 9, Olia Road" ,
	'box_no' => "P.O. Box 272 " ,
	'city' => "Gulu" ,
	'phone' => " Tel: 0471433045 and 0 471433049  Mobile: 0777766694 and 0711690555" ,
	'email' => "  czdradri@field.winrock.; g " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Road Construction, Communication Masts, Building and Construction Projects, Social Impact Evaluation"             
));

$practitioner117 = Practitioner::create(array(
  'person' => "Mr. Joseph AGUMA-ACON" ,
	'organisation_name' => "Occupational Q & E Mgt Systems Ltd, Plot 99, Ntinda-Nakawa Road, " ,
	'box_no' => "P.O. Box 28831" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772-463288" ,
	'email' => " joeaacon@yahoo.com " ,
	'qualifications' => "BSc. Chemistry" ,
	'expertise' => "Occupational Safety and Health; Chemical Safety; and Pollution Management. "             
));

$practitioner118 = Practitioner::create(array(
  'person' => "Mr. Joseph AGUMA-ACON" ,
	'organisation_name' => "Occupational Q & E Mgt Systems Ltd, Plot 99, Ntinda-Nakawa Road, " ,
	'box_no' => "P.O. Box 28831" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772-463288" ,
	'email' => " joeaacon@yahoo.com " ,
	'qualifications' => "BSc. Chemistry" ,
	'expertise' => "Occupational Safety and Health; Chemical Safety; and Pollution Management"             
));

$practitioner119 = Practitioner::create(array(
  'person' => "Mr. George KUNIHIRA " ,
	'organisation_name' => "Omudima Services Limited" ,
	'box_no' => "P.O. Box 9 " ,
	'city' => "Entebbe" ,
	'phone' => "Tel: 0782980306" ,
	'qualifications' => "BA. Economics " ,
	'expertise' => "Socio-economic assessment, Community Development, Cultural Assessment, Business Plans"             
));

$practitioner120 = Practitioner::create(array(
  'person' => "Mr. Alfred TUMUSIIME" ,
	'organisation_name' => "OPEP Consult Ltd." ,
	'box_no' => "P.O. Box 34502" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782-335405" ,
	'email' => " alfreduganda@yahoo.com  ; opepconsult@yahoo.com " ,
	'qualifications' => "BSc. Forestry " ,
	'expertise' => "Natural Resources Management, Forestry resources assessments, Energy Projects"             
));

$practitioner121 = Practitioner::create(array(
  'person' => "Mr. Alfred TUMUSIIME" ,
	'organisation_name' => "OPEP Consult Ltd." ,
	'box_no' => "P.O. Box 34502" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782-335405" ,
	'email' => " alfreduganda@yahoo.com ; opepconsult@yahoo.com " ,
	'qualifications' => "BSc. Forestry " ,
	'expertise' => "Natural Resources Management, Forestry resources, Energy Projects"             
));

$practitioner122 = Practitioner::create(array(
  'person' => "Dr. Deogratius  Kaheeru SEKIMPI " ,
	'organisation_name' => "OSHFA Ltd." ,
	'box_no' => "P.O. Box 16422" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772-451641" ,
	'email' => " oshefa@yahoo.com ; dsekimpi@yahoo.com " ,
	'qualifications' => "MSc. Occupational Medicine;" ,
	'expertise' => "Occupational Health and Safety, Environmental Health, Public Health, Environment and Natural Resources"             
));

$practitioner123 = Practitioner::create(array(
  'person' => "Dr. Deogratius  Kaheeru SEKIMPI " ,
	'organisation_name' => "OSHFA Ltd." ,
	'box_no' => "P.O. Box 16422" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772-451641" ,
	'email' => " oshefa@yahoo.com ; dsekimpi@yahoo.com" ,
	'qualifications' => "MSc. Occupational Medicine;" ,
	'expertise' => "Occupational Health and Safety, Environmental Health, Public Health, Environment and Natural Resources"             
));

$practitioner124 = Practitioner::create(array(
  'person' => "Dr. Joseph KOBUSHESHE" ,
	'organisation_name' => "Petroleum Exploration & Production Department" ,
	'box_no' => "P.O. Box 9" ,
	'city' => "Entebbe" ,
	'phone' => "Tel:0777863903" ,
	'email' => " jkobusheshe@yahoo.com ; j.kobusheshe@petroleum.go.ug " ,
	'qualifications' => "PhD in Environmental Engineering, MSc. in Environmental & Resource Engineering, BSc.  Civil Engineering" ,
	'expertise' => "Petroleum Exploration (Drilling) and Production and Supplies, Energy Resources Development (Hydro-power and Nuclear Energy Civil Engineering Projects (Highway, Water, Housing)"             
));

$practitioner125 = Practitioner::create(array(
  'person' => "Mr. John Ochoko KAMERI " ,
	'organisation_name' => "Pinnacle Enviro Consult" ,
	'box_no' => "P.O. Box 22546" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0714333200 and 0703333200" ,
	'email' => " pinnacle@utlonline.co.ug " ,
	'qualifications' => "MBA. Marketing" ,
	'expertise' => "Stone Quarry, Communication Masts (Telecom Projects), Fuel stations, Waste Management, Mining, Building & Construction Projects."             
));

$practitioner126 = Practitioner::create(array(
  'person' => "Ms. Penelope Atuhaire KAMERI" ,
	'organisation_name' => "Pinnacle Enviro Consult" ,
	'box_no' => "P.O. Box 22546" ,
	'city' => "Kampala" ,
	'phone' => "Tel:+256-41-3340756; Mobile: 0392822139 / 0392822406 " ,
	'email' => " penny.kimeri@yahoo.com " ,
	'qualifications' => "BA. Economics" ,
	'expertise' => "Social Impact Assessment, Quarries, Telecom Projects, Fuel & service stations"             
));

$practitioner127 = Practitioner::create(array(
  'person' => "Mr. Roland Bless TAREMWA" ,
	'organisation_name' => "Pinnacle Enviro Consult" ,
	'box_no' => "P.O. Box 22546" ,
	'city' => "Kampala" ,
	'phone' => "Tel:+256-414340756 Mobile:0 711586509 and 0772586509" ,
	'email' => " roland.taremwa@in.com " ,
	'qualifications' => "BSc Computer Science" ,
	'expertise' => "Electronic waste management, Telecom developments, Information Technology developments and Infrastructure developments."             
));

$practitioner128 = Practitioner::create(array(
  'person' => "Mr. John Ochoko KAMERI" ,
	'organisation_name' => "Pinnacle Enviro Consult" ,
	'box_no' => "P.O. Box 22546" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0714333200 and 703333200" ,
	'email' => "  pinnacle@utlonline.co.ug " ,
	'qualifications' => "MBA. Marketing" ,
	'expertise' => "Cleaner Production, EMS-ISO 14001:2004, Auditing Construction Infrastructure (roads, dams, bridges, buildings), Communication Facilities, Agricultural Projects, Fuel & Service Stations, Quarries,  Waste Management,  Noise Pollution."             
));

$practitioner129 = Practitioner::create(array(
  'person' => "Ms. Susan N BUSULWA-LUBEGA" ,
	'organisation_name' => "Quality Assurance and" ,
	'visiting_address' => "Management Consultants, Plot 1001, Nsambya-Gaba Road" ,
	'box_no' => "P.O. Box 1367" ,
	'city' => "Kampala" ,
	'phone' => "Mob: 0772 856202" ,
	'email' => " sueybluey@hotmail.com " ,
	'qualifications' => "MSc. Environmental Pollution Control; BSc. Chemistry" ,
	'expertise' => "Waste Management, Environment and Natural Resource Impact Assessment, and Environmental Pollution Analysis"             
));

$practitioner130 = Practitioner::create(array(
  'person' => "Mr. Stephen A. K. MAGEZI" ,
	'organisation_name' => "Rwenzo – Green Associates" ,
	'box_no' => "P.O. Box 1299" ,
	'city' => "Kampala" ,
	'phone' => "Mob + 256702878322 or +256752878322 or  +256772878322" ,
	'email' => " rwenzogreen@gmail.com ; sak_magezi@yahoo.com  " ,
	'qualifications' => "MSc. Meteorology (Tropical Urban Pollution Potential Assessment);" ,
	'expertise' => "Tropical Urban Pollution; climate change,"             
));

$practitioner131 = Practitioner::create(array(
  'person' => "Mrs. Gertrude MAGEZI" ,
	'organisation_name' => "Rwenzo – Green Associates" ,
	'box_no' => "P.O. Box 1299" ,
	'city' => "Kampala" ,
	'phone' => "Mob: 0701441846 and 0752441844" ,
	'email' => " rwenzogreen@gmail.com ; sak_magezi@yahoo.com  " ,
	'qualifications' => "BA. Social Sciences" ,
	'expertise' => "Social Environment Impact Assessment; Resettlement Impacts & Plans"             
));

$practitioner132 = Practitioner::create(array(
  'person' => "Mr. Stephen A. K. MAGEZI" ,
	'organisation_name' => "Rwenzo – Green Associates" ,
	'box_no' => "P.O. Box 1299" ,
	'city' => "Kampala" ,
	'phone' => "Mob: 0702878322 or 0752878322 or  0772878322" ,
	'email' => " rwenzogreen@gmail.com ; sak_magezi@yahoo.com  " ,
	'qualifications' => "MSc. Meteorology (Tropical Urban Pollution Potential Assessment);" ,
	'expertise' => "Tropical Urban Pollution"             
));

$practitioner133 = Practitioner::create(array(
  'person' => "Mr. Samuel Vivian MATAAGI" ,
	'organisation_name' => "Savimaxx Ltd." ,
	'visiting_address' => "Nalya Housing Estate, Plot 843, Shelter Road" ,
	'box_no' => "P.O. Box 25250 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712 654651 " ,
	'email' => " savimaxxcompanylimited@gmail.com " ,
	'qualifications' => "MSc. Plant Taxonomy; BSc. Botany & Zoology" ,
	'expertise' => "ISO 1400 Environmental Management Systems; Industrial Waste Water Management; Environmental Pollution Assessment"             
));

$practitioner134 = Practitioner::create(array(
  'person' => "Mr. Samuel Vivian MATAAGI" ,
	'organisation_name' => "Savimaxx Ltd." ,
	'visiting_address' => "Nalya Housing Estate, Plot 843, Shelter Road" ,
	'box_no' => "P.O. Box 25250 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712 654651 " ,
	'email' => " savimaxxcompanylimited@gmail.com " ,
	'qualifications' => "MSc. Zoology; BSc. Botany, Zoology & Chemistry" ,
	'expertise' => "ISO 1400 Environmental Management Systems; Industrial Waste water Management; Environmental Pollution Assessment"             
));

$practitioner135 = Practitioner::create(array(
  'person' => "Eng. Simon P. OTOI" ,
	'organisation_name' => "Spot-on Engineering Services Ltd." ,
	'box_no' => "P.O. Box 5883" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712 707502 and 0771460309." ,
	'email' => " simonotoi@yahoo.co.uk  ; simonotoi@gmail.com " ,
	'qualifications' => "MSc. Sanitary & Civil Engineering; BSc. Civil Engineering" ,
	'expertise' => "Public Health – Water & Sanitation Assessments; Water Resources Investigations; Assessment"             
));

$practitioner136 = Practitioner::create(array(
  'person' => "Eng. Andrew Nabikamba TADHUBA" ,
	'organisation_name' => "TAMP  Engineering Consultants Ltd" ,
	'visiting_address' => "Plot 6 Entebbe Road" ,
	'box_no' => "P.O. Box 6780 " ,
	'city' => "Kampala" ,
	'phone' => "Mob: 0751504444 or 0772404414" ,
	'email' => "  tadhuba@yahoo.com" ,
	'qualifications' => "BSc. Engineering (Civil), BA. Development Studies and Democracy" ,
	'expertise' => "Civil works & construction infrastructure, Risk Assessment, Occupational Safety & Health, Materials' suitability analysis,"             
));

$practitioner137 = Practitioner::create(array(
  'person' => "Eng. Andrew Nabikamba TADHUBA" ,
	'organisation_name' => "TAMP  Engineering Consultants Ltd" ,
	'visiting_address' => "Plot 6 Entebbe Road" ,
	'box_no' => "P.O. Box 6780 " ,
	'city' => "Kampala" ,
	'phone' => "Mob:   0751504444  or 772404414" ,
	'email' => "  tadhuba@yahoo.com" ,
	'qualifications' => "BSc. Engineering (Civil), BA. Development Studies and Democracy" ,
	'expertise' => "Civil works & construction infrastructure, Risk Assessment, Occupational Safety & Health, Materials' suitability analysis,"             
));

$practitioner138 = Practitioner::create(array(
  'person' => "Ms. Sheba NDAGIRE " ,
	'organisation_name' => "Thom Consult Ltd" ,
	'visiting_address' => "33 Martyrs Way, Ntinda, " ,
	'box_no' => "P.O. Box 3976" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712638250  " ,
	'email' => " shndagire@gmail.com ; ndagires@thomug.; g " ,
	'qualifications' => "MSc. Environmental Science; BSc. Forestry " ,
	'expertise' => "Health Impact Assessment; Ecotoxicology; Biodiversity Conservation & Management; Health & Safety; Ecosystem & Spatial Epidemiology; Global Environmental Change; Energy, Housing & Construction."             
));

$practitioner139 = Practitioner::create(array(
  'person' => "Ms. Sheba NDAGIRE " ,
	'organisation_name' => "Thom Consult Ltd" ,
	'visiting_address' => "33 Martyrs Way, Ntinda, " ,
	'box_no' => "P.O. Box 3976" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712638250  " ,
	'email' => " shndagire@gmail.com ; ndagires@thomug.; g" ,
	'qualifications' => "MSc. Environmental Science, BSc. Forestry " ,
	'expertise' => "Health Impact Assessment; Ecotoxicology; Biodiversity Conservation & Management; Health & Safety; Ecosystem & Spatial Epidemiology; Global Environmental Change; Energy, Housing & Construction."             
));

$practitioner140 = Practitioner::create(array(
  'person' => "Mr. Silver SSEBAGALA" ,
	'organisation_name' => "Uganda Cleaner Production Centre " ,
	'box_no' => "P.O. Box 34644    " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0774647363" ,
	'email' => " silverssebagala@yahoo.com " ,
	'qualifications' => "Master of Science in Analytical Chemistry " ,
	'expertise' => "Cleaner Production and Industrial Process, Environment Management System (EMS), Life Cycle Analysis (LCA), Industrial Pollution Control & Management; Waste Management and Sanitation"             
));

$practitioner141 = Practitioner::create(array(
  'person' => "Dr. Charles A. KOOJO " ,
	'organisation_name' => "Urban Research and Training Consultancy (URTC)/ Enviro and Industrial Consult (EICU) " ,
	'box_no' => "P.O. Box 20032 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: Office: + 256 312 10 5641; Mobile: 0772 522707 " ,
	'email' => " Koojocharles@yahoo.co.uk ; Urtcea@urban-research.net " ,
	'qualifications' => "PhD. Landuse & Regional Planning; MSc. Geography.; PgD. Environmental Impact Assessment;" ,
	'expertise' => "Landuse Planning & Policy; Land Resources Analysis;  Environmental Planning; Strategic Environmental Assessment; Eco-Benefits & Cleaner Production; Urban Development Planning; Resettlement Action Plans for Infrastructure "             
));

$practitioner142 = Practitioner::create(array(
  'person' => "Dr. Charles A. KOOJO " ,
	'organisation_name' => "Urban Research and Training Consultancy (URTC)/ Enviro and Industrial Consult (EICU) " ,
	'box_no' => "P.O. Box 20032 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: Office:     + 256 312 10 5641; Mobile:           + 256 772 522707 " ,
	'email' => " Koojocharles@yahoo.co.uk ; Urtcea@urban-research.net" ,
	'qualifications' => "PhD. Landuse & Regional Planning; MSc. Geography.PgD. Environmental Impact Assessment;" ,
	'expertise' => "Eco-benefits and cleaner production, Infrastructure Developments, water resources, energy projects, urban planning, and telecommunications systems"             
));

$practitioner143 = Practitioner::create(array(
  'person' => "Mr. Moses OLUKA " ,
	'organisation_name' => "Urban Research and Training Consultancy Ltd" ,
	'box_no' => "P.O. Box 34950" ,
	'city' => "Kampala" ,
	'phone' => "Mob: 0774 205209 and 0702 205209" ,
	'email' => " olukaomo@yahoo.co.uk " ,
	'qualifications' => "B. Urban Planning " ,
	'expertise' => "Land Use Planning, Land Resource Assessment, Environmental Planning, Social Impact Assessment, and Infrastructural Projects Evaluation"             
));

$practitioner144 = Practitioner::create(array(
  'person' => "Mr. David Samuel WAFULA" ,
	'organisation_name' => "Urban Research and Training Consultancy Ltd" ,
	'box_no' => "P.O. Box 34950" ,
	'city' => "Kampala" ,
	'phone' => "  Tel: +256-312105641; Mob: +256-772957515" ,
	'email' => " wafulasamueldavid@yahoo.com " ,
	'qualifications' => "BA. Urban Planning; PhD. Environmental Microbiology; MSc. Environmental Science and Technology  BSc. Biochemistry and Zoology" ,
	'expertise' => "Infrastructural development, resettlement action planning, and urban planning & housing studies"             
));

$practitioner145 = Practitioner::create(array(
  'person' => "Ms. Olivia NAMUTOSI" ,
	'organisation_name' => "Winsjet Associates " ,
	'box_no' => "P.O. Box 2887 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0776949098 / 0712949098" ,
	'email' => " onamu@yahoo.com " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Social Impact Assessment, ecological, eco-tourism impact analysis, land and water resources management; and Strategic Environmental planning"             
));

$practitioner146 = Practitioner::create(array(
  'person' => "Mr. Jerome TWIMUKYE " ,
	'organisation_name' => "Winsjet Associates " ,
	'box_no' => "P.O. Box 2887 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712 152503 and  0784 115204" ,
	'email' => " jetwimkye@yahoo.co.uk " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Waste Management; Biodiversity Assessments."             
));

$practitioner147 = Practitioner::create(array(
  'person' => "Ms. Diana NAKALANZI" ,
	'organisation_name' => "WSS Services(U) Ltd" ,
	'visiting_address' => "6th Floor Impala House Annex, Plot 13/15 Kimathi Avenue" ,
	'box_no' => "P.O. Box 27755" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256752840101" ,
	'email' => " dianak@yahoo.com " ,
	'qualifications' => "MSc. Limnology and Wetland Ecosystems" ,
	'expertise' => "Wetlands ecology assessments, water quality assessments, wetlands efficiency assessments, EIA for petrol stations"             
));

$practitioner148 = Practitioner::create(array(
  'person' => "Dr. Denis BYAMUKAMA " ,
	'organisation_name' => "WSS Services(U) Ltd" ,
	'visiting_address' => "6th Floor Impala House Annex, Plot 13/15 Kimathi Avenue" ,
	'box_no' => "P.O. Box 27755" ,
	'city' => "Kampala" ,
	'phone' => " Tel: 0782 519 315 " ,
	'expertise' => "Environmental Impacts Assessment; Environmental Audits; Environmental Health; Environmental Monitoring/ Planning for Water, Wastewater, Housing, and Roads Projects."             
));

$practitioner149 = Practitioner::create(array(
  'person' => "Dr. Denis BYAMUKAMA " ,
	'organisation_name' => "WSS Services(U) Ltd" ,
	'visiting_address' => "6th Floor Impala House Annex, Plot 13/15 Kimathi Avenue" ,
	'box_no' => "P.O. Box 27755" ,
	'city' => "Kampala" ,
	'phone' => " Tel: 0782 519 315 " ,
	'qualifications' => "PhD. Environmental Microbiology;  MSc. Environmental Science and Technology;  BSc. Biochemistry and Zoology" ,
	'expertise' => "Infrastructure projects, water resources, supply industries, energy development. Solid waste and waste water, agricultural projects"             
));

$practitioner150 = Practitioner::create(array(
  'person' => "Dr. Isyagi–Levine Nelly AJANGALE" ,
	'box_no' => "P.O. Box 20044 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256 782 728028" ,
	'qualifications' => "Ph.D. Aquaculture; MSc. Aquaculture; B. Veterinary Medicine" ,
	'expertise' => "Aquaculture; Fish Health and Animal Production Assessments"             
));

$practitioner151 = Practitioner::create(array(
  'person' => "Mr. Pius KAHANGIRWE" ,
	'box_no' => "P.O. Box 27755 " ,
	'city' => "Kampala" ,
	'phone' => "Mob: 0712 929120" ,
	'email' => " kpuirs@gmail.com ; pkahangirwe@muienr.mak.ac.ug " ,
	'qualifications' => "MSc. Environment & Natural Resources, BA. Environmental Management" ,
	'expertise' => "Environmental Heath and Social Impact assessment, Water resources management, Cumulative Effects Assessment, Climate Change Impact Assessment, Planning Infrastructure Development"             
));

$practitioner152 = Practitioner::create(array(
  'person' => "Mr. Richard OSALIYA" ,
	'box_no' => "P.O. Box 7611" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782 451815" ,
	'email' => " osaliya@yahoo.com " ,
	'qualifications' => "MSc. Environment & Natural Resources; Bachelor of Urban Planning" ,
	'expertise' => "Water Resources Management, Urban Development, Land-use assessments, Cumulative Impacts, Climate Change Impact Assessment"             
));

$practitioner153 = Practitioner::create(array(
  'person' => "Dr. Bruce RUKUNDO" ,
	'box_no' => "P.O. Box 1729" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256782392951" ,
	'email' => "rukundobr@yahoo.com ; brucerukundo@gmail.com " ,
	'qualifications' => "Phd Land Management (Dr.-Ing.); MSc. Land Management and Tenure, BA. Environmental Management" ,
	'expertise' => "Land-use Planning and Management, Disaster and Environmental Risk Assessments"             
));

$practitioner154 = Practitioner::create(array(
  'person' => "Mr. Robert NDYABAREMA" ,
	'box_no' => "P.O. Box 10491 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256-414-543826 / Mobile: +256-712-417452" ,
	'email' => " rndyaba@gmail.com  " ,
	'qualifications' => "MSc. Environment & Natural Resources; BSc. Geography & Environment." ,
	'expertise' => "Environment & Natural Resources"             
));

$practitioner155 = Practitioner::create(array(
  'person' => "Mr. Ronald ANGUTOKO" ,
	'box_no' => "P.O. Box 37372 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0789467372  OR  0701839299" ,
	'email' => " rangutoko@yahoo.com " ,
	'qualifications' => "BSc. in Environmental Engineering " ,
	'expertise' => "Infrastructural  Development, Waste management, Water and Air Pollution, Wetland Resources Management, Public Health and Safety"             
));

$practitioner156 = Practitioner::create(array(
  'person' => "Mr. Bryan OKEDI" ,
	'box_no' => "P.O. Box 9317" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782 383300" ,
	'email' => "  bryokd@live.com " ,
	'qualifications' => "BSc. Environmental Management" ,
	'expertise' => "Environmental Pollution assessment, Water quality  assessments, Fuel dispensing facilities, , and Social Impact Assessment"             
));

$practitioner157 = Practitioner::create(array(
  'person' => "Mr. Richard BAVAKURE " ,
	'visiting_address' => "Plot 44 Lunyo Road" ,
	'box_no' => "P.O. Box 34 " ,
	'city' => "Entebbe" ,
	'phone' => "Tel: 0782 090677/ 0754 090677" ,
	'email' => " bavarichard@yahoo.co.uk " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Telecom Projects and assisting in general EIAs."             
));

$practitioner158 = Practitioner::create(array(
  'person' => "Mr. Alex ASIIMWE" ,
	'box_no' => "P.O. Box 34061" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0784 224448 or  0702 213165" ,
	'email' => " asiimwealex@gmail.com " ,
	'qualifications' => "MSc. Environment & Natural Resources; BA. Environmental Management; PgD-PPM, & PgD-OSH" ,
	'expertise' => "Occupational Safety & Health, Natural Resources Management, Social Safeguards, Resettlement Action Planning, Labourforce management, Waste Management, Cleaner"             
));

$practitioner159 = Practitioner::create(array(
  'person' => "Mr. Tom Ndamira RUKUNDO " ,
	'box_no' => "P.O. Box 21129" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 591205" ,
	'email' => "  rukundotn@yahoo.com  ; tomr@nfa.; g.ug " ,
	'qualifications' => "MSc. Environment and Natural Resource  Management, BSc. Forestry, PgD. Education" ,
	'expertise' => "Environmental  and Natural Resources Management Forestry"             
));

$practitioner160 = Practitioner::create(array(
  'person' => "Mr. Wilbroad KUKUNDAKWE" ,
	'visiting_address' => "Plot 4 Jinja Road, 3rd Floor, Northern Wing, Social Security House," ,
	'box_no' => "P.O. Box 29005  " ,
	'city' => "Kampala" ,
	'phone' => "Mobile: 0772-842416" ,
	'email' => " wilbroadk@gmail.com " ,
	'qualifications' => "BSc. Industrial Chemistry" ,
	'expertise' => "Chemicals Management; Waste Management; "             
));

$practitioner161 = Practitioner::create(array(
  'person' => "Mr. Isaac KIFAMULUSI" ,
	'box_no' => "P.O. Box 28119 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0783019566; 0702209581" ,
	'email' => " isaackifamulusi@yahoo.com" ,
	'qualifications' => "BSc. Environmental Science" ,
	'expertise' => "Ecosystems Management, Environmental Pollution, Waste Management, Cleaner Production, Occupational Health and Safety and Climate Change Services "             
));

$practitioner162 = Practitioner::create(array(
  'person' => "Ms. Enid Ocaya KABASINGUZI" ,
	'box_no' => "P.O. Box 3790 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256 772668727" ,
	'email' => " enidkabocaya@gmail.com" ,
	'qualifications' => "BSc. Botany and Zoology" ,
	'expertise' => "Environment Natural Resources Management"             
));

$practitioner163 = Practitioner::create(array(
  'person' => "Mr. Fred SSEGIRINYA" ,
	'visiting_address' => "Plot 15, Bandali Rise, Bugolobi; " ,
	'box_no' => "P.O. Box 40311 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712 804425" ,
	'email' => " fssegirinya93@yahoo.com " ,
	'qualifications' => "BSc. Forestry" ,
	'expertise' => "Forestry Projects, Seismic Surveys; Exploratory Drilling; Quarries; Water & Infrastructural Developments; "             
));

$practitioner164 = Practitioner::create(array(
  'person' => "Mr. Derrick KYATEREKERA " ,
	'box_no' => "P.O. Box 10454 " ,
	'city' => "Kampala" ,
	'phone' => "Mob: 0772 457282 and  0712 574159" ,
	'email' => " kyderrick@gmail.com " ,
	'qualifications' => "MSc. Natural Resources Management, BA. Environmental Management " ,
	'expertise' => "Oil & Gas Environmental Management, Waste Management; Eco-Tourism Impact Analysis; Work-Public Health and Safety;  Social Impact Assessment; Control of Substances Hazardous to Health (COSHH); Site Rehabilitation & Restoration, Gas testing & Confined space related works"             
));

$practitioner165 = Practitioner::create(array(
  'person' => "Ms. Celia NALWADDA" ,
	'box_no' => "P.O. Box 10395" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256 772537830" ,
	'email' => " jtcelia@yahoo.co.uk ; jtcelia@gmail.com " ,
	'qualifications' => "MSc. Land Management (Natural Resources management), BSc. Forestry" ,
	'expertise' => "Natural resources management, social resources survey, land use planning, and GIS & Remote sensing"             
));

$practitioner166 = Practitioner::create(array(
  'person' => "Mr. Godfrey BAHATI" ,
	'box_no' => "P.O. Box 9" ,
	'city' => "Entebbe" ,
	'phone' => "Tel: 0775601232" ,
	'email' => " gbahati@gmail.com " ,
	'qualifications' => "MSc. Environmental Management,  BSc. Chemistry" ,
	'expertise' => "Minerals and Energy, Geothermal Assessment, Waste Management, Pollution Control"             
));

$practitioner167 = Practitioner::create(array(
  'person' => "Ms. Edith Birungi KAHUBIRE " ,
	'box_no' => "P.O. Box 1299" ,
	'city' => "Kampala" ,
	'phone' => "Tel.     0772 540966 and 702540966" ,
	'email' => " kahubire@yahoo.co.uk " ,
	'qualifications' => "M.Phil. Development Geography; MSc. Geo-Information Science and Earth Observation (Natural Resource Management); BA. Social Sciences " ,
	'expertise' => "Social Impact Assessment; Economic Assessment; Cultural Assessment."             
));

$practitioner168 = Practitioner::create(array(
  'person' => "Mr. Isaac TUNYWANE " ,
	'box_no' => "P.O. Box 11175 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256 782 036665" ,
	'email' => " itunywane@yahoo.com " ,
	'qualifications' => "B. Environmental Science " ,
	'expertise' => "Waste Management, Environmental Health and Safety, Water and Sanitation Assessment."             
));

$practitioner169 = Practitioner::create(array(
  'person' => "Mr. John T. TUMUHIMBISE" ,
	'box_no' => "P.O. Box 7270" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 694014 and 0414-257863." ,
	'qualifications' => "MSc. Energy Studies; BSc. Forestry." ,
	'expertise' => "Forestry and Energy."             
));

$practitioner170 = Practitioner::create(array(
  'person' => "Ms. Harriet NANKYA" ,
	'box_no' => "P.O. Box 4856" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772 868154" ,
	'email' => " nankyaha@yahoo.co.uk " ,
	'qualifications' => "BSc. Forestry" ,
	'expertise' => "Forestry and Natural Resources, Ecosystem Assessment Impacts Analysis, Recreation and Tourism Infrastructure."             
));

$practitioner171 = Practitioner::create(array(
  'person' => "Mr. George Herbert KYABOONA" ,
	'box_no' => "P.O. Box 16422" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772996387" ,
	'email' => " kyaboona@gmail.com " ,
	'qualifications' => "MSc. Environment and Development, B.A Environment Management; PgD. Research Methods and Writing Skills " ,
	'expertise' => "Resettlement Action Planning, Social impact Assessments, Environmental Education, Waste management, Occupational Health and Safety Assessments."             
));

$practitioner172 = Practitioner::create(array(
  'person' => "Ms. Phenella EMODEK" ,
	'box_no' => "P.O. Box 70711" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0787492755 and 0712 614 491" ,
	'email' => " emophenella@yahoo.com " ,
	'qualifications' => "BSc. Fisheries and" ,
	'expertise' => "Environmental Management and Resource Management; Basic Aquatic Ecology Assessments; Utilization of Non-Conventional Aquatic Resources; Aquaculture"             
));

$practitioner173 = Practitioner::create(array(
  'person' => "Ms. Susan Kigozi TAKIRAMBUDDE" ,
	'box_no' => "P.O. Box 7062" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772450749 and 0772409491" ,
	'email' => " tskigozi@yahoo.co.uk " ,
	'qualifications' => "MSc. Environment and Natural Resources; Diploma in Science Technology (Chemistry)" ,
	'expertise' => "Social Economic Assessments, Occupational Health and Safety, Natural resource Management and Cleaner Production"             
));

$practitioner174 = Practitioner::create(array(
  'person' => "Mr. Isaiah OWIUNJI" ,
	'box_no' => "P.O. Box 3205" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0772-411278" ,
	'email' => " iowiunji@wwfuganda.; g ; " ,
	'qualifications' => "MSc. Zoology (Vertebrate Ecology &
Natural Resource
Management) BSc. Zoology" ,
	'expertise' => "Vertebrate Ecology, Wildlife Evaluation, and Natural"             
));

$practitioner175 = Practitioner::create(array(
  'person' => "Dr. Fred Alex TUGUME" ,
	'box_no' => "P.O. Box 9" ,
	'city' => " Entebbe" ,
	'phone' => "Tel: 0772471131" ,
	'email' => "   fredtugume@gmail.com" ,
	'qualifications' => "PhD. in Geo Sciences, MSc.  GeoSciences, MSc.  Geophysics, BSc. Physics & Mathematics" ,
	'expertise' => "Land Use Planning and Management, Impact Predictions."             
));

$practitioner176 = Practitioner::create(array(
  'person' => "Ms. Shallon NIWAMANYA" ,
	'box_no' => "P.O. Box 28907 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0774422616" ,
	'email' => " shalloni@gmail.com " ,
	'qualifications' => "BSc. In Environmental Science, PgD. in Environmental Management  " ,
	'expertise' => "Waste Management, Environmental Health and Safety, Water and Sanitation Assessment and Energy/ Petroleum Retail Facilities"             
));

$practitioner177 = Practitioner::create(array(
  'person' => "Dr. Isyagi–Levine Nelly AJANGALE" ,
	'box_no' => "P.O. Box 20044 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256 782 728028" ,
	'email' => " nisyagi18@yahoo.co.uk " ,
	'qualifications' => "Ph.D. Aquaculture; MSc. Aquaculture; B. Veterinary Medicine" ,
	'expertise' => "Aquaculture; Fish Health and Animal Production Assessments"             
));

$practitioner178 = Practitioner::create(array(
  'person' => "Mr. Alex KAKUUKU" ,
	'box_no' => "P.O. Box 9031" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0782022087" ,
	'email' => " ajkakuuku@gmail.com" ,
	'qualifications' => "Bachelor of Science in Environmental Management" ,
	'expertise' => "Industrial Waste management, Environmental Management Systems, Infrastructural development(Telecom masts), Occupational health and safety"             
));

$practitioner179 = Practitioner::create(array(
  'person' => "Dr. Bruce RUKUNDO" ,
	'box_no' => "P.O. Box 1729" ,
	'city' => "Kampala" ,
	'phone' => "Tel: +256782392951" ,
	'email' => " rukundobr@yahoo.com ; brucerukundo@gmail.com " ,
	'qualifications' => "Phd Land Management (Dr.-Ing.), MSc. Land Management and Tenure, BA. Environmental Management" ,
	'expertise' => "Land-use Planning and Management, Disaster and Environmental Risk Assessments"             
));

$practitioner180 = Practitioner::create(array(
  'person' => "Mr. Pius KAHANGIRWE" ,
	'box_no' => "P.O. Box 27755 " ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0712 929120 or  0701 570318" ,
	'email' => " kpuirs@gmail.com ; pkahangirwe@muienr.mak.ac.ug" ,
	'qualifications' => "MSc. Environment & Natural Resources, BA. Environmental Management" ,
	'expertise' => "Water resources management, Cumulative effects assessments, Climate change, planning infrastructure development"             
));

$practitioner181 = Practitioner::create(array(
  'person' => "Mr. Richard BAVAKURE " ,
	'visiting_address' => "Plot 44 Lunyo Road" ,
	'box_no' => "P.O. Box 34 " ,
	'city' => "Entebbe" ,
	'phone' => "Tel: 0782 090677/ 0754 090677" ,
	'email' => " bavarichard@yahoo.co.uk " ,
	'qualifications' => "B.A. Environmental Management  " ,
	'expertise' => "Telecom Projects and Assisting in General EA’s."             
));

$practitioner182 = Practitioner::create(array(
  'person' => "Mr. Alex ASIIMWE" ,
	'box_no' => "P.O. Box 34061" ,
	'city' => "Kampala" ,
	'phone' => "Tel: 0784 224448/ 0702 213165" ,
	'email' => " asiimwealex@gmail.com " ,
	'qualifications' => "MSc. Environment & Natural Resources, PgD-PPM, &  PgD-OSH" ,
	'expertise' => "Occupational Safety & Health, Natural Resources Management, Social Safeguards, Waste Management, Cleaner"             
));

$practitioner183 = Practitioner::create(array(
  'person' => "Mr. Wilbroad KUKUNDAKWE" ,
	'visiting_address' => "Plot 4 Jinja Road, 3rd Floor, Northern Wing, Social Security House," ,
	'box_no' => "P.O. Box 29005  " ,
	'city' => "Kampala" ,
	'phone' => "Mobile: 0772-842416" ,
	'email' => " wilbroadk@gmail.com " ,
	'qualifications' => "BSc. Industrial Chemistry" ,
	'expertise' => "Waste Management, Pollution Control, Environmental Management Systems, Cleaner Production "             
));

$practitioner184 = Practitioner::create(array(
  'person' => "Ms. Celia NALWADDA" ,
	'box_no' => "P.O. Box 10395" ,
	'city' => "Kampala" ,
	'phone' => "Mob: +256 772537830" ,
	'email' => " jtcelia@yahoo.co.uk ; jtcelia@gmail.com " ,
	'qualifications' => "MSc. Land Management (Natural Resources management); BSc. Forestry" ,
	'expertise' => "Natural resources management, social resources survey, land use planning, and GIS & Remote sensing"             
));

$practitioner185 = Practitioner::create(array(
  'person' => "Ms. Edith Birungi KAHUBIRE " ,
	'box_no' => "P.O. Box 1299" ,
	'city' => "Kampala" ,
	'phone' => "Tel. 0772 540966 and  0702540966" ,
	'email' => " kahubire@yahoo.co.uk " ,
	'qualifications' => "M.Phil. Development Geography; MSc. Geo-Information Science and Earth Observation (Natural Resource Management); BA. Social Sciences" ,
	'expertise' => "Social Impact Audits; Socio-Economic Audits; Cultural Assessments."             
));

$practitionercertificate1 = PractitionerCertificate::create(array(
  'practitioner_id' => 1 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 80 ,
	'cert_no' => "CC/EIA/080/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate2 = PractitionerCertificate::create(array(
  'practitioner_id' => 2 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 73 ,
	'cert_no' => "CC/EIA/073/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate3 = PractitionerCertificate::create(array(
  'practitioner_id' => 3 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 74 ,
	'cert_no' => "CC/EIA/074/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate4 = PractitionerCertificate::create(array(
  'practitioner_id' => 4 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 75 ,
	'cert_no' => "CC/EIA/075/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate5 = PractitionerCertificate::create(array(
  'practitioner_id' => 5 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 76 ,
	'cert_no' => "CC/EIA/076/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate6 = PractitionerCertificate::create(array(
  'practitioner_id' => 6 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 77 ,
	'cert_no' => "CC/EIA/077/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate7 = PractitionerCertificate::create(array(
  'practitioner_id' => 7 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 78 ,
	'cert_no' => "CC/EIA/078/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate8 = PractitionerCertificate::create(array(
  'practitioner_id' => 8 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 79 ,
	'cert_no' => "CC/EIA/079/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate9 = PractitionerCertificate::create(array(
  'practitioner_id' => 9 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 39 ,
	'cert_no' => "CC/EA/039/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate10 = PractitionerCertificate::create(array(
  'practitioner_id' => 10 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 40 ,
	'cert_no' => "CC/EA/040/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate11 = PractitionerCertificate::create(array(
  'practitioner_id' => 11 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 41 ,
	'cert_no' => "CC/EA/041/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate12 = PractitionerCertificate::create(array(
  'practitioner_id' => 12 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 42 ,
	'cert_no' => "CC/EA/042/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate13 = PractitionerCertificate::create(array(
  'practitioner_id' => 13 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 29 ,
	'cert_no' => "CC/EIA/029/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate14 = PractitionerCertificate::create(array(
  'practitioner_id' => 14 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-10" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 9 ,
	'cert_no' => "CC/EIA/009/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate15 = PractitionerCertificate::create(array(
  'practitioner_id' => 15 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 113 ,
	'cert_no' => "CC/EIA/113/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate16 = PractitionerCertificate::create(array(
  'practitioner_id' => 16 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 57 ,
	'cert_no' => "CC/EA/057/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate17 = PractitionerCertificate::create(array(
  'practitioner_id' => 17 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 30 ,
	'cert_no' => "CC/EIA/030/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate18 = PractitionerCertificate::create(array(
  'practitioner_id' => 18 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 31 ,
	'cert_no' => "CC/EIA/031/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate19 = PractitionerCertificate::create(array(
  'practitioner_id' => 19 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 16 ,
	'cert_no' => "CC/EA/016/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate20 = PractitionerCertificate::create(array(
  'practitioner_id' => 20 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 17 ,
	'cert_no' => "CC/EA/017/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate21 = PractitionerCertificate::create(array(
  'practitioner_id' => 21 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 20 ,
	'cert_no' => "CC/EIA/020/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate22 = PractitionerCertificate::create(array(
  'practitioner_id' => 22 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 12 ,
	'cert_no' => "CC/EA/012/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate23 = PractitionerCertificate::create(array(
  'practitioner_id' => 23 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 5 ,
	'cert_no' => "CC/EIA/005/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate24 = PractitionerCertificate::create(array(
  'practitioner_id' => 24 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 21 ,
	'cert_no' => "CC/EIA/021/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate25 = PractitionerCertificate::create(array(
  'practitioner_id' => 25 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 38 ,
	'cert_no' => "CC/EIA/038/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate26 = PractitionerCertificate::create(array(
  'practitioner_id' => 26 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 102 ,
	'cert_no' => "CC/EIA/102/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate27 = PractitionerCertificate::create(array(
  'practitioner_id' => 27 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 3 ,
	'cert_no' => "CC/EA/003/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate28 = PractitionerCertificate::create(array(
  'practitioner_id' => 28 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 13 ,
	'cert_no' => "CC/EA/013/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate29 = PractitionerCertificate::create(array(
  'practitioner_id' => 29 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 20 ,
	'cert_no' => "CC/EA/020/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate30 = PractitionerCertificate::create(array(
  'practitioner_id' => 30 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 52 ,
	'cert_no' => "CC/EA/052/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate31 = PractitionerCertificate::create(array(
  'practitioner_id' => 31 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 126 ,
	'cert_no' => "CC/EIA/126/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate32 = PractitionerCertificate::create(array(
  'practitioner_id' => 32 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-14" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 14 ,
	'cert_no' => "CC/EIA/014/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate33 = PractitionerCertificate::create(array(
  'practitioner_id' => 33 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-20" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 50 ,
	'cert_no' => "CC/EIA/050/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate34 = PractitionerCertificate::create(array(
  'practitioner_id' => 34 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 82 ,
	'cert_no' => "CC/EIA/082/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate35 = PractitionerCertificate::create(array(
  'practitioner_id' => 35 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-20" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 28 ,
	'cert_no' => "CC/EA/028/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate36 = PractitionerCertificate::create(array(
  'practitioner_id' => 36 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-08" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 6 ,
	'cert_no' => "CC/EIA/006/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate37 = PractitionerCertificate::create(array(
  'practitioner_id' => 37 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 16 ,
	'cert_no' => "CC/EIA/016/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate38 = PractitionerCertificate::create(array(
  'practitioner_id' => 38 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 9 ,
	'cert_no' => "CC/EA/009/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate39 = PractitionerCertificate::create(array(
  'practitioner_id' => 39 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-09" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 8 ,
	'cert_no' => "CC/EIA/008/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate40 = PractitionerCertificate::create(array(
  'practitioner_id' => 40 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-09" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 5 ,
	'cert_no' => "CC/EA/005/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate41 = PractitionerCertificate::create(array(
  'practitioner_id' => 41 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-16" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 25 ,
	'cert_no' => "CC/EIA/025/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate42 = PractitionerCertificate::create(array(
  'practitioner_id' => 42 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-14" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 7 ,
	'cert_no' => "CC/EA/007/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate43 = PractitionerCertificate::create(array(
  'practitioner_id' => 43 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 27 ,
	'cert_no' => "CC/EIA/027/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate44 = PractitionerCertificate::create(array(
  'practitioner_id' => 44 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-05" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 44 ,
	'cert_no' => "CC/EIA/044/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate45 = PractitionerCertificate::create(array(
  'practitioner_id' => 45 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-20" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 51 ,
	'cert_no' => "CC/EIA/051/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate46 = PractitionerCertificate::create(array(
  'practitioner_id' => 46 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-20" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 52 ,
	'cert_no' => "CC/EIA/052/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate47 = PractitionerCertificate::create(array(
  'practitioner_id' => 47 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-20" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 29 ,
	'cert_no' => "CC/EA/029/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate48 = PractitionerCertificate::create(array(
  'practitioner_id' => 48 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-20" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 30 ,
	'cert_no' => "CC/EA/030/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate49 = PractitionerCertificate::create(array(
  'practitioner_id' => 49 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 97 ,
	'cert_no' => "CC/EIA/097/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate50 = PractitionerCertificate::create(array(
  'practitioner_id' => 50 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 50 ,
	'cert_no' => "CC/EA/050/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate51 = PractitionerCertificate::create(array(
  'practitioner_id' => 51 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 28 ,
	'cert_no' => "CC/EIA/028/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate52 = PractitionerCertificate::create(array(
  'practitioner_id' => 52 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 15 ,
	'cert_no' => "CC/EA/015/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate53 = PractitionerCertificate::create(array(
  'practitioner_id' => 53 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-25" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 59 ,
	'cert_no' => "CC/EIA/059/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate54 = PractitionerCertificate::create(array(
  'practitioner_id' => 54 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 19 ,
	'cert_no' => "CC/EIA/019/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate55 = PractitionerCertificate::create(array(
  'practitioner_id' => 55 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 23 ,
	'cert_no' => "CC/EIA/023/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate56 = PractitionerCertificate::create(array(
  'practitioner_id' => 56 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-22" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 33 ,
	'cert_no' => "CC/EIA/033/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate57 = PractitionerCertificate::create(array(
  'practitioner_id' => 57 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-22" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 34 ,
	'cert_no' => "CC/EIA/034/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate58 = PractitionerCertificate::create(array(
  'practitioner_id' => 58 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 10 ,
	'cert_no' => "CC/EA/010/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate59 = PractitionerCertificate::create(array(
  'practitioner_id' => 59 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-22" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 19 ,
	'cert_no' => "CC/EA/019/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate60 = PractitionerCertificate::create(array(
  'practitioner_id' => 60 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 81 ,
	'cert_no' => "CC/EIA/081/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate61 = PractitionerCertificate::create(array(
  'practitioner_id' => 61 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 43 ,
	'cert_no' => "CC/EA/043/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate62 = PractitionerCertificate::create(array(
  'practitioner_id' => 62 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-21" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 55 ,
	'cert_no' => "CC/EIA/055/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate63 = PractitionerCertificate::create(array(
  'practitioner_id' => 63 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-21" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 33 ,
	'cert_no' => "CC/EA/033/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate64 = PractitionerCertificate::create(array(
  'practitioner_id' => 64 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 48 ,
	'cert_no' => "CC/EIA/048/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate65 = PractitionerCertificate::create(array(
  'practitioner_id' => 65 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 25 ,
	'cert_no' => "CC/EA/025/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate66 = PractitionerCertificate::create(array(
  'practitioner_id' => 66 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-01" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 55 ,
	'cert_no' => "CC/EA/055/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate67 = PractitionerCertificate::create(array(
  'practitioner_id' => 67 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 42 ,
	'cert_no' => "CC/EIA/042/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate68 = PractitionerCertificate::create(array(
  'practitioner_id' => 68 ,
	'year' => 2013 ,
	'date_of_entry' => "2012-01-20" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 23 ,
	'cert_no' => "CC/EA/023/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate69 = PractitionerCertificate::create(array(
  'practitioner_id' => 69 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-07" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 117 ,
	'cert_no' => "CC/EIA/117/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate70 = PractitionerCertificate::create(array(
  'practitioner_id' => 70 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 40 ,
	'cert_no' => "CC/EIA/040/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate71 = PractitionerCertificate::create(array(
  'practitioner_id' => 71 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 41 ,
	'cert_no' => "CC/EIA/041/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate72 = PractitionerCertificate::create(array(
  'practitioner_id' => 72 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 21 ,
	'cert_no' => "CC/EA/021/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate73 = PractitionerCertificate::create(array(
  'practitioner_id' => 73 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 22 ,
	'cert_no' => "CC/EA/022/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate74 = PractitionerCertificate::create(array(
  'practitioner_id' => 74 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 68 ,
	'cert_no' => "CC/EIA/068/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate75 = PractitionerCertificate::create(array(
  'practitioner_id' => 75 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 103 ,
	'cert_no' => "CC/EIA/103/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate76 = PractitionerCertificate::create(array(
  'practitioner_id' => 76 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 53 ,
	'cert_no' => "CC/EA/053/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate77 = PractitionerCertificate::create(array(
  'practitioner_id' => 77 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 83 ,
	'cert_no' => "CC/EIA/083/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate78 = PractitionerCertificate::create(array(
  'practitioner_id' => 78 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 44 ,
	'cert_no' => "CC/EA/044/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate79 = PractitionerCertificate::create(array(
  'practitioner_id' => 79 ,
	'year' => 2013 ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 123 ,
	'cert_no' => "CC/EIA/123/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate80 = PractitionerCertificate::create(array(
  'practitioner_id' => 80 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 60 ,
	'cert_no' => "CC/EA/060/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate81 = PractitionerCertificate::create(array(
  'practitioner_id' => 81 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 98 ,
	'cert_no' => "CC/EIA/098/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate82 = PractitionerCertificate::create(array(
  'practitioner_id' => 82 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-03" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 4 ,
	'cert_no' => "CC/EIA/004/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate83 = PractitionerCertificate::create(array(
  'practitioner_id' => 83 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-03" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 2 ,
	'cert_no' => "CC/EA/002/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate84 = PractitionerCertificate::create(array(
  'practitioner_id' => 84 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 104 ,
	'cert_no' => "CC/EIA/104/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate85 = PractitionerCertificate::create(array(
  'practitioner_id' => 85 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 54 ,
	'cert_no' => "CC/EA/054/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate86 = PractitionerCertificate::create(array(
  'practitioner_id' => 86 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 18 ,
	'cert_no' => "CC/EIA/018/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate87 = PractitionerCertificate::create(array(
  'practitioner_id' => 87 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 121 ,
	'cert_no' => "CC/EIA/121/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate88 = PractitionerCertificate::create(array(
  'practitioner_id' => 88 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 59 ,
	'cert_no' => "CC/EA/059/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate89 = PractitionerCertificate::create(array(
  'practitioner_id' => 89 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 88 ,
	'cert_no' => "CC/EIA/088/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate90 = PractitionerCertificate::create(array(
  'practitioner_id' => 90 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 94 ,
	'cert_no' => "CC/EIA/094/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate91 = PractitionerCertificate::create(array(
  'practitioner_id' => 91 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-21" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 53 ,
	'cert_no' => "CC/EIA/053/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate92 = PractitionerCertificate::create(array(
  'practitioner_id' => 92 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-22" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 56 ,
	'cert_no' => "CC/EIA/056/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate93 = PractitionerCertificate::create(array(
  'practitioner_id' => 93 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-22" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 34 ,
	'cert_no' => "CC/EA/034/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate94 = PractitionerCertificate::create(array(
  'practitioner_id' => 94 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-13" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 46 ,
	'cert_no' => "CC/EIA/046/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate95 = PractitionerCertificate::create(array(
  'practitioner_id' => 95 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-13" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 47 ,
	'cert_no' => "CC/EIA/047/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate96 = PractitionerCertificate::create(array(
  'practitioner_id' => 96 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-13" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 119 ,
	'cert_no' => "CC/EIA/119/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate97 = PractitionerCertificate::create(array(
  'practitioner_id' => 97 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-13" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 58 ,
	'cert_no' => "CC/EA/058/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate98 = PractitionerCertificate::create(array(
  'practitioner_id' => 98 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 122 ,
	'cert_no' => "CC/EIA/122/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate99 = PractitionerCertificate::create(array(
  'practitioner_id' => 99 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 61 ,
	'cert_no' => "CC/EIA/061/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate100 = PractitionerCertificate::create(array(
  'practitioner_id' => 100 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 71 ,
	'cert_no' => "CC/EIA/071/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate101 = PractitionerCertificate::create(array(
  'practitioner_id' => 101 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-05" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 43 ,
	'cert_no' => "CC/EIA/043/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate102 = PractitionerCertificate::create(array(
  'practitioner_id' => 102 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => "/91" ,
	'cert_no' => "CC/EIA/91/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate103 = PractitionerCertificate::create(array(
  'practitioner_id' => 103 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-05" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 24 ,
	'cert_no' => "CC/EA/024/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate104 = PractitionerCertificate::create(array(
  'practitioner_id' => 104 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-01" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 105 ,
	'cert_no' => "CC/EIA/105/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate105 = PractitionerCertificate::create(array(
  'practitioner_id' => 105 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-01" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 106 ,
	'cert_no' => "CC/EIA/106/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate106 = PractitionerCertificate::create(array(
  'practitioner_id' => 106 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-09" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 7 ,
	'cert_no' => "CC/EIA/007/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate107 = PractitionerCertificate::create(array(
  'practitioner_id' => 107 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-09" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 4 ,
	'cert_no' => "CC/EA/004/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate108 = PractitionerCertificate::create(array(
  'practitioner_id' => 108 ,
	'year' => 2013 ,
	'date_of_entry' => "2012-12-19" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 1 ,
	'cert_no' => "CC/EIA/001/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate109 = PractitionerCertificate::create(array(
  'practitioner_id' => 109 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-11" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 11 ,
	'cert_no' => "CC/EIA/011/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate110 = PractitionerCertificate::create(array(
  'practitioner_id' => 110 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-11" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 12 ,
	'cert_no' => "CC/EIA/012/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate111 = PractitionerCertificate::create(array(
  'practitioner_id' => 111 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-11" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 13 ,
	'cert_no' => "CC/EIA/013/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate112 = PractitionerCertificate::create(array(
  'practitioner_id' => 112 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 24 ,
	'cert_no' => "CC/EIA/024/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate113 = PractitionerCertificate::create(array(
  'practitioner_id' => 113 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-01" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 109 ,
	'cert_no' => "CC/EIA/109/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate114 = PractitionerCertificate::create(array(
  'practitioner_id' => 114 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-01" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 110 ,
	'cert_no' => "CC/EIA/110/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate115 = PractitionerCertificate::create(array(
  'practitioner_id' => 115 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-01" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 56 ,
	'cert_no' => "CC/EA/056/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate116 = PractitionerCertificate::create(array(
  'practitioner_id' => 116 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 39 ,
	'cert_no' => "CC/EIA/039/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate117 = PractitionerCertificate::create(array(
  'practitioner_id' => 117 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-10" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 10 ,
	'cert_no' => "CC/EIA/010/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate118 = PractitionerCertificate::create(array(
  'practitioner_id' => 118 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-10" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 6 ,
	'cert_no' => "CC/EA/006/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate119 = PractitionerCertificate::create(array(
  'practitioner_id' => 119 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 67 ,
	'cert_no' => "CC/EIA/067/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate120 = PractitionerCertificate::create(array(
  'practitioner_id' => 120 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-21" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 54 ,
	'cert_no' => "CC/EIA/054/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate121 = PractitionerCertificate::create(array(
  'practitioner_id' => 121 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-21" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 31 ,
	'cert_no' => "CC/EA/031/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate122 = PractitionerCertificate::create(array(
  'practitioner_id' => 122 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 85 ,
	'cert_no' => "CC/EIA/085/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate123 = PractitionerCertificate::create(array(
  'practitioner_id' => 123 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 46 ,
	'cert_no' => "CC/EA/046/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate124 = PractitionerCertificate::create(array(
  'practitioner_id' => 124 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 120 ,
	'cert_no' => "CC/EIA/120/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate125 = PractitionerCertificate::create(array(
  'practitioner_id' => 125 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 99 ,
	'cert_no' => "CC/EIA/099/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate126 = PractitionerCertificate::create(array(
  'practitioner_id' => 126 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 100 ,
	'cert_no' => "CC/EIA/100/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate127 = PractitionerCertificate::create(array(
  'practitioner_id' => 127 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 101 ,
	'cert_no' => "CC/EIA/101/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate128 = PractitionerCertificate::create(array(
  'practitioner_id' => 128 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 51 ,
	'cert_no' => "CC/EA/051/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate129 = PractitionerCertificate::create(array(
  'practitioner_id' => 129 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-05" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 115 ,
	'cert_no' => "CC/EIA/115/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate130 = PractitionerCertificate::create(array(
  'practitioner_id' => 130 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-02" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 2 ,
	'cert_no' => "CC/EIA/002/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate131 = PractitionerCertificate::create(array(
  'practitioner_id' => 131 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-02" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 3 ,
	'cert_no' => "CC/EIA/003/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate132 = PractitionerCertificate::create(array(
  'practitioner_id' => 132 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-02" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 1 ,
	'cert_no' => "CC/EA/001/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate133 = PractitionerCertificate::create(array(
  'practitioner_id' => 133 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-14" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 15 ,
	'cert_no' => "CC/EIA/015/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate134 = PractitionerCertificate::create(array(
  'practitioner_id' => 134 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-14" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 8 ,
	'cert_no' => "CC/EA/008/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate135 = PractitionerCertificate::create(array(
  'practitioner_id' => 135 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-06" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 116 ,
	'cert_no' => "CC/EIA/116/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate136 = PractitionerCertificate::create(array(
  'practitioner_id' => 136 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-19" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 49 ,
	'cert_no' => "CC/EIA/049/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate137 = PractitionerCertificate::create(array(
  'practitioner_id' => 137 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-19" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 26 ,
	'cert_no' => "CC/EA/026/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate138 = PractitionerCertificate::create(array(
  'practitioner_id' => 138 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 95 ,
	'cert_no' => "CC/EIA/095/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate139 = PractitionerCertificate::create(array(
  'practitioner_id' => 139 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 49 ,
	'cert_no' => "CC/EA/049/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate140 = PractitionerCertificate::create(array(
  'practitioner_id' => 140 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-20" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 27 ,
	'cert_no' => "CC/EA/027/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate141 = PractitionerCertificate::create(array(
  'practitioner_id' => 141 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 89 ,
	'cert_no' => "CC/EIA/089/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate142 = PractitionerCertificate::create(array(
  'practitioner_id' => 142 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 47 ,
	'cert_no' => "CC/EA/047/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate143 = PractitionerCertificate::create(array(
  'practitioner_id' => 143 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 90 ,
	'cert_no' => "CC/EIA/090/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate144 = PractitionerCertificate::create(array(
  'practitioner_id' => 144 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 92 ,
	'cert_no' => "CC/EIA/092/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate145 = PractitionerCertificate::create(array(
  'practitioner_id' => 145 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 62 ,
	'cert_no' => "CC/EIA/062/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate146 = PractitionerCertificate::create(array(
  'practitioner_id' => 146 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 87 ,
	'cert_no' => "CC/EIA/087/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate147 = PractitionerCertificate::create(array(
  'practitioner_id' => 147 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 37 ,
	'cert_no' => "CC/EIA/037/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate148 = PractitionerCertificate::create(array(
  'practitioner_id' => 148 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 93 ,
	'cert_no' => "CC/EIA/093/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate149 = PractitionerCertificate::create(array(
  'practitioner_id' => 149 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 48 ,
	'cert_no' => "CC/EA/048/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate150 = PractitionerCertificate::create(array(
  'practitioner_id' => 150 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 17 ,
	'cert_no' => "CC/EIA/017/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate151 = PractitionerCertificate::create(array(
  'practitioner_id' => 151 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 22 ,
	'cert_no' => "CC/EIA/022/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate152 = PractitionerCertificate::create(array(
  'practitioner_id' => 152 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-17" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 26 ,
	'cert_no' => "CC/EIA/026/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate153 = PractitionerCertificate::create(array(
  'practitioner_id' => 153 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 32 ,
	'cert_no' => "CC/EIA/032/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate154 = PractitionerCertificate::create(array(
  'practitioner_id' => 154 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-23" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 35 ,
	'cert_no' => "CC/EIA/035/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate155 = PractitionerCertificate::create(array(
  'practitioner_id' => 155 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-25" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 36 ,
	'cert_no' => "CC/EIA/036/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate156 = PractitionerCertificate::create(array(
  'practitioner_id' => 156 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-06" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 45 ,
	'cert_no' => "CC/EIA/045/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate157 = PractitionerCertificate::create(array(
  'practitioner_id' => 157 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-22" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 57 ,
	'cert_no' => "CC/EIA/057/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate158 = PractitionerCertificate::create(array(
  'practitioner_id' => 158 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-25" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 58 ,
	'cert_no' => "CC/EIA/058/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate159 = PractitionerCertificate::create(array(
  'practitioner_id' => 159 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 60 ,
	'cert_no' => "CC/EIA/060/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate160 = PractitionerCertificate::create(array(
  'practitioner_id' => 160 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 63 ,
	'cert_no' => "CC/EIA/063/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate161 = PractitionerCertificate::create(array(
  'practitioner_id' => 161 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 64 ,
	'cert_no' => "CC/EIA/064/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate162 = PractitionerCertificate::create(array(
  'practitioner_id' => 162 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 65 ,
	'cert_no' => "CC/EIA/065/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate163 = PractitionerCertificate::create(array(
  'practitioner_id' => 163 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 66 ,
	'cert_no' => "CC/EIA/066/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate164 = PractitionerCertificate::create(array(
  'practitioner_id' => 164 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 69 ,
	'cert_no' => "CC/EIA/069/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate165 = PractitionerCertificate::create(array(
  'practitioner_id' => 165 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 70 ,
	'cert_no' => "CC/EIA/070/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate166 = PractitionerCertificate::create(array(
  'practitioner_id' => 166 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 72 ,
	'cert_no' => "CC/EIA/072/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate167 = PractitionerCertificate::create(array(
  'practitioner_id' => 167 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 84 ,
	'cert_no' => "CC/EIA/084/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate168 = PractitionerCertificate::create(array(
  'practitioner_id' => 168 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 86 ,
	'cert_no' => "CC/EIA/086/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate169 = PractitionerCertificate::create(array(
  'practitioner_id' => 169 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-28" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 96 ,
	'cert_no' => "CC/EIA/096/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate170 = PractitionerCertificate::create(array(
  'practitioner_id' => 170 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-01" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 108 ,
	'cert_no' => "CC/EIA/108/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate171 = PractitionerCertificate::create(array(
  'practitioner_id' => 171 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-01" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 111 ,
	'cert_no' => "CC/EIA/111/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate172 = PractitionerCertificate::create(array(
  'practitioner_id' => 172 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-04" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 112 ,
	'cert_no' => "CC/EIA/112/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate173 = PractitionerCertificate::create(array(
  'practitioner_id' => 173 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-05" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 114 ,
	'cert_no' => "CC/EIA/114/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate174 = PractitionerCertificate::create(array(
  'practitioner_id' => 174 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-07" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 118 ,
	'cert_no' => "CC/EIA/118/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate175 = PractitionerCertificate::create(array(
  'practitioner_id' => 175 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 124 ,
	'cert_no' => "CC/EIA/124/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate176 = PractitionerCertificate::create(array(
  'practitioner_id' => 176 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-03-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL IMPACT ASSESSORS" ,
	'number' => 125 ,
	'cert_no' => "CC/EIA/125/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate177 = PractitionerCertificate::create(array(
  'practitioner_id' => 177 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-15" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 11 ,
	'cert_no' => "CC/EA/011/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate178 = PractitionerCertificate::create(array(
  'practitioner_id' => 178 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-16" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 14 ,
	'cert_no' => "CC/EIA/014/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Impact Assessment team."             
));

$practitionercertificate179 = PractitionerCertificate::create(array(
  'practitioner_id' => 179 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-01-18" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 18 ,
	'cert_no' => "CC/EA/018/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate180 = PractitionerCertificate::create(array(
  'practitioner_id' => 180 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-21" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 32 ,
	'cert_no' => "CC/EA/032/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate181 = PractitionerCertificate::create(array(
  'practitioner_id' => 181 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-22" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 35 ,
	'cert_no' => "CC/EA/035/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate182 = PractitionerCertificate::create(array(
  'practitioner_id' => 182 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-25" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 36 ,
	'cert_no' => "CC/EA/036/13" ,
	'conditions' => "The practitioner shall practice as a MEMBER of an Environmental Audit team"             
));

$practitionercertificate183 = PractitionerCertificate::create(array(
  'practitioner_id' => 183 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-26" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 37 ,
	'cert_no' => "CC/EA/037/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate184 = PractitionerCertificate::create(array(
  'practitioner_id' => 184 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 38 ,
	'cert_no' => "CC/EA/038/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

$practitionercertificate185 = PractitionerCertificate::create(array(
  'practitioner_id' => 185 ,
	'year' => 2013 ,
	'date_of_entry' => "2013-02-27" ,
	'cert_type' => "CERTIFIED ENVIRONMENTAL AUDITORS" ,
	'number' => 45 ,
	'cert_no' => "CC/EA/045/13" ,
	'conditions' => "The practitioner shall practice as a TEAM LEADER/ MEMBER of an Environmental Audit team."             
));

// seed end
    }

}