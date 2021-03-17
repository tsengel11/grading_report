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

$PAGE->set_url(new moodle_url('/blocks/grading_report/grade_details.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('Grade Details');

echo $OUTPUT->header();

$users = get_userlist(82) ;

print_r($users);


$templatecontext = (object)[
    'texttodisplay'=>'here is some text'
];

echo $OUTPUT->render_from_template('block_grading_report/report',$templatecontext);



//echo $content;

echo $OUTPUT->footer();