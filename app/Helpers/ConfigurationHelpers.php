<?php
if (!function_exists('configuration')) {
	function configuration($id, $defaultValue = null, $defaultGroup = "APP", $defaultName = "App Configuration")
    {
        $config = App\Models\AuthConfiguration::where('configuration_cd', $id)->first();

        if ($config) {
            return $config->configuration_value;
        }

        if ($defaultValue) {
            $config = new App\Models\AuthConfiguration();
            $config->configuration_cd = $id;
            $config->configuration_nm = $defaultName;
            $config->configuration_group = $defaultGroup;
            $config->configuration_value = $defaultValue ?: "";
            $config->created_by = "defaultValue";
            $config->created_at = date('Y-m-d H:i:s');
            $config->save();
        }

        return $defaultValue;
    }
	
	/* function configuration($id){
        $config=App\Models\AuthConfiguration::where('configuration_cd', $id)->first();
		
        return $config->configuration_value;
    } */
}
