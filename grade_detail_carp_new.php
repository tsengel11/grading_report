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


$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details_carp_new.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');


echo $OUTPUT->header();

$selected_groupid = optional_param('cohortid',NULL, PARAM_INT);

$users = get_userdata($selected_groupid);
// Selecting the cohort list from cohorts based on Cohort Name.
$cohorts=get_cohort('New Carpentry');
// Creating the Cohort list on Grading report pages.

$unit_data = $DB->get_records('block_grading_report_units',['course'=>'Carp']);

foreach($cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_details_carp_new.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}

foreach($users as $user){
    $user->userlink=convert_userlink_without_td_general($user->id,$user->firstname,$user->lastname,$url,'grade_carp_new');
    foreach ($unit_data as $u){
        //$user->$u->course_code=get_grade_from_item($user->id,$u->unit_code,explode(',',$u->activities));
        $temp_coursecode = $u->course_code;
        $temp_activities = explode(',',$u->activities);

        if($u->activities==''){
            $user->$temp_coursecode=get_grade_from_item($user->id,$u->unit_code,array());
        }
        else{
            $user->$temp_coursecode=get_grade_from_item($user->id,$u->unit_code,$temp_activities);
        }

    }
}
$templatecontext = (object)[
    'texttodisplay'=>'Certificate III in Carpentry',
    'users'=>array_values($users),
    'cohorts'=>array_values($cohorts),
    'studentnumber'=>count($users),
    'groupname'=>$cohorts[$selected_groupid]->name
];
echo $OUTPUT->render_from_template('block_grading_report/report_carpentry_new',$templatecontext);


//echo $content;

echo $OUTPUT->footer();