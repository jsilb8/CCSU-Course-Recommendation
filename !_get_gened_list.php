<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';

function sort_courses_by_name($course_array) {
    if (!is_array($course_array))
        return false;

    foreach ($course_array as $course_obj)
        $course[$course_obj->des . $course_obj->num] = $course_obj;

    if (!is_array($course))
        return false;

    ksort($course);
    return $course;
}

$gened = new GenEd();
$gened_list = $gened->get_full_course_list();

$exclude = [2079];
if(!empty($_POST['language'])) $exclude[] =  2078;
if(!empty($_POST['transfer'])) $exclude[] =  2067;

echo '<h6>General Education Program <input type="text" value="" placeholder="Search for Gen-Ed Course" class="live_search" data-targetlist="gen_ed_container .section_course" data-targetfield=" " data-min_input="0" /></h6>
        <div id="gen_ed_container">';

ksort($gened->area_list);

foreach ($gened->area_list as $area) {
    
    if(in_array($area->db_id,$exclude)) continue;
    
    echo '<div class="area_box">
            <h3>' . $area->display_name . '<input type="text" value="" placeholder="Search in this Area" class="live_search" data-targetlist="area_'.$area->db_id.' .section_course" data-targetfield=" " data-min_input="0" /></h3>
            <div class="area_scroller" id="area_'.$area->db_id.'">';

    // reoreder subareas with key value
    $sub_area_list = $area->sub_groups;

    //print_c($sub_area_list);

    // Sort the courses by their name
    $course_list = sort_courses_by_name($area->get_full_course_list());

    $section = $section_narrative = false;
    
    foreach ($course_list as $course) {
        // Set up section Identifier
        $section[$area->db_id] = '';
        
        // Check if course exists in a unique subgroup
        if (is_array($sub_area_list)){
            
            foreach ($sub_area_list as $sub_area) {
            
                if($sub_area->name !== $area->name.'-core'){
                    if (in_array($course->db_id, $sub_area->full_course_list)) {
                        $section[$area->db_id] = 'sub_section';
                        $section_narrative[$area->db_id] = $sub_area->narrative; 
                    }
                    break;
                }
            }
        }
            
        echo '<label class="section_course '.$section[$area->db_id].'"><input type="checkbox" name="course_taken[]" value="' . $course->db_id . '" />
                     <span class="course_name flex">' . $course . '</span><br /></label>';
    }

    echo '</div>'.($section_narrative[$area->db_id] ? '<p>Courses in bold meet the following requirement:<br /> <b>'.$section_narrative[$area->db_id].'</b>' : '').'</div>';
}
echo "</div>";

