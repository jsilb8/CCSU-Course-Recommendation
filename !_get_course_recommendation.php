<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';
require_once '__functions.php';

$program_id = $_POST['program_id'] ? $_POST['program_id'] : 114;                        // Major ID
$sub_groups = $_POST['sub_groups'] ? $_POST['sub_groups'] : false;                      // Array of sub-group / specialization group ids OR false
$minor_required = ($_POST['minor_required'] == '1');                                    // true / false -> is a minor required
$minor_id = $_POST['minor_id'] ? $_POST['minor_id'] : false;                            // Minor ID 
$transferred_groups = is_array($_POST['groupsTaken']) ? $_POST['groupsTaken'] : [];   // Array of atomic group ID

$math101 = $_POST['math101'] ? $_POST['math101'] : false;                               // If placed out of Math101
$fl = $_POST['fl'] ? $_POST['fl'] : false;                                              // id of 111 FL group OR false
$ska4 = ($_POST['ska4']);

$numtaken = $_POST['courseload'] ? $_POST['courseload'] : 5;                            // how many courses are they taking
$taken = is_array($_POST['course_taken']) ? $_POST['course_taken'] : [];                // Array of courses taken

$semester_num = $_POST['semester_num'] ? $_POST['semester_num'] : 1;                    // Which semester number
$term = isset($_POST['term']) ? $_POST['term'] : 0;

$credits = $_POST['credits'] ? $_POST['credits'] : 0;

print_c($_POST);
$show_process = false;
echo '<div class="process">';
include "_course_processor.php";
echo '</div>';

$button_active = 'active';

$recommendation_num = 0; // identify each recommendation with a unique num 

$general_ed_ids = array_flip($gED->atomic_ids);
$minor_course_ids = is_array($minor->full_course_list) ? array_flip($minor->full_course_list) : [];

foreach ($output_array as $rec_option) {
    $recommendation_num++;

    // Single Course
    if (is_a($rec_option, "Course")) {
        $display_type = isset($minor_course_ids[$rec_option->db_id]) ? 'minor' : 'major';
        $output2 .= '<div id="class_' . $semester_num . '_' . $recommendation_num . '" class="recommended_course ' . $display_type . '" data-priority="' . $rec_option->priority . '" data-id="' . $rec_option->db_id . '">' . $rec_option . '</div>';

        // Selection of Courses
    } else if (is_a($rec_option[0], "Course")) {
        $button_active = 'inactive'; // deactivate the next semester button because a selection has to be made

        foreach ($rec_option as $course_id)
            $course_ids[] = $course_id->db_id;

        $output2 .= '<div id="class_' . $semester_num . '_' . $recommendation_num . '" class="recommended_course select" data-priority="' . $rec_option[0]->priority . '" data-course_id="' . (implode(",", array_unique($course_ids))) . '"><span>Core Course</span><span>(Please Select)</span></div>';

        // Group
    } else {
        $button_active = 'inactive'; // deactivate the next semester button because a selection has to be made 
        // Collection of Groups
        if (count($rec_option) > 1) {
            $group_ids = $group_course_ids = [];
            foreach ($rec_option as $group) {
                $group_ids[] = $group->db_id;
                foreach ($group->course_list as $course) {
                    $group_course_ids[] = $course->db_id;
                }
            }
            if (isset($general_ed_ids[$group->db_id])) {
                $display_name = 'General Education Course';
                $display_type = 'gened';
            } else {
                $display_name = 'Core Course';
                $display_type = '';
            }

            $output2 .= '<div id="class_' . $semester_num . '_' . $recommendation_num . '" '
                    . 'class="recommended_course select ' . $display_type . '" '
                    . 'data-priority="' . $rec_option[0]->priority . '" '
                    . 'data-group_id="' . (implode(",", array_unique($group_ids))) . '" '
                    . 'data-courses="' . (implode(",", array_unique($group_course_ids))) . '"><span>' . $display_name . '</span><span>(Please Select)</span></div>';

            // Single Groups
        } else {
            $group_id = $rec_option[0]->db_id;
            foreach ($rec_option[0]->course_list as $rec) {
                $group_course_ids[] = $rec->db_id;
            }
            //$group_course_ids = $rec_option->full_course_list;

            if (isset($general_ed_ids[$group_id])) {
                $display_type = 'gened';
            } else {
                $display_type = '';
            }


            $output2 .= '<div id="class_' . $semester_num . '_' . $recommendation_num . '" '
                    . 'class="recommended_course select ' . $display_type . '" '
                    . 'data-priority="' . $rec_option[0]->priority . '" '
                    . 'data-group_id="' . $group_id . '"'
                    . 'data-courses="' . (implode(",", array_unique($group_course_ids))) . '"><span>' . ($rec_option[0]->display_name ? $rec_option[0]->display_name : $rec_option[0]->name) . '</span><span>(Please Select)</span></div>';
        }
    }
}


// Credit Remaining Table
if ($chart['core']) {
    ksort($chart['core']);
}
if($chart['gened']) {
    ksort($chart['gened']);
}
if($chart['core']) {
    foreach ($chart['core'] as $group_name => $credits) {
        $group_name = explode(":", $group_name);
        $core_credits .= '<p class="flex"><span class="col-4">' . $group_name[0] . '</span><span class="col-1">' . $credits . '</span></p>';
    }
}
if($chart['gened']) {
    foreach ($chart['gened'] as $group_name => $credits) {
        $group_name = explode(":", $group_name);
        $gened_credits[substr($group_name[0], 0, 10)] .= '<p class="flex"><span class="col-4">' . $group_name[0] . '</span><span class="col-1">' . $credits . '</span></p>';
    }
}
if($gened_credits) {
    $table_output = '<div class="col-1 credits_remaining_table"><h4>Remaining Credits</h4>
                    <div class="flex">  <div class="col-1">' . $core_credits . '</div>
                                        <div class="col-1 flex">    <div class="col-1">' . array_shift($gened_credits) . '</div>
                                                                    <div class="col-1">' . array_shift($gened_credits) . '</div></div></div></div>';
}
// Output
$term_array = ['Fall', 'Spring'];
$next_semester = $semester_num + 1;   // Iterate the button so it loads the next semester when clicked
echo '  <div id="semester_' . $semester_num . '" class="semester_courses">
            <h6>Semester ' . $semester_num . ' - ' . $term_array[$term] . '</h6>
            '.$table_output.'
            <h4>Course Recommendations</h4>
            <div class="flex course_recommendation_list">' . $output2 . '</div>
        </div>
        <div id="next_semester">
            <label><p>Number of courses you would like to take next semester: <input name="courseload" type="number" value="' . $numtaken . '" /></p></label>
            <button id="get_courses" class="' . $button_active . '" data-semester_num="' . ($next_semester) . '">Get Next Semester</button>
        </div>';

echo '<div style="width:100%; overflow:scroll; display:none;">';
print_c($output_array);
echo '</div>';






