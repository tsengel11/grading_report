
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
    style = "display: block;border:0.5px solid black;
    height:50px;
    " class="text-center">
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
    <div>    
    <a href='.$url.'/user/profile.php?id='.$userid.'><b> '.$firstname.'<br>'.$lastname.'</b></a>
    <a href="'.$url.'/blocks/student_dashboard/grade_cert4.php?id='.$userid.'"; 
    target="_blank";
    class="action-icon"><i class="icon fa fa-search-plus fa-fw " title="Grade analysis" aria-label="Grade analysis"></i></a>
    </div>

';
}
function convert_userlink_without_td_carp($userid,$firstname,$lastname,$url)
{
    return '
    <a href='.$url.'/user/profile.php?id='.$userid.'><b> '.$firstname.'<br>'.$lastname.'</b></a>
    <a href="'.$url.'/blocks/student_dashboard/grade_carp.php?id='.$userid.'"; 
    target="_blank";
    class="action-icon"><i class="icon fa fa-search-plus fa-fw " title="Grade analysis" aria-label="Grade analysis"></i></a>
    ';
}

function convert_userlink_dip($userid,$firstname,$lastname,$url)
{
    return '<div
    style = "height:50px" class="text-center">
    <a href='.$url.'/user/profile.php?id='.$userid.'><b> '.$firstname.'<br>'.$lastname.'</b></a>
    <a href="'.$url.'/blocks/student_dashboard/grade_dip.php?id='.$userid.'"; 
    target="_blank" ;
    class="action-icon"><i class="icon fa fa-search-plus fa-fw " title="Grade analysis" aria-label="Grade analysis"></i></a>
    </div>';
}
// // Seperating Assment names
// function get_assesmentname($itemname)
// {
//     $itemnames= explode(" - ",$itemname);
//     print_object($itemnames);

//     $result= "";
//     // foreach($i as $itemname){
//     //     $result.= $i""
//     // }
//     if($itemnames[1]){
//         return substr($itemnames[0],0,2)."-".substr($itemnames[1],0,2);
//     }
//     return $itemnames[0];
    
// }

function convert_grade_quiz($grade,$userid) // For QUIZ based units
{
    $result = '';
    if($grade == null)
    {
       $result = '<td
       class "class="text-center" 
       style = "display: hide;
       border:1px solid black;
       padding: 0.1rem;
       "> N/A </td>';
    }
    else
    {
       if($grade==100){
           //$result = 'Satisfactory';
           $result = '<td
           id = "term1";
           class ="bg-success text-center" ;
           style = "display: hide;
        border:1px solid black;
           padding: 0.1rem;
           ">Satisfactory('.$grade.'%)</td>';
       }
       elseif ($grade==0)
       {
           $result = '<td 
           class = "bg-secondary text-center"
           style = "display: hide;
        border:1px solid black;
           padding: 0.1rem;
           ">Not Submitted</td>';
       }
       elseif ($grade>0 || $grade<100)
       {
        $result = '<td 
        class = "bg-danger text-center"
        style = "display: hide;
        border:1px solid black;
        padding: 0.1rem;
        ">Not Completed('.$grade.'%)</td>';
       }
    }

    return $result;
}
function convert_grade_quiz_carp($grade,$userid) // For QUIZ based units
{
    $result = '';
    if($grade == null)
    {
       $result = '<td
       class "class="text-center" 
       style = "display: hide;
       padding: 0.1rem;
       "> N/A </td>';
    }
    else
    {
       if($grade==100){
           //$result = 'Satisfactory';
           $result = '<td
           id = "term1";
           class ="bg-success text-center" ;
           style = "display: hide;
           padding: 0.1rem;
           ">Satisfactory('.$grade.'%)</td>';
       }
       elseif ($grade==0)
       {
           $result = '<td 
           class = "bg-secondary text-center"
           style = "display: hide;
           padding: 0.1rem;
           ">Not Submitted</td>';
       }
       elseif ($grade>0 || $grade<100)
       {
        $result = '<td 
        class = "bg-danger text-center"
        style = "display: hide;
        padding: 0.1rem;
        ">Not Completed('.$grade.'%)</td>';
       }
    }

    return $result;
}

function convert_grade_quiz_without_td($grade,$userid) // For QUIZ based units
{
    $result = '';
    if($grade == null)
    {
       $result = '<div
       class "class="text-center" 
       style = "display: block;
       "> N/A </div>';
    }
    else
    {
       if($grade==100){
           //$result = 'Satisfactory';
           $result = '<div
           id = "term1";
           class ="bg-success text-center" ;
           style = "display: block;
           ">Satisfactory('.$grade.'%)</div>';
       }
       elseif ($grade==0)
       {
           $result = '<div 
           class = "bg-secondary text-center"
           style = "display: block;
           ">Not Submitted</div>';
       }
       elseif ($grade>0 || $grade<100)
       {
        $result = '<div 
        class = "bg-danger text-center"
        style = "display: block;
        border:1px solid black;
        ">Not Completed('.$grade.'%)</div>';
       }
    }

    return $result;
}

