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
    $user->cpccwhs1001=convert_grade_one_item($user->cpccwhs1001,$user->userid,0,0);
    $user->cpccbc4001a=convert_grade($user->cpccbc4001a,$user->userid,2788,"W",2789,"S");
    $user->cpccbc4003a=convert_grade($user->cpccbc4003a,$user->userid,2449,"W",2448,"S");
    $user->cpccbc4004a=convert_grade($user->cpccbc4004a,$user->userid,2451,"W",2450,"S");
    $user->cpccbc4010b=convert_grade($user->cpccbc4010b,$user->userid,2463,"W",2462,"S");
    $user->cpccbc4013a=convert_grade($user->cpccbc4013a,$user->userid,2471,"W",2468,"S");
    $user->cpccbc4005a=convert_grade($user->cpccbc4005a,$user->userid,2453,"W",2452,"S");
    $user->cpccbc5001b=convert_grade($user->cpccbc5001b,$user->userid,2533,"W",2548,"S");
    $user->cpccbc5010b=convert_grade($user->cpccbc5010b,$user->userid,2539,"W",2624,"S");
    $user->cpccbc5003a=convert_grade($user->cpccbc5003a,$user->userid,2538,"W",2702,"S");
    $user->cpccbc5002a=convert_grade($user->cpccbc5002a,$user->userid,2537,"W",2574,"S");
    $user->cpccbc5011a=convert_grade($user->cpccbc5011a,$user->userid,2658,"W",2659,"S");
    $user->cpccbc5018a=convert_grade($user->cpccbc5018a,$user->userid,2622,"W",2623,"S");
    $user->cpccbc5005a=convert_grade($user->cpccbc5005a,$user->userid,2558,"W",2559,"S");
    $user->cpccbc5004a=convert_grade($user->cpccbc5004a,$user->userid,2555,"W",2556,"S");
    $user->bsbpmg508a=convert_grade($user->bsbpmg508a,$user->userid,2713,"W",2856,"S");
    $user->bsbpmg505a=convert_grade($user->bsbpmg505a,$user->userid,2707,"W",2708,"S");
    $user->bsbohs504b=convert_grade($user->bsbohs504b,$user->userid,2710,"W",2711,"S");
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