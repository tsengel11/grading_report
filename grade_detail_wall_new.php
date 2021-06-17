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
    $user->userlink=convert_userlink_without_td_wall($user->id,$user->firstname,$user->lastname,$url);
    $user->cpccwhs1001 =get_grade_from_item($user->id, 289,array());
    $user->CPCCWHS2001 =get_grade_from_item($user->id, 844,array(3127));
    $user->CPCCOM1012 =get_grade_from_item($user->id, 835,array(3129));
    $user->CPCCOM1013 =get_grade_from_item($user->id, 836,array(3131,3132));
    $user->CPCCOM1014 =get_grade_from_item($user->id, 837,array(3137,3263));
    $user->CPCCOM1015 =get_grade_from_item($user->id, 838,array(3248,3262));
    $user->CPCCCM2006 =get_grade_from_item($user->id, 830,array());
    $user->CPCCCM2008 =get_grade_from_item($user->id, 831,array());
    
    $user->CPCCWF3001 =get_grade_from_item($user->id, 771,array());
    $user->CPCCWF2001 =get_grade_from_item($user->id, 769,array());
    $user->CPCCOM2001 =get_grade_from_item($user->id, 768,array(3280,3281));
    $user->CPCCWF2002 =get_grade_from_item($user->id, 770,array());

    $user->CPCCWF3009 =get_grade_from_item($user->id, 778,array());
    $user->CPCCWF3002 =get_grade_from_item($user->id, 772,array());
    $user->CPCCWF3003 =get_grade_from_item($user->id, 773,array());
    $user->CPCCWF3004 =get_grade_from_item($user->id, 774,array());

    $user->CPCCWF3007 =get_grade_from_item($user->id, 777,array());
    $user->CPCCWF3006 =get_grade_from_item($user->id, 776,array());
    $user->CPCCWF3005 =get_grade_from_item($user->id, 775,array());
    $user->BSBESB301 =get_grade_from_item($user->id, 761,array());
    $user->BSBESB407 =get_grade_from_item($user->id, 762,array(3270,3271));
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