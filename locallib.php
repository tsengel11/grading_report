
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


function convert_userlink($userid,$firstname,$lastname,$url)
{
    return '<td
    style = "display: block;border:0.5px solid black;height:50px" class="text-center">
    <a href='.$url.'/user/profile.php?id='.$userid.'><b> '.$firstname.'<br>'.$lastname.'</b></a>
    <a 
    href="'.$url.'/blocks/student_dashboard/grade_cert4.php?id='.$userid.'"; 
    target="_blank";
    class="action-icon"><i class="icon fa fa-search-plus fa-fw " title="Grade analysis" aria-label="Grade analysis"></i></a>
    </td>';
}
function convert_userlink_without_td($userid,$firstname,$lastname,$url)
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

function convert_grade($grade,$userid,$item_w,$item_s) // Detailed information of Grades
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

            if($item_w==0)
            {
                $result = '<td 
                class = "bg-danger text-center"
                style = "display: block;
                border:1px solid black;
                ">Require Re-submission</td>';
            }
            
            else {
                $w_mark_per =get_grade_details_itemid($userid,$item_w)->grade;
                $s_mark_per =get_grade_details_itemid($userid,$item_s)->grade;

                $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
                $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);

                

                //print_object($w_attempt);
                // $w_result =get_grade_letter_with_attemptlink($w_mark_per,$w_attempt);
                // $s_result =get_grade_letter_with_attemptlink($s_mark_per,$s_attempt);

                if($w_attempt)
                {
                    $w_result =get_grade_letter_with_attemptlink($w_mark_per,$w_attempt);
                }
                else
                {
                    $w_mark='';
                }
                if($s_attempt)
                {
                    $s_result =get_grade_letter_with_attemptlink($s_mark_per,$s_attempt);
                }
                else
                {
                    $s_mark='';
                }
               $result = '<td 
                class ="text-left"
                style = "display: block;
                border:1px solid black;
                background-color:#D3D3D3;
                "><b>W:</b>'.$w_result.';&nbsp<b>S:</b>'.$s_result.'
                </td>';
            }

        }
        
     }
     return $result;

}

function get_grade_details_itemid($userid,$itemid)
{
    global $DB;
    $sql = " SELECT 
        ROUND(rawgrade / rawgrademax * 100, 1) AS grade
    FROM
        {grade_grades}
    WHERE
        itemid = :item_id AND userid =:user_id
    ";
    $para = ['item_id'=>$itemid,'user_id'=>$userid];
    $result = $DB->get_record_sql($sql,$para);
    
    return $result;
    
}

function get_grade_details($attemptid)
{
    global $DB;
    $sql = " SELECT  a.id, round(a.sumgrades/q.sumgrades*100) as mark, a.attempt 
    FROM {quiz_attempts} as a
    left join {quiz} as q on a.quiz = q.id
    where a.id = :attempt_id;
    ";
    $para = ['attempt_id'=>$attemptid];
    $result = $DB->get_record_sql($sql,$para);
    
    return $result;
    
}

function convert_attempt_link($attemptid,$url,$mark,$attempt)