function convert_grade_one_item($grade,$userid,$item_w,$letter) // FOR ONE assigment units
{
    //die($grade);
    $result = '';
     if($grade == null){
        $result = '<td
        class "class="text-center" 
        style = "display: hide;
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
        elseif ($grade>0 || $grade<100)
        {
            // echo $item_w;
            // echo $userid;

            // echo "overall grade:".$grade;
            // echo "\n userid:".$userid;
            // echo "\n itemid:".$item_w;
                $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
                $w_grade_detail =get_grade_details_itemid($userid,$item_w);

                // print_object($w_grade_detail);
                if($w_grade_detail)
                {
                    $w_mark_per =$w_grade_detail->grade;
                    if($w_attempt)
                    {
                        $w_result =get_grade_letter_with_attemptlink($w_mark_per,$w_attempt);
                    }
                    else
                    {
                        $w_result='';
                    }
                }
                else
                {
                    $w_result='';
                }
             $result = '<td 
                class ="text-left"
                style = "display: block;
                border:1px solid black;
                background-color:#F5F5F5;
                "><b>'.$letter.':</b>'.$w_result.'
                </td>';
            }

        
     }
     return $result;

}
function convert_grade_one_item_carp($grade,$userid,$item_w,$letter) // FOR ONE assigment units
{
    //die($grade);
    $result = '';
     if($grade == null){
        $result = '<td
        class "class="text-center" 
        style = "display: hide;
        padding: 0.1rem;
        "> N/A </td>';
     }
     else
     {
        if($grade==100){
            //$result = 'Satisfactory';
            $result = '<td
            class ="bg-success text-center" 
            style = "display: hide;
            padding: 0.1rem;
            ">Satisfactory</td>';
        }
        elseif ($grade==0){
            $result = '<td 
            class = "bg-secondary text-center"
            style = "display: hide;
            padding: 0.1rem;
            ">Not Submitted</td>';
        }
        elseif ($grade>0 || $grade<100)
        {
            // echo $item_w;
            // echo $userid;

            // echo "overall grade:".$grade;
            // echo "\n userid:".$userid;
            // echo "\n itemid:".$item_w;
                $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
                $w_grade_detail =get_grade_details_itemid($userid,$item_w);

                // print_object($w_grade_detail);
                if($w_grade_detail)
                {
                    $w_mark_per =$w_grade_detail->grade;
                    if($w_attempt)
                    {
                        $w_result =get_grade_letter_with_attemptlink($w_mark_per,$w_attempt);
                    }
                    else
                    {
                        $w_result='';
                    }
                }
                else
                {
                    $w_result='';
                }

              
               $result = '<td 
                class ="text-left"
                style = "display: hide;
                padding: 0.1rem;
                background-color:#F5F5F5;
                "><b>'.$letter.':</b>'.$w_result.'
                </td>';
            }

        
     }
     return $result;

}

function convert_grade($grade,$userid,
                        $item_w,$w_letter,
                        $item_s,$s_letter) // Grade item of Combined old Assessments
{
    $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
    $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);    
    $w_grade_detail =get_grade_details_itemid($userid,$item_w);
    $s_grade_detail =get_grade_details_itemid($userid,$item_s);

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
            //echo $item_w.':'.$grade.'<br>';
               $result = '<td
            class ="text-center bg-success"
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
        elseif ($grade>0 || $grade<100)
        {
                // $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
                // $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);
                //$w_grade_detail =get_grade_details_itemid($userid,$item_w);
                if($w_grade_detail)
                {
                    $w_mark_per =$w_grade_detail->grade;
                    if($w_attempt)
                    {
                        $w_result =get_grade_letter_with_attemptlink($w_mark_per,$w_attempt);
                    }
                    else
                    {
                        $w_result='';
                    }
                }
                else
                {
                    $w_result='';
                }
                //$s_grade_detail =get_grade_details_itemid($userid,$item_s);
                if($s_grade_detail)
                {
                    $s_mark_per = $s_grade_detail->grade;
                    if($s_attempt)
                    {
                        $s_result =get_grade_letter_with_attemptlink($s_mark_per,$s_attempt);
                    }
                    else
                    {
                        $s_result='';
                    }
                }
                else
                {
                    $s_result='';
                }
               $result = '<td 
                class ="text-left"
                style = "display: block;
                border:1px solid black;
                background-color:#F5F5F5;
                "><b>'.$w_letter.':</b>'.$w_result.';&nbsp<b>'.$s_letter.':</b>'.$s_result.'
                </td>';
        }
     }
     return $result;
}

