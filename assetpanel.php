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
                                    <li class='sidenav-men-item activemenitem' id='alldev' style='border-bottom: solid gray 0.5px;'>
                                        <a><span class='glyphicon glyphicon-folder-close'></span> All Devices</a>
                                    </li>
                                    <li id='alldev-sub' class='sidenavsubmen' style=''>
                                        <ul class='sidenav-men'>
                                            <li class='sidenav-men-item sidenav-sub-item' id='asgndev'><a><span class='fas fa-cookie'></span> Assigned Devices</a></li>
                                            <li class='sidenav-men-item sidenav-sub-item' id='unasgndev'><a><span class='fas fa-cookie-bite'></span> Unassigned Devices</a></li>
                            <!--            <li class='sidenav-men-item'><a>Sub Item 3</a></li>  -->
                                        </ul>
                                    </li>
                                    <li class='sidenav-men-item' id='devusers'><a><span class='fas fa-users'></span></a> Device Users</li>
                                    <li class='sidenav-men-item' id='newdev'><a><span class='glyphicon glyphicon-plus-sign'></span> Add New Device</a></li>
                                    <li class='sidenav-men-item' id='dashbrd'><a><span class='glyphicon glyphicon-chevron-left'></span> Back to Dashboard</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='det-con' id='asst-det-con'>
                        <div class='det-hd-con' id='asst-det-hd-con'>
                            <span class='det-hd' id='asst-det-hd' style='display:block;'><i class='glyphicon glyphicon-folder-close'></i> All Devices</span>
                            <span id='' style='display:block;float:right;margin-top:-30px;'>
                                <input type='search' id='asst-search' class='form-control search-box' name='s' placeholder='Search All Devices' style='' />
                            </span>
                        </div>
                        <div class='det-main' id='asst-det-main'>
                            <!-- Section Content-->
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
                                <tbody style='font-size:11px; text-align:center;'>
                                    <?php 
                                        if(!$result){
                                            echo "
                                                <tr><td>Unable to fetch data</td></tr>
                                                ";
                                        }else{
                                            $sn = 1;
                                        //  $asst = mysqli_fetch_assoc($result);
                                            while(($assts = mysqli_fetch_assoc($result)) !== null){
                                                if(count(explode("::",$assts['deviceuserrecord'])) < 2){
                                                    $curdevuserrecord = explode(":",$assts['deviceuserrecord']);
                                                }else{
                                                    $devuserrecord = explode("::",$assts['deviceuserrecord']);
                                                    $curdevuserrecord = explode(":",$devuserrecord[count($devuserrecord) - 1]);
                                                }
                                                $devcond = $devstock = '';
                                                
                                                $ret = $retstyl = $retstylnd = '';

                                                if($assts['healthy']==0){
                                                    $devcond = '<span class="label label-danger">Faulty</span>';
                                                    $retstyl = '<em>';
                                                    $retstylnd = '</em>';
                                                }

                                                if($assts['sold']==1){
                                                    $devstock = '<span class="label label-info">Sold</span>';
                                                    $retstyl = '<em>';
                                                    $retstylnd = '</em>';
                                                }

                                                if($assts['assigned']==0){                                                    
                                                    if($assts['healthy']==1 && $assts['sold']==0){
                                                        $ret = '<span class="label label-default">Unassigned</span>';
                                                    }else{
                                                        $ret = '';
                                                    }
                                                    $retstyl = '<em>';
                                                    $retstylnd = '</em>';
                                                }

                                                $purchasedate = $assts['purchasedateraw'];
                                                echo "
                                                <tr class='devitem'>
                                                    <td>".$retstyl.$sn."<br>".$ret." ".$devcond." ".$devstock.$retstylnd."</td>";
                                                if(($assts['model'] == 'N/A')||($assts['model'] == '') || ($assts['model']==' ')){
                                                    echo "<td class='devitemname'>".$retstyl.$assts['brand'].$retstylnd."</td>";
                                                }else{
                                                    echo "<td class='devitemname'>".$retstyl.$assts['brand']." ".$assts['model'].$retstylnd."</td>";
                                                }
                                                echo "
                                                    <td class='devitemtype'>".$retstyl.$assts['devicetype'].$retstylnd."</td>";
                                                if(($assts['processor']=='N/A')||($assts['processor']=='')){
                                                    echo "<td>".$retstyl.$assts['otherdesc'].$retstylnd."</td>";
                                                }else{
                                                    echo "<td>".$retstyl.$assts['processor'].", <br>".$assts['otherdesc'].$retstylnd."</td>";
                                                }
                                                echo "
                                                    <td class='devitemasstnum'>".$retstyl.$assts['assetnum'].$retstylnd."</td>
                                                    <td>".$retstyl.date('D, d-M-Y',$purchasedate).$retstylnd."</td>
                                                    <td>".$retstyl.$curdevuserrecord[0].$retstylnd."</td>
                                                    <td>".$retstyl.$curdevuserrecord[4].$retstylnd."</td>
                                                    <td><span id='' class='devinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='' class='mgset mgdev'><i class='fa fa-cog'></i></span>&nbsp;<span id='' class='devdel del' style='color:orangered;'><i class='fa fa-trash'></i></span></td>
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
        <!--Begin Modals-->
	<div class='modals' id='modal-back'>
		<div class='' id='modal-con'>
			<div class='' id='modal-hs'>
				<span id='modal-hd'></span>
				<span id='modal-cls'> <i class='fa fa-times'></i> </span>			  
			</div>
			<div class='' id='modal-bd'>
			</div>
			<div>
				<div class='' id='modal-ft'>
				</div>
			</div>
		</div>
	</div>
    <!--End Modals-->
</body>