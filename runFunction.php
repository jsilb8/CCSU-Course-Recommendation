<?php
define("_TMPL", $_SERVER['DOCUMENT_ROOT'] . '/_tmpl/');
require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';

require_once '__functions.php';

$values = query("SELECT * FROM `course`");

while($val = fetch_array($values)){
    echo  "UPDATE `course` SET temp = '".$val['des']." ".$val['num']."' WHERE courseID = '".$val['courseID']."'<br />";
    query("UPDATE `course` SET temp = '".$val['des']." ".$val['num']."' WHERE courseID = '".$val['courseID']."'");
}