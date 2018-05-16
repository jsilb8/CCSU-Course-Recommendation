<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';

if (!$_POST['program_id'])
    exit;

$program_id = $_POST['program_id'];
$sel_program = new Program($program_id);

if ($sel_program->sub_options) {
    $opt_output .= '<h3>Please select specializations/tracks for this program</h3>';
    foreach ($sel_program->sub_options as $opt_group_id => $opt_selections) {
        $category_name = (Prereq_Group::get_display_name($opt_group_id));
        $opt_output .= '<h4>' . $category_name . ' <select name="sub_groups[]" data-name="' . $category_name . '"><option value="0">None Chosen</option>';
        foreach ($opt_selections as $sel_id => $sel_opt_name)
            $opt_output .= '<option value="' . $sel_id . '">' . $sel_opt_name . '</option>';
        $opt_output .= '</select></h4>';
    }
}

if (!in_array($program_id, Program_List::minor_required()))
    $minor_req = "<i>A Minor is not required for this program</i>";

echo $minor_req || $opt_output ? '<div id="selection_container">' . $minor_req . $opt_output . '</div><div id="selection_display"></div>' : "";





/*
 * <?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';

if (!$_POST['program_id'])
    exit;

$program_id = $_POST['program_id'];
$sel_program = new Program($program_id);

if ($sel_program->sub_options) {
    $opt_output .= '<h3>Please select specializations/tracks for this program</h3>';
    foreach ($sel_program->sub_options as $opt_group_id => $opt_selections) {
        $category_name = (Prereq_Group::get_display_name($opt_group_id));
        $opt_output .= '<h4>' . $category_name . '</h4><div id="program_options_' . $opt_group_id . '" data-name="'.$category_name.'">';
        foreach ($opt_selections as $sel_id => $sel_opt_name)
            $opt_output .= '<label><input type="radio" name="sub_group_' . $opt_group_id . '" value="' . $sel_id . '" /><span>' . $sel_opt_name . '</span></label>';
        $opt_output .= '</div>';
    }
}

if (!in_array($program_id, Program_List::minor_required()))
    $minor_req = "<p>A Minor is not required for this program</p>";

echo '<div id="selection_container">'.$minor_req.$opt_output.'</div><div id="selection_display"></div>';

 */