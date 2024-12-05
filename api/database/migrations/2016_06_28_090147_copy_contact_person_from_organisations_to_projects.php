<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CopyContactPersonFromOrganisationsToProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = "CREATE TEMPORARY TABLE IF NOT EXISTS temp_organisations AS 
(
  SELECT  id, contact_person FROM organisations
  where id in 
  (SELECT
    o.id
	FROM organisations AS o 
		LEFT OUTER JOIN projects as p on o.id=p.organisation_id
	where o.deleted_at is null
	and p.deleted_at is null	
	and o.contact_person is not null
	GROUP BY o.id
	having count(p.id) = 1
  )
);

UPDATE projects p INNER JOIN temp_organisations o on p.organisation_id = o.id	
SET p.contact_person = o.contact_person;

drop table temp_organisations;
        ";
        DB::connection()->getPdo()->exec($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        print("Copying contacts can't be rolled back.\n");
    }
}