function convert_grade_without_td($grade,$userid,
                        $item_w,$w_letter,
                        $item_s,$s_letter) // Grade item of Combined old Assessments
{
    $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
    $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);    
    $w_grade_detail =get_grade_details_itemid($userid,$item_w);
    $s_grade_detail =get_grade_details_itemid($userid,$item_s);

    $result = '';
     if($grade == null){
        $result = '<div
        class "class="text-center" 
        "> N/A </div>';
     }
     else
     {
        
        if($grade==100){
            //echo $item_w.':'.$grade.'<br>';
               $result = '<div
            class ="text-center bg-success"
            ">Satisfactory</div>';
        }
        elseif ($grade==0){
            $result = '<div 
            class = "bg-secondary text-center"
            ">Not Submitted</div>';
        }
        elseif ($grade>0 || $grade<100)
        {
                // $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
                // $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);
                //$w_grade_detail =get_grade_details_itemid($userid,$item_w);
                if($w_grade_detail)
                {
                    $w_mark_per =$w_grade_detail->grade;
                    if($w_attempt)
                    {
                        $w_result =get_grade_letter_with_attemptlink($w_mark_per,$w_attempt);
                    }
                    else
                    {
                        $w_result='';
                    }
                }
                else
                {
                    $w_result='';
                }
                //$s_grade_detail =get_grade_details_itemid($userid,$item_s);
                if($s_grade_detail)
                {
                    $s_mark_per = $s_grade_detail->grade;
                    if($s_attempt)
                    {
                        $s_result =get_grade_letter_with_attemptlink($s_mark_per,$s_attempt);
                    }
                    else
                    {
                        $s_result='';
                    }
                }
                else
                {
                    $s_result='';
                }
               $result = '<div 
                class ="text-left"
                background-color:#F5F5F5;
                "><b>'.$w_letter.':</b>'.$w_result.';&nbsp<b>'.$s_letter.':</b>'.$s_result.'
                </div>';
        }
     }
     return $result;
}
function convert_grade_carp($grade,$userid,
                        $item_w,$w_letter,
                        $item_s,$s_letter) // Grade item of Combined old Assessments
{
    $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
    $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);

    
    $w_grade_detail =get_grade_details_itemid($userid,$item_w);
    $s_grade_detail =get_grade_details_itemid($userid,$item_s);

    // print_object($w_attempt);
    // print_object($s_attempt);

    

    $result = '';
     if($grade == null){
        $result = '<td
        class "class="text-center"
        style = "display: hide;
        padding:0.1rem
        "> N/A </td>';
     }
     else
     {
        
        if($grade==100){
            //echo $item_w.':'.$grade.'<br>';
               $result = '<td
            class ="text-center bg-success"
            style = "display: hide;
            padding:0.1rem
            ">Satisfactory</td>';
        }
        elseif ($grade==0){
            $result = '<td 
            class = "bg-secondary text-center"
            style = "display: hide;
            padding:0.1rem
            ">Not Submitted</td>';
        }
        elseif ($grade>0 || $grade<100)
        {
                // $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
                // $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);
                //$w_grade_detail =get_grade_details_itemid($userid,$item_w);
                if($w_grade_detail)
                {
                    $w_mark_per =$w_grade_detail->grade;
                    if($w_attempt)
                    {
                        $w_result =get_grade_letter_with_attemptlink($w_mark_per,$w_attempt);
                    }
                    else
                    {
                        $w_result='';
                    }
                }
                else
                {
                    $w_result='';
                }
                //$s_grade_detail =get_grade_details_itemid($userid,$item_s);
                if($s_grade_detail)
                {
                    $s_mark_per = $s_grade_detail->grade;
                    if($s_attempt)
                    {
                        $s_result =get_grade_letter_with_attemptlink($s_mark_per,$s_attempt);
                    }
                    else
                    {
                        $s_result='';
                    }
                }
                else
                {
                    $s_result='';
                }
               $result = '<td 
                class ="text-left"
                style = "display: hide;
                padding:0.1rem
                background-color:#F5F5F5;
                "><b>'.$w_letter.':</b>'.$w_result.';&nbsp<br><b>'.$s_letter.':</b>'.$s_result.'
                </td>';
        }
     }
     return $result;
}
function convert_grade_cert4($grade,$userid,
                        $item_w,$w_letter,
                        $item_s,$s_letter,
                        $item_pa2,$pa2_letter,// Grade item of Combined old Assessments
                        $item_pa,$pa_letter) // Most Oldest assessment
{
    $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
    $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);
    

    
    //die($grade);
    $w_grade_detail = get_grade_details_itemid($userid,$item_w);
    $s_grade_detail = get_grade_details_itemid($userid,$item_s);
    //$pa_grade_detail = get_grade_details_itemid($userid,$item_pa);

    // print_object($w_attempt);
    // print_object($s_attempt);
    // initilizing the total grades
    $pa1_total=0;
    $pa2_total=0;
    $w_total=0;
    $s_total=0;

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
         
        // if($grade==100){
        //     $result = '<td
        //     class ="bg-success text-center" 
        //     style = "display: block;
        //     border:1px solid black;
        //     ">Satisfactory</td>';
        // }
        if ($grade==0){
            $result = '<td 
            class = "bg-secondary text-center"
            style = "display: block;
            border:1px solid black;
            ">Not Submitted</td>';
        }
        elseif ($grade>0 || $grade<=100)
        {
                
                // $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
                // $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);
                // $w_grade_detail =get_grade_details_itemid($userid,$item_w);
                if($w_grade_detail)
                {
                    $w_mark_per =$w_grade_detail->grade;
                    if($w_attempt)
                    {
                        $w_result =get_grade_letter_with_attemptlink($w_mark_per,$w_attempt);
                        $w_total = $w_mark_per;
                        
                    }
                    else
                    {
                        $w_result='';
                    }
                }
                else
                {
                    $w_result='';
                }
                //$s_grade_detail =get_grade_details_itemid($userid,$item_s);
                if($s_grade_detail)
                {
                    $s_mark_per = $s_grade_detail->grade;
                    if($s_attempt)
                    {
                        $s_result =get_grade_letter_with_attemptlink($s_mark_per,$s_attempt);
                        $s_total = $s_mark_per;
                    }
                    else
                    {
                        $s_result='';
                    }
                }
                else
                {
                    $s_result='';
                }
               $result = '<td 
                class ="text-left"
                style = "display: block;
                border:1px solid black;
                "><b>'.$w_letter.':</b>'.$w_result.';&nbsp<b>'.$s_letter.':</b>'.$s_result.'
                </td>';

                // Checking the combined version of Assessment

                $pa2_attempt = get_attemtid_from_gradeitem($item_pa2,$userid);
                if($userid==389){

                    print_object ($pa2_attempt);
                }
                if($pa2_attempt){
                    
                    //print_object ($pa2_attempt);
                    if($pa2_attempt->grade==100)
                    {   $pa2_total = 100;
                        $pa2_result = get_grade_letter_with_attemptlink($pa2_attempt->grade,$pa2_attempt);
                        $result = '<td 
                        class ="text-left "
                        style = "display: block;
                        border:1px solid black;
                        "><b>'.$pa2_letter.':</b>'.$pa2_result.'</td>';
                        $pa2_total=200;
                    }
                }
                // Checking the very old assessment exist or not.
                if($item_pa!=0){
                    $pa_attempt = get_attemtid_from_gradeitem($item_pa,$userid);
                    if($pa_attempt){
                        //print_object ($pa_attempt);
                        if($pa_attempt->grade==100)
                        {   
                            $pa1_total = 100;
                            $pa_result = get_grade_letter_with_attemptlink($pa_attempt->grade,$pa_attempt);
                            $result = '<td 
                            class ="text-left "
                            style = "display: block;
                            border:1px solid black;
                            "><b>'.$pa_letter.':</b>'.$pa_result.'</td>';
                            $pa1_total=200;
                        }
                    }
                }
                // Checking the Manual grading
                $total= $pa1_total+$pa2_total+$w_total+$s_total;

                                if($userid==493){
                                    
                                }

                if($grade==100 && $total==0){
                    $result = '<td
                    class ="bg-success text-center" 
                    style = "display: block;
                    border:1px solid black;
                    ">Satisfactory (CT)</td>';
                }
                // // Checking the manual overrall grading
                // // echo $userid.':'.$grade.';'.$pa1_total.';'.$pa2_total.';'.$s_total.';'.$s_total.'\n';
                // if($grade==100&&($pa1_total<200||$pa2_total<200||($s_total+$w_total)<200)){
          
                //     $result = '<td
                //     class ="bg-success text-center" 
                //     style = "display: block;
                //     border:1px solid black;
                //     ">Satisfactory</td>';
        
                // }
        }
     }
     return $result;
}
function convert_grade_cert4_without_td($grade,$userid,
                        $item_w,$w_letter,
                        $item_s,$s_letter,
                        $item_pa2,$pa2_letter,// Grade item of Combined old Assessments
                        $item_pa,$pa_letter) // Most Oldest assessment
{
    $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
    $s_attempt = get_attemtid_from_gradeitem($item_s,$userid);
    $w_grade_detail = get_grade_details_itemid($userid,$item_w);
    $s_grade_detail = get_grade_details_itemid($userid,$item_s);
    $pa1_total=0;
    $pa2_total=0;
    $w_total=0;
    $s_total=0;

    $result = '';
     if($grade == null){
        $result = '<div
        class "class="text-center" 
        "> N/A </div>';
     }
     else
     {
  
        if ($grade==0){
            $result = '<div 
            class = "bg-secondary text-center"
            border:1px solid black;
            ">Not Submitted</div>';
        }
        elseif ($grade>0 || $grade<=100)
        {
                if($w_grade_detail)
                {
                    $w_mark_per =$w_grade_detail->grade;
                    if($w_attempt)
                    {
                        $w_result =get_grade_letter_with_attemptlink($w_mark_per,$w_attempt);
                        $w_total = $w_mark_per;
                        
                    }
                    else
                    {
                        $w_result='';
                    }
                }
                else
                {
                    $w_result='';
                }
                //$s_grade_detail =get_grade_details_itemid($userid,$item_s);
                if($s_grade_detail)
                {
                    $s_mark_per = $s_grade_detail->grade;
                    if($s_attempt)
                    {
                        $s_result =get_grade_letter_with_attemptlink($s_mark_per,$s_attempt);
                        $s_total = $s_mark_per;
                    }
                    else
                    {
                        $s_result='';
                    }
                }
                else
                {
                    $s_result='';
                }
               $result = '<div 
                class ="text-center"
                border:1px solid black;
                "><b>'.$w_letter.':</b>'.$w_result.';&nbsp<b>'.$s_letter.':</b>'.$s_result.'
                </div>';

                // Checking the combined version of Assessment

                $pa2_attempt = get_attemtid_from_gradeitem($item_pa2,$userid);
                if($userid==389){

                    print_object ($pa2_attempt);
                }
                if($pa2_attempt){
                    
                    //print_object ($pa2_attempt);
                    if($pa2_attempt->grade==100)
                    {   $pa2_total = 100;
                        $pa2_result = get_grade_letter_with_attemptlink($pa2_attempt->grade,$pa2_attempt);
                        $result = '<div
                        class ="text-left "
                        border:1px solid black;
                        "><b>'.$pa2_letter.':</b>'.$pa2_result.'</div>';
                        $pa2_total=200;
                    }
                }
                // Checking the very old assessment exist or not.
                if($item_pa!=0){
                    $pa_attempt = get_attemtid_from_gradeitem($item_pa,$userid);
                    if($pa_attempt){
                        //print_object ($pa_attempt);
                        if($pa_attempt->grade==100)
                        {   
                            $pa1_total = 100;
                            $pa_result = get_grade_letter_with_attemptlink($pa_attempt->grade,$pa_attempt);
                            $result = '<div
                            class ="text-left "
                            border:1px solid black;
                            "><b>'.$pa_letter.':</b>'.$pa_result.'</div>';
                            $pa1_total=200;
                        }
                    }
                }
                // Checking the Manual grading
                $total= $pa1_total+$pa2_total+$w_total+$s_total;

                if($grade==100 && $total==0){
                    $result = '<div
                    class ="bg-success text-center" 
                    ">Satisfactory (CT)</div>';
                }
        }
     }
     return $result;
}

