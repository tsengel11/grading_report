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

        global $DB, $USER, $CFG;
        require_once(__DIR__ . '/../../config.php');
       

        if ($this->content !== NULL) {
            return $this->content;
        }

        //$content .= $USER->firstname;
        //$showcourses = get_config('block_student_dashboard', 'showcourses');
        $user_id = $USER->id;
        $link = $CFG->wwwroot;
        
        $resources_url = $link."/blocks/grading_report/grade_detail.php";

        
        $content = '';
        // $content .=' <a href="'.$attendance_url.'">Attendance |</a>';
        // $content .=' <a href="'.$online_lecture_url.'">Online Lectures |</a>';
        // $content .=' <a href="'.$askliberty_url.'">Ask Liberty(9am-5pm)</a>';



        $link_res=html_writer::link($resources_url,'Grading Report',array('style'=>'color: #1a1a1a'));
        $menus = 
        html_writer::div($link_res ,'grid-item4',array('style'=>'  background-color: #A7C957;
        border: 2px solid #e5e4e2;
        padding: 10px;
        font-size: 20px;
        text-align: center;'));
        $content .= html_writer::div($menus,"grid-container",array('style'=>'  display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        padding: 5px;'));
        
        # Hide for temporary
        $this->content = new stdClass;
        $this->content->text = $content;
        
        //$this->content->footer = 'this is the footera';
        return $this->content;
        
    }
}
