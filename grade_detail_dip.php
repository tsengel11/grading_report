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


$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details_dip.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');


echo $OUTPUT->header();
$selected_groupid=$_GET['cohortid'];
$users = get_userlist_dip($selected_groupid);



$dip_cohorts=get_cohort_dip();

$selected_groupname= $dip_cohorts[$selected_groupid]->name;

//print_r($dip_cohorts[$selected_groupid]->name) ;

foreach($dip_cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_detail_dip.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}
//print_object($users);
foreach($users as $user){
    $user->cpccwhs1001=convert_grade($user->cpccwhs1001,$user->userid,0,0);
    $user->cpccbc4001a=convert_grade($user->cpccbc4001a,$user->userid,2788,2789);
    $user->cpccbc4003a=convert_grade($user->cpccbc4003a,$user->userid,2449,2448);
    $user->cpccbc4004a=convert_grade($user->cpccbc4004a,$user->userid,2451,2450);
    $user->cpccbc4010b=convert_grade($user->cpccbc4010b,$user->userid,2463,2462);
    $user->cpccbc4013a=convert_grade($user->cpccbc4013a,$user->userid,2471,2468);
    $user->cpccbc4005a=convert_grade($user->cpccbc4005a,$user->userid,2453,2452);
    $user->cpccbc5001b=convert_grade($user->cpccbc5001b,$user->userid,2533,2548);
    $user->cpccbc5010b=convert_grade($user->cpccbc5010b,$user->userid,2539,2624);
    $user->cpccbc5003a=convert_grade($user->cpccbc5003a,$user->userid,2538,2702);
    $user->cpccbc5002a=convert_grade($user->cpccbc5002a,$user->userid,2537,2574);
    $user->cpccbc5011a=convert_grade($user->cpccbc5011a,$user->userid,2658,2659);
    $user->cpccbc5018a=convert_grade($user->cpccbc5018a,$user->userid,2622,2623);
    $user->cpccbc5005a=convert_grade($user->cpccbc5005a,$user->userid,2558,2559);
    $user->cpccbc5004a=convert_grade($user->cpccbc5004a,$user->userid,2555,2556);
    $user->bsbpmg508a=convert_grade($user->bsbpmg508a,$user->userid,2713,2856);
    $user->bsbpmg505a=convert_grade($user->bsbpmg505a,$user->userid,2707,2708);
    $user->bsbohs504b=convert_grade($user->bsbohs504b,$user->userid,2710,2711);
    $user->userlink=convert_userlink_dip($user->userid,$user->firstname,$user->lastname,$url);
}
// print_object($CFG->wwwroot);

$templatecontext = (object)[
    'texttodisplay'=>'Diploma of Building and Construction (Building)',
    'users'=>array_values($users),
    'cohorts'=>array_values($dip_cohorts),
    'studentnumber'=>count($users),
    'groupname'=>$dip_cohorts[$selected_groupid]->name
];

echo $OUTPUT->render_from_template('block_grading_report/report_dip',$templatecontext);



//echo $content;

echo $OUTPUT->footer();