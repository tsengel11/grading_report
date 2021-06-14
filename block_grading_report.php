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
        $dip_url_new = $link."/blocks/grading_report/grade_detail_dip_new.php?cohortid=135";

        // default cohorts when selecting the grading report
        $cert4_url = $link."/blocks/grading_report/grade_detail_cert4.php?cohortid=102";
        $cert4_url_new = $link."/blocks/grading_report/grade_detail_cert4_new.php?cohortid=134";

        $wall_grade_link_url = $link."/blocks/grading_report/grade_detail_wall.php?cohortid=117";
        $newwall_grade_link_url = $link."/blocks/grading_report/grade_detail_wall_new.php?cohortid=133";

        $carp_grade_link_url = $link."/blocks/grading_report/grade_detail_carp.php?cohortid=110";
        $carp_link_url_new = $link."/blocks/grading_report/grade_detail_carp_new.php?cohortid=132";
        
        
        $content = '';  
        $diplomalink = '<a href="'.$dip_url.'" class="alert-link">Grading Report Diploma</a>';
        $dip_link_new = '<a href="'.$dip_url_new.'" class="alert-link">Diploma New CPC</a>';
        $cer4link = '<a href="'.$cert4_url.'" class="alert-link">Grading Report Certificate IV</a>';
        $cer4link_new = '<a href="'.$cert4_url_new.'" class="alert-link">Certificate IV New CPC</a>';
        $carp_link = '<a href="'.$carp_grade_link_url.'" class="alert-link">Grading Certificate III </a>';
        $carp_link_new = '<a href="'.$carp_link_url_new.'" class="alert-link">Certificate III New CPC </a>';
        $wall_link = '<a href="'.$wall_grade_link_url.'" class="alert-link">Grading Certificate III W&F</a>';
        $wall_link_new = '<a href="'.$newwall_grade_link_url.'" class="alert-link"> Certificate III W&F New CPC</a>';
        $templatecontext = (object)[
            'texttodisplay'=>'Diploma of Building and Construction (Building)',
            'carp_grade_link'=>$carp_link,
            'diplomalink'=>$diplomalink,
            '$dip_link_new'=>$dip_link_new,
            'cer4link'=>$cer4link,
            'cer4link_new'=>$cer4link_new,
            'wall_link'=>$wall_link,
            '$wall_link_new'=>$wall_link_new,
            '$carp_link_new'=>$carp_link_new,
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
