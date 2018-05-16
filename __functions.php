<?php

function getPrograms(){
	$data = query('SELECT * FROM `program` 
	
	WHERE level = "Undergraduate" 
	
	ORDER BY name ASC','name');

	while($program = fetch_array($data)){
		$output .= "<p>".$program['name'].' '.$program['major'].'</p>';
	}
	return $output;
}


function get_curl_data($url) {
	$ch = curl_init();
	//$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


$course_curl = new SimpleXmlElement( 
    get_curl_data("http://ccsu.smartcatalogiq.com/APIs/courseapi?path=/sitecore/content/Catalogs/Central-Connecticut-State-University/current/Undergraduate-Graduate-Catalog/All-Courses/" ) 
);

function build_course_list($course_list) {
  //   print_c($course_list);
	
	foreach($course_list->course as $course){
		//print_c($course);
		$insert = array();
		$insert[] = "des = '".$course->subject_code."'";
		$insert[] = "num = '".$course->number."'";
		$insert[] = "name = '".$course->name."'";
		$insert[] = "credits = '".$course->credits."'";
		$insert[] = "description = '".htmlentities($course->description)."'";
		$insert[] = "catalogURL = '".$course->url."'";
		
	//	echo "INSERT INTO `course` SET ".implode(',',$insert).'<br /><br />';
	//	$result = query_insert("INSERT INTO `course` SET ".implode(',',$insert));
		
		
		echo '<p>';
		echo $course->subject_code.' '.$course->number.' '.$course->name;
		
		if(($course->prerequisite))
			foreach($course->prerequisite as $prereq)
				echo '<br /> - '.$prereq->subject_code.' '.$prereq->number.' '.$prereq->name;
		
		echo '</p>';
				
		
	}
	
	 
    //$output = '<h1>'.$p->program->title.'</h1>';
    $return = !empty($p->program->content) ? $p->program->content : '';
    
	$num_tracks = count($p->program->requirements);
	
    for($i=0; $i< $num_tracks; $i++) {
		$req = $p->program->requirements[$i];
		
		$output[$i] = '<h1>'.$req->title.'</h1>';
		$output[$i] .= '<div id="course_track_'.$i.'">';
			$output[$i] .=!empty($req->content) ? $req->content : '';
			foreach($req->requirement_list as $requirement_list) 
				$output[$i] .= '<div class="requirement_list">'.get_requirement_list($requirement_list).'</div>';
					   
			$output[$i] .= $req->credits == '0' ? '' : '<p><span>Total Credit Hours: </span><span class="total_credit_hours">'.$req->credits.'</span></p>';
		$output[$i] .= '</div>';
	}
	$return .= implode('',$output);
	$return .= $p->program->credits == '0' 			? '' : '<p class="final_total_credit_hours"><span>Total Credit Hours: </span><span class="total_credit_hours">'.$p->program->credits.'</span></p>';
    $return .= !empty($p->program->bottom_content) 	? "<p>".$p->program->bottom_content."</p>" : '';
	
	return $return;
}


