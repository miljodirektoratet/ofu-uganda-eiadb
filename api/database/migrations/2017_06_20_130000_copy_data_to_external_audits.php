<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CopyDataToExternalAudits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1.
        $sql1 = "update documents set external_audit_id = eia_permit_id where type in (11,12) and deleted_at is null;\n";
        DB::connection()->getPdo()->exec($sql1);


        // 2.
        $sql2 = "INSERT INTO external_audits (id, project_id, status, teamleader_id, user_id, review_findings, verification_inspection, date_inspection, created_by, updated_by, created_at, updated_at) ";
        $sql2 .= "SELECT id, project_id, status, teamleader_id, user_id, CONCAT(COALESCE(`officer_recommend`,''),'\n\n',COALESCE(`remarks`,'')), inspection_recommended, date_inspection, created_by, updated_by, created_at, updated_at ";
        $sql2 .= "FROM eias_permits WHERE id in (SELECT eia_permit_id FROM documents WHERE external_audit_id is not null)";
        DB::connection()->getPdo()->exec($sql2);

        // 3.
        $sql3 = "INSERT INTO team_members_external_audits (id, practitioner_id, external_audit_id) ";
        $sql3 .= "SELECT id, practitioner_id, eia_permit_id FROM team_members ";
        $sql3 .= "WHERE eia_permit_id IN (SELECT id FROM external_audits) ";
        DB::connection()->getPdo()->exec($sql3);

        // 4.
        $sql4 = "INSERT INTO external_audits_personnel (id, user_id, external_audit_id) ";
        $sql4 .= "SELECT id, user_id, eia_permit_id FROM eias_permits_personnel ";
        $sql4 .= "WHERE eia_permit_id IN (SELECT id FROM external_audits) ";
        DB::connection()->getPdo()->exec($sql4);

        // 5.
        $sql5 = "update documents set eia_permit_id = null where type in (11,12) and deleted_at is null;\n";
        DB::connection()->getPdo()->exec($sql5);

        // 6.
        $sql6 = "update eias_permits set deleted_at = now()";
        $sql6 .= "WHERE id IN (SELECT id FROM external_audits)";
        DB::connection()->getPdo()->exec($sql6);

        // TODO? Delete from team_members and eias_permits_personnel.

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        print("Copying data to external audits can not be rolled back.\n");
    }
}
