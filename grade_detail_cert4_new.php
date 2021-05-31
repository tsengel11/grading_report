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


$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details_cert4_new.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');


echo $OUTPUT->header();
$selected_groupid=$_GET['cohortid'];

$users = get_userlist_cert4($selected_groupid);
$cohorts=get_cohort_cert4();

$grading_info = grade_get_grades(381, 'mod', quiz, 897, array('99','129'));

print_object($grading_info->items[0]);
foreach($cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_detail_cert4.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}

$templatecontext = (object)[
    'texttodisplay'=>'Certificate IV in Building and Construction (Building)',
    'users'=>array_values($users),
    'cohorts'=>array_values($cohorts),
    'groupname'=>$cohorts[$selected_groupid]->name,
    'grade_info'=>array_values($grading_info->items)
];

echo $OUTPUT->render_from_template('block_grading_report/report_cert4',$templatecontext);



//echo $content;

echo $OUTPUT->footer();