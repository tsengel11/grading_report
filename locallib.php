
<?php

/**
 * Version details
 *
 * @package    local_grade_notification
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();


function check_admin($user_id)
{
    $user_array=explode(',',get_config('block_grading_report','adminuser'));

    foreach($user_array as $user){

        if($user==$user_id)
        {
            return true;
        }
    }

    return false;
}



function combine_letter($grade)
{
    //return $grade = get_grade_letter($grade)." (". strval($grade).")" ;
    return $grade = convert_grade($grade) ;
}

function convert($grade)
{
    //return $grade = get_grade_letter($grade)." (". strval($grade).")" ;
    return $grade = convert_grade($grade) ;
}

function convert_userlink($userid,$firstname,$lastname,$url)
{
    return '<td
    style = "display: block;border:0.5px solid black;height:50px" class="text-center" 
    >
    <a href='.$url.'/user/profile.php?id='.$userid.'><b> '.$firstname.'<br>'.$lastname.'</b></a>
    <a 
    href="'.$url.'/blocks/student_dashboard/grade_cert4.php?id='.$userid.'"; 
    target="_blank";
    class="action-icon"><i class="icon fa fa-search-plus fa-fw " title="Grade analysis" aria-label="Grade analysis"></i></a>
    </td>';
}
function convert_userlink_notd($userid,$firstname,$lastname,$url)
{
    return '
    <a href='.$url.'/user/profile.php?id='.$userid.'><b> '.$firstname.'<br>'.$lastname.'</b></a>
    <a href="'.$url.'/blocks/student_dashboard/grade_cert4.php?id='.$userid.'"; 
    target="_blank";
    class="action-icon"><i class="icon fa fa-search-plus fa-fw " title="Grade analysis" aria-label="Grade analysis"></i></a>
    ';
}

function convert_userlink_dip($userid,$firstname,$lastname,$url)
{
    return '<td
    style = "display: block;border:0.5px solid black;height:50px" class="text-center" 
    >
    <a href='.$url.'/user/profile.php?id='.$userid.'><b> '.$firstname.'<br>'.$lastname.'</b></a>
    <a 
    href="'.$url.'/blocks/student_dashboard/grade_dip.php?id='.$userid.'"; 
    target="_blank";
    class="action-icon"><i class="icon fa fa-search-plus fa-fw " title="Grade analysis" aria-label="Grade analysis"></i></a>
    </td>';
}

function convert_grade($grade)
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
            ">Not Yet Completed</td>';
        }
        
     }
     return $result;

}
function get_grade_letter($grade)
{
    //die($grade);
    $result = '';
     if($grade == null){
        $result = '<div
        class "class="text-center" 
        style = "
        "> - </div>';
     }
     else
     {
        if($grade==100){
            //$result = 'Satisfactory';
            $result = '<div
            class =" text-center" 
            style = " color:green"
            ">Satisfactory</div>';
        }
        elseif ($grade==50){
            $result = '<div
            class =" text-center text-primary" 
            style = "
            ">Submitted</div>';
        }
        elseif ($grade==0){
            $result = '<div 
            class = " text-center"
            style = " ;
            ">Not Submitted</div>';
        }
        elseif ($grade>50 || $grade<100){
            $result = '<div 
            class =" text-center  "
            style = " color:red"
            ">Require Re-submission</div>';
        }
        
     }
     return $result;

}function get_cohort_dip(){
    global $DB;
    $sql = 'SELECT * FROM {cohort} ch
    where ch.name like "%Diploma%"';
    $result = $DB->get_records_sql($sql);
    return $result;
}

function get_cohort_cert4(){
    global $DB;
    $sql = 'SELECT * FROM {cohort} ch
    where ch.name like "%Cert IV%"';
    $result = $DB->get_records_sql($sql);
    return $result;
}
function get_cohort_carptenty(){
    global $DB;
    $sql = 'SELECT * FROM {cohort} ch
    where ch.name like "%Carptenty%"';
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
        
        from_unixtime(i1.data,'%d %M %Y') as `startdate`,
        from_unixtime(i2.data,'%d %M %Y') as `enddate`,
        if(i3.data='','N/A',i3.data) as `studentid`,
        ROUND(SUM(IF(i.itemname = 'CPCCWHS1001: Prepare to work safely in the construction industry',
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
        right join 
	    {cohort_members} as cm on u.id = cm.userid
    WHERE
        i.courseid = 668 
            AND i.itemtype = 'mod'
            AND i1.fieldid = 4
            AND i2.fieldid = 5
            AND i3.fieldid = 3
            AND cm.cohortid =:cohort_id
    GROUP BY g.userid
    ORDER BY i2.data
    ";

    $para = ['cohort_id'=>$cohortid];
    $result = $DB->get_records_sql($sql,$para);

    return $result;
}
function get_userlist_cert4($cohortid)
{
    global $DB;
    $sql = "SELECT
    u.id, 
	u.firstname,
    u.lastname,
    u.email,
    g.userid,
	from_unixtime(i1.data,'%d %M %Y') as `startdate`,
    from_unixtime(i2.data,'%d %M %Y') as `enddate`,
    if(i3.data='','N/A',i3.data) as `studentid`,
    ROUND(SUM(IF(i.itemname = 'CPCCWHS1001:Prepare to work safely in the construction industry',
                 g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCWHS1001',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4001A: Apply building codes',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4001A',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4002A: Manage occupational health',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4002A',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4003A: Select and prepare',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4003A',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4004A: Identify and produce',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4004A',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4005A: Produce labour',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4005A',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4006B: Select, procure and store',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4006B',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4007A: Plan building or construction',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4007A',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4008B: Conduct on-site',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4008B',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4009B: Apply legal requirements',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4009B',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4010B: Apply structural principles',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4010B',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4011B: Apply structural principles',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4011B',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4012B: Read and interpret plans',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4012B',
    ROUND(SUM(IF(i.itemname = 'BSBLDR403: Lead team effectiveness',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'BSBLDR403',
    ROUND(SUM(IF(i.itemname = 'CPCCBC4013A: Prepare and evaluate',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'CPCCBC4013A',
    ROUND(SUM(IF(i.itemname = 'BSBSMB406: Manage small business finances',
                g.finalgrade/ g.rawgrademax * 100,
                NULL)),
            2) AS 'BSBSMB406'
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
    i.courseid = 301 AND i.itemtype = 'mod'
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
    ORDER BY i2.data ; ";

    $para = ['cohort_id'=>$cohortid];
    $result = $DB->get_records_sql($sql,$para);

    return $result;

}

function get_userlist_carptenty($cohortid)
{
    global $DB;
    $sql = " SELECT
    g.userid, 
    u.firstname,
    u.firstname,
	u.lastname,
    round(sum(if(g.itemid=2868, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCOHS2001A_practical`,
    round(sum(if(g.itemid=2104, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCM1012A_practical`,
    round(sum(if(g.itemid=2803, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCM1013A_practical_swms`,
    round(sum(if(g.itemid=2804, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCM1013A_practical_photo`,
    round(sum(if(g.itemid=2561, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCM1014A_practical`,
    round(sum(if(g.itemid=2695, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCM1015A_practical`,
	round(sum(if(g.itemid=2697, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCM2001A_practical`,
    round(sum(if(g.itemid=2807, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCA2011A_practical_swms`,
    round(sum(if(g.itemid=2805, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCA2011A_practical_photo`,
	round(sum(if(g.itemid=2808, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCA2002B_practical_swms`,
    round(sum(if(g.itemid=2806, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCA2002B_practical_photo`,
	round(sum(if(g.itemid=2801, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCA3002A_practical_swms`,
    round(sum(if(g.itemid=2802, (g.finalgrade / g.rawgrademax * 100 ),null)),2) as `CPCCCA3002A_practical_photo`
    FROM {grade_grades} as g
    left join {user} as u on g.userid = u.id
    left join {cohort_members} as cm on u.id = cm.userid
    where cm.cohortid=:cohort_id
    GROUP BY g.userid";

    $para = ['cohort_id'=>$cohortid];
    $result = $DB->get_records_sql($sql,$para);

    return $result;

}