function convert_grade_three_item($grade,$userid,$item_1,$letter_1,$item_2,$letter_2,$item_3,$letter_3) // Detailed information of Grades
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
        elseif ($grade>0 || $grade<100)
        {
            // //echo $grade;
            // echo $item_w;
            // echo ",";
            // echo $userid;
            // echo ":";
                $w_attempt = get_attemtid_from_gradeitem($item_w,$userid);
                $result_1=grade_result($userid,$item_1);
                $result_2=grade_result($userid,$item_2);
                $result_3=grade_result($userid,$item_2);


               $result = '<td 
                class ="text-left"
                style = "display: block;
                border:1px solid black;
                background-color:#D3D3D3;
                "><b>'.$letter_1.':</b>'.$result_1.';&nbsp<b>'.$letter_2.':</b>'.$result_2.';&nbsp<b>'.$letter_3.':</b>'.$result_3.'
                </td>';
            }
     }
     return $result;
}
function grade_result($userid,$item){
    $attempt = get_attemtid_from_gradeitem($item,$userid);
    $grade_detail =get_grade_details_itemid($userid,$item,$attempt);

    if($grade_detail)
    {
        $mark_per =$grade_detail->grade;
        if($attempt)
        {
            return get_grade_letter_with_attemptlink($mark_per,$attempt);
        }
        else
        {
            return '';
        }
    }
    else
    {
        return '';
    }
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
    $url = new moodle_url('/mod/quiz/review.php', array('attempt' => $attempt->attemptid));
    $result = '';
     if($grade == null){
        $result = '<span
        class "class="text-center" 
        style = "
        "> Not Submitted </span>';
     }
     else
     {
        if($grade==100)
        {
            $result= html_writer::link($url, 'Satisfactory'.'('.$attempt->attempt.')',array('style'=>"color: green","target"=>"_blank"));
        }
        elseif ($grade==50)
        {
            $result= html_writer::link($url, 'Submitted'.'('.$attempt->attempt.')',array("target"=>"_blank"));
        }
        elseif ($grade==0)
        {
            $result= html_writer::link($url, 'Not Submitted'.'('.$attempt->attempt.')',array('style'=>"color: gray","target"=>"_blank"));
        }
        elseif ($grade>50 || $grade<100){
            $result= html_writer::link($url, 'Require Re-sub'.'('.$attempt->attempt.')',array('style'=>"color: red","target"=>"_blank"));
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
            class =" text-center text-light  bg-success" 
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
    where ch.name like "%Carpentry%"';
    $result = $DB->get_records_sql($sql);
    return $result;
}
function get_cohort_wall(){
    global $DB;
    $sql = 'SELECT * FROM {cohort} ch
    where ch.name like "%Wall & Floor%"';
    $result = $DB->get_records_sql($sql);
    return $result;
}
function get_cohort_wall_new(){
    global $DB;
    $sql = 'SELECT * FROM {cohort} ch
    where ch.name like "New Wall & Floor%"';
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
    $sql = " SELECT 
    u.id,
    u.firstname,
    u.lastname,
    u.email,
    g.userid,
    FROM_UNIXTIME(i1.data, '%d %M %Y') AS `startdate`,
    FROM_UNIXTIME(i2.data, '%d %M %Y') AS `enddate`,
    IF(i3.data = '', 'N/A', i3.data) AS `studentid`,
            ROUND(SUM(IF(i.itemname = 'CPCCWHS1001: White Card',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCWHS1001,
            ROUND(SUM(IF(i.itemname = 'CPCCSH3008: Install internal shop walls and fixtures_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCSH3008_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCSH3008: Install internal shop walls and fixtures',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCSH3008,
            ROUND(SUM(IF(i.itemname = 'CPCCSF2004A: Place and fix reinforcement materials_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCSF2004A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCSF2004A: Place and fix reinforcement materials',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCSF2004A,
            ROUND(SUM(IF(i.itemname = 'CPCCOHS2001A: Apply OHS requirements, policies and procedures in the construction industry_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCOHS2001A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCOHS2001A: Apply OHS requirements, policies and procedures in the construction industry',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCOHS2001A,
            ROUND(SUM(IF(i.itemname = 'CPCCCO2013A: Carry out concreting to simple forms_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCO2013A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCO2013A: Carry out concreting to simple forms',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCO2013A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2010B: Work safely at heights_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2010B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2010B: Work safely at heights',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2010B,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2008B: Erect and dismantle restricted height scaffolding_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2008B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2008B: Erect and dismantle restricted height scaffolding',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2008B,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2007B: Use explosive power tools_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2007B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2007B: Use explosive power tools',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2007B,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2002A: Carry out excavation_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2002A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2002A: Carry out excavation',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2002A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2001A: Read and interpret plans and specifications_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2001A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2001A: Read and interpret plans and specifications',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2001A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1015A: Carry out measurements and calculations_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1015A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1015A: Carry out measurements and calculations',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1015A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1014A: Conduct workplace communication_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1014A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1014A: Conduct workplace communication',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1014A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1013A: Plan and organise work_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1013A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1013A: Plan and organise work',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1013A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1012A: Work effectively and sustainably in the construction industry_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1012A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1012A: Work effectively and sustainably in the construction industry',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1012A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3023A: Carry out levelling operations_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3023A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3023A: Carry out levelling operations',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3023A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3017B: Install exterior cladding_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3017B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3017B: Install exterior cladding',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3017B,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3010A: Install and replace windows and doors_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3010A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3010A: Install and replace windows and doors',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3010A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3008B: Construct eaves_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3008B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3008B: Construct eaves',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3008B,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3007C: Construct pitched roofs_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3007C_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3007C: Construct pitched roofs',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3007C,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3006B: Erect roof trusses_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3006B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3006B: Erect roof trusses',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3006B,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3005B: Construct ceiling frames_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3005B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3005B: Construct ceiling frames',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3005B,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3004A: Construct wall frames_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3004A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3004A: Construct wall frames',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3004A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3003A: Install flooring systems_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3003A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3003A: Install flooring systems',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3003A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3002A: Carry out setting out_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3002A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3002A: Carry out setting out',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3002A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3001A: Carry out general demolition of minor building structures_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3001A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3001A: Carry out general demolition of minor building structures',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3001A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2011A: Handle carpentry materials_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2011A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2011A: Handle carpentry materials',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2011A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2003A: Erect and dismantle formwork for footings and slabs on ground_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2003A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2003A: Erect and dismantle formwork for footings and slabs on ground',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2003A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2002B: Use carpentry tools and equipment_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2002B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2002B: Use carpentry tools and equipment',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2002B,
            ROUND(SUM(IF(i.itemname = 'BSBSMB406: Manage small business finances',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS BSBSMB406,
            ROUND(SUM(IF(i.itemname = 'BSBSMB301: Investigate micro business opportunities_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS BSBSMB301_practical,
            ROUND(SUM(IF(i.itemname = 'BSBSMB301: Investigate micro business opportunities',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS BSBSMB301
        FROM
            {grade_grades} AS g
                LEFT JOIN
            {grade_items} AS i ON g.itemid = i.id
                LEFT JOIN
            {user} AS u ON g.userid = u.id
                LEFT JOIN
            {user_info_data} AS i1 ON g.userid = i1.userid
                LEFT JOIN
            {user_info_data} AS i2 ON g.userid = i2.userid
                LEFT JOIN
            {user_info_data} AS i3 ON g.userid = i3.userid
        WHERE
            i.courseid = 212 AND i.itemtype = 'mod'
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
        ORDER BY i2.data;";

    $para = ['cohort_id'=>$cohortid];
    $result = $DB->get_records_sql($sql,$para);

    return $result;
}
function get_userlist_carp_oneuser($userid)
{
    global $DB;
    $sql = " SELECT 
    u.id,
    u.firstname,
    u.lastname,
    u.email,
    g.userid,
    FROM_UNIXTIME(i1.data, '%d %M %Y') AS `startdate`,
    FROM_UNIXTIME(i2.data, '%d %M %Y') AS `enddate`,
    IF(i3.data = '', 'N/A', i3.data) AS `studentid`,
            ROUND(SUM(IF(i.itemname = 'CPCCWHS1001: White Card',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCWHS1001,
            ROUND(SUM(IF(i.itemname = 'CPCCSH3008: Install internal shop walls and fixtures_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCSH3008_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCSH3008: Install internal shop walls and fixtures',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCSH3008,
            ROUND(SUM(IF(i.itemname = 'CPCCSF2004A: Place and fix reinforcement materials_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCSF2004A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCSF2004A: Place and fix reinforcement materials',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCSF2004A,
            ROUND(SUM(IF(i.itemname = 'CPCCOHS2001A: Apply OHS requirements, policies and procedures in the construction industry_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCOHS2001A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCOHS2001A: Apply OHS requirements, policies and procedures in the construction industry',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCOHS2001A,
            ROUND(SUM(IF(i.itemname = 'CPCCCO2013A: Carry out concreting to simple forms_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCO2013A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCO2013A: Carry out concreting to simple forms',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCO2013A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2010B: Work safely at heights_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2010B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2010B: Work safely at heights',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2010B,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2008B: Erect and dismantle restricted height scaffolding_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2008B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2008B: Erect and dismantle restricted height scaffolding',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2008B,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2007B: Use explosive power tools_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2007B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2007B: Use explosive power tools',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2007B,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2002A: Carry out excavation_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2002A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2002A: Carry out excavation',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2002A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2001A: Read and interpret plans and specifications_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2001A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM2001A: Read and interpret plans and specifications',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM2001A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1015A: Carry out measurements and calculations_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1015A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1015A: Carry out measurements and calculations',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1015A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1014A: Conduct workplace communication_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1014A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1014A: Conduct workplace communication',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1014A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1013A: Plan and organise work_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1013A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1013A: Plan and organise work',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1013A,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1012A: Work effectively and sustainably in the construction industry_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1012A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCM1012A: Work effectively and sustainably in the construction industry',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCM1012A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3023A: Carry out levelling operations_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3023A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3023A: Carry out levelling operations',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3023A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3017B: Install exterior cladding_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3017B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3017B: Install exterior cladding',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3017B,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3010A: Install and replace windows and doors_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3010A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3010A: Install and replace windows and doors',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3010A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3008B: Construct eaves_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3008B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3008B: Construct eaves',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3008B,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3007C: Construct pitched roofs_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3007C_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3007C: Construct pitched roofs',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3007C,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3006B: Erect roof trusses_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3006B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3006B: Erect roof trusses',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3006B,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3005B: Construct ceiling frames_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3005B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3005B: Construct ceiling frames',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3005B,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3004A: Construct wall frames_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3004A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3004A: Construct wall frames',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3004A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3003A: Install flooring systems_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3003A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3003A: Install flooring systems',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3003A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3002A: Carry out setting out_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3002A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3002A: Carry out setting out',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3002A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3001A: Carry out general demolition of minor building structures_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3001A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA3001A: Carry out general demolition of minor building structures',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA3001A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2011A: Handle carpentry materials_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2011A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2011A: Handle carpentry materials',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2011A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2003A: Erect and dismantle formwork for footings and slabs on ground_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2003A_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2003A: Erect and dismantle formwork for footings and slabs on ground',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2003A,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2002B: Use carpentry tools and equipment_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2002B_practical,
            ROUND(SUM(IF(i.itemname = 'CPCCCA2002B: Use carpentry tools and equipment',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS CPCCCA2002B,
            ROUND(SUM(IF(i.itemname = 'BSBSMB406: Manage small business finances',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS BSBSMB406,
            ROUND(SUM(IF(i.itemname = 'BSBSMB301: Investigate micro business opportunities_Practical',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS BSBSMB301_practical,
            ROUND(SUM(IF(i.itemname = 'BSBSMB301: Investigate micro business opportunities',
                        g.finalgrade / g.rawgrademax * 100,
                        NULL)),
                    2) AS BSBSMB301
        FROM
            {grade_grades} AS g
                LEFT JOIN
            {grade_items} AS i ON g.itemid = i.id
                LEFT JOIN
            {user} AS u ON g.userid = u.id
                LEFT JOIN
            {user_info_data} AS i1 ON g.userid = i1.userid
                LEFT JOIN
            {user_info_data} AS i2 ON g.userid = i2.userid
                LEFT JOIN
            {user_info_data} AS i3 ON g.userid = i3.userid
        WHERE
            i.courseid = 212 AND i.itemtype = 'mod'
                AND g.userid =:userid
                AND i1.fieldid = 4
                AND i2.fieldid = 5
                AND i3.fieldid = 3
        GROUP BY g.userid
        ORDER BY i2.data;";

    $para = ['userid'=>$userid];
    $result = $DB->get_records_sql($sql,$para);

    return $result;
}

function get_userlist_wall($cohortid)
{
    global $DB;
    $sql = " SELECT 
    u.id,
    u.firstname,
    u.lastname,
    u.email,
    g.userid,
    FROM_UNIXTIME(i1.data, '%d %M %Y') AS `startdate`,
    FROM_UNIXTIME(i2.data, '%d %M %Y') AS `enddate`,
    IF(i3.data = '', 'N/A', i3.data) AS `studentid`,
    ROUND(SUM(IF(i.itemname = 'CPCCWP3002A: Apply waterproofing process to internal wet areas_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWP3002A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCWP3002A: Apply waterproofing process to internal wet areas',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWP3002A,
    ROUND(SUM(IF(i.itemname = 'CPCCWHS1001: White Card',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWHS1001,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3007A: Tile curved surfaces_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3007A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3007A: Tile curved surfaces',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3007A,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3006A: Carry out mosaic tiling_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3006A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3006A: Carry out mosaic tiling',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3006A,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3004A: Repair wall and floor tiles_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3004A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3004A: Repair wall and floor tiles',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3004A,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3003A: Fix wall tiles_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3003A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3003A: Fix wall tiles',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3003A,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3002A: Fix floor tiles_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3002A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3002A: Fix floor tiles',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3002A,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3001A: Prepare surfaces for tiling application_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3001A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCWF3001A: Prepare surfaces for tiling application',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF3001A,
    ROUND(SUM(IF(i.itemname = 'CPCCWF2002A: Use wall and floor tiling tools and equipment_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF2002A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCWF2002A: Use wall and floor tiling tools and equipment',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF2002A,
    ROUND(SUM(IF(i.itemname = 'CPCCWF2001A: Handle wall and floor tiling materials_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF2001A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCWF2001A: Handle wall and floor tiling materials',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCWF2001A,
    ROUND(SUM(IF(i.itemname = 'CPCCOHS2001A: Apply OHS requirements, policies and procedures in the construction industry_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCOHS2001A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCOHS2001A: Apply OHS requirements, policies and procedures in the construction industry',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCOHS2001A,
    ROUND(SUM(IF(i.itemname = 'CPCCCM2006B: Apply basic levelling procedures_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM2006B_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCCM2006B: Apply basic levelling procedures',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM2006B,
    ROUND(SUM(IF(i.itemname = 'CPCCCM2001A: Read and interpret plans and specifications_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM2001A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCCM2001A: Read and interpret plans and specifications',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM2001A,
    ROUND(SUM(IF(i.itemname = 'CPCCCM1015A: Carry out measurements and calculations_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM1015A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCCM1015A: Carry out measurements and calculations',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM1015A,
    ROUND(SUM(IF(i.itemname = 'CPCCCM1014A: Conduct workplace communication_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM1014A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCCM1014A: Conduct workplace communication',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM1014A,
    ROUND(SUM(IF(i.itemname = 'CPCCCM1013A: Plan and organise work_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM1013A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCCM1013A: Plan and organise work',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM1013A,
    ROUND(SUM(IF(i.itemname = 'CPCCCM1012A: Work effectively and sustainably in the construction industry_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM1012A_practical,
    ROUND(SUM(IF(i.itemname = 'CPCCCM1012A: Work effectively and sustainably in the construction industry',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS CPCCCM1012A,
    ROUND(SUM(IF(i.itemname = 'BSBSMB406: Manage small business finances',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS BSBSMB406,
    ROUND(SUM(IF(i.itemname = 'BSBSMB301: Investigate micro business_Practical',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS BSBSMB301_practical,
    ROUND(SUM(IF(i.itemname = 'BSBSMB301: Investigate micro business',
                g.finalgrade / g.rawgrademax * 100,
                NULL)),
            2) AS BSBSMB301
        FROM
            {grade_grades} AS g
                LEFT JOIN
            {grade_items} AS i ON g.itemid = i.id
                LEFT JOIN
            {user} AS u ON g.userid = u.id
                LEFT JOIN
            {user_info_data} AS i1 ON g.userid = i1.userid
                LEFT JOIN
            {user_info_data} AS i2 ON g.userid = i2.userid
                LEFT JOIN
            {user_info_data} AS i3 ON g.userid = i3.userid
        WHERE
            i.courseid = 214 AND i.itemtype = 'mod'
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
        ORDER BY i2.data;";

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

// Fetching grade item information based itemid and userid
function get_attemtid_from_gradeitem($grade_itemid,$userid)
{
    global $DB;
    if ($grade_itemid)
    {
        $sql = " SELECT 
            i.id,
            i.courseid,
            MAX(a.id) AS attemptid,
            q.id,
            max(ROUND(a.sumgrades / q.sumgrades * 100, 1)) AS grade,
            MAX(a.attempt) AS attempt,
            state,
            a.userid
            FROM
                {grade_items} AS i
                    LEFT JOIN
                {quiz_attempts} AS a ON i.iteminstance = a.quiz
                    LEFT JOIN
                {quiz} AS q ON i.iteminstance = q.id
            WHERE
                i.id = :itemid AND a.userid = :user_id
                    AND i.itemmodule = 'quiz'
            order by a.attempt desc";
    
        $para = ['itemid'=>$grade_itemid,'user_id'=>$userid];
        $result = $DB->get_record_sql($sql,$para);
        return $result;
    }

}
function get_userdata($cohortid){
    global $DB;

    $sql = "SELECT
                u.id, 
                u.firstname,
                u.lastname,
                u.email,
                from_unixtime(i1.data,'%d %M %Y') as `startdate`,
                from_unixtime(i2.data,'%d %M %Y') as `enddate`,
                if(i3.data='','N/A',i3.data) as `studentid`
                FROM
                    {user} as u
                        LEFT JOIN
                    {user_info_data} AS i1 ON u.id = i1.userid
                        LEFT JOIN
                    {user_info_data} AS i2 ON u.id = i2.userid
                    LEFT JOIN
                    {user_info_data} AS i3 ON u.id = i3.userid
                WHERE u.id IN (SELECT 
                        userid
                    FROM
                        {cohort_members} AS cm
                    WHERE
                        cohortid =:cohort_id)
                    AND i1.fieldid = 4
                    AND i2.fieldid = 5
                    AND i3.fieldid = 3
                GROUP BY u.id
                ORDER BY i2.data ";
    $para = ['cohort_id'=>$cohortid];
    $result = $DB->get_records_sql($sql,$para);
    return $result;
}
/*
    $userid = Moodle user id of student.
    $course = Moodle course id for calculating overrall grade of units.
    $items = array if list of activity items

*/
function get_grade_from_item($userid,$courseid,$items){
    //
    $colors = array(3131,3132);


    global $DB;
    if(empty($items)){
        // returning Total grade of units.
        $result=grade_get_grades($courseid, 'course',NULL,get_modinstance_id($courseid)->iteminstance, $userid)->items[null];
        if($result->grademax==$result->grades[$userid]->grade){
            return html_writer::div($result->grades[$userid]->str_grade,'text-center',array('style'=>"color: green"));
        }
        //print_object($result);
        return $result->grades[$userid]->str_grade;
    }
    else{
        $result='';
        foreach ($items as $item){
            echo $item;
            $grade_letter = ' <b>'.get_item_letter($item).': '.'</b>';

            print_object(get_attemtid_from_gradeitem($item,$userid));

            $attempt=(get_attemtid_from_gradeitem($item,$userid));

            $url = new moodle_url('/mod/quiz/review.php', array('attempt' => $attempt->attemptid));
            if($attempt->grade==100){
                $result.=   $grade_letter.html_writer::link($url, 'Satisfactory'.'('.$attempt->attempt.')',array('style'=>"color: green","target"=>"_blank"));
            }
            elseif ($attempt->grade==null||$attempt->grade==0){
                $result.=  $grade_letter.'Not Submitted';
            }
            else{
                $result.=   $grade_letter.html_writer::link($url, 'Require Re-sub'.'('.$attempt->attempt.')',array('style'=>"color: red","target"=>"_blank"));
            }
        }
    return $result;
    }
}

function get_modinstance_id($courseid){
    global $DB;
    return $DB->get_record('grade_items',array("courseid"=>$courseid,"itemtype"=>'course'),'iteminstance');
}
function get_item_letter($item)
{
    global $DB;
    return $DB->get_record('grade_items',array("id"=>$item,"itemtype"=>'mod'),'itemname')->itemname[0];
}

//        if($grade==100)
//        {
//            $result= html_writer::link($url, 'Satisfactory'.'('.$attempt->attempt.')',array('style'=>"color: green","target"=>"_blank"));
//        }
//        elseif ($grade==50)
//        {
//            $result= html_writer::link($url, 'Submitted'.'('.$attempt->attempt.')',array("target"=>"_blank"));
//        }
//        elseif ($grade==0)
//        {
//            $result= html_writer::link($url, 'Not Submitted'.'('.$attempt->attempt.')',array('style'=>"color: gray","target"=>"_blank"));
//        }
//        elseif ($grade>50 || $grade<100){
//            $result= html_writer::link($url, 'Require Re-sub'.'('.$attempt->attempt.')',array('style'=>"color: red","target"=>"_blank"));
//        }
//
//     }