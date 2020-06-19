<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->text('report')->after('payload')->nullable();
            $table->string('state')->after('payload');
            $table->integer('progress')->after('payload')->nullable();
            $table->string('command')->after('payload');
            $table->integer('created_by')->unsigned()->nullable();
            $table->dateTime('finished_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropColumn('report');
            $table->dropColumn('state');
            $table->dropColumn('progress');
            $table->dropColumn('command');
            $table->dropColumn('created_by');
            $table->dropColumn('finished_at');
        });
    }
}
