<?php
    session_start();
    require "lib/plug.php";
    require 'assets/conf.php';
    require "assets/assetmgtconf.php";
    require "parts/head.php";
    if(!isset($_SESSION['logged-in'])){
        header("Location: index.php");
    }
    $query = "SELECT * FROM assets";
    $result = mysqli_query($con,$query);
?>
<body id='asstpnl-bod'>
    <div class='' id='asstpnl-con' style=''>
        <?php require "parts/header-in.php"; ?>
        <div class='' style='margin: 0 auto; margin-top: 50px;'>
        <div class='row' style='margin: 0 auto; top: 0px;'>
            <div class='col-md-12' style='margin-left: -15px; padding-left: 0px;'>
                <div id='pnl-con' style=''>
                    <div class='sidenav' id='asst-sidenav' style=''>
                        <div style=''>
                            <div class='sidenav-hd' id='asst-sidenav-hd'></div>
                            <div class='' id='' style=''>
                                <ul class='sidenav-men' id='asst-sidenav-men' style='padding-left: 15px;'>
                                    <li class='sidenav-men-item activemenitem' id='alldev'><a><span class='glyphicon glyphicon-folder-close'></span></a> All Devices</li>
                                    <li class='sidenav-men-item' id='devusers'><a><span class='fas fa-users'></span></a> Device Users</li>
                                    <li class='sidenav-men-item' id='newdev'><a><span class='glyphicon glyphicon-plus-sign'></span> Add New Device</li></a>
                                    <li class='sidenav-men-item' id='dashbrd'><a><span class='glyphicon glyphicon-chevron-left'></span></a> Back to Dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='det-con' id='asst-det-con'>
                        <div class='det-hd' id='asst-det-hd' style=''><span class='glyphicon glyphicon-folder-close'></span> All Devices</div>
                        <div class='det-main' id='asst-det-main'>
                            <!-- Section Content-->
                            <table class='table table-responsive table-hover table-striped'>
                                <thead>
                                  <tr class='tab-col-hd' style='text-align:center;'>
                                    <th>S/No</th>
                                    <th>Name &amp; Model</th>                                    
                                    <th>Description</th>
                                    <th>Device Type</th>
                                    <th>Asset Number</th>
                                    <th>Date Purchased</th>
                                    <th>Current User</th>
                                    <th>Location</th>
                                    <th>Actions</th>
                                  </tr>
                                </thead>
                                <tbody style='font-size:11px;'>
                                    <?php 
                                        if(!$result){
                                            echo "
                                                <tr><td>No Data</td></tr>
                                                ";
                                        }else{
                                            $sn = 1;
                                        //    $asst = mysqli_fetch_assoc($result);
                                            while(($assts = mysqli_fetch_assoc($result)) !== null){
                                                if(count(explode("::",$assts['deviceuserrecord'])) < 2){
                                                    $curdevuserrecord = explode(":",$assts['deviceuserrecord']);
                                                }else{
                                                    $devuserrecord = explode("::",$assts['deviceuserrecord']);
                                                    $curdevuserrecord = explode(":",$devuserrecord[count($devuserrecord) - 1]);
                                                }
                                               
                                                $purchasedate = $assts['purchasedateraw'];
                                                echo "
                                                 <tr>
                                                    <td>".$sn."</td>";
                                                 if(($assts['model'] == 'N/A')||($assts['model'] == '') || ($assts['model']==' ')){
                                                    echo "<td>".$assts['brand']."</td>";
                                                 }else{
                                                    echo "<td>".$assts['brand']." ".$assts['model']."</td>";
                                                 }
                                                 echo "
                                                    <td>".$assts['otherdesc']."</td>
                                                    <td>".$assts['devicetype']."</td>
                                                    <td>".$assts['assetnum']."</td>
                                                    <td>".date('D, d-M-Y',$purchasedate)."</td>
                                                    <td>".$curdevuserrecord[0]."</td>
                                                    <td>".$curdevuserrecord[1]."</td>
                                                    <td><span id='devinfo' class='devinf'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='mgdev' class=''><i class='fa fa-cog'></i></span>&nbsp;<span id='devdel' class='devdelt'><i class='fa fa-trash'></i></span></td>
                                                </tr>
                                                ";
                                                $sn++;
                                            }
                                            
                                        }
                                    ?>                                   
                                </tbody>                                
                            </table>
                            <!--Section Content-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
</body>