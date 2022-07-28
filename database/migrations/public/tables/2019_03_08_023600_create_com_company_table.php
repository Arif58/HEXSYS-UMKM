<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    function up(){
        Schema::create('public.com_company', function (Blueprint $table) {
            $table->string('comp_cd',20);
            $table->string('comp_nm',100)->nullable();          
            $table->string('comp_root',20)->nullable();          
            $table->char('comp_level',1)->nullable();       
            $table->string('ref_cd',100)->nullable();   
            $table->string('address',1000)->nullable();            
            $table->string('region_prop',100)->nullable();
            $table->string('region_kab',100)->nullable();   
            $table->string('region_kec',100)->nullable();           
            $table->string('region_kel',100)->nullable();           
            $table->string('postcode',20)->nullable();             
            $table->string('phone',20)->nullable();                
            $table->string('mobile',20)->nullable();               
            $table->string('fax',20)->nullable();                  
            $table->string('email',100)->nullable();    
            $table->string('npwp',100)->nullable();
            $table->string('nppkp',100)->nullable();
            $table->string('pkp_st',1)->nullable();
            $table->date('pkp_date')->nullable();
            $table->string('trx_header',20)->nullable();
            $table->string('tax_header',20)->nullable();            
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            $table->primary('comp_cd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    function down(){
        Schema::dropIfExists('hrms.com_company');
    }
}
