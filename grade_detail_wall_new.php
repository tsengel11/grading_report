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

$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details_wall_new.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');

//$PAGE->requires->js('/blocks/grading_report/javascripts/scripts.js',true);


echo $OUTPUT->header();
$selected_groupid=$_GET['cohortid'];
$users = get_userdata($selected_groupid);
$cohorts=get_cohort_wall_new();
foreach($cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_details_wall_new.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}


//print_object($cohorts);
//print_object($users);
foreach($users as $user){
    $user->userlink=convert_userlink_without_td($user->id,$user->firstname,$user->lastname,$url);
    $user->cpccwhs1001 =get_grade_from_item($user->id, 289,array());
    $user->cpccwhs2001 =get_grade_from_item($user->id, 844,array());
    $user->CPCCOM1013 =get_grade_from_item($user->id, 836,array(3131,3132));
    // Quizes
    //Term 1
    //$user->cpccwhs1001=convert_grade_quiz($user->cpccwhs1001,$user->userid);

}
//print_object($users);

$templatecontext = (object)[
    'texttodisplay'=>'Certificate III in Wall and Floor Tiling',
    'users'=>array_values($users),
    'cohorts'=>array_values($cohorts),
    'studentnumber'=>count($users),
    'groupname'=>$cohorts[$selected_groupid]->name
];

echo $OUTPUT->render_from_template('block_grading_report/report_wall_new',$templatecontext);



//echo $content;

echo $OUTPUT->footer();