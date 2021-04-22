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

$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details_cert4.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');


echo $OUTPUT->header();
$selected_groupid=$_GET['cohortid'];

$users = get_userlist_cert4($selected_groupid);
$cohorts=get_cohort_cert4();
foreach($cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_detail_cert4.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}
//print_object($users);
foreach($users as $user){
    $user->userlink=convert_userlink($user->userid,$user->firstname,$user->lastname,$url);
    $user->cpccwhs1001=convert_grade($user->cpccwhs1001,$user->userid,0,"W",0,"S");
    $user->cpccbc4001a=convert_grade($user->cpccbc4001a,$user->userid,2788,"W",2789,"S");
    $user->cpccbc4002a=convert_grade($user->cpccbc4002a,$user->userid,2447,"W",2446,"S");
    $user->cpccbc4003a=convert_grade($user->cpccbc4003a,$user->userid,2449,"W",2448,"S");
    $user->cpccbc4004a=convert_grade($user->cpccbc4004a,$user->userid,2451,"W",2450,"S");

    $user->cpccbc4005a=convert_grade($user->cpccbc4005a,$user->userid,2453,"W",2452,"S");
    $user->cpccbc4006b=convert_grade($user->cpccbc4006b,$user->userid,2455,"W",2454,"S");
    $user->cpccbc4007a=convert_grade($user->cpccbc4007a,$user->userid,2457,"W",2456,"S");
    $user->cpccbc4008b=convert_grade($user->cpccbc4008b,$user->userid,2459,"W",2458,"S");

    $user->cpccbc4009b=convert_grade($user->cpccbc4009b,$user->userid,2461,"W",2460,"S");
    $user->cpccbc4010b=convert_grade($user->cpccbc4010b,$user->userid,2463,"W",2462,"S");
    $user->cpccbc4011b=convert_grade($user->cpccbc4011b,$user->userid,2465,"W",2464,"S");
    $user->cpccbc4012b=convert_grade($user->cpccbc4012b,$user->userid,2467,"W",2466,"S");

    $user->cpccbc4013a=convert_grade($user->cpccbc4013a,$user->userid,2471,"W",2468,"S");
    $user->bsbldr403=convert_grade($user->bsbldr403,$user->userid,2472,"W",2469,"S");
    $user->bsbsmb406=convert_grade($user->bsbsmb406,$user->userid,2473,"W",2470,"S");
}
//print_object($users);

$templatecontext = (object)[
    'texttodisplay'=>'Certificate IV in Building and Construction (Building)',
    'users'=>array_values($users),
    'cohorts'=>array_values($cohorts),
    'studentnumber'=>count($users),
    'groupname'=>$cohorts[$selected_groupid]->name
];

echo $OUTPUT->render_from_template('block_grading_report/report_cert4',$templatecontext);



//echo $content;

echo $OUTPUT->footer();