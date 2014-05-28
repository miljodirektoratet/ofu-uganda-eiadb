<?php
 
class UserTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('assigned_roles')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        $role1 = Role::create(array('name' => 'Rolle 1'));
        $role2 = Role::create(array('name' => 'Rolle 2'));

        $permission1 = Permission::create(array('name' => 'Rettighet 1', 'display_name' => 'Rettighet 1'));
        $permission2 = Permission::create(array('name' => 'Rettighet 2', 'display_name' => 'Rettighet 2'));

        $role1->attachPermission($permission1);
        $role2->attachPermission($permission1);
        $role2->attachPermission($permission2);

$user0 = User::create(array(
  'initials' => 'josska',
'full_name' => 'Jostein Skaar',
'job_position_code' => 'NEI',
'job_position_name' => 1,
'email' => 'jostein.skaar@miljodir.no',
'password' => Hash::make('jostein')            
  ));



// Creating seeds for User
$user1 = User::create(array(
  'initials' => 'pkato',
    'full_name' => 'Phillip Kato',
    'job_position_code' => 'NA',
    'job_position_name' => 1,
    'email' => 'pkato@nemaug.org',
    'password' => Hash::make('password')            
));

$user2 = User::create(array(
  'initials' => 'gsawula',
    'full_name' => 'Gerald Sawula',
    'job_position_code' => 'DED',
    'job_position_name' => 1,
    'email' => 'gsawula@nemaug.org',
    'password' => Hash::make('password')            
));

$user3 = User::create(array(
  'initials' => 'fogwal',
    'full_name' => 'Francis Ogwal',
    'job_position_code' => 'NRM(B&R)',
    'job_position_name' => 1,
    'email' => 'fogwal@nemaug.org',
    'password' => Hash::make('password')            
));

$user4 = User::create(array(
  'initials' => 'glubega',
    'full_name' => 'Lubega George',
    'job_position_code' => 'NRM(Aq)',
    'job_position_name' => 1,
    'email' => 'glubega@nemaug.org',
    'password' => Hash::make('password')            
));

$user5 = User::create(array(
  'initials' => 'dlufafa',
    'full_name' => 'Dick Lufafa',
    'job_position_code' => 'EAMO-1',
    'job_position_name' => 1,
    'email' => 'dlufafa@nemaug.org',
    'password' => Hash::make('password')            
));

$user6 = User::create(array(
  'initials' => 'fbagoora',
    'full_name' => 'Festus Bagoora',
    'job_position_code' => 'NRM(S&L)',
    'job_position_name' => 1,
    'email' => 'fbagoora@nemaug.org',
    'password' => Hash::make('password')            
));

$user7 = User::create(array(
  'initials' => 'tokurut',
    'full_name' => 'Tom O. Okurut',
    'job_position_code' => 'ED',
    'job_position_name' => 1,
    'email' => 'tokurut@nemaug.org',
    'password' => Hash::make('password')            
));

$user8 = User::create(array(
  'initials' => 'rnamara',
    'full_name' => 'Namara Rhona',
    'job_position_code' => 'SPS',
    'job_position_name' => 1,
    'email' => 'rnamara@nemaug.org',
    'password' => Hash::make('password')            
));

$user9 = User::create(array(
  'initials' => 'bbirungi',
    'full_name' => 'Bonny Birungi',
    'job_position_code' => 'DS',
    'job_position_name' => 1,
    'email' => 'kbirungi@nemaug.org',
    'password' => Hash::make('password')            
));

$user10 = User::create(array(
  'initials' => 'gkitutu',
    'full_name' => 'Goreti K. Kitutu',
    'job_position_code' => 'EISS',
    'job_position_name' => 1,
    'email' => 'gkitutu@nemaug.org',
    'password' => Hash::make('password')            
));

$user11 = User::create(array(
  'initials' => 'wayazika',
    'full_name' => 'Waiswa Ayazika',
    'job_position_code' => 'DEMC',
    'job_position_name' => 1,
    'email' => 'wayazika@nemaug.org',
    'password' => Hash::make('password')            
));

$user12 = User::create(array(
  'initials' => 'enidt',
    'full_name' => 'Enid Turyahikayo',
    'job_position_code' => 'EAMO',
    'job_position_name' => 1,
    'email' => 'enidt@nemaug.org',
    'password' => Hash::make('password')            
));

