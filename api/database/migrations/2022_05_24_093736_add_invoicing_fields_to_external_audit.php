<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInvoicingFieldsToExternalAudit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('external_audits', function (Blueprint $table) {
            $table->date('date_invoice_payment')->nullable();
            $table->date('date_invoice_receipt_issued')->nullable();
            $table->date('date_create_invoice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('external_audits', function (Blueprint $table) {
            $table->dropColumn('date_invoice_payment');
            $table->dropColumn('date_invoice_receipt_issued');
            $table->dropColumn('date_create_invoice');
        });
    }
}
