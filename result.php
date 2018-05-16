<?php
define("_TMPL", $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';
require_once '__functions.php';
// Override default configurations here for page
require_once '__config.php';
require $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/header.php';
require '_head.php';

$groupsTaken = $_POST['groups_completed'] ? $_POST['groups_completed'] : [];
if($_POST['sa1'] >= '3')    $groupsTaken[] = 2081;
if($_POST['sa1'] == '6')    $groupsTaken[] = 2074;

if($_POST['sa2'] >= '3')    $groupsTaken[] = 2082;
if($_POST['sa2'] == '6')    $groupsTaken[] = 2075;

if($_POST['sa3'] >= '3')    $groupsTaken[] = 2077;

if($_POST['sa4'] >= '3')    $groupsTaken[] = 2083;

if($_POST['sk1'] >= '3')    $groupsTaken[] = 2084;

if($_POST['sk2'] >= '3')    $groupsTaken[] = 2085;
if($_POST['sk2'] == '6')    $groupsTaken[] = 2061;

if($_POST['sk4'] >= '3')    $groupsTaken[] = 2066;

?>
<link rel="stylesheet" type="text/css" href="/_res/recommendations.css?ABD" />
<script type="text/javascript" language="javascript">
    var courses_taken = [<?= count($_POST['course_taken']) ? '"'.implode('","', $_POST['course_taken']).'"' : '' ?>];
    var program_id = <?= $_POST['program_id'] ?>;
    var sub_groups = <?= count($_POST['sub_groups']) ? '['.$_POST['sub_groups'].']' : 'false' ?>;
    var groupsTaken = [<?= count($groupsTaken) ? '"'.(implode('","',$groupsTaken)).'"' : '' ?>];
    var minor_id = <?= $_POST['minor_id'] ? $_POST['minor_id'] : 'false' ?>;
    var ska4 = <?= isset($_POST['transfer']) ? 'true' : 'false' ?>;
    var fl = <?= isset($_POST['language']) ? (array_values($_POST['course_taken'])[0]) : 'false' ?>;
    var math101 = <?= isset($_POST['math101']) ? 'true' : 'false' ?>;
    var courseload = <?= $_POST['courseload'] ? $_POST['courseload'] : '5' ?>;
    var credits = <?= $_POST['language'] + $_POST['math101'] ?>;
    var term = 0; 
</script>
<script type="text/javascript" language="javascript" src="/_res/recommendations.js?ABD"></script>
<style id="display_style"></style>
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/topBanner.php';
include $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/site_header.php';
if ($include_left_banner)
    include $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/site_leftBanner.php';
?>
<div id="content" class="col-body">
    <div class="flex-row sm-flex-row">
        <div id="mainContent_Body" class="flex-col">
            <?php print_c($_POST); ?>
            <h1>Course Recommendations</h1>
            <output id="course_recommendations"></output>
        </div>
        <?php if ($include_right_banner) include $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/site_rightBanner.php'; ?>
    </div>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/_tmpl/bottomBanner.php'); ?>