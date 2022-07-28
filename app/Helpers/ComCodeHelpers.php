<?php 
if (! function_exists('comCodeOptions')) {
    function comCodeOptions($id){
        $comCodeList = App\Models\PublicComCode::where('code_group', $id)
                    ->orderBy('com_cd')
                    ->get();

        $options='<option value="">=== Pilih Data ===</option>';

        foreach($comCodeList as $item){
            $options .='<option value="'.$item->com_cd.'">'.$item->code_nm.'</option>';
        }

        return $options;
    }
}

if (! function_exists('comCodeData')) {
    function comCodeData($id){
        $comCodeData = App\Models\PublicComCode::where('code_group', $id)
                    ->orderBy('com_cd')
                    ->get();
        if ($comCodeData) {
            return $comCodeData;
        }else{
            return NULL;
        }
    }
}

if (! function_exists('comCodeName')) {
    function comCodeName($id){
        $comCodeName = App\Models\PublicComCode::where('com_cd', $id)->first();
        if ($comCodeName) {
            return $comCodeName->code_nm;
        }else{
            return NULL;
        }
    }
}

if (! function_exists('comCodeValue')) {
    function comCodeValue($id){
        $comCodeValue = App\Models\PublicComCode::where('com_cd', $id)->first();
        if ($comCodeValue) {
            return $comCodeValue->code_value;
        }else{
            return NULL;
        }
    }
}

if (! function_exists('comCodeByValue')) {
    function comCodeByValue($id){
        $comCodeValue = App\Models\PublicComCode::where('code_value', $id)->first();
        if ($comCodeValue) {
            return $comCodeValue->com_cd;
        }else{
            return NULL;
        }
    }
}
