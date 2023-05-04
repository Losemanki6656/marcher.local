<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnToPaymentTranscationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_transcations', function (Blueprint $table) {
            $table->float('total', 12, 2)->nullable()->default(0)->change();
            $table->string('card_num')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_transcations', function (Blueprint $table) {
            $table->dropColumn("card_num");
        });
    }
}
