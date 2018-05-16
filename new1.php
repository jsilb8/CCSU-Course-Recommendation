<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/_srv/DB_Connect.php';

require_once '__functions.php';



$ged = new GenEd();
echo $ged->master_group;

//$numtaken = 5;
//$term = 0;
//$minor_id = 'false';
//$ska4 = 'false';
////if student didn't pas out of math101, add it to courses required
//if ($math101 == 'false') {
//    $majReqCourses[] = 1695;
//}
//
//
////if student didn't take 2 years of HS language, add for lang 111 to groups. Otherwise, dont add it 
//if ($fl == 'false') {
//    $fl = true;
//}
//
//
////if student didnt transfer with more than 15 credits, don't add ska4 to groups and add PE144 to courses required
//if ($ska4 == 'false') {
//    $ska4 = false;
//    $majReqCourses[] = 2837;
//}
//
//
////get the courses for this major
//$major = new Program(114);
//for ($x = 0; $x < count($major->master_group->course_list); $x++) {
//    $majReqCourses[] = $major->master_group->course_list[$x]->db_id;
//}
//
//
////for each specialization selected, remove all other specializations that share a parent from major groups. If spec has children, remove it as well and add atomic children instead.
////if no spec selected, remove all specialization groups from major groups
//$majGroups = $major->atomics;
//if ($sub_groups != 'false' AND $sub_groups) {
//    foreach ($sub_groups as $id) {
//        $pg = new Prereq_Group($id);
//        $parentID = $pg->get_parent_group2();
//        foreach ($majGroups as $g) {
//            if (strstr($g->name, "Spec-") AND $g->db_id != $id AND $g->get_parent_group2() == $parentID) {
//                unset($majGroups[array_search($g, $majGroups)]);
//                array_filter($majGroups);
//            } else if (strstr($g->name, "Spec-") AND $g->db_id == $id) {
//                if ($pg->sub_groups) {
//                    unset($majGroups[array_search($g, $majGroups)]);
//                    array_filter($majGroups);
//                    $atomics = $pg->getAtomics();
//                    $majGroups = array_merge($majGroups, $atomics);
//                    if (strstr($pg->name, "Spec") AND $pg->course_list) {
//                        foreach ($pg->course_list as $c) {
//                            $majReqCourses[] = $c->db_id;
//                        }
//                    }
//                }
//                else
//                {
//                    $parent = new Prereq_Group($parentID);
//                    if (strstr($parent->name, "Spec") AND $pg->course_list) {
//                        if($parent->course_list) {
//                            foreach ($parent->course_list as $c) {
//                                $majReqCourses[] = $c->db_id;
//                            }
//                        }
//                    }
//                }
//            }
//        }  
//    }
//    foreach ($majGroups as $g) {
//        $cids = false;
//        $credits2 = 0;
//        foreach ($g->course_list as $c) {
//            $credits2 += $c->credit;
//            $cids[] = $c->db_id;
//        }
//        if ($credits2 == $g->req_credits) {
//            $majReqCourses = array_merge($majReqCourses, $cids);
//            unset($majGroups[array_search($g, $majGroups)]);
//            array_filter($majGroups);
//        }
//    }
//} else if (!$sub_groups) {
//    foreach ($majGroups as $g) {
//        if (strstr($g->name, "Spec-")) {
//            unset($majGroups[array_search($g, $majGroups)]);
//            array_filter($majGroups);
//        }
//    }
//}
//$majReqGroups = $majGroups;
//
//
////print the courses for this major
//echo  "Major courses required: ".'<br>';
//foreach ($majReqCourses as $id) {
//    $course = new Course($id);
//    echo $course->db_id . " " . $course->des . " " . $course->num . "|| ";
//}
//
//
////print the groups for this major
//echo  '<br>'.'<br>'."Major Groups Required: ".'<br>'; 
//foreach ($majGroups as $sg) {
//    $majReqGroups[] = $sg;
//    echo $sg->db_id . " " . $sg->name . "|| ";
//}
//
//
//
////add incomplete major groups after applying courses taken to rem major groups and print
//echo  '<br>'.'<br>'."Major Groups remaining: ".'<br>';
//$result3 = $major->get_areas_compl($taken, $majGroups);
//$inc3 = [];
//foreach ($result3 as $r) {
//
//    if ($r->remCredits AND $r->remCredits > 0 AND $r != $prevR) {
//        $inc3[] = $r;
//    } else if ($r->remCredits == null AND $r->remCredits != 0 AND $r != $prevR) {
//        $r->remCredits = $r->req_credits;
//        $inc3[] = $r;
//    }
//    $prevR = $r;
//}
//foreach ($inc3 as $i) {
//    echo $i->name . " " . $i->remCredits . " |";
//}
//
//
////print major filter groups
//echo  '<br>'.'<br>'."Major filter groups: ".'<br>'; 
//if ($major->filter_groups) {
//    foreach ($major->filter_groups as $g) {
//        echo $g->db_id . " " . $g->name . " " . $g->req_credits . " ||";
//    }
//}
//
//
////add incomplete groups after applying taken from rem maj filter groups to rem maj groups
//echo  '<br>'.'<br>'."Major filter groups remaining: ".'<br>'; 
//if ($major->filter_groups) {
//    $filtCompl = $major->get_areas_compl($taken, $major->filter_groups);
//
//    foreach ($filtCompl as $g) {
//
//        if ($g->remCredits) {
//            $inc3[] = $g;
//            echo $g->db_id . " " . $g->name . " " . $g->remCredits . " ||";
//        }
//    }
//}
//
//
////get the courses for this minor
//$minReqCourses = [];
//if ($minor_id AND $minor_id != 'false') {
//
//    $minor = new Program($minor_id);
//    for ($x = 0; $x < count($minor->master_group->course_list); $x++) {
//        $minReqCourses[] = $minor->master_group->course_list[$x]->db_id;
//    }
//
//    $minReqC = $minReqCourses;
//
//    
//    //print minor courses
//    echo '<br>' . '<br>' . "Minor Courses Required: " . '<br>';
//    foreach ($minReqCourses as $id) {
//        $course = new Course($id);
//        echo $course->db_id . " " . $course->des . " " . $course->num . "|| ";
//    }
//
//    
//    //print minor groups
//    echo '<br>' . '<br>' . "MinorGroups Required: " . '<br>';
//    foreach ($minor->master_group->sub_groups as $msg) {
//        $minReqGroups[] = $msg;
//        echo $msg->db_id . " " . $msg->name . "|| ";
//    }
//
//    
//    //print inc min groups after applying taken
//    echo '<br>' . '<br>' . "Minor Groups remaining: " . '<br>';
//    $result4 = $minor->get_areas_compl($taken, $minor->atomics);
//
//    $inc4 = [];
//    foreach ($result4 as $r) {
//        if ($r->remCredits AND $r != $prev) {
//            $inc4[] = $r;
//        }
//        $prev = $r;
//    }
//
//    foreach ($inc4 as $i) {
//        echo $i->name . " " . $i->remCredits . " |";
//    }
//}
//
//
////merge major and minor courses
//$majMinCourses = array_merge($majReqCourses, $minReqCourses);
//
//
////merge major and minor groups
//if (!$inc4) {
//    $majMinRemGroups = $inc3;
//} else if (!$inc3) {
//    $majMinRemGroups = $inc4;
//} else {
//    $majMinRemGroups = array_merge($inc3, $inc4);
//}
//
//
////turn list of taken IDs into array of taken course objects called list and print them
//$creditCount = 0;
//echo  '<br>'.'<br>'."Courses taken: ".'<br>';
//for ($x = 0; $x < count($taken); $x++) {
//    if ($taken[$x]) {
//        $course = new Course($taken[$x]);
//        $list[] = $course;
//        $creditCount += $course->credit;
//        echo $course->db_id . " " . $course->des . " " . $course->num . "|| ";
//    }
//}
//
//
////subtract credits for math101 and/ or for lang class if they were passed out of and pre-added to taken. 
////print credits
//$creditCount += $credits;
//echo  '<br>'.'<br>'."Credit Count: ".$creditCount;
//
//
////set updated req courses to the original req - taken and print them
//echo  '<br>'.'<br>'."Courses Remaining: ".'<br>';
//foreach ($majMinCourses as $id) {
//    $unset = false;
//    for ($x = 0; $x < count($taken); $x++) {
//        if ($id == $taken[$x]) {
//            $unset = true;
//            break;
//        }
//    }
//    if (!$unset) {
//        $updReqC[] = $id;
//        $course = new Course($id);
//        echo $course->db_id . " " . $course->des . " " . $course->num . "|| ";
//    }
//}
//
//
////store the merge of gen ed req groups and maj req groups so they can be switched between at recomm time
//$gED = new GenEd();
//foreach ($gED->area_list as $g) {
//
//    $requiredGroups[] = $g->db_id;
//}
//$requiredGroups = array_merge($requiredGroups, $majReqGroups);
//
//
////for each course taken, see if it's on the maj/ min list. If it's not, it must have come from a gen ed group, so store it in the genEd course array.
////if it is on maj/min, store it in nonGenEd
//$genEd;
//echo  '<br>'.'<br>'."Gen Ed Courses Taken: ".'<br>';
//for ($x = 0; $x < count($taken); $x++) {
//    $reqCourse = false;
//    $ind = in_array($taken[$x], $majMinCourses);
//    if ($ind) {
//        $reqCourse = true;
//    }
//    
//    if (!$reqCourse) {
//        if ($taken[$x]) {
//            $genEd[] = $taken[$x];
//            $course = new Course($taken[$x]);
//            echo $course->db_id . " " . $course->des . " " . $course->num . "|| ";
//        }
//    } else {
//
//        $nonGenEd[] = $taken[$x];
//    }
//}
//
//
//
////see which gen ed groups are complete based on input gen ed course taken array and print them
//echo  '<br>'.'<br>'."Complete Atomics: ".'<br>';
//$ac = $gED->get_areas_compl($genEd,$fl,$ska4);
//if ($ac) {
//    foreach ($ac as $a) {
//        if ($a->remCredits) {
//            if (($a->remCredits == 0 AND $a->remCredits != null) OR $a->remCredits < 0) {
//                echo $a->db_id . " " . $a->name . "|| ";
//                $a->remCredits = 0;
//                $completes[] = $a;
//            } else {
//                if (strstr($a->name, "SA") OR strstr($a->name, "SK")) {
//                    $remSkSt[] = $a;
//                }
//                $inc[] = $a;
//                $AR[] = $a;
//                $arIDS[] = $a->db_id;
//            }
//        } else {
//            echo $a->db_id . " " . $a->name . "|| ";
//            $completes[] = $a;
//        }
//    }
//} else {
//    $inc = $gED->area_list;
//}
//
//
////print gen ed groups still inc after applying gen ed taken
//echo  '<br>'.'<br>'."Incomplete/ Remaining Atomics: ".'<br>';
//if ($inc) {
//    foreach ($inc as $g) {
//        $incIDS[] = $g->db_id;
//
//        if (!$g->remCredits) {
//            echo $g->db_id . " " . $g->name . ": " . $g->req_credits . " credits remain|| ";
//        } else {
//            echo $g->db_id . " " . $g->name . ": " . $g->remCredits . " credits remain|| ";
//        }
//    }
//}
//
//
////add ids of inc gen eds to ids of inc major groups and store for later use
//if ($inc3) {
//    foreach ($inc3 as $g) {
//        $incIDS[] = $g->db_id;
//    }
//}
//
//
////print gen eds still incomplete after trying to apply 16 credits of maj/ min courses taken towards them
//echo  '<br>'.'<br>'."Incomplete Atomics after applying maj/ min courses: ".'<br>';
//foreach ($remSkSt as $r) {
//    $ids[] = $r->db_id;
//}
//
//$GED = new GenEd();
//foreach ($GED->atomics as $a) {
//    $ind = array_search($a->db_id, $ids);
//    if ($ind OR $ids[$ind] == $a->db_id) {
//        if (strstr($a->name, "SA") OR STRSTR($a->name, "SK")) {
//            $remss[] = $a;
//        }
//    }
//}
//
//
//$result = $GED->get_areas_compl2($nonGenEd,$remss);
//$result2 = array_merge($result, $inc3);
//array_filter($result2);
//foreach ($inc3 as $g) {
//    if ($g->remCredits) {
//
//        $arIDS[] = $g->db_id;
//    }
//}
//
//foreach ($result as $g) {
//    if ($g->remCredits) {
//        echo $g->name . " " . $g->remCredits . " ||";
//        $ind = array_search($g->db_id, $incIDS);
//        if ($ind OR $incIDS[$ind] == $g->db_id) {
//            $tempCred = $g->remCredit;
//            $g->remCredit = $inc[$ind]->remCredit - ($g->req_credits - $tempCred);
//            $ind2 = array_search($g->db_id, $arIDS);
//            $AR[$ind2] = $g;
//        }
//    } else {
//        $completes2[] = $g;
//        $ind = array_search($g->db_id, $arIDS);
//        unset($AR[$ind]);
//        array_filter($AR);
//    }
//}
//
//
////print gen eds completed after applying maj/min courses
//echo  '<br>'.'<br>'."Complete Atomics after applying maj/ min courses: ".'<br>';
//if ($completes2) {
//    foreach ($completes2 as $c) {
//        echo $c->name . " ||";
//    }
//}
//
//
////apply gen ed taken toward international and output result. If inc, add it to rem groups
//echo  '<br>'.'<br>'."International complete?: ".'<br>';
//$intCredit = 0;
//$complete = false;
//$pg = new Prereq_Group(2079);
//$pg->remCredits = $pg->req_credits;
//
//if ($genEd) {
//    foreach ($genEd as $id) {
//        if ($pg->remCredits <= 0 OR $pg->remCredits == null OR ! $pg->remCredits) {
//            $complete = true;
//            break;
//        } else if ($pg->remCredits > 0) {
//            $c = new Course($id);
//            $ind = in_array($id, $pg->full_course_list);
//            if ($ind) {
//                $intCredit += $c->credit;
//                $pg->remCredits -= $c->credit;
//                if ($pg->remCredits <= 0) {
//                    $complete = true;
//                    break;
//                }
//            }
//        }
//    }
//}
//
//if ($complete) {
//    echo "yes";
//} else {
//    echo "no: " . $pg->remCredits . " credits remaining.";
//    $AR[] = $pg;
//}
//
//
////with the rem req courses, get all courses on it without a prereq and add them to avail array if offered this semester. 
////If the course has a prereq group and it passes, add it to avail if offered this sem
//$avail;
//
//if ($updReqC) {
//    foreach ($updReqC as $id) {
//        $course = new Course($id);
//        if (!$course->prereq_group) {
//            
//            if($course->term == $term OR $course->term == 2 OR ($course->term == 3 AND $term == 1))
//            {
//                $avail[] = $id;
//            }
//        } else {
//            if (Prereq_Group::check_completion(new Prereq_Group($course->prereq_group), $list)) {
//                
//                if($course->term == $term OR $course->term == 2 OR ($course->term == 3 AND $term == 1))
//                {
//                    $avail[] = $id;
//                }
//            }
//        }
//    }
//}
//
//
//
////for each taken course, see the courses that require it. For each of the courses requiring it, check the completion of its prereq group against taken. 
////if its prereq group is complete, add that course to avail if offered this sem
//for ($x = 0; $x < count($nonGenEd); $x++) {
//    $courses = Course::getCoursesMadeAvail($nonGenEd[$x], $updReqC, $list, $avail);
//    for ($y = 0; $y < count($courses); $y++) {
//        
//        if($course->term == $term OR $course->term == 2 OR ($course->term == 3 AND $term == 1))
//        {
//            $avail[] = $courses[$y];
//        }
//    }
//}
//
//
////print avail courses
//echo  '<br>'.'<br>'."Courses Available: ".'<br>';
//if($avail) {
//    //for each avail course, if its priority is statically set in DB, get it. Otherwise, calculate its priority against the starting required list.
//    //Store these priorities in an array
//    foreach ($avail as $a) {
//        $c = new Course($a);
//        echo $c->db_id . " " . $c->des . " " . $c->num . "|| ";
//        if ($c->priority == null OR $c->priority == 0) {
//            $c->priority = Course::getPriority($a, $majMinCourses);
//        }
//        $cs[] = $c;
//    }
//
//    
//    //sort avail by priority and calc top x priorities, where x = # of courses student wants to take for this recomm cycle
//    usort($cs, 'GenEd::sortByPriority');
//    for ($x = 0; $x < $numtaken; $x++) {
//        $topP[$x] = $cs[$x]->priority;
//    }
//
//
//    //create a course matrix where levels are priorities from topx list. At each level, store array of all avail with that priority
//    for ($x = 0; $x < $numtaken; $x++) {
//        $count = 0;
//        for ($y = 0; $y < count($cs); $y++) {
//            if ($cs[$y]->priority == $topP[$x]) {
//                $cMatrix[$x][$count] = $cs[$y];
//                $count++;
//            }
//        }
//    }
//}
//
//
////print course matrix
//echo  '<br>'.'<br>'."Course Matrix: ".'<br>';
//for ($x = 0; $x < count($cMatrix); $x++) {
//    for ($y = 0; $y < count($cMatrix[$x]); $y++) {
//
//        echo $cMatrix[$x][$y]->db_id . " " . $cMatrix[$x][$y]->des . " " . $cMatrix[$x][$y]->num . " || ";
//    }
//    echo " " . $topP[$x] . '<br>';
//}
//
////sort remaining gen ed groups by priority (all maj/ min groups have priority = 0) and store top 5 priorities
//usort($AR, 'GenEd::sortByPriorityAsc');
//for ($x = 0; $x < $numtaken; $x++) {
//    $topGP[$x] = $AR[$x]->priority;
//}
//
//
////update the course lists of the remaining atomic groups. Keep only courses that dont have prereqs, or do and have them satisfied with taken, and are not on taken themselves
//if ($AR) {
//    foreach ($AR as $g) {
//        $cl = $g->course_list;
//        for ($x = 0; $x < count($cl); $x++) {
//            if ($taken != null) {
//                
//                $take = false;
//                foreach ($taken as $id) {
//                    if ($id == $g->course_list[$x]->db_id) {
//                        unset($g->course_list[$x]);
//                        $take = true;
//                        break;
//                    }
//                }
//            }
//            if (!$take) {
//                $pg = new Prereq_Group($g->course_list[$x]->prereq_group);
//                if ($g->course_list[$x]->prereq_group) {
//                    if (!$list) {
//                        
//                        unset($g->course_list[$x]);
//                    } else {
//                        if (!Prereq_Group::check_completion($pg, $list)) {
//                            unset($g->course_list[$x]);
//                        }
//                    }
//                }
//            }
//        }
//        if ($g->course_list) {
//            array_filter($g->course_list);
//        }
//    }
//}
//
//
////update the course lists of the remaining majMin groups. Keep only courses that dont have prereqs, or do and have them satisfied with taken; and are not on taken themselves
//if ($majMinRemGroups) {
//    foreach ($majMinRemGroups as $g) {
//        $cl = $g->course_list;
//        for ($x = 0; $x < count($cl); $x++) {
//            if ($taken != null) {
//                $take = false;
//                foreach ($taken as $id) {
//                    if ($g->course_list[$x]->db_id == $id) {
//                        unset($g->course_list[$x]);
//                        $take = true;
//                        break;
//                    }
//                }                
//            }
//            if (!$take) {
//                $pg = new Prereq_Group($g->course_list[$x]->prereq_group);
//                if ($g->course_list[$x]->prereq_group) {
//                    if (!$list) {
//                        unset($g->course_list[$x]);
//                    } else {
//                        if (!Prereq_Group::check_completion($pg, $list)) {
//                            unset($g->course_list[$x]);
//                        }
//                    }
//                }
//            }
//        }
//        if ($g->course_list) {
//            array_filter($g->course_list);
//        }
//    }
//}
//
//
//
//
//
////populate group matrix.
//$count2 = 0;
//$count3 = 0;
//$count4 = 0;
//if (!$cMatrix) {
//    for ($x = 0; $x < 5; $x++) {
//        $count = 0;
//        if ($topGP[$x] > 0) {
//            for ($y = 0; $y < count($AR); $y++) {
//                if ($topGP[$x] == $AR[$y]->priority) {
//                    $gMatrix[$x][$count] = $AR[$y];
//                    $count++;
//                }
//            }
//        } else {
//            if ($count2 % 2 == 0 AND $majMinRemGroups) {
//                if($count3 < count($majMinRemGroups))
//                {
//                    $count3++;
//                    for ($y = 0; $y < count($majMinRemGroups); $y++) {
//                        if ($topGP[$x] == $majMinRemGroups[$y]->priority) {
//                            $gMatrix[$x][$count] = $majMinRemGroups[$y];
//                            $count++;
//                        }
//                    }
//                } else {
//                    foreach ($majMinRemGroups as $g) {
//                        $maxCredit = 0;
////                     foreach ($g->course_list as $c) {
////                            if ($c->credit > $maxCredit) {
////                                $maxCredit = $c->credit;
////                            }
////                        }
//                        if ($g->remCredits - (3 * $count3) > 0) {
//                            $stillInc[] = $g;
//                        }
//                    }
//                    if ($stillInc) {
//                        $count3++;
//                        for ($y = 0; $y < count($stillInc); $y++) {
//                            if ($topGP[$x] == $stillInc[$y]->priority) {
//                                $gMatrix[$x][$count] = $stillInc[$y];
//                                $count++;
//                            }
//                        }
//                    } else
//                    {          
//                        if ($count4 < count($AR)) {
//                            $count4++;
//                            for ($y = 0; $y < count($AR); $y++) {
//                                if ($topGP[$x] == $AR[$y]->priority) {
//                                    $gMatrix[$x][$count] = $AR[$y];
//                                    $count++;
//                                }
//                            }
//                        } else {
//                            foreach ($AR as $g) {
//                                $maxCredit = 0;
////                                foreach ($g->course_list as $c) {
////                                    if ($c->credit > $maxCredit) {
////                                        $maxCredit = $c->credit;
////                                    }
////                                }
//                                if ($g->remCredits - (3 * $count4) > 0) {
//                                    $stillInc[] = $g;
//                                }
//                            }
//                            if ($stillInc) {
//                                $count4++;
//                                for ($y = 0; $y < count($stillInc); $y++) {
//                                    if ($topGP[$x] == $stillInc[$y]->priority) {
//                                        $gMatrix[$x][$count] = $stillInc[$y];
//                                        $count++;
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//            } else {
//                if($count4 < count($AR))
//                {
//                    $count4++;
//                    for ($y = 0; $y < count($AR); $y++) {
//                        if ($topGP[$x] == $AR[$y]->priority) {
//                            $gMatrix[$x][$count] = $AR[$y];
//                            $count++;
//                        }
//                    }
//                }
//                else
//                {
//                    foreach ($AR as $g) {
//                        $maxCredit = 0;
////                        foreach ($g->course_list as $c) {
////                            if ($c->credit > $maxCredit) {
////                                $maxCredit = $c->credit;
////                            }
////                        }
//                        if ($g->remCredits - ($maxCredit * $count4) > 0) {
//                            $stillInc[] = $g;
//                        }
//                    }
//                    if ($stillInc) {
//                        $count4++;
//                        for ($y = 0; $y < count($stillInc); $y++) {
//                            if ($topGP[$x] == $stillInc[$y]->priority) {
//                                $gMatrix[$x][$count] = $stillInc[$y];
//                                $count++;
//                            }
//                        }
//                    }
//                }
//            }
//            $count2++;
//        }
//    }
//} else {
//    echo "pppp";
//    for ($x = 0; $x < count($topGP); $x++) {
//        $count = 0;
//        if ($topGP[$x] > 0) {
//            for ($y = 0; $y < count($AR); $y++) {
//                if ($topGP[$x] == $AR[$y]->priority) {
//                    $gMatrix[$x][$count] = $AR[$y];
//                    $count++;
//                }
//            }
//        } else {
//            if ($count2 % 2 == 0 AND $majMinRemGroups) {
//                if($count3 < count($majMinRemGroups))
//                {
//                    $count3++;
//                    for ($y = 0; $y < count($majMinRemGroups); $y++) {
//                        if ($topGP[$x] == $majMinRemGroups[$y]->priority) {
//                            $gMatrix[$x][$count] = $majMinRemGroups[$y];
//                            $count++;
//                        }
//                    }
//                } else {
//                    foreach ($majMinRemGroups as $g) {
//                        $maxCredit = 0;
////                        foreach ($g->course_list as $c) {
////                            if ($c->credit > $maxCredit) {
////                                $maxCredit = $c->credit;
////                            }
////                        }
//                        if ($g->remCredits - (3 * $count3) > 0) {
//                            $stillInc[] = $g;
//                        }
//                    }
//                    if ($stillInc) {
//                        $count3++;
//                        for ($y = 0; $y < count($stillInc); $y++) {
//                            if ($topGP[$x] == $stillInc[$y]->priority) {
//                                $gMatrix[$x][$count] = $stillInc[$y];
//                                $count++;
//                            }
//                        }
//                    } else
//                    {          
//                        if ($count4 < count($AR)) {
//                            $count4++;
//                            for ($y = 0; $y < count($AR); $y++) {
//                                if ($topGP[$x] == $AR[$y]->priority) {
//                                    $gMatrix[$x][$count] = $AR[$y];
//                                    $count++;
//                                }
//                            }
//                        } else {
//                            foreach ($AR as $g) {
//                                $maxCredit = 0;
////                                foreach ($g->course_list as $c) {
////                                    if ($c->credit > $maxCredit) {
////                                        $maxCredit = $c->credit;
////                                    }
////                                }
//                                if ($g->remCredits - (3 * $count4) > 0) {
//                                    $stillInc[] = $g;
//                                }
//                            }
//                            if ($stillInc) {
//                                $count4++;
//                                for ($y = 0; $y < count($stillInc); $y++) {
//                                    if ($topGP[$x] == $stillInc[$y]->priority) {
//                                        $gMatrix[$x][$count] = $stillInc[$y];
//                                        $count++;
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//            } else {
//                if ($count4 < count($AR)) {
//                    $count4++;
//                    for ($y = 0; $y < count($AR); $y++) {
//                        if ($topGP[$x] == $AR[$y]->priority) {
//                            $gMatrix[$x][$count] = $AR[$y];
//                            $count++;
//                        }
//                    }
//                } else {
//                    foreach ($AR as $g) {
//                        $maxCredit = 0;
////                        foreach ($g->course_list as $c) {
////                            if ($c->credit > $maxCredit) {
////                                $maxCredit = $c->credit;
////                            }
////                        }
//                        if ($g->remCredits - (3 * $count4) > 0) {
//                            $stillInc[] = $g;
//                        }
//                    }
//                    if ($stillInc) {
//                        $count4++;
//                        for ($y = 0; $y < count($stillInc); $y++) {
//                            if ($topGP[$x] == $stillInc[$y]->priority) {
//                                $gMatrix[$x][$count] = $stillInc[$y];
//                                $count++;
//                            }
//                        }
//                    }
//                }
//            }
//            $count2++;
//        }
//    }
//}
//
//
////print group matrix
//echo  '<br>'.'<br>'."Group Matrix: ".'<br>';
//for ($x = 0; $x < count($gMatrix); $x++) {
//    for ($y = 0; $y < count($gMatrix[$x]); $y++) {
//
//        echo $gMatrix[$x][$y]->name . "|||| ";
//    }
//    echo " " . $topGP[$x] . '<br>';
//}
//
//
////populate final group matrix given that some courses are recommended in place of groups
//$count = count($genEd);
//$unset = false;
//for ($x = 0; $x < count($gMatrix); $x++) {
//    if ($topGP[$x] > $topP[count($topP) - 1 - $x]) {
//
//        unset($cMatrix[count($topP) - 1 - $x]);
//        $ngMatrix[] = $gMatrix[$x];
//    } else if ($topGP[$x] == $topP[count($topP) - 1 - $x]) {
//        if ($count % 2 != 0 OR $count == 0 OR $unset OR count($gMatrix) == 1) {
//            unset($cMatrix[count($topP) - 1 - $x]);
//            $ngMatrix[] = $gMatrix[$x];
//            $count++;
//            $unset = false;
//        } else {
//
//            $unset = true;
//        }
//    }
//}
//
//
////print recomm courses
//echo  '<br>'.'<br>'."Course Matrix final: ".'<br>';
//$cnt = 0;
//$prevCnt = 0;
//$output_array = array();
//for ($x = 0; $x < count($cs); $x++) {
//    // If there is a group and it can be ungrouped 
//    if (count($cMatrix[$x]) <= count($cMatrix) - $x + $cnt) {
//        if (count($cMatrix[$x]) > 1) {
//            $output_array[] = $cMatrix[$x][$cnt];
//            echo $cMatrix[$x][$cnt]->db_id . " " . $cMatrix[$x][$cnt]->des . " " . $cMatrix[$x][$cnt]->num . " ||";
//            $cnt++;
//            if ($cnt == count($cMatrix[$x])) {
//                $cnt = 0;
//            }
//            echo " " . $topP[$x] . 'Broken Up<br>';
//        } elseif ($cMatrix[$x][$cnt]) {
//            // There is only one course option
//            $output_array[] = $cMatrix[$x][$cnt];
//            echo $cMatrix[$x][$cnt]->db_id . " " . $cMatrix[$x][$cnt]->des . " " . $cMatrix[$x][$cnt]->num . " || <br />";
//        }
//    } else {
//        for ($y = 0; $y < count($cMatrix[$x]); $y++) {
//            $c_output[] = $cMatrix[$x][$y];
//            echo $cMatrix[$x][$y]->db_id . " " . $cMatrix[$x][$y]->des . " " . $cMatrix[$x][$y]->num . " ||";
//        }
//
//        // If 
//        if ($cMatrix[$x]) {
//            echo " " . $topP[$x] . 'Not Broken<br>';
//
//            if (count($c_output) > '1')
//                $output_array[] = $c_output;
//            
//            $c_output = [];
//        }
//    }
//    $cMatrix[$x]['priority'] = $topP[$x];
//}
//
//
//
////print recomm groups
//echo  '<br>'.'<br>'."Group Matrix final: ".'<br>';
//for ($x = 0; $x < count($ngMatrix); $x++) {
//    for ($y = 0; $y < count($ngMatrix[$x]); $y++) {
//
//        $g_output[] = $ngMatrix[$x][$y];
//        echo $ngMatrix[$x][$y]->name . "|||| ";
//    }
//
//    if ($ngMatrix[$x]) {
//        $output_array[] = $g_output;
//        $g_output = [];
//        echo " " . $topGP[$x] . '<br>&bull;';
//    }
//}
//
//echo $show_process ? $echo : '';