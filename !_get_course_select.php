<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';
require_once '__functions.php';

print_c($_POST);

if (!$_POST['course_list'])
    return "false";

$minor_course_list = [];
if($_POST['minor_id'] != 'false') {
    $minor_id = $_POST['minor_id'];
    $minor = new Program($minor_id);
    $minor_course_list = $minor->full_course_list;
}

// Courses / Groups that have been selected in other areas for this semester
$hide_selections = $_POST['hide_selections'] ? $_POST['hide_selections'] : [];
$hidden_group = $hidden_course = [];
foreach($hide_selections as $sel){
    if(startsWith($sel, 'g_'))
        $hidden_group[] = str_replace('g_','',$sel);
    elseif(startsWith($sel, 'c_'))
        $hidden_course[str_replace('c_','',$sel)] = true;
            
}
print_c($hidden_course);

$course_id_list = explode(",", $_POST['course_list']);

foreach ($course_id_list as $course_id) 
    $course_list[] = new Course($course_id);

usort($course_list,array('Course','cmp_sort'));

//print_c($hidden_course);

foreach($course_list as $course){
    if($hidden_course[$course->db_id]) continue;    // Ignore Courses that have already been selected
    $type = ( in_array($course->db_id, $minor_course_list ) ? 'minor' : 'major' );
    $options .= '<label class="c_'.$course->db_id.'"><button value="' . $course->db_id . '" data-course_type="'.$type.'"><span class="course_name">' . $course . '</span><span class="group">'. ucfirst($type). '</span></button></label>';
    
}
?>
<p class="close">&times;</p>
<h2>Select a course from the list</h2>
<input type="text" value="" placeholder="Search in this list" class="live_search" data-targetlist="select_course_list label" data-targetfield="button" data-min_input='1'>
<div id="select_course_list" class="select_course_list"><?= $options ?></div>