$user13 = User::create(array(
  'initials' => 'tkiwanuka',
    'full_name' => 'Tonny Kiwanuka',
    'job_position_code' => 'EIAA',
    'job_position_name' => 1,
    'email' => 'tkiwanuma@nemaug.org',
    'password' => Hash::make('password')            
));

$user14 = User::create(array(
  'initials' => 'hnamara',
    'full_name' => 'Harriet Namara',
    'job_position_code' => 'EIAA',
    'job_position_name' => 1,
    'email' => 'hnamara@nemaug.org',
    'password' => Hash::make('password')            
));

$user15 = User::create(array(
  'initials' => 'rmugambwa',
    'full_name' => 'Richard Mugambwa',
    'job_position_code' => 'PM-MSW',
    'job_position_name' => 1,
    'email' => 'rmugambwa@nemaug.org',
    'password' => Hash::make('password')            
));

$user16 = User::create(array(
  'initials' => 'nallimadi',
    'full_name' => 'Nancy Allimadi',
    'job_position_code' => 'EI',
    'job_position_name' => 1,
    'email' => 'nallimadi@nemaug.org',
    'password' => Hash::make('password')            
));

$user17 = User::create(array(
  'initials' => 'nobbo',
    'full_name' => 'Obbo Naome',
    'job_position_code' => 'EIAO',
    'job_position_name' => 1,
    'email' => 'nobbo@nemaug.org',
    'password' => Hash::make('password')            
));

$user18 = User::create(array(
  'initials' => 'mmubangizi',
    'full_name' => 'Matia Mubangizi',
    'job_position_code' => 'EAA',
    'job_position_name' => 1,
    'email' => 'mmubangizi@nemaug.org',
    'password' => Hash::make('password')            
));

$user19 = User::create(array(
  'initials' => 'awinyi',
    'full_name' => 'Alex Winyi',
    'job_position_code' => 'EIAO',
    'job_position_name' => 1,
    'email' => 'awinyi@nemaug.org',
    'password' => Hash::make('password')            
));

$user20 = User::create(array(
  'initials' => 'inamuleme',
    'full_name' => 'Namuleme Immaculate',
    'job_position_code' => 'EAIMA',
    'job_position_name' => 1,
    'email' => 'inamuleme@nemaug.org',
    'password' => Hash::make('password')            
));

$user21 = User::create(array(
  'initials' => 'jkagoda',
    'full_name' => 'Joy Kagoda',
    'job_position_code' => 'SPS',
    'job_position_name' => 1,
    'email' => 'jkagoda@nemaug.org',
    'password' => Hash::make('password')            
));

$user22 = User::create(array(
  'initials' => 'pnsereko',
    'full_name' => 'Patience Nsereko',
    'job_position_code' => 'EMO',
    'job_position_name' => 1,
    'email' => 'pnsereko@nemaug.org',
    'password' => Hash::make('password')            
));

$user23 = User::create(array(
  'initials' => 'fonyai',
    'full_name' => 'Fred Onyai',
    'job_position_code' => 'IMES',
    'job_position_name' => 1,
    'email' => 'fonyai@nemaug.org',
    'password' => Hash::make('password')            
));

$user24 = User::create(array(
  'initials' => 'iintujju',
    'full_name' => 'Isaac I.G. Ntujju',
    'job_position_code' => 'SEI',
    'job_position_name' => 1,
    'email' => 'iigntujju@nemaug.org',
    'password' => Hash::make('password')            
));

$user25 = User::create(array(
  'initials' => 'naisha',
    'full_name' => 'Nakanwaji Aisha',
    'job_position_code' => 'RA',
    'job_position_name' => 1,
    'email' => 'naisha@nemaug.org',
    'password' => Hash::make('password')            
));

$user26 = User::create(array(
  'initials' => 'maanyu',
    'full_name' => 'Aanyu Margaret',
    'job_position_code' => 'EIAC',
    'job_position_name' => 1,
    'email' => 'maanyu@nemaug.org',
    'password' => Hash::make('password')            
));

$user27 = User::create(array(
  'initials' => 'jkutesakwe',
    'full_name' => 'Jeniffer Kutesakwe',
    'job_position_code' => 'LT',
    'job_position_name' => 1,
    'email' => 'jkutesakwe@nemaug.org',
    'password' => Hash::make('password')            
));

        //$user2->attachRole($role2);
    }
 
}