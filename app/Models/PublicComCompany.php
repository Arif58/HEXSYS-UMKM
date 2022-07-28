<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublicComCompany extends Model{
    protected $table        = 'public.com_company';
    protected $primaryKey   = 'comp_cd'; 
    public $incrementing    = false;
    public $keyType 		= 'string';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comp_cd',
        'comp_nm',
        'comp_root',
        'comp_level',
        'ref_cd',
        'address',
        'region_prop',
        'region_kab',
        'region_kec',
        'region_kel',
        'postcode',
        'phone',
        'mobile',
        'fax',
        'email',
        'npwp',
        'nppkp',
        'pkp_st',
        'trx_header',
        'tax_header',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    static function getCompaniesUnder($companyCd){
        $company = PublicComCompany::find($companyCd);
        $companiesUnder = PublicComCompany::where('comp_root',$companyCd)->orWhere('comp_cd',$companyCd)->get();
        if($company->comp_level == '1'){
            $midCompanies = array($companyCd);
            foreach($companiesUnder as $data){
                array_push($midCompanies, $data->comp_cd);
            }
            $companiesUnder = PublicComCompany::whereIn('comp_root',$midCompanies)->orWhere('comp_cd',$companyCd)->get();
        }
        return $companiesUnder;
    }
}
