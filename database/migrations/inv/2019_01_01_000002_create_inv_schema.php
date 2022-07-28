<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        DB::unprepared('drop schema if exists inv cascade;');
        DB::unprepared('create schema if not exists inv');
        // DB::unprepared('ALTER database "'.env('DB_DATABASE').'" SET search_path TO inv');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        DB::unprepared('drop schema inv cascade');
    }
}
