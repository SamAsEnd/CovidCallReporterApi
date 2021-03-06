<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCallReportFollowupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_report_followups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('call_report_id');
            $table->boolean('has_symptom')->default(false)->nullable();
            $table->float('temperature')->default(null)->nullable();
            $table->longText('other')->nullable();
            $table->timestamps();
            $table->foreign('call_report_id')->references('id')->on('call_reports')->onDelete('restrict')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('call_report_followups');
    }
}
