<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErpSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        DB::unprepared('drop schema if exists erp cascade;');
        DB::unprepared('create schema if not exists erp');
        // DB::unprepared('ALTER database "'.env('DB_DATABASE').'" SET search_path TO erp');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        DB::unprepared('drop schema erp cascade');
    }
}
