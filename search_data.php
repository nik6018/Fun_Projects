<?php

	###################################
	#  
	#	// Response Structure
	# 
	#	[
	#		script_type:[
	#
	#			script_cat:[
	#
	#				[script_name,desc,category_name]
	#										
	#			]
	#			..,
	#
	#		]
	#       ...,
	#	]
	######################################
	
	/*
		This File Gets a string and searches that string in the 
		database for the match and returns if a match is found 
		or even a partial match is found
		
		Use this type of Ajax request while Ajaxing to this page
		
		$.ajax({
	            type: "POST",
	            url: "Your URL to the Site",
	            data: {data:value,base_app:website},
	            success: function(result){"Your function if the request is successful"}
	*/

	$result = array();
		
	if(isset($_POST['data'])){

		$value_to_search = strtolower($_POST['data']);
		// extra post variable to check the base app
		$base_app = $_POST['base_app'];
		foreach($allcatwise as $type => $script_cats){

			if (empty($script_cats) || ($base_app == "softaculous" && ($type == "java" || $type == "python"))) continue;
			
			$result[$type] = array();
			
			foreach ($script_cats as $key => $value) {
				
				$key = ucfirst($key);
				if(empty($value)) continue;

				$result[$type][$key] = array();

				//searching the cat for script
				foreach ($value as $key1 => $value1) {

					if (substr(strtolower($value1['name']), 0, strlen($value_to_search)) === $value_to_search) {

						$value1['name'] = ucfirst($value1['name']);
						$cat_name = $lang['cat_'.$value1['type'].'_'.$value1['category']];
						array_push($result[$type][$key], array($value1['name'], $value1['desc'], $cat_name));

					}	
				}
				
				// remove cat if no match is found
				if (count($result[$type][$key]) < 1) {
					unset($result[$type][$key]);
				}
			}

			if (count($result[$type]) < 1) {
				unset($result[$type]);
			}
		}

		// check if atleast one match found
		if (count($result) > 0) {
			
			$result = json_encode($result);
			echo $result;
			
		}else{
			// echo"No Match found";
		}
		
	}else{
		// "No data received";
	}

	// r_print($allcatwise);

?>
