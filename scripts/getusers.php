<?php
require "../assets/conf.php";
require "../assets/assetmgtconf.php";
require "../assets/reuse.php";
require "../lib/plug.php";

    $query0 = "SELECT * FROM assetusers";
//    $query = "SELECT DISTINCT 'user','email','location' FROM asset_users";
    
    $result0 = mysqli_query($con,$query0);
//    $result = mysqli_query($con,$query);

echo "
<table class='table table-hover table-striped table-responsive' id='' style='font-size:12px;'>
    <thead>
        <tr class='tab-col-hd' style='text-align:center;'>
            <th>S/No.</th>
            <th style='width:auto;'>Device User</th>
            <th>Email</th>
            <th>Current Location</th>
            <th>Current Designation</th>
            <th>Latest Device Assigned</th>
            <th>Date Assigned</th>
            <th>Actions</th>
        </tr>
    </thead>
";
echo "<tbody style='font-size:12px;text-align:center;'>";
if(!$result0){
    echo "<tr><td>No Data Available</td></tr>";
}else{          
    $sn = 1;
    while(($devusers=mysqli_fetch_assoc($result0)) !== null){
        $devuserid = $devusers['userid'];
//      $query1 = "SELECT deviceuserrecord,devicetype,dev FROM assets WHERE deviceuserrecord LIKE %$devuserid% ORDER BY updatetrack DESC LIMIT 1";
//      $query2 = "SELECT devicetype,brand,model FROM assets WHERE deviceid='$'";
//      $res1 = mysqli_query($con,$query1);

        if(count(explode('::',$devusers['devicerecord']))>1){
            $numusrdevrec = count(explode('::',$devusers['devicerecord']));
            $usrdevrec = explode('::',$devusers['devicerecord'])[$numusrdevrec-1];
    //      $curusrdevrec = explode(':',$recusrdevrec);
    //      $curusrdevid = explode(':',$curusrdevrec);
        }else{
            $usrdevrec = $devusers['devicerecord'];            
        }
        $curusrdevrec = explode(':',$usrdevrec);
        $curusrdevid = $curusrdevrec[0];

//        $query2 = "SELECT devicetype,brand,model FROM assets WHERE deviceid='$curusrdevid'";
//        $res2 = mysqli_query($con,$query2);
//        $curusrdev = mysqli_fetch_assoc($res2);
        $curusrdev = strtoupper($curusrdevrec[2])."<br>(".$curusrdevrec[3].")";
//        $curusrdev = $curusrdev['devicetype']."<br>(".$curusrdevrec[3]."<br>".$curusrdev['brand']." ".$curusrdev['model'].")";
        $rowstyle = $rowstylend='';
        $usrstate = "<span class='del usrdel' style='color:orangered;'><i class='fa fa-trash'></i></span>";
        if($devusers['userstate']==0){
            $rowstyle = "<del>";
            $rowstylend = "</del>";
            $usrstate = "<span class='del' style='color:gray;'><i class='fa fa-align-center'></i></span>";
        }

        echo "<tr>
            <td>".$sn."</td>
            <td class='devusrname itemname'>".$rowstyle.$devusers['fname'].' '.$devusers['lname'].$rowstylend."</td>
            <td class='devusrunique'><span class='devusrmail'>".$rowstyle.$devusers['email']."</span><span class='devusruniquenum'><input type='hidden' class='devusrid' value='".$devusers['userid']."'></span>".$rowstylend."</td>
            <td>".$rowstyle.$devusers['recentlocation'].$rowstylend."</td>
            <td>".$rowstyle.$devusers['recentdesignation'].$rowstylend."</td>
            <td style='text-align:center;width:250px;'>".$rowstyle.$curusrdev.$rowstylend."</td>
            <td>".$rowstyle.Date('D,d-M-Y',$curusrdevrec[6]).$rowstylend."</td>
            <td><span class='usrinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;".$usrstate."</td>
        </tr>";
        $sn++;
    }
    
}

echo "       
</tbody>
</table>";
?>