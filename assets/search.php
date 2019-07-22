<?php
session_start();
require "../assets/reuse.php";
require "../lib/plug.php";

$usrq='';
$dsr='';
if(isset($_REQUEST['q'])){
    $usrq = cleanValidate(testInput($_REQUEST['q']),'string');
    if(isset($_REQUEST['dsr'])){
        $query ='';
        $dsr = cleanValidate(testInput($_REQUEST['dsr']),'string');
        $newdsr = explode(' ',$dsr,2);
        $srchsrc = $newdsr[1];
        // print_r($newdsr);

        /* code block to query all devices (assets table) for search result */
        if(strtolower($srchsrc)=='all devices'){
            $query = "SELECT * FROM assets WHERE (devicetype LIKE '%$usrq%' OR brand LIKE '%$usrq%' OR model LIKE '%$usrq%' OR
            serialimei LIKE '%$usrq%' OR ram LIKE '%$usrq%' OR hdd LIKE '%$usrq%' OR processor LIKE '%$usrq%' OR otherdesc LIKE '%$usrq%'
            OR assetnum LIKE '%$usrq%' OR vendor LIKE '%$usrq%' OR vendordetails LIKE '%$usrq%' OR newpurdate LIKE '%$usrq%' OR
            devicecost LIKE '%$usrq%' OR boughtby LIKE '%$usrq%' OR deviceuserrecord LIKE '%$usrq%' OR dateadded LIKE '%$usrq%' OR
            addedby LIKE '%$usrq%')";

            $result = mysqli_query($con,$query);

            if($result){
                echo "
                <table class='table table-responsive table-hover table-striped'>
                    <thead>
                    <tr class='tab-col-hd' style='text-align:center;'>
                        <th>S/No</th>
                        <th>Name &amp; Model</th>                                    
                        <th>Device Type</th>
                        <th>Description</th>                
                        <th>Asset Number</th>
                        <th>Date Purchased</th>
                        <th>Current User</th>
                        <th>User Location</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody style='font-size:11px; text-align:center;'>";

                if(mysqli_num_rows($result)==0){
                    echo "<tr><td colspan=9>Your search <em>".$usrq."</em> did not match any records in ".$srchsrc." </td></tr>";
                }else{
                    $sn = 1;
                    while(($records=mysqli_fetch_assoc($result))!==null){
                        // echo "<tr><td colspan=9>Your search Returned <strong>".mysqli_num_rows($result)."record(s).</strong>";
                         
                        // print_r($records);

                        if(count(explode("::",$records['deviceuserrecord'])) < 2){
                            $curdevuserrecord = explode(":",$records['deviceuserrecord']);
                        }else{
                            $devuserrecord = explode("::",$records['deviceuserrecord']);
                            $curdevuserrecord = explode(":",$devuserrecord[count($devuserrecord) - 1]);
                        }
                    
                        $purchasedate = $records['purchasedateraw'];
                        echo "
                        <tr class='devitem'>
                            <td>".$sn."</td>";
                        if(($records['model'] == 'N/A')||($records['model'] == '') || ($records['model']==' ')){
                            echo "<td class='devitemname'>".$records['brand']."</td>";
                        }else{
                            echo "<td class='devitemname'>".$records['brand']." ".$records['model']."</td>";
                        }
                        echo "
                        <td class='devitemtype'>".$records['devicetype']."</td>";
                        if(($records['processor']=='N/A')||($records['processor']=='')){
                            echo "<td>".$records['otherdesc']."</td>"; 
                        }else{
                            echo "<td>".$records['processor'].", <br>".$records['otherdesc']."</td>";
                        }
                        echo "                                
                            <td class='devitemasstnum'>".$records['assetnum']."</td>
                            <td>".date('D, d-M-Y',$purchasedate)."</td>
                            <td>".$curdevuserrecord[0]."</td>
                            <td>".$curdevuserrecord[4]."</td>
                            <td><span id='' class='devinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='' class='mgset mgdev'><i class='fa fa-cog'></i></span>&nbsp;<span id='' class='del devdel'><i class='fa fa-trash' style='color:orangered;'></i></span></td>
                        </tr>
                        ";
                        $sn++;
                    }
                }                

            }else{
                echo "<span class='fa fa-exclamation-triangle'></span><br>Ouch...Search Error!!!<br>".mysqli_error($con);
            }
            echo "                                               
                </tbody>                                
            </table>";
        }

        /* code block to query all assigned devices (assets table) for search result */
        if(strtolower($srchsrc)=='assigned devices'){
            $query = "SELECT * FROM assets WHERE (devicetype LIKE '%$usrq%' OR brand LIKE '%$usrq%' OR model LIKE '%$usrq%' OR
            serialimei LIKE '%$usrq%' OR ram LIKE '%$usrq%' OR hdd LIKE '%$usrq%' OR processor LIKE '%$usrq%' OR otherdesc LIKE '%$usrq%'
            OR assetnum LIKE '%$usrq%' OR vendor LIKE '%$usrq%' OR vendordetails LIKE '%$usrq%' OR newpurdate LIKE '%$usrq%' OR
            devicecost LIKE '%$usrq%' OR boughtby LIKE '%$usrq%' OR deviceuserrecord LIKE '%$usrq%' OR dateadded LIKE '%$usrq%' OR
            addedby LIKE '%$usrq%') AND assigned=1";

            $result = mysqli_query($con,$query);

            if($result){
                echo "
                <table class='table table-responsive table-hover table-striped'>
                    <thead>
                    <tr class='tab-col-hd' style='text-align:center;'>
                        <th>S/No</th>
                        <th>Name &amp; Model</th>                                    
                        <th>Device Type</th>
                        <th>Description</th>                
                        <th>Asset Number</th>
                        <th>Date Purchased</th>
                        <th>Current User</th>
                        <th>User Location</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody style='font-size:11px; text-align:center;'>";

                if(mysqli_num_rows($result)==0){
                    echo "<tr><td colspan=9>Your search <em>".$usrq."</em> did not match any records in ".$srchsrc." </td></tr>";
                }else{
                    $sn = 1;
                    while(($records=mysqli_fetch_assoc($result))!==null){
                        // echo "<tr><td colspan=9>Your search Returned <strong>".mysqli_num_rows($result)."record(s).</strong>";
                         
                        // print_r($records);

                        if(count(explode("::",$records['deviceuserrecord'])) < 2){
                            $curdevuserrecord = explode(":",$records['deviceuserrecord']);
                        }else{
                            $devuserrecord = explode("::",$records['deviceuserrecord']);
                            $curdevuserrecord = explode(":",$devuserrecord[count($devuserrecord) - 1]);
                        }
                    
                        $purchasedate = $records['purchasedateraw'];
                        echo "
                        <tr class='devitem'>
                            <td>".$sn."</td>";
                        if(($records['model'] == 'N/A')||($records['model'] == '') || ($records['model']==' ')){
                            echo "<td class='devitemname'>".$records['brand']."</td>";
                        }else{
                            echo "<td class='devitemname'>".$records['brand']." ".$records['model']."</td>";
                        }
                        echo "
                        <td class='devitemtype'>".$records['devicetype']."</td>";
                        if(($records['processor']=='N/A')||($records['processor']=='')){
                            echo "<td>".$records['otherdesc']."</td>"; 
                        }else{
                            echo "<td>".$records['processor'].", <br>".$records['otherdesc']."</td>";
                        }
                        echo "                                
                            <td class='devitemasstnum'>".$records['assetnum']."</td>
                            <td>".date('D, d-M-Y',$purchasedate)."</td>
                            <td>".$curdevuserrecord[0]."</td>
                            <td>".$curdevuserrecord[4]."</td>
                            <td><span id='' class='devinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='' class='mgset mgdev'><i class='fa fa-cog'></i></span>&nbsp;<span id='' class='del devdel'><i class='fa fa-trash' style='color:orangered;'></i></span></td>
                        </tr>
                        ";
                        $sn++;
                    }
                }                

            }else{
                echo "<span class='fa fa-exclamation-triangle'></span><br>Ouch...Search Error!!!<br>".mysqli_error($con);
            }
            echo "                                               
                </tbody>                                
            </table>";
        }

        /* code block to query all unassigned/returned devices (assets table) for search result */
        if(strtolower($srchsrc)=='unassigned devices'){
            $query = "SELECT * FROM assets WHERE (devicetype LIKE '%$usrq%' OR brand LIKE '%$usrq%' OR model LIKE '%$usrq%' OR
            serialimei LIKE '%$usrq%' OR ram LIKE '%$usrq%' OR hdd LIKE '%$usrq%' OR processor LIKE '%$usrq%' OR otherdesc LIKE '%$usrq%'
            OR assetnum LIKE '%$usrq%' OR vendor LIKE '%$usrq%' OR vendordetails LIKE '%$usrq%' OR newpurdate LIKE '%$usrq%' OR
            devicecost LIKE '%$usrq%' OR boughtby LIKE '%$usrq%' OR deviceuserrecord LIKE '%$usrq%' OR dateadded LIKE '%$usrq%' OR
            addedby LIKE '%$usrq%') AND assigned=0";

            $result = mysqli_query($con,$query);

            if($result){
                echo "
                <table class='table table-responsive table-hover table-striped'>
                    <thead>
                    <tr class='tab-col-hd' style='text-align:center;'>
                        <th>S/No</th>
                        <th>Name &amp; Model</th>                                    
                        <th>Device Type</th>
                        <th>Description</th>                
                        <th>Asset Number</th>
                        <th>Date Purchased</th>
                        <th>Current User</th>
                        <th>User Location</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody style='font-size:11px; text-align:center;'>";

                if(mysqli_num_rows($result)==0){
                    echo "<tr><td colspan=9>Your search <em>".$usrq."</em> did not match any records in ".$srchsrc." </td></tr>";
                }else{
                    $sn = 1;
                    while(($records=mysqli_fetch_assoc($result))!==null){
                        // echo "<tr><td colspan=9>Your search Returned <strong>".mysqli_num_rows($result)."record(s).</strong>";
                         
                        // print_r($records);

                        if(count(explode("::",$records['deviceuserrecord'])) < 2){
                            $curdevuserrecord = explode(":",$records['deviceuserrecord']);
                        }else{
                            $devuserrecord = explode("::",$records['deviceuserrecord']);
                            $curdevuserrecord = explode(":",$devuserrecord[count($devuserrecord) - 1]);
                        }
                    
                        $purchasedate = $records['purchasedateraw'];
                        echo "
                        <tr class='devitem'>
                            <td>".$sn."</td>";
                        if(($records['model'] == 'N/A')||($records['model'] == '') || ($records['model']==' ')){
                            echo "<td class='devitemname'>".$records['brand']."</td>";
                        }else{
                            echo "<td class='devitemname'>".$records['brand']." ".$records['model']."</td>";
                        }
                        echo "
                        <td class='devitemtype'>".$records['devicetype']."</td>";
                        if(($records['processor']=='N/A')||($records['processor']=='')){
                            echo "<td>".$records['otherdesc']."</td>"; 
                        }else{
                            echo "<td>".$records['processor'].", <br>".$records['otherdesc']."</td>";
                        }
                        echo "                                
                            <td class='devitemasstnum'>".$records['assetnum']."</td>
                            <td>".date('D, d-M-Y',$purchasedate)."</td>
                            <td>".$curdevuserrecord[0]."</td>
                            <td>".$curdevuserrecord[4]."</td>
                            <td><span id='' class='devinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='' class='mgset mgdev'><i class='fa fa-cog'></i></span>&nbsp;<span id='' class='del devdel'><i class='fa fa-trash' style='color:orangered;'></i></span></td>
                        </tr>
                        ";
                        $sn++;
                    }
                }                

            }else{
                echo "<span class='fa fa-exclamation-triangle'></span><br>Ouch...Search Error!!!<br>".mysqli_error($con);
            }
            echo "                                               
                </tbody>                                
            </table>";
        }

        /* code block to query all device users (assetusers table) for search result */
        if(strtolower($srchsrc)=='all users'){
            $query = "SELECT * FROM assetusers WHERE (fname LIKE '%$usrq%' OR lname LIKE '%$usrq%' OR email LIKE '%$usrq%' 
            OR userid LIKE '%$usrq%' OR recentlocation LIKE '%$usrq%' OR recentdesignation LIKE '%$usrq%' OR devicerecord LIKE '%$usrq%' 
            OR dateadded LIKE '%$usrq%' OR addedby LIKE '%$usrq%')";

            $result = mysqli_query($con,$query);

            if($result){
                echo "
                <table class='table table-hover table-striped table-responsive' id='' style='font-size:12px;'>
                    <thead>
                        <tr class='tab-col-hd' style='text-align:center;'>
                            <th>S/No.</th>
                            <th style='width:auto;'>Device User</th>
                            <th>Email</th>
                            <th>Current Location</th>
                            <th>Current Designation</th>
                            <th>Recent Device Assigned</th>
                            <th>Date Assigned</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                ";
                echo "<tbody style='font-size:12px;text-align:center;'>";

                if(mysqli_num_rows($result)==0){
                    echo "<tr><td colspan=8>Your search <em>".$usrq."</em> did not match any records in ".$srchsrc." </td></tr>";
                }else{
                    $sn = 1;
                    while(($devusers=mysqli_fetch_assoc($result)) !== null){
                        $devuserid = $devusers['userid'];
                
                        if(count(explode('::',$devusers['devicerecord']))>1){
                            $numusrdevrec = count(explode('::',$devusers['devicerecord']));
                            $usrdevrec = explode('::',$devusers['devicerecord'])[$numusrdevrec-1];
                        }else{
                            $usrdevrec = $devusers['devicerecord'];            
                        }
                        $curusrdevrec = explode(':',$usrdevrec);
                        $curusrdevid = $curusrdevrec[0];
                
                        $curusrdev = strtoupper($curusrdevrec[2])."<br>(".$curusrdevrec[3].")";
                                        
                        echo "<tr>
                            <td>".$sn."</td>
                            <td class='devusrname itemname'>".$devusers['fname'].' '.$devusers['lname']."</td>
                            <td class='devusrunique'><span class='devusrmail'>".$devusers['email']."</span><span class='devusruniquenum'><input type='hidden' class='devusrid' value='".$devusers['userid']."'></span></td>
                            <td>".$devusers['recentlocation']."</td>
                            <td>".$devusers['recentdesignation']."</td>
                            <td style='text-align:center; width:250px;'>".$curusrdev."</td>
                            <td>".Date('D,d-M-Y',$curusrdevrec[6])."</td>
                            <td><span class='usrinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span class='del usrdel' style='color:orangered;'><i class='fa fa-trash'></i></span></td>
                        </tr>";
                        $sn++;
                    }
                }

            }else{
                echo "<span class='fa fa-exclamation-triangle'></span><br>Ouch...Search Error!!!<br>".mysqli_error($con);
            }
            echo "                                               
                </tbody>                                
            </table>";
        }

         /* code block to query all user accounts (users table) for search result */
         if(strtolower($srchsrc)=='all accounts'){
            $query = "SELECT * FROM users WHERE (fname LIKE '%$usrq%' OR lname LIKE '%$usrq%' OR email LIKE '%$usrq%' 
            OR uniqueid LIKE '%$usrq%' OR joindate LIKE '%$usrq%' OR addedby LIKE '%$usrq%') AND accttype<10";

            $result = mysqli_query($con,$query);

            if($result){
                echo "
                <table class='table table-responsive table-hover table-striped'>
                    <thead>
                    <tr class='tab-col-hd' style='text-align:center;'>
                        <th>S/No</th>
                        <th>Name</th>                                    
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Account Type</th>
                        <th>Date Added</th>               
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody style='font-size:11px; text-align:center;'>";

                if(mysqli_num_rows($result)==0){
                    echo "<tr><td colspan=8>Your search <em>".$usrq."</em> did not match any records in ".$srchsrc." </td></tr>";
                }else{
                    $sn = 1;                
                    while(($accts = mysqli_fetch_assoc($result)) !== null){
                        $joindate = $accts['joindateraw'];                        
                        echo "
                        <tr class='devitem'>
                            <td>".$sn."</td>
                            <td class='itemname devitemname'>".ucfirst($accts['fname'])." ".ucfirst($accts['lname'])."</td>
                            <td class='devitemtype'><span>".$accts['email']."</span><span class=''><input class='acctuniquenum' id='' type='hidden' value='".$accts['uniqueid']."' /></span></td>
                            <td>".$accts['phone']."</td>
                            <td>";
                            if($accts['accttype']==0){
                                echo "Standard";
                            }else{
                                echo "Administrator";
                            }
                            echo "</td>
                            <td>".date('D, d-M-Y',$joindate)."</td>
                            <td><span id='' class='acctinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='' class='mgset mgacct'>
                            <i class='fa fa-cog'></i></span>&nbsp;";if($_SESSION['logged-in']=='admin' || $_SESSION['logged-in']=='superadmin'){echo "<span id='' class='del acctdel'><i class='fa fa-trash' style='color:orangered;'></i></span>";}echo"</td>
                        </tr>
                        ";
                        $sn++;                        
                    }
                }

            }else{
                echo "<span class='fa fa-exclamation-triangle'></span><br>Ouch...Search Error!!!<br>".mysqli_error($con);
            }
            echo "                                               
                </tbody>                                
            </table>";
        }
        
    }else{
        echo "<script>alert('Search criteria not understood');</script>";
        exit();
    }
    
}

?>