{   
    if($attemptid)
    {        
        //$mark = get_grade_details($attemptid);
        if($mark->mark==100){
            return '<a href="'.$url.'/mod/quiz/review.php?attempt='.$attemptid.'"; style="color: green" ; target="_blank";>Satisfactory('.$attempt.')</a>';   
        }
        elseif ($mark->mark==50){
            return '<a href="'.$url.'/mod/quiz/review.php?attempt='.$attemptid.'";style="color: #0275d8"; target="_blank">Sumitted('.$attempt.')</a>';   
        }
        elseif ($mark->mark>50 && $mark->mark<100){
            return '<a href="'.$url.'/mod/quiz/review.php?attempt='.$attemptid.'"; style="color: #d9534f" ;target="_blank">Require Re-submission('.$attempt.')</a>'; 
        }
        else {
            return '<a href="'.$url.'/mod/quiz/review.php?attempt='.$attemptid.'"; style="color: #292b2c" target="_blank">Not Finished('.$attempt.')</a>'; 
        }

    }

}
function get_grade_letter_with_attemptlink($grade,$attempt)
{
    // global $CFG;
    // $url = $CFG->wwwroot;
    //die($grade);
    $result = '';
     if($grade == null){
        $result = '<span
        class "class="text-center" 
        style = "
        "> Not Submitted </span>';
     }
     else
     {
        if($grade==100){
            $result = 'Satisfactory';
            $result = '<span
            style = " color:green"
            ">Satisfactory</span>';
            //print_object($attempt);
            //echo $attempt->attemptid;
            gettype($attempt->attemptid);
            $url = new moodle_url('/mod/quiz/review.php', array('attempt' => $attempt->attemptid));
            $result.= html_writer::link($url, 'Satisfactory'.'('.$attempt->attempt.')',array('style'=>"color: green","target"=>"_blank"));
            //$result .= '<a href="'.$url.'/mod/quiz/review.php?attempt=''"; style="color: green" ; target="_blank";>Satisfactory('')</a>';
        }
        elseif ($grade==50){
            $result = '<span
            class ="text-primary" 
            style = "
            ">Submitted</span>';
        }
        elseif ($grade==0){
            $result = '<span 
            ">Not Submitted</span>';
        }
        elseif ($grade>50 || $grade<100){
            $result = '<span 
            style = " color:red"
            ">Require Re-sub</span>';
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

function get_userlist_carp($cohortid)
{
    global $DB;
    $sql = " select 
    u.firstname,
    u.lastname,
    u.email,
    max(if(m.id=3768, a.id,null )) as `CPCCOHS2001_practical`,
    max(if(m.id=3288, a.id,null )) as `CPCCCM1012A_practical`,
    max(if(m.id=3689, a.id,null )) as `CPCCCM1013A_practical_SWMS`,
    max(if(m.id=3690, a.id,null )) as `CPCCCM1013A_practical_Photo`,
    max(if(m.id=3447, a.id,null )) as `CPCCCM1014A_practical`,
    max(if(m.id=3583, a.id,null )) as `CPCCCM1015A_practical`,
    max(if(m.id=3585, a.id,null )) as `CPCCCM2001A_practical`,
    max(if(m.id=3694, a.id,null )) as `CPCCCA2011A_practical_SWMS`,
    max(if(m.id=3691, a.id,null )) as `CPCCCA2011A_practical_Photo`,
    max(if(m.id=3695, a.id,null )) as `CPCCCA2002B_practical_SWMS`,
    max(if(m.id=3692, a.id,null )) as `CPCCCA2002B_practical_Photo`,
    max(if(m.id=3686, a.id,null )) as `CPCCCA3002A_practical_SWMS`,
    max(if(m.id=3692, a.id,null )) as `CPCCCA3002A_practical_Photolog`
    from mdl_cohort_members as cm
    left join mdl_quiz_attempts as a on  cm.userid = a.userid
    left join mdl_course_modules as m on a.quiz = m.instance
    left join mdl_quiz as q on a.quiz = q.id
    left join mdl_user as u on a.userid = u.id
    where cm.cohortid=101
    and m.id in (3768,3288,3689,3690,3447,  3583,3585,3694,3691,3695,3692,3686,3692)
    group by a.userid ";

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

// Carpentry units

function get_carptenty_units()
{
    global $DB;

    $sql = "SELECT 
            m.id,
            q.name,
            SUBSTRING_INDEX(SUBSTRING_INDEX(c.fullname, ': ', 1),
                    '_',
                    - 1) AS `unit_name`
            FROM
            {quiz} AS q
                LEFT JOIN
            mdl_course_modules AS m ON q.id = m.instance
                LEFT JOIN
            mdl_course AS c ON q.course = c.id
            WHERE
            m.id IN (
                3768, 
                3288,
                3689,
                3690,
                3447,
                3583,
                3585,
                3694,
                3691,
                3695,
                3692,
                3686,
                3696,
                3697,
                3698,
                3699,
                3700,
                3702,
                3701,
                3704,
                3705,
                3706,
                3715,
                3711,
                3707,
                3708,
                3712,
                3709,
                3713,
                3710,
                3714,
                3724,
                3716,
                3720,
                3725,
                3717,
                3721,
                3718,
                3723,
                3719,
                3722,
                3726,
                3731,
                3727,
                3729,
                3728,
                3730,
                2693,
                2694,
                2725)
                order by unit_name,id ";
                ;
            $result = $DB->get_records_sql($sql);

            return $result;
}
   

function get_userlist_carptenty($cohortid)
{
    $units = get_carptenty_units();

 
    global $DB;
    $sql = " SELECT
            u.id as userid, 
            u.firstname,
            u.lastname,
            u.email,";

            foreach ($units as $unit)
            {
                $sql.= "MAX(IF(m.id = ".$unit->id.", a.id, NULL)) AS `".$unit->id."`,";
            };
           $sql= rtrim($sql,", ") ;
            $sql.="FROM
                {cohort_members} AS cm
                    LEFT JOIN
                {quiz_attempts} AS a ON cm.userid = a.userid
                    LEFT JOIN
                {course_modules} AS m ON a.quiz = m.instance
                    LEFT JOIN
                {quiz} AS q ON a.quiz = q.id
                    LEFT JOIN
                {user} AS u ON a.userid = u.id
            WHERE
                cm.cohortid = :cohort_id
                    AND m.id ";
                $sql.= "IN (";
                foreach ($units as $unit)
                {
                    $sql.=$unit->id.",";
                };
                $sql= rtrim($sql,", ") ;
        $sql.=") GROUP BY a.userid";

    $para = ['cohort_id'=>$cohortid];
    $result = $DB->get_records_sql($sql,$para);
    return $result;

}

function get_attemtid_from_gradeitem($grade_itemid,$userid)
{
    global $DB;
    if ($grade_itemid)
    {
        $sql = " SELECT 
        i.id, i.courseid, max(a.id) AS attemptid, max(a.attempt) as attempt, a.userid
            FROM
                {grade_items} AS i
                    LEFT JOIN
                {quiz_attempts} AS a ON i.iteminstance = a.quiz
            WHERE
                i.id = :itemid AND a.userid = :user_id
                    AND i.itemmodule = 'quiz'
            order by a.attempt desc";
    
        $para = ['itemid'=>$grade_itemid,'user_id'=>$userid];
        $result = $DB->get_record_sql($sql,$para);
        

        return $result;
        
    }

}