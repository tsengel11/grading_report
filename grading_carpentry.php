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

$PAGE->set_url(new moodle_url('/blocks/grading_report/grading_carpentry.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');


echo $OUTPUT->header();
$selected_groupid=$_GET['cohortid'];



$users = get_userlist_carptenty($selected_groupid);
$cohorts = get_cohort_carptenty();


foreach($cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_detail_cert4.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}
//print_object($users);
$units = get_carptenty_units();
$count=0;
    foreach($users as $user)
    {
        $count=$count+1;
        $user->userlink=convert_userlink_without_td($user->userid,$user->firstname,$user->lastname,$url);

        foreach ($units as $unit)
        {
            $unit_code = $unit->id;

            $user->$unit_code = convert_attempt_link($user->$unit_code,$url);
        }

        $user->count =$count;
    
    }
    foreach($units as $unit)
    {
        $unit->assigment_link = '<a href="'.$url.'/mod/quiz/report.php?id='.$unit->id.'&mode=overview">'.$unit->unit_name.'</br>'.$unit->name.'</a>';
    }

print_object($users) ;
print_object($units);
$templatecontext = (object)[
    'texttodisplay'=>'Certificate III in Carpentry 2019',
    'users'=>array_values($users),
    'cohorts'=>array_values($cohorts),
    'studentnumber'=>count($users),
    'url'=>$url,
    'units'=>array_values($units)
];

echo $OUTPUT->render_from_template('block_grading_report/grading_carpentry',$templatecontext);



//echo $content;

echo $OUTPUT->footer();