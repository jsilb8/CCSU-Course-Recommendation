<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';
require_once '__functions.php';

// return if there no group list to offer
if (!$_POST['group_list'])
    return "false";

// Groups to be included in the selection
$group_list = explode(",", $_POST['group_list']);

// Possible Courses that can be taken based on prereqs, etc
$possible_courses = explode(",", $_POST['courses']);

// Courses / Groups that have been selected in other areas for this semester
$hide_selections = $_POST['hide_selections'] ? $_POST['hide_selections'] : [];
$hidden_group = $hidden_course = [];
foreach ($hide_selections as $sel) {
    if (startsWith($sel, 'g_'))
        $hidden_group[] = str_replace('g_', '', $sel);
    elseif (startsWith($sel, 'c_'))
        $hidden_course[] = str_replace('c_', '', $sel);
}

// If a minor was selected, get the course list for it
if ($_POST['minor_id'] != 'false') {
    $minor_id = $_POST['minor_id'];
    $minor = new Program($minor_id);
    $minor_course_list = $minor->full_course_list;
}

// Determin if the selection is a gened list
$is_gED = $_POST['is_gened'] != 'false' ? true : false;

// Create the course list based on the groups passed
$course_list = [];
foreach ($group_list as $group_id) {
    if (in_array($group_id, $hidden_group))
        continue;    // If the group has been selected somewhere else, ignore it

    $group = new Prereq_Group($group_id); // Create the group object
    
    // Format the coures list array for convenient output
    foreach ($group->course_list as $course) {
        // If its not a possible course, ignore it.
        if ((!in_array($course->db_id, $possible_courses)) || in_array($course->db_id, $hidden_course))
            continue;   

        $course_list[$course->db_id]['groups'][] = $group_id;
        $course_list[$course->db_id]['course'] = $course;
    }
}

foreach ($course_list as $key => $course) {
    // If its not a possible course, ignore it.
    if (!in_array($key, $possible_courses) && in_array($key, $hidden_course))
        continue;
    
    $group_id_class = $group_display_name = $int_req = [];
    
    $course_groups = $course['groups'];
    foreach ($course_groups as $group_id) {
        if ($group_id == 2079)
            $int_req[0] = 'class="int_req"';
        else {
            $name = Prereq_Group::get_area_name($group_id);
            $group_display_name[$name] = $name . ' ';

            if ($is_gED) {
                $group_id_class[$group_id] = 'g_' . $group_id;
                $type = 'gened';
            } else {
                $type = ( in_array($course['course']->db_id, $minor_course_list) ? 'minor' : 'major' );
            }
        }
    }
    $c_des = $course['course']->des . $course['course']->num;

    if (!empty($group_display_name))
        $options[$c_des] = '<label class="' . 'c_' . $course['course']->db_id . ' ' . implode(' ', $group_id_class) . '"><button value="' . $course['course']->db_id . '" ' . $int_req[0] . ' data-course_type="' . $type . '"><span class="course_name">' . $course['course'] . '</span><span class="group">' . implode('', $group_display_name) . '</span></button></label>';
}
ksort($options);
?>
<p class="close">&times;</p>
<h2>Select a course from the list</h2>
<input type="text" value="" placeholder="Search in this list" class="live_search" data-targetlist="select_course_list label" data-targetfield="button" data-min_input='1'>
<div id="select_course_list" class="select_course_list"><?= implode(' ', $options) ?></div>
