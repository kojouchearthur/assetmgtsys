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
    echo "Unable to fetch Device Info";
    die();
}else{
    $userinfo = mysqli_fetch_assoc($result);

    echo "<h5 style='text-align:center; font-size:11px; font-weight:bold; margin-top:0px;'>Device User: ".strtoupper($userinfo['fname']." ".$userinfo['lname'])."</h5>";
    echo "<table id='devinftab' class='table table-responsive table-condensed mod-tab dev-inf' style=''>";
    echo "<tbody style='font-size:12px;'>
    <tr style=''>
        <td style='width:50%;'><span class='inftit' style=''>Email: </span><br>".$userinfo['email']."</td>    
        <td class=''><span class='inftit' style=''>User Id: </span><br>".$userinfo['userid']."</td>
    </tr>
    <tr style=''>
        <td><span class='inftit' style=''>Current Designation: </span><br>".$userinfo['recentdesignation']."</td>    
        <td class=''><span class='inftit' style=''>Current Location: </span><br>".$userinfo['recentlocation']."</td>
    </tr>
    ";

echo "</tbody>
    </table>";
    $userdevs = explode('::',$userinfo['devicerecord']);
    $rcntuserdev = $userdevs[count($userdevs)-1];    
    $inituserdev = $userdevs[0];

    if(count($userdevs)==1){
        $userdevs = $userinfo['devicerecord'];
        $inituserdev = $rcntuserdev = $userdevs;
    }
    
    $rcntuserdevdet = explode(':',$rcntuserdev);
    $inituserdevdet = explode(':',$inituserdev);

    echo "<h6 style='text-decoration:none;text-align:center;'><strong>Device Usage Summary</strong></h6>";

    echo "<table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>
        <!--<tr style='border-bottom:gray solid 1px'><td style='border-bottom:gray solid 1px'>&nbsp;</td><td style='border-bottom:gray solid 1px'>&nbsp;</td></tr>-->
        <tr style='border-top:gray solid 1px;'>
            <td style='width:50%; border-right:gray solid 1px;border-top:gray solid 1px;line-height:20px;'>
            <span class='inftit' style='display:inline-block;text-align:center;'>Latest Device</span><br>
            <span class='inftit'>Asset Num: </span>".$rcntuserdevdet[1]."<br>
            <span class='inftit'>Device Type: </span>".strtoupper($rcntuserdevdet[2])."<br>            
            <span class='inftit'>Condition/Type: </span>".$rcntuserdevdet[4]."<br>
            <span class='inftit'>Date Assigned: </span>".Date('D, d-M-y',$rcntuserdevdet[6])."<br>";
            if(isset($rcntuserdevdet[8])){
               echo "<span class='inftit'>Date Returned: </span>".Date('D, d-M-y',$rcntuserdevdet[8])."<br>";
            }
        echo "
            <span class='inftit'>Device Details: </span><span style='display:inline-block;text-align:center;'>".$rcntuserdevdet[3]."</span><br>
            </td>
            <td style='border-top:gray solid 1px;line-height:25px;line-height:20px;'>
            <span class='inftit' style='display:inline-block;text-align:center;'>Initial Device</span><br>
            <span class='inftit'>Asset Num: </span>".$inituserdevdet[1]."<br>
            <span class='inftit'>Device Type: </span>".strtoupper($inituserdevdet[2])."<br>            
            <span class='inftit'>Condition/Type: </span>".$inituserdevdet[4]."<br>
            <span class='inftit'>Date Assigned: </span>".Date('D, d-M-y',$inituserdevdet[6])."<br>";
            if(isset($inituserdevdet[8])){
               echo "<span class='inftit'>Date Returned: </span>".Date('D, d-M-y',$inituserdevdet[8])."<br>";
            }
        
        echo"
            <span class='inftit'>Device Details: </span><span style='display:inline-block;text-align:center;'>".$inituserdevdet[3]."</span><br>
            </td>
        </tr>
        </table>";
}



?>