<?php
require "../assets/conf.php";
require "../assets/assetmgtconf.php";
require "../assets/reuse.php";
require "../lib/plug.php";

if(isset($_REQUEST['uniqueid'])){
    $acct = cleanValidate($_REQUEST['uniqueid'],'string');  
}

$query = "SELECT * FROM users WHERE uniqueid='$acct'";
$result = mysqli_query($con,$query);

if(!$result){
    echo "Unable to fetch Account Info";
    exit();
}else{
    $acctinfo = mysqli_fetch_assoc($result);
    $acctusern = $acctinfo['username'];

    echo "<h5 style='text-align:center; font-size:12px; font-weight:bold; margin-top:0px;'>Account: <span style='font-weight:normal;'>".ucfirst($acctinfo['fname'])." ".ucfirst($acctinfo['lname'])." (".$acctinfo['username'].")</span>"."</h5>";
    echo "<table id='devinftab' class='table table-responsive table-condensed mod-tab dev-inf' style=''>";
    echo "<tbody style='font-size:12px;'>
    <tr style=''>
        <td style='width:50%;'><span class='inftit' style=''>Account Type: </span><br>";if($acctinfo['accttype']==0){echo"Standard";}else{echo"Administrator";} echo"</td>
        <td class=''><span class='inftit' style=''>Phone No.: </span><br>".$acctinfo['phone']."</td>
    </tr>";

echo " 
    <tr>
        <td><span class='inftit' style=''>Date Added: </span><br>".Date('D, d-M-Y',$acctinfo['joindateraw'])."</td>
        <td class=''><span class='inftit' style=''>Added By: </span><br>".$acctinfo['addedby']."</td>
    </tr>
    <tr>
        <td colspan=2 style='text-align:center;'><span class='inftit' style=''>Email: </span>".$acctinfo['email']."</td>
    </tr>
    </tbody>
    </table>";

    /*
    $devusers = explode('::',$acctinfo['deviceuserrecord']);
    $curdevuser = $devusers[count($devusers)-1];
    
    $initdevuser = $devusers[0];

    if(count($devusers)==1){
        $devusers = $acctinfo['deviceuserrecord'];
        $initdevuser = $rcntpstdevuser = $curdevuser = $devusers;
    }elseif(count($devusers)==2){
        $rcntpstdevuser = $initdevuser = $devusers[0];
    }elseif(count($devusers)>2){
        $rcntpstdevuser = $devusers[count($devusers)-2];
    }

    $curdevuserdet = explode(':',$curdevuser);
    $rcntpstdevuserdet = explode(':',$rcntpstdevuser);
    $initdevuserdet = explode(':',$initdevuser);
    */

    echo "<h6 style='text-decoration:none;text-align:center;'><strong>Account Activity Summary</strong></h6>";

    $query1 = "SELECT * FROM asset_users WHERE (addedby='$acctusern' OR modifiedby='$acctusern')";
    $query1a = "SELECT * FROM asset_users WHERE (addedby = '$acctusern' OR modifiedby='$acctusern') ORDER BY id ASC LIMIT 1";
    $query1b = "SELECT * FROM asset_users WHERE (addedby = '$acctusern' OR modifiedby='$acctusern') ORDER BY id DESC LIMIT 1";

    $res1 = mysqli_query($con,$query1);
    $res1a = mysqli_query($con,$query1a);
    $res1b = mysqli_query($con,$query1b);

    if(!($res1 && $res1a && $res1b)){
        echo print_r(mysqli_error_list($con));
    }

    if(mysqli_num_rows($res1)>0){       
        $numacty = mysqli_num_rows($res1);
        $acctinitacty = mysqli_fetch_assoc($res1a);
        $acctrcntacty = mysqli_fetch_assoc($res1b);

        echo "
        <table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>
        <!--<tr style='border-bottom:gray solid 1px'><td style='border-bottom:gray solid 1px'>&nbsp;</td><td style='border-bottom:gray solid 1px'>&nbsp;</td></tr>-->
        <tr style='border-top:gray solid 1px;'>
            <td style='width:50%; border-right:gray solid 1px;border-top:gray solid 1px;line-height:25px;'>
            <span class='inftit' style='display:inline-block;text-align:center;'>Latest Activity</span><br>
            <span class='inftit'>Device Type: </span>".strtoupper($acctrcntacty['devicetype'])."<br>
            <span class='inftit'>Asset No.: </span>".$acctrcntacty['assetnum']."<br>
            <span class='inftit'>Type: </span>";if($acctrcntacty['devicestate']=='New'){echo "Fresh Assign";}else{echo "ReAssign";}echo "<br>
            <span class='inftit'>User: </span>".$acctrcntacty['fname']." ".$acctrcntacty['lname']."<br>
            <span class='inftit'>Email: </span>".$acctrcntacty['email']."<br>
            <span class='inftit'>Position: </span>".$acctrcntacty['recentdesignation']."<br>
            <span class='inftit'>Location: </span>".$acctrcntacty['recentlocation']."<br>
            <span class='inftit'>Date Assigned: </span>".Date('D, d-M-y',$acctrcntacty['dateassignedraw'])."<br>";
            if($acctrcntacty['datereturnedraw']!=0){
               echo "<span class='inftit'>Date Returned: </span>".Date('D, d-M-y',$acctrcntacty['datereturnedraw'])."<br>";
            }
        echo "
            <span class='inftit'>Device Details: </span><br><span style='display:inline-block;text-align:center;'>".$acctrcntacty['devicedesc']."</span><br>
            </td>
            <td style='border-top:gray solid 1px;line-height:25px;line-height:25px;'>
            <span class='inftit' style='display:inline-block;text-align:center;'>First Activity</span><br>
            <span class='inftit'>Device Type: </span>".strtoupper($acctinitacty['devicetype'])."<br>
            <span class='inftit'>Asset No.: </span>".$acctinitacty['assetnum']."<br>
            <span class='inftit'>Type: </span>";if($acctinitacty['devicestate']=='New'){echo "Fresh Assign";}else{echo "ReAssign";}echo "<br>
            <span class='inftit'>User: </span>".$acctinitacty['fname']." ".$acctinitacty['lname']."<br>
            <span class='inftit'>Email: </span>".$acctinitacty['email']."<br>
            <span class='inftit'>Position: </span>".$acctinitacty['recentdesignation']."<br>
            <span class='inftit'>Location: </span>".$acctinitacty['recentlocation']."<br>
            <span class='inftit'>Date Assigned: </span>".Date('D, d-M-y',$acctinitacty['dateassignedraw'])."<br>";
            if($acctinitacty['datereturnedraw']!=0){
               echo "<span class='inftit'>Date Returned: </span>".Date('D, d-M-y',$acctinitacty['datereturnedraw'])."<br>";
            }
        
        echo "
            <span class='inftit'>Device Details: </span><br><span style='display:inline-block;text-align:center;'>".$acctinitacty['devicedesc']."</span><br>
            </td>
        </tr>
        </table>";
    }else{
        echo "
        <table class='table table-responsive table-condensed mod-tab dev-inf' id='' style='font-size:12px;border-top:gray solid 1px;'>
        <!--<tr style='border-bottom:gray solid 1px'><td style='border-bottom:gray solid 1px'>&nbsp;</td><td style='border-bottom:gray solid 1px'>&nbsp;</td></tr>-->
        <tr style='border-top:gray solid 1px;text-align:center;'>
            <td style='border-top:gray solid 1px;line-height:25px;'>No Device Activity yet</td>
        </tr>
        </table>";
    }
        
}

?>