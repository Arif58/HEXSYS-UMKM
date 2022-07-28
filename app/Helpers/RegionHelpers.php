<?php
if ( ! function_exists('regionName')){
    function regionName($id){
        $region = App\Models\PublicComRegion::where('region_cd', $id)->first();

        if($region){
            return $region->region_nm;
        }else{
            return '';
        }
    }
}