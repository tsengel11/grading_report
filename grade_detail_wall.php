<?php
// This file is part of Moodle - http://moodle.org/
//

/**
 * Version details
 *
 * @package    block_grading_report
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

global $DB, $USER, $CFG;
require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/blocks/grading_report/locallib.php');

require_login();
$user_id = $USER->id;
$url = $CFG->wwwroot;

$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details_wall.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');

//$PAGE->requires->js('/blocks/grading_report/javascripts/scripts.js',true);


echo $OUTPUT->header();
$selected_groupid=$_GET['cohortid'];

$users = get_userlist_wall($selected_groupid);
$cohorts=get_cohort_wall();
foreach($cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_detail_wall.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}
print_object($cohorts);
// print_object($users);
foreach($users as $user){
    $user->userlink=convert_userlink($user->userid,$user->firstname,$user->lastname,$url);
    // Quizes
    //Term 1
    $user->cpccwhs1001=convert_grade_quiz($user->cpccwhs1001,$user->userid);
    $user->cpccohs2001a=convert_grade_quiz($user->cpccohs2001a,$user->userid);
    $user->cpccohs2001a_practical=convert_grade_one_item($user->cpccohs2001a_practical,$user->userid,2868,"PA");
    $user->cpcccm1012a=convert_grade_quiz($user->cpcccm1012a,$user->userid);
    $user->cpcccm1012a_practical=convert_grade_one_item($user->cpcccm1012a_practical,$user->userid,2547,"PA");
    $user->cpcccm1013a=convert_grade_quiz($user->cpcccm1013a,$user->userid);
    $user->cpcccm1013a_practical=convert_grade_one_item($user->cpcccm1013a_practical,$user->userid,2130,"PA");
    $user->cpcccm1014a=convert_grade_quiz($user->cpcccm1014a,$user->userid);
    $user->cpcccm1014a_practical=convert_grade_one_item($user->cpcccm1014a_practical,$user->userid,2578,"PA");
    // Term 2
    $user->cpcccm1015a=convert_grade_quiz($user->cpcccm1015a,$user->userid);  
    $user->cpcccm1015a_practical=convert_grade_one_item($user->cpcccm1015a_practical,$user->userid,2696,"PA");
    $user->cpcccm2001a=convert_grade_quiz($user->cpcccm2001a,$user->userid);
    $user->cpcccm2001a_practical=convert_grade_one_item($user->cpcccm2001a_practical,$user->userid,2701,"PA");
    $user->cpcccm2006b=convert_grade_quiz($user->cpcccm2006b,$user->userid);
    $user->cpcccm2006b_practical=convert_grade_one_item($user->cpcccm2006b_practical,$user->userid,2167,"PA");
    $user->cpccwf2001a=convert_grade_quiz($user->cpccwf2001a_practical,$user->userid);
    $user->cpccwf2001a_practical=convert_grade_one_item($user->cpccwf2001a_practical,$user->userid,2168,"PA");
    $user->cpccwf2002a=convert_grade_quiz($user->cpccwf2002a,$user->userid);
    $user->cpccwf2002a_practical=convert_grade_one_item($user->cpccwf2002a_practical,$user->userid,2170,"PA");
    // Term 3

    $user->cpccwf3001a=convert_grade_quiz($user->cpccwf3001a,$user->userid);
    $user->cpccwf3001a_practical=convert_grade_one_item($user->cpccwf3001a_practical,$user->userid,2173,"PA");
    $user->cpccwp3002a=convert_grade_quiz($user->cpccwp3002a,$user->userid);
    $user->cpccwp3002a_practical=convert_grade_one_item($user->cpccwp3002a_practical,$user->userid,2163,"PA");
    $user->cpccwf3003a=convert_grade_quiz($user->cpccwf3003a,$user->userid);
    $user->cpccwf3003a_practical=convert_grade_one_item($user->cpccwf3003a_practical,$user->userid,2165,"PA");
    $user->cpccwf3002a=convert_grade_quiz($user->cpccwf3002a,$user->userid);
    $user->cpccwf3002a_practical=convert_grade_one_item($user->cpccwf3002a_practical,$user->userid,2176,"PA");
    $user->cpccwf3004a=convert_grade_quiz($user->cpccwf3004a,$user->userid);
    $user->cpccwf3004a_practical=convert_grade_one_item($user->cpccwf3004a_practical,$user->userid,2179,"PA");
    // TERM 4
    $user->cpccwf3006a=convert_grade_quiz($user->cpccwf3006a,$user->userid);
    $user->cpccwf3006a_practical=convert_grade_one_item($user->cpccwf3006a_practical,$user->userid,2182,"PA");
    $user->cpccwf3007a=convert_grade_quiz($user->cpccwf3007a,$user->userid);
    $user->cpccwf3007a_practical=convert_grade_one_item($user->cpccwf3007a_practical,$user->userid,2184,"PA");
    $user->bsbsmb406=convert_grade_one_item($user->bsbsmb406,$user->userid,2438,"PA");
    $user->bsbsmb301=convert_grade_quiz($user->bsbsmb301,$user->userid);
    $user->bsbsmb301_practical=convert_grade_one_item($user->bsbsmb301_practical,$user->userid,2160,"PA");
}
//print_object($users);

$templatecontext = (object)[
    'texttodisplay'=>'Certificate III in Wall and Floor Tiling',
    'users'=>array_values($users),
    'cohorts'=>array_values($cohorts),
    'studentnumber'=>count($users),
    'groupname'=>$cohorts[$selected_groupid]->name
];

echo $OUTPUT->render_from_template('block_grading_report/report_wall',$templatecontext);



//echo $content;

echo $OUTPUT->footer();