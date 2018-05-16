<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/_srv/DB_Connect.php';


function sort_courses_by_des($course_array){
    if(!is_array($course_array)) return false;
    
    foreach ($course_array as $course_obj)
        $course[$course_obj->des . $course_obj->num] = $course_obj;
    
    if(!is_array($course))
        return false;
    ksort($course);
    return $course;
}

if(!empty($_POST['pID'])){
    $type_name = "Major";
    $type = "program_id";
    $id = $_POST['pID'];
}elseif(!empty($_POST['minorID'])){
    $type_name = "Minor";
    $type = "minor_id";
    $id = $_POST['minorID'];
}
if(!$id && $type_name != "Minor"){ echo '<p style="color:#c22">Please Select a Major</p>'; exit; }

$program = new Program($id);


if($program->full_course_list == false) {
    echo '<p style="color:#c22">Course Information Not Found</p>';
    exit;
}

echo '<h6>'.$type_name.'</h6>
      <div class="area_box">
        <h3>'.$program->name.'<input type="text" value="" placeholder="Search in this Area" class="live_search" data-targetlist="program_'.$program->db_id.' .section_course" data-targetfield=" " data-min_input="0"></h3>
        <div class="area_scroller" id="program_'.$program->db_id.'">
        <input type="hidden" name="'.$type.'" value="'.$id.'" />';

$course_list = $program->get_full_course_list();
$course_list = sort_courses_by_des($course_list);

foreach ($course_list as $course)
    echo '<label class="section_course"><input type="checkbox" name="course_taken[]" value="' . $course->db_id . '" />
                 <span class="course_name flex">' . $course . '</span></label>';


echo '</div></div>';
            