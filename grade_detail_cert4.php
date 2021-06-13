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



    // Checking the admin user;
    $user_array=explode(',',get_config('block_grading_report','adminuser'));
    //print_object($user_array);
    //echo $user_id;
    if (!in_array($user_id, $user_array))
    {
        echo "not found";
        \core\notification::add("You don't have permission to access to Grading Report", \core\output\notification::NOTIFY_ERROR);
        redirect($url);
    }


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
foreach($users as $user){
    $user->userlink=convert_userlink_without_td($user->userid,$user->firstname,$user->lastname,$url);
    $user->cpccwhs1001=convert_grade_without_td($user->cpccwhs1001,$user->userid,0,"W",0,"S");
    $user->cpccbc4001a=convert_grade_cert4_without_td($user->cpccbc4001a,$user->userid,2788,"W",2789,"S",2280,'PA1',2403,'PA2');
    $user->cpccbc4002a=convert_grade_cert4_without_td($user->cpccbc4002a,$user->userid,2447,"W",2446,"S",2421,'PA1',2281,'PA2');
    $user->cpccbc4003a=convert_grade_cert4_without_td($user->cpccbc4003a,$user->userid,2449,"W",2448,"S",2423,'PA1',2282,'PA2');
    $user->cpccbc4004a=convert_grade_cert4_without_td($user->cpccbc4004a,$user->userid,2451,"W",2450,"S",2428,'PA1',2283,'PA2');

    $user->cpccbc4005a=convert_grade_cert4_without_td($user->cpccbc4005a,$user->userid,2453,"W",2452,"S",2431,'PA1',2284,'PA2');
    $user->cpccbc4006b=convert_grade_cert4_without_td($user->cpccbc4006b,$user->userid,2455,"W",2454,"S",2285,'PA1',2341,'PA2');
    $user->cpccbc4007a=convert_grade_cert4_without_td($user->cpccbc4007a,$user->userid,2457,"W",2456,"S",2420,'PA1',2286,'PA2');
    $user->cpccbc4008b=convert_grade_cert4_without_td($user->cpccbc4008b,$user->userid,2459,"W",2458,"S",2422,'PA1',2287,'PA2');

    $user->cpccbc4009b=convert_grade_cert4_without_td($user->cpccbc4009b,$user->userid,2461,"W",2460,"S",2424,'PA1',2288,'PA2');
    $user->cpccbc4010b=convert_grade_cert4_without_td($user->cpccbc4010b,$user->userid,2463,"W",2462,"S",2425,'PA1',2289,'PA2');
    $user->cpccbc4011b=convert_grade_cert4_without_td($user->cpccbc4011b,$user->userid,2465,"W",2464,"S",2429,'PA1',0,0);
    $user->cpccbc4012b=convert_grade_cert4_without_td($user->cpccbc4012b,$user->userid,2467,"W",2466,"S",2430,'PA1',2290,'PA2');

    $user->cpccbc4013a=convert_grade_cert4_without_td($user->cpccbc4013a,$user->userid,2471,"W",2468,"S",2432,'PA1',2291,'PA2');
    $user->bsbldr403=convert_grade_cert4_without_td($user->bsbldr403,$user->userid,2472,"W",2469,"S",2437,'PA1',0,0);
    $user->bsbsmb406=convert_grade_cert4_without_td($user->bsbsmb406,$user->userid,2473,"W",2470,"S",2434,'PA1',2293,'PA2');
}

$templatecontext = (object)[
    'texttodisplay'=>'Certificate IV in Building and Construction (Building)',
    'users'=>array_values($users),
    'cohorts'=>array_values($cohorts),
    'groupname'=>$cohorts[$selected_groupid]->name
];

echo $OUTPUT->render_from_template('block_grading_report/report_cert4',$templatecontext);
//echo $content;

echo $OUTPUT->footer();