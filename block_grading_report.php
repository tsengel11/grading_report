<?php
// This file is part of Moodle - http://moodle.org/

/**
 * Form for editing HTML block instances.
 *
 * @package   block_grading_report
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */




class block_grading_report extends block_base
{

    function init()
    {
        $this->title = 'Grading Report';
    }

    function has_config()
    {
        return true;
    }

    function get_content()
    {

        global $DB, $USER, $CFG,$OUTPUT;
        require_once(__DIR__ . '/../../config.php');
       

        if ($this->content !== NULL) {
            return $this->content;
        }

        //$content .= $USER->firstname;
        //$showcourses = get_config('block_student_dashboard', 'showcourses');
        $user_id = $USER->id;
        $link = $CFG->wwwroot;
        
        $dip_url = $link."/blocks/grading_report/grade_detail_dip.php?cohortid=103";
        $cert4_url = $link."/blocks/grading_report/grade_detail_cert4.php?cohortid=102";
        $carp_grade_link_url = $link."/blocks/grading_report/grade_detail_carp.php?cohortid=110";
        $wall_grade_link_url = $link."/blocks/grading_report/grade_detail_wall.php?cohortid=117";
        $newwall_grade_link_url = $link."/blocks/grading_report/grade_detail_wall.php?cohortid=133";
        
        $content = '';  
        // $content .=' <a href="'.$attendance_url.'">Attendance |</a>';
        // $content .=' <a href="'.$online_lecture_url.'">Online Lectures |</a>';
        // $content .=' <a href="'.$askliberty_url.'">Ask Liberty(9am-5pm)</a>';
        $diplomalink = '<a href="'.$dip_url.'" class="alert-link">Grading Report Diploma</a>';
        $cer4link = '<a href="'.$cert4_url.'" class="alert-link">Grading Report Certificate IV</a>';
        $carp_link = '<a href="'.$carp_grade_link_url.'" class="alert-link">Grading Certificate III </a>';
        $wall_link = '<a href="'.$wall_grade_link_url.'" class="alert-link">Grading Certificate III W&F</a>';
        $templatecontext = (object)[
            'texttodisplay'=>'Diploma of Building and Construction (Building)',
            'carp_grade_link'=>$carp_link,
            'diplomalink'=>$diplomalink,
            'cer4link'=>$cer4link,
            'wall_link'=>$wall_link
        ];
        //print_object($templatecontext);
        $content .= $OUTPUT->render_from_template('block_grading_report/block',$templatecontext);
        
        # Hide for temporary
        $this->content = new stdClass;
        $this->content->text = $content;
        
        //$this->content->footer = 'this is the footera';
        return $this->content;
    }
}
