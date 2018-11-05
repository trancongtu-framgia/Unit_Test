<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNullableInSomeColumnsInReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('link')->nullable(false)->default('')->change();
            $table->string('content')->nullable(false)->default('')->change();
            $table->string('lesson')->nullable(false)->default('')->change();
            $table->string('status')->nullable(false)->default('')->change();
            $table->string('test_link')->nullable(false)->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('link')->change();
            $table->string('content')->change();
            $table->string('lesson')->change();
            $table->string('status')->change();
            $table->string('test_link')->change();
        });
    }
}
