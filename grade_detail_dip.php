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

$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details_dip.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');


echo $OUTPUT->header();
$selected_groupid=$_GET['cohortid'];
$users = get_userlist_dip($_GET['cohortid']);
$dip_cohorts=get_cohort_dip();

$selected_groupname= $dip_cohorts[$selected_groupid]->name;

//print_r($dip_cohorts[$selected_groupid]->name) ;

foreach($dip_cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_detail_dip.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}
//print_object($users);
foreach($users as $user){
    $user->startdate = gmdate( "d/m/Y",$user->startdate);
    $user->enddate = gmdate( "d/m/Y",$user->enddate);
    $user->cpccwhs1001=combine_letter($user->cpccwhs1001);
    $user->cpccbc4001a=combine_letter($user->cpccbc4001a);
    $user->cpccbc4003a=combine_letter($user->cpccbc4003a);
    $user->cpccbc4004a=combine_letter($user->cpccbc4004a);
    $user->cpccbc4010b=combine_letter($user->cpccbc4010b);
    $user->cpccbc4013a=combine_letter($user->cpccbc4013a);
    $user->cpccbc4005a=combine_letter($user->cpccbc4005a);
    $user->cpccbc5001b=combine_letter($user->cpccbc5001b);
    $user->cpccbc5010b=combine_letter($user->cpccbc5010b);
    $user->cpccbc5003a=combine_letter($user->cpccbc5003a);
    $user->cpccbc5002a=combine_letter($user->cpccbc5002a);
    $user->cpccbc5011a=combine_letter($user->cpccbc5011a);
    $user->cpccbc5018a=combine_letter($user->cpccbc5018a);
    $user->cpccbc5005a=combine_letter($user->cpccbc5005a);
    $user->cpccbc5004a=combine_letter($user->cpccbc5004a);
    $user->bsbpmg508a=combine_letter($user->bsbpmg508a);
    $user->bsbpmg505a=combine_letter($user->bsbpmg505a);
    $user->bsbohs504b=combine_letter($user->bsbohs504b);
    $user->userlink=convert_userlink($user->userid,$user->firstname,$user->lastname,$url);
    //$user->cpccbc4005a = get_grade_letter($user->cpccbc4005a);
}
print_object($users);

$templatecontext = (object)[
    'texttodisplay'=>'Diploma of Building and Construction (Building)',
    'users'=>array_values($users),
    'cohorts'=>array_values($dip_cohorts),
    'groupname'=>$dip_cohorts[$selected_groupid]->name
];

echo $OUTPUT->render_from_template('block_grading_report/report_dip',$templatecontext);



//echo $content;

echo $OUTPUT->footer();