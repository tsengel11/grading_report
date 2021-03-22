
<?php

/**
 * Version details
 *
 * @package    local_grade_notification
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


function combine_letter($grade)
{
    //return $grade = get_grade_letter($grade)." (". strval($grade).")" ;
    return $grade = get_grade_letter($grade) ;
}

function convert($grade)
{
    //return $grade = get_grade_letter($grade)." (". strval($grade).")" ;
    return $grade = get_grade_letter($grade) ;
}

function convert_userlink($userid,$firstname,$lastname,$url)
{


    return '<td
    style = "display: block;border:1px solid black;height:50px" class="text-center" 
    >
    <a href='.$url.'/user/profile.php?id='.$userid.'><b> '.$firstname.'<br>'.$lastname.'</b></a>
    </td>';
}

function get_grade_letter($grade)
{
    //die($grade);
    $result = '';
     if($grade == null){
        $result = '<td
        class "class="text-center" 
        style = "display: block;
        border:1px solid black;
        "> N/A </td>';
     }
     else
     {
        if($grade==100){
            //$result = 'Satisfactory';
            $result = '<td
            class ="bg-success text-center" 
            style = "display: block;
            border:1px solid black;
            ">Satisfactory</td>';
        }
        elseif ($grade==0){
            $result = '<td 
            class = "bg-secondary text-center"
            style = "display: block;
            border:1px solid black;
            ">Not Submitted</td>';
        }
        elseif ($grade>0 || $grade<100){
            $result = '<td 
            class ="bg-danger text-center"
            style = "display: block;
            border:1px solid black;
            ">Not completed Yet</td>';
        }
        
     }
     return $result;

}
function get_grade_letter2($grade)
{
    //die($grade);
    $result = '';

    switch(true){
        case ($grade== null): 
            $result=' - '; 
            break;
        case ($grade== 0):
            $result='Not Submitted'; 
            break;
        case ($grade== 50):
            $result='Submitted'; 
            break;
        case ($grade== 100):
            $result='Satisfactory'; 
            break;
        case ($grade>0||$grade<50):
            $result='Require Re-submission'; 
            break;
        case ($grade>50||$grade<100):
            $result='Require Re-submission'; 
            break;
    }

     return $result;

}
function get_cohort_dip(){
    global $DB;
    $sql = 'SELECT * FROM {cohort} ch
    where ch.name like "%Diploma%"';
    $result = $DB->get_records_sql($sql);
    return $result;
}
function get_userlist_dip($cohortid)
{
    global $DB;
    $sql = " SELECT
        g.userid,
     	u.firstname,
        u.lastname,
        

        if(i1.data='','N/A',i1.data) as `startdate`,
        if(i2.data='','N/A',i2.data) as `enddate`,
        if(i3.data='','N/A',i3.data) as `studentid`,
        ROUND(SUM(IF(i.itemname = 'CPCCWHS1001:Prepare to work safely in the construction industry',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCWHS1001',
        ROUND(SUM(IF(i.itemname = 'CPCCBC4001A:Apply building codes and standards to the construction process for low rise building projects',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC4001A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC4003A: Select and prepare a construction contract',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC4003A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC4004A:Identify and produce estimated costs for building and construction projects',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC4004A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC4010B:Apply structural principles to residential low rise constructions',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC4010B',
        ROUND(SUM(IF(i.itemname = 'CPCCBC4013: Prepare and evaluate tender documentation',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC4013A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC4005A:Produce labour and material schedules for ordering',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC4005A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC5001B: Apply building codes and standards to the construction process for medium rise building projects',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC5001B',
        ROUND(SUM(IF(i.itemname = 'CPCCBC5010B: Manage construction work',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC5010B',
        ROUND(SUM(IF(i.itemname = 'CPCCBC5003A: Supervise the planning of on-site medium rise building or construction work',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC5003A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC5002A: Monitor costing systems on medium rise building and construction projects',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC5002A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC5011A: Manage environmental management practices and processes in building and construction',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC5011A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC5018A: Apply structural principles to the construction of medium rise buildings',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC5018A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC5005A: Select and manage building and construction contractors',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC5005A',
        ROUND(SUM(IF(i.itemname = 'CPCCBC5004A: Supervise and apply quality standards to the selection of building and construction materials',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'CPCCBC5004A',
        ROUND(SUM(IF(i.itemname = 'BSBPMG508A:Manage project risk',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'BSBPMG508A',
        ROUND(SUM(IF(i.itemname = 'BSBPMG505A: Manage project quality',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'BSBPMG505A',
        ROUND(SUM(IF(i.itemname = 'BSBOHS504B: Apply principles of OHS risk management',
        g.finalgrade/ g.rawgrademax * 100,
                    NULL)),
                1) AS 'BSBOHS504B'
    FROM
        {grade_grades} AS g
            LEFT JOIN
        {grade_items} AS i ON g.itemid = i.id
            LEFT JOIN
        {user} as u on g.userid = u.id
            LEFT JOIN
        {user_info_data} AS i1 ON g.userid = i1.userid
            LEFT JOIN
        {user_info_data} AS i2 ON g.userid = i2.userid
        LEFT JOIN
        {user_info_data} AS i3 ON g.userid = i3.userid
    WHERE
        i.courseid = 668 
            AND i.itemtype = 'mod'
            AND g.userid IN (SELECT 
                userid
            FROM
                {cohort_members} AS cm
            WHERE
                cohortid = :cohort_id)
            AND i1.fieldid = 4
            AND i2.fieldid = 5
            AND i3.fieldid = 3
    GROUP BY g.userid
    ORDER BY i2.data
    ";

    $para = ['cohort_id'=>$cohortid];
    $result = $DB->get_records_sql($sql,$para);

    return $result;
}
function get_grade($userid)
{

}