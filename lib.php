
<?php

/**
 * Version details
 *
 * @package    local_grade_notification
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function get_grade_letter($grade)
{
    //die($grade);

    $result = '';
    if($grade==50){
        $result = 'Submitted';
    }
    elseif ($grade>50||$grade<100){
        $result = 'Require Re-submission';
    }
    elseif ($grade==100){
        $result = 'Satisfactory';
    }
    return $result;
}
function get_userlist($cohortid)
{
    global $DB;
    $sql = 'SELECT
            u.id as userid, 
            u.firstname,
            i1.data as startdate,
            i2.data as enddate
    FROM {user} as u
    left join {user_info_data} as i2 on u.id = i2.userid
    left join {user_info_data} as i1 on u.id = i1.userid
    left join {cohort_members} as cm on u.id = cm.userid
    left join {cohort} as c on cm.cohortid = c.id
    where c.id=:cohort_id
    and i1.fieldid=3
    and i2.fieldid=4
    order by i2.data';

    $para = ['cohort_id'=>$cohortid];
    $result = $DB->get_records_sql($sql,$para);

    return $result;
}
function get_grade($userid)
{

}