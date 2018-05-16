<?php
define("_TMPL", $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';

require_once '__functions.php';

function get_selectable_majors() {
    $data = DB::query(' SELECT p.programID, p.name, p.programType FROM `program` `p` 
                    WHERE p.level = "Undergraduate" AND p.programType != "Minor" ORDER BY p.name ASC');

    while ($program = DB::fetch_array($data))
        $output .= '<label class="name live_hidden">
                        <input type="radio" name="program_id" value="' . $program['programID'] . '" />
                        <span>' . $program['name'] . ' ' . $program['programType'] . '</span>
                    <br /></label>';

    return $output;
}

function get_selectable_minors() {
    $data = DB::query(' SELECT p.programID, p.name, p.programType FROM `program` `p` 
                    WHERE p.level = "Undergraduate" AND p.programType = "Minor" ORDER BY p.name ASC');

    while ($program = DB::fetch_array($data))
        $output .= '<label class="name live_hidden">
                        <input type="radio" name="minor_id" value="' . $program['programID'] . '" />
                        <span>' . $program['name'] . '</span>
                    <br /></label>';

    return $output;
}

function get_foreign_language_list() {
    $fl_group = new Prereq_Group(2078);
    $output = '<select id="language_select" name="course_taken[]" class="hidden"><option value="">Please Select...</option>';
    foreach ($fl_group->course_list as $course)
        $output .= '<option value="' . $course->db_id . '" />' . rtrim((str_replace("Elementary ", "", $course->name)), 'I') . '</option>';
    $output .= '</select>';
    return $output;
}

// Override default configurations here for page
require_once '__config.php';

require $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/header.php';
require '_head.php';
?>
<script type="text/javascript" language="javascript" src="/_res/course_selection.js?2"></script>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/topBanner.php';
include $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/site_header.php';

//$program_id     // Major ID
//$sub_groups     // Array of sub-group / specialization group ids OR false
//$minor_required // true / false  
//$minor_id       // Minor ID 
//
//$fl             // id of 111 FL group OR false
//$ska4           // true / false
//
//$numtaken       // how many courses are they taking
//$taken          // Array of courses taken
?>


<div id="content" class="col-body">
    <div class="flex-row sm-flex-row">
        <div id="mainContent_Body" class="flex-col">
            <h1>Introduction</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum aliquet quis est sed dictum. Integer ac scelerisque eros. Vivamus volutpat dolor non orci vestibulum, sed dictum orci varius. Ut sodales velit nec porta feugiat. Pellentesque tempor hendrerit lobortis. Pellentesque eu egestas sem. Suspendisse luctus aliquam justo eu iaculis. Integer sagittis mi ipsum, id tincidunt augue vulputate sit amet. Aenean bibendum sed purus ut tincidunt. Ut eu interdum sem.</p>
            <form action="/result.php" method="post">
                <fieldset id="setup">
                    <h3>Incoming Status</h3>
                    <label id="has_credit"><p><input type="checkbox" name="credits" value="1" /> <span>I entered CCSU with credit (ex: transfer credit)</span></p></label>
                    <label id="is_transfer" class="hidden"><p><input type="checkbox" name="transfer" value="1" /> <span>I transfered to CCSU with more than 15 credits</span></p></label>
                    <label id="math_placement"><p><input type="checkbox" name="math101" value="-3" /> <span>I placed out of Math 101 before coming to Central</span><input type="hidden" name="course_taken[]" value="1695" id="math_101_id" disabled="disabled" /></p></label>
                    <label id="foriegn_language"><p><input type="checkbox" name="language" value="-3" /> <span>I took 2 years of Foriegn Language in High School</span> <?= get_foreign_language_list() ?></p></label>
                </fieldset>
                <div id="program_selection_search" class="flex">
                    <div class="col-1">
                        <fieldset id="major_select">
                            <h3>What is your Major?</h3>
                            <input type="text" value="" placeholder="Search for your Major" class="live_search" data-targetlist="select_major_list .name" data-targetfield=" ">
                            <div id="select_major_list" class="select_program_list"><?= get_selectable_majors() ?></div>
                        </fieldset>
                        <div id="additional_program_information"></div>
                    </div>
                    <div class="col-1">
                        <h3>What is your Minor? <label id="has_minor"><input type="checkbox" name="minor_toggle" value="1" id="minor_toggle"><span>I have not selected a Minor</span></label></h3>
                        <fieldset id="minor_select">
                            <input type="text" value="" placeholder="Search for your Minor" class="live_search" data-targetlist="select_minor_list .name" data-targetfield=" " data-min_input="2">
                            <div id="select_minor_list" class="select_program_list"><?= get_selectable_minors() ?></div>
                        </fieldset>
                    </div>
                </div>
                <div id="transfer_groups" class="flex hidden">
                    <div class="section">
                        <h4>Study Area I - Arts &amp; Humanities</h4>
                        <label><input type="checkbox" name="groups_completed[]" value="2050" /><span>Literature</span></label>
                        <select name="sa1">
                            <option value="0">No Credits</option>
                            <option value="3">Less than 6 credits</option>
                            <option value="6">6 or more credits</option>
                        </select>
                    </div> 
                    <div class="section">
                        <h4>Study Area II Sciences Sciences</h4>
                        <label><input type="checkbox" name="groups_completed[]" value="2051" /><span>History</span></label>
                        <select name="sa2">
                            <option value="0">No Credits</option>
                            <option value="3">Less than 6 credits</option>
                            <option value="6">6 or more credits</option>
                        </select>
                    </div> 
                    <div class="section">
                        <h4>Study Area III - Behavioral Sciences</h4>
                        <select name="sa3">
                            <option value="0">No Credits</option>
                            <option value="3">Less than 6 credits</option>
                            <option value="6">6 or more credits</option>
                        </select>
                    </div> 
                    <div class="section">
                        <h4>Study Area IV - Natural Sciences</h4>
                        <label><input type="checkbox" name="groups_completed[]" value="2056" /><span>Lab</span></label>
                        <select name="sa4">
                            <option value="0">No Credits</option>
                            <option value="3">Less than 6 credits</option>
                            <option value="6">6 or more credits</option>
                        </select>
                    </div> 
                    <div class="section">
                        <h4>Skill Area I - Communication Skills</h4>
                        <label><input type="checkbox" name="groups_completed[]" value="2058" /><span>Writing 110 or equivalent</span></label>
                        <select name="sk1">
                            <option value="0">No Credits</option>
                            <option value="3">Less than 6 credits</option>
                            <option value="6">6 or more credits</option>
                        </select>
                    </div> 
                    <div class="section">
                        <h4>Skill Area II - Mathematics</h4>
                        <select name="sk2">
                            <option value="0">No Credits</option>
                            <option value="3">Less than 6 credits</option>
                            <option value="6">6 or more credits</option>
                        </select>
                    </div> 
                    <div class="section">
                        <h4>Skill Area III - Foreign Language Proficiency</h4>
                        <label><input type="checkbox" name="groups_completed[]" value="2064" /><span>Foreign Language (above 111 level)</span></label>
                    </div> 
                    <div class="section">
                        <h4>Skill Area IV - University Requirement</h4>
                        <select name="sk4">
                            <option value="0">No Credits</option>
                            <option value="3">Less than 6 credits</option>
                            <option value="6">6 or more credits</option>
                        </select>
                    </div>
                </div>
                <button id="get_courses" type='button'>Continue</button>
                <div id="program_output" class="flex"><output class="major col-1"></output><output class="minor col-1"></output></div>
                <div id="gened_output"><output></output></div>
                <div id="submit_button" class="hidden">
                    <label><p>Number of courses you would like to take next semester: <input name="courseload" type="number" value="5" /></p></label>
                    <button name="submit" value="1" type="submit">Find Courses</button>
                </div>
            </form>
        </div>
        <?php if ($include_right_banner) include $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/site_rightBanner.php'; ?>
    </div>
</div> 
<?php include($_SERVER['DOCUMENT_ROOT'] . '/_tmpl/bottomBanner.php'); ?>