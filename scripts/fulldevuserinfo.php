<?php
require "../assets/conf.php";
require "../assets/assetmgtconf.php";
require "../assets/reuse.php";
require "../lib/plug.php";

$userid = '';
$useremail = '';
if(isset($_REQUEST['userid']) && isset($_REQUEST['useremail'])){
    $userid = cleanValidate(testInput($_REQUEST['userid']),'string');
    $useremail = cleanValidate(testInput($_REQUEST['useremail']),'email');
}


$query = "SELECT * FROM assetusers WHERE userid='$userid' AND email='$useremail'";
$result = mysqli_query($con,$query);


if(!$result){
    echo "Unable to fetch User Info";
    exit();
}else{
    $userinfo = mysqli_fetch_assoc($result);

    echo "<br><h5 style='text-align:center; font-size:11px; font-weight:bold; margin-top:0px;'>Device User: ".strtoupper($userinfo['fname']." ".$userinfo['lname'])."</h5>";
    echo "<div class='' id='' style='margin:0 auto;max-width:500px;'>
    <table id='devinftab' class='table table-responsive table-condensed mod-tab dev-inf' style=''>";
    echo "<tbody style='font-size:12px;'>
    <tr style=''>
        <td style='width:50%;'><span class='inftit' style=''>Email: </span><br>".$userinfo['email']."</td>    
        <td class=''><span class='inftit' style=''>User Id: </span><br>".$userinfo['userid']."</td>
    </tr>
    <tr style=''>
        <td><span class='inftit' style=''>Recent Designation: </span><br>".$userinfo['recentdesignation']."</td>    
        <td class=''><span class='inftit' style=''>Recent Location: </span><br>".$userinfo['recentlocation']."</td>
    </tr>    
    </tbody>
    </table></div>";
    $userdevs = explode('::',$userinfo['devicerecord']);
    $rcntuserdev = $userdevs[count($userdevs)-1];
    $rcntuserdevdet = explode(':',$rcntuserdev);

    echo "<h6 style='text-decoration:none;text-align:center;'><strong>Devices Used</strong></h6>
    <div class='' id='' style='margin:0 auto;max-width:500px;'>
    <table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>";
    $i = 0;
    while(count($userdevs)>$i){
        $devuserdet = explode(':',$userdevs[$i]);

        echo"<tr'>
            <td  style='line-height:20px;width:50%;border-top:gray solid 1px;'>
            <span class='inftit' style='display:inline-block;text-indent:0px;'>Device Details</span><br>
            <span class='inftit'>Asset Num: </span><br>
            <span class='inftit'>Device Type: </span><br>
            <span class='inftit'>Condition/Type: </span><br>            
            <span class='inftit'>Date Assigned: </span><br>";
            if(isset($devuserdet[8])){
                echo "<span class='inftit'>Date Returned: </span><br><br>";
            }
        echo"<span class='inftit'>Device Details: </span><br>
            </td>
            <td style='border-top:gray solid 1px;line-height:20px;'>
            <span></span><br>
            <span>".$devuserdet[1]."</span><br>
            <span>".strtoupper($devuserdet[2])."</span><br>            
            <span>";if($devuserdet[4]=='New'){ echo "New (Fresh Assign)";}else{echo "Used (ReAssign)";} echo"</span><br>
            <span>".Date('D, d-M-Y',$devuserdet[6])."</span><br>";
            if(isset($devuserdet[8])){
                echo Date('D, d-M-y',$devuserdet[8])."<br><br>";
            }
        echo"<span>".$devuserdet[3]."</span><br>
            </td>
            </tr>";
        $i++;
    }
    echo"
    </table></div>";
}



?>