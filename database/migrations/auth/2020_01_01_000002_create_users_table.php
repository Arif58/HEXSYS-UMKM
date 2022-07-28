<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth.users', function (Blueprint $table) {
            $table->string('user_id',20)->primary();
            $table->string('user_nm',100);
            $table->string('email',100)->nullable();
            $table->string('phone',20)->nullable();
            $table->string('password',100);
            $table->string('comp_cd',20)->nullable();
			$table->string('image',100)->nullable();
            $table->string('rule_tp',20)->default('1111');
            $table->boolean('active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->longText('token_register')->nullable();
            $table->datetime('last_login')->nullable();
			$table->string('unit_cd',20)->nullable();
			$table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('comp_cd')
            ->references('comp_cd')->on('public.com_company')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
