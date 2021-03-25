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
require_once($CFG->dirroot . '/blocks/grading_report/lib.php');


$user_id = $USER->id;
$url = $CFG->wwwroot;

$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details_cert4.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');


echo $OUTPUT->header();
$selected_groupid=$_GET['cohortid'];
$users = get_userlist_cert4($_GET['cohortid']);
$cohorts=get_cohort_cert4();

$selected_groupname= $dip_cohorts[$selected_groupid]->name;

//print_r($dip_cohorts[$selected_groupid]->name) ;

foreach($cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_detail_cert4.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}
//print_object($users);
foreach($users as $user){
    $user->userlink=convert_userlink($user->userid,$user->firstname,$user->lastname,$url,$enddate);
    $user->startdate_std = gmdate( "d/m/Y",$user->startdate);
    $user->enddate_std = gmdate( "d/m/Y",$user->enddate);
    $user->cpccwhs1001=combine_letter($user->cpccwhs1001);
    $user->cpccbc4001a=combine_letter($user->cpccbc4001a);
    $user->cpccbc4002a=combine_letter($user->cpccbc4002a);
    $user->cpccbc4003a=combine_letter($user->cpccbc4003a);
    $user->cpccbc4004a=combine_letter($user->cpccbc4004a);

    $user->cpccbc4005a=combine_letter($user->cpccbc4005a);
    $user->cpccbc4006b=combine_letter($user->cpccbc4006b);
    $user->cpccbc4007a=combine_letter($user->cpccbc4007a);
    $user->cpccbc4008b=combine_letter($user->cpccbc4008b);

    $user->cpccbc4009b=combine_letter($user->cpccbc4009b);
    $user->cpccbc4010b=combine_letter($user->cpccbc4010b);
    $user->cpccbc4011b=combine_letter($user->cpccbc4011b);
    $user->cpccbc4012b=combine_letter($user->cpccbc4012b);

    $user->cpccbc4013a=combine_letter($user->cpccbc4013a);
    $user->bsbldr403=combine_letter($user->bsbldr403);
    $user->bsbsmb406=combine_letter($user->bsbsmb406);
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