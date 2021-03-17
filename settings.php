<?php
if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox(
        'block_grading_report/showcourses',
        get_string('showcourses', 'block_grading_report'),
        get_string('showcoursesdesc', 'block_grading_report'),
        0
    ));
    $settings->add(new admin_setting_configtext('block_grading_report/adminuser', 
                   'Administration user id:',
                   'User who can see Grading Report',2));
}