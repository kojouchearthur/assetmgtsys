<?php
require "../assets/conf.php";
require "../assets/assetmgtconf.php";
require "../assets/reuse.php";
require "../lib/plug.php";

$query0 = "SELECT * FROM assetusers";
$query = "SELECT DISTINCT 'user','email','location' FROM asset_users";
$result = mysqli_query($con,$query);
$result0 = mysqli_query($con,$query0);

echo "
<table class='table table-hover table-striped table-responsive' id='' style='font-size:12px;'>
    <thead>
        <tr>
            <th>S/No.</th>
            <th>Device User</th>
            <th>Email</th>
            <th>Current Location</th>
            <th>Current Designation</th>
            <th>Recent Device Assigned</th>
            <th>Date Assigned</th>
            <th>Actions</th>
        </tr>
    </thead>
";
echo "<tbody style='font-size:12px;'>";
if(!$result0){
    echo "<tr><td>No Data Available</td></tr>";
}else{
    $sn = 1;
    while(($devusers=mysqli_fetch_assoc($result0)) !== null){
        $devuserid = $devusers['userid'];
        $query1 = "SELECT deviceuserrecord,devicetype,dev FROM assets WHERE deviceuserrecord LIKE %$devuserid% ORDER BY updatetrack DESC LIMIT=1";
//      $query2 = "SELECT devicetype,brand,model FROM assets WHERE deviceid='$'";
        $res1 = mysqli_query($con,$query1);

        if(count(explode('::',$devusers['devicerecord']))>1){
            $numusrdevrec = count(explode('::',$devusers['devicerecord']));
            $recusrdevrec = explode('::',$devusers['devicerecord'])[$numusrdevrec-1];
    //      $curusrdevrec = explode(':',$recusrdevrec);
    //      $curusrdevid = explode(':',$curusrdevrec);
        }else{
            $recusrdevrec = $devusers['devicerecord'];            
        }
        $curusrdevrec = explode(':',$recusrdevrec);
        $curusrdevid = $curusrdevrec[2];

        $query2 = "SELECT devicetype,brand,model FROM assets WHERE deviceid='$curusrdevid'";
        $res2 = mysqli_query($con,$query2);
        $curusrdev = mysqli_fetch_assoc($res2);
        $curusrdev = $curusrdev['devicetype']."<br>(".$curusrdevrec[3]."<br>".$curusrdev['brand']." ".$curusrdev['model'].")";
        
        echo "<tr>
            <td>".$sn."</td>
            <td>".$devusers['fname'].' '.$devusers['lname']."</td>
            <td>".$devusers['email']."</td>
            <td>".$devusers['recentlocation']."</td>
            <td>".$devusers['recentdesignation']."</td>
            <td style='text-align:center;'>".$curusrdev."</td>
            <td>".Date('D,d-M-Y',$curusrdevrec[1])."</td>
            <td><span class='usrinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span class='del usrdel' style='color:orangered;'><i class='fa fa-trash'></i></span></td>
        </tr>";
        $sn++;
    }
}

echo "       
</tbody>
</table>";
?>