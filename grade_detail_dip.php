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
    $user->userlink=convert_userlink_without_td($user->userid,$user->firstname,$user->lastname,$url);
    $user->cpccwhs1001=convert_grade_one_item($user->cpccwhs1001,$user->userid,0,0);
    $user->cpccbc4001a=convert_grade_cert4_without_td($user->cpccbc4001a,$user->userid,2788,"W",2789,"S",2280,'PA1',2403,'PA2');
    $user->cpccbc4003a=convert_grade_cert4_without_td($user->cpccbc4003a,$user->userid,2449,"W",2448,"S",2423,'PA1',2282,'PA2');
    $user->cpccbc4004a=convert_grade_cert4_without_td($user->cpccbc4004a,$user->userid,2451,"W",2450,"S",2428,'PA1',2283,'PA2');
    $user->cpccbc4010b=convert_grade_cert4_without_td($user->cpccbc4010b,$user->userid,2463,"W",2462,"S",2425,'PA1',2289,'PA2');
    $user->cpccbc4013a=convert_grade_cert4_without_td($user->cpccbc4013a,$user->userid,2471,"W",2468,"S",2432,'PA1',2291,'PA2');
    $user->cpccbc4005a=convert_grade_cert4_without_td($user->cpccbc4005a,$user->userid,2453,"W",2452,"S",2431,'PA1',2284,'PA2');
    $user->cpccbc5001b=convert_grade_cert4_without_td($user->cpccbc5001b,$user->userid,2533,"W",2548,"S",0,0,0,0);
    $user->cpccbc5010b=convert_grade_cert4_without_td($user->cpccbc5010b,$user->userid,2539,"W",2624,"S",0,0,0,0);
    $user->cpccbc5003a=convert_grade_cert4_without_td($user->cpccbc5003a,$user->userid,2538,"W",2702,"S",0,0,0,0);
    $user->cpccbc5002a=convert_grade_cert4_without_td($user->cpccbc5002a,$user->userid,2537,"W",2574,"S",0,0,0,0);
    $user->cpccbc5011a=convert_grade_cert4_without_td($user->cpccbc5011a,$user->userid,2658,"W",2659,"S",0,0,0,0);
    $user->cpccbc5018a=convert_grade_cert4_without_td($user->cpccbc5018a,$user->userid,2622,"W",2623,"S",0,0,0,0);
    $user->cpccbc5005a=convert_grade_cert4_without_td($user->cpccbc5005a,$user->userid,2558,"W",2559,"S",0,0,0,0);
    $user->cpccbc5004a=convert_grade_cert4_without_td($user->cpccbc5004a,$user->userid,2555,"W",2556,"S",0,0,0,0);
    $user->bsbpmg508a=convert_grade_cert4_without_td($user->bsbpmg508a,$user->userid,2713,"W",2856,"S",0,0,0,0);
    $user->bsbpmg505a=convert_grade_cert4_without_td($user->bsbpmg505a,$user->userid,2707,"W",2708,"S",0,0,0,0);
    $user->bsbohs504b=convert_grade_cert4_without_td($user->bsbohs504b,$user->userid,2710,"W",2711,"S",0,0,0,0);
    // $user->userlink=convert_userlink_dip($user->userid,$user->firstname,$user->lastname,$url);
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