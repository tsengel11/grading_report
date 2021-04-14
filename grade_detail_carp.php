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

$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details_carp.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');


echo $OUTPUT->header();
$selected_groupid=$_GET['cohortid'];

$users = get_userlist_carp($selected_groupid);
$cohorts=get_cohort_carptenty();
foreach($cohorts as $cohort){
    $cohort->drop_downitem='<a class="dropdown-item" href="'.$CFG->wwwroot.'/blocks/grading_report/grade_detail_carpc.php?cohortid='.$cohort->id.'">'.$cohort->name.'</a>';
}
//print_object($cohorts);
//print_object($users);
foreach($users as $user){
    $user->userlink=convert_userlink($user->userid,$user->firstname,$user->lastname,$url);
    // Quizes
    //Term 1
    $user->cpccwhs1001=convert_grade_quiz($user->cpccwhs1001,$user->userid);
    $user->cpccohs2001a=convert_grade_quiz($user->cpccohs2001a,$user->userid);
    $user->cpccohs2001a_practical=convert_grade_one_item($user->cpccohs2001a_practical,$user->userid,2868);
    $user->cpcccm1012a=convert_grade_quiz($user->cpcccm1012a,$user->userid);
    $user->cpcccm1012a_practical=convert_grade_one_item($user->cpcccm1012a_practical,$user->userid,2442);
    $user->cpcccm1013a=convert_grade_quiz($user->cpcccm1013a,$user->userid);
    $user->cpcccm1013a_practical=convert_grade($user->cpcccm1013a_practical,$user->userid,2803,2804);
    $user->cpcccm1014a=convert_grade_quiz($user->cpcccm1014a,$user->userid);
    $user->cpcccm1014a_practical=convert_grade_one_item($user->cpcccm1014a_practical,$user->userid,2561);
    // Term 2
    $user->cpcccm1015a=convert_grade_quiz($user->cpcccm1015a,$user->userid);
    $user->cpcccm1015a_practical=convert_grade_one_item($user->cpcccm1015a_practical,$user->userid,2695);
    $user->cpcccm2001a=convert_grade_quiz($user->cpcccm2001a,$user->userid);
    $user->cpcccm2001a_practical=convert_grade_one_item($user->cpcccm2001a_practical,$user->userid,2697);
    $user->cpccca2011a=convert_grade_quiz($user->cpccca2011a,$user->userid);
    $user->cpccca2011a_practical=convert_grade($user->cpccca2011a_practical,$user->userid,2807,2805);
    $user->cpccca2002b=convert_grade_quiz($user->cpccca2002b,$user->userid);
    $user->cpccca2002b_practical=convert_grade($user->cpccca2002b_practical,$user->userid,2808,2806);
    $user->cpccca3002a=convert_grade_quiz($user->cpccca3002a,$user->userid);
    $user->cpccca3002a_practical=convert_grade($user->cpccca3002a_practical,$user->userid,2801,2802);
    // Term 3

    $user->cpccca3003a=convert_grade_quiz($user->cpccca3003a,$user->userid);
    $user->cpccca3003a_practical=convert_grade($user->cpccca3003a_practical,$user->userid,2809,2810);
    $user->cpccca3004a=convert_grade_quiz($user->cpccca3004a,$user->userid);
    $user->cpccca3004a_practical=convert_grade($user->cpccca3004a_practical,$user->userid,2811,2812);
    $user->cpccsh3008=convert_grade_quiz($user->cpccsh3008,$user->userid);
    $user->cpccsh3008_practical=convert_grade($user->cpccsh3008_practical,$user->userid,2813,2815);
    $user->cpccca3010a=convert_grade_quiz($user->cpccca3010a,$user->userid);
    $user->cpccca3010a_practical=convert_grade($user->cpccca3010a_practical,$user->userid,2814,2816);
    $user->cpccca3017b=convert_grade_quiz($user->cpccca3017b,$user->userid);
    $user->cpccca3017b_practical=convert_grade($user->cpccca3017b_practical,$user->userid,2817,2818);
    // TERM 4
    $user->cpccca3007c=convert_grade_quiz($user->cpccca3007c,$user->userid);
    $user->cpccca3007c_practical=convert_grade($user->cpccca3007c_practical,$user->userid,2819,2828);
    $user->cpccca3005b=convert_grade_quiz($user->cpccca3005b,$user->userid);
    $user->cpccca3005b_practical=convert_grade($user->cpccca3005b_practical,$user->userid,2820,2824);
    $user->cpccca3008b=convert_grade_quiz($user->cpccca3008b,$user->userid);
    $user->cpccca3008b_practical=convert_grade($user->cpccca3008b_practical,$user->userid,2821,2825);
    $user->cpccca3006b=convert_grade_quiz($user->cpccca3006b,$user->userid);
    $user->cpccca3006b_practical=convert_grade($user->cpccca3006b_practical,$user->userid,2822,2826);
    $user->cpccca3023a=convert_grade_quiz($user->cpccca3023a,$user->userid);
    $user->cpccca3023a_practical=convert_grade($user->cpccca3023a_practical,$user->userid,2823,2827);
    // TERM 5
    $user->cpcccm2007b=convert_grade_quiz($user->cpcccm2007b,$user->userid);
    $user->cpcccm2007b_practical=convert_grade($user->cpcccm2007b_practical,$user->userid,2829,2837);
    $user->cpcccm2002a=convert_grade_quiz($user->cpcccm2002a,$user->userid);
    $user->cpcccm2002a_practical=convert_grade($user->cpcccm2002a_practical,$user->userid,2833,2838);
    $user->cpcccm2010b=convert_grade_quiz($user->cpcccm2010b,$user->userid);
    $user->cpcccm2010b_practical=convert_grade($user->cpcccm2010b_practical,$user->userid,2830,2834);
    $user->cpcccm2008b=convert_grade_quiz($user->cpcccm2008b,$user->userid);
    $user->cpcccm2008b_practical=convert_grade($user->cpcccm2008b_practical,$user->userid,2831,2836);
    $user->cpccca3001a=convert_grade_quiz($user->cpccca3001a,$user->userid);
    $user->cpccca3001a_practical=convert_grade($user->cpccca3001a_practical,$user->userid,2832,2835);
    // TERM 6
    $user->cpccsf2004a=convert_grade_quiz($user->cpccsf2004a,$user->userid);
    $user->cpccsf2004a_practical=convert_grade($user->cpccsf2004a_practical,$user->userid,2839,2844);
    $user->cpccco2013a=convert_grade_quiz($user->cpccco2013a,$user->userid);
    $user->cpccco2013a_practical=convert_grade($user->cpccco2013a_practical,$user->userid,2840,2842);
    $user->cpccca2003a=convert_grade_quiz($user->cpccca2003a,$user->userid);
    $user->cpccca2003a_practical=convert_grade($user->cpccca2003a_practical,$user->userid,2841,2843);
    $user->bsbsmb406=convert_grade_quiz($user->bsbsmb406,$user->userid);
    $user->bsbsmb301=convert_grade_quiz($user->bsbsmb301,$user->userid);
    $user->bsbsmb301_practical=convert_grade_one_item($user->bsbsmb301_practical,$user->userid,2161);



}
//print_object($users);

$templatecontext = (object)[
    'texttodisplay'=>'Certificate III in Carpentry',
    'users'=>array_values($users),
    'cohorts'=>array_values($cohorts),
    'studentnumber'=>count($users),
    'groupname'=>$cohorts[$selected_groupid]->name
];

echo $OUTPUT->render_from_template('block_grading_report/report_carpentry',$templatecontext);



//echo $content;

echo $OUTPUT->footer();