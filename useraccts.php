<?php
    session_start();
    require "lib/plug.php";
    require 'assets/conf.php';
    require "assets/assetmgtconf.php";
    require "parts/head.php";
    if(!isset($_SESSION['logged-in'])){
        header("Location: index.php");
    }
    $query = "SELECT * FROM users where (accttype=0 or accttype=1) and blocked=0";
    $query1 = "SELECT * FROM users where (accttype=0 or accttype=1) and blocked=1";
    $query0 = "SELECT * FROM users";

    $result = mysqli_query($con,$query);
    $result1 = mysqli_query($con,$query1);
    $result0 = mysqli_query($con,$query0);
?>
<body id='asstpnl-bod'>
    <div class='' id='asstpnl-con' style=''>
        <?php require "parts/header-in1.php"; ?>
        <div class='' style='margin: 0 auto; margin-top: 50px;'>
        <div id='alrt' style='display:none;'></div>
        <div class='row' style='margin: 0 auto; top: 0px;'>
            <div class='col-md-12' style='margin-left: -15px; padding-left: 0px;'>
                <div id='pnl-con' style=''>
                    <div class='sidenav' id='asst-sidenav' style=''>
                        <div style=''>
                            <div class='sidenav-hd' id='asst-sidenav-hd'></div>
                            <div class='' id='' style=''>
                                <ul class='sidenav-men' id='asst-sidenav-men' style='padding-left: 15px;'>
                                    <li class='sidenav-men-item activemenitem' id='allacct' style='border-bottom: solid gray 0.5px;'>
                                        <a><span class='glyphicon glyphicon-folder-close'></span> All Accounts</a>
                                    </li>
                                    <li class='sidenav-men-item' id='newacct'><a><span class='glyphicon glyphicon-plus-sign'></span> Add New Account</a></li>
                                    <li class='sidenav-men-item' id='dashbrd'><a><span class='glyphicon glyphicon-chevron-left'></span> Back to Dashboard</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class='det-con' id='asst-det-con'>
                        <div class='det-hd-con' id='asst-det-hd-con'>
                            <span class='det-hd' id='asst-det-hd' style='display:block;'><i class='glyphicon glyphicon-folder-close'></i> All Accounts</span>
                            <span id='' style='display:block;float:right;margin-top:-30px;'>
                                <input type='search' id='asst-search' class='form-control' name='s' placeholder='Search All Accounts' style=''>
                            </span>
                        </div>
                        <div class='det-main' id='asst-det-main'>
                            <!-- Section Content-->
                            <table class='table table-responsive table-hover table-striped'>
                                <thead>
                                  <tr class='tab-col-hd' style='text-align:center;'>
                                    <th>S/No</th>
                                    <th>Name</th>                                    
                                    <th>Email</th>
                                    <th>Phone</th>                                    
                                    <th>Account type</th>
                                    <th>Date Added</th>
                                    <th>Actions</th>
                                  </tr>
                                </thead>
                                <tbody style='font-size:11px; text-align:center;'>
                                    <?php 
                                        if(!$result){
                                            echo "
                                                <tr><td colspan=8>Unable to fetch data</td></tr>
                                                ";
                                        }else{
                                            $sn = 1;
                                        //  $asst = mysqli_fetch_assoc($result);
                                            while(($accts = mysqli_fetch_assoc($result)) !== null){
                                                /*
                                                if(count(explode("::",$accts['Accountuserrecord'])) < 2){
                                                    $curdevuserrecord = explode(":",$accts['Accountuserrecord']);
                                                }else{
                                                    $devuserrecord = explode("::",$accts['Accountuserrecord']);
                                                    $curdevuserrecord = explode(":",$devuserrecord[count($devuserrecord) - 1]);
                                                }
                                                */
                                            
                                                $joindate = $accts['joindateraw'];                                                
                                                    echo "
                                                    <tr class='devitem'>
                                                        <td>".$sn."</td>
                                                        <td class='itemname devitemname'>".ucfirst($accts['fname'])." ".ucfirst($accts['lname'])."</td>
                                                        <td class='devitemtype'><span>".$accts['email']."</span><span class=''><input class='acctuniquenum' type='hidden' id='' value='".$accts['uniqueid']."' /></span></td>
                                                        <td>".$accts['phone']."</td>                                                        
                                                        <td>";
                                                        if($accts['accttype']==0){
                                                            echo "Standard";
                                                        }else{
                                                            echo "Adminstrator";
                                                        }
                                                        echo "</td>
                                                        <td>".date('D, d-M-Y',$joindate)."</td>                                                                                          
                                                        <td><span id='' class='acctinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='' class='mgset mgacct'><i class='fa fa-cog'></i></span>&nbsp;";if($_SESSION['logged-in']=='admin' || $_SESSION['logged-in']=='superadmin'){echo "<span id='' class='acctdel del' style='color:orangered;'><i class='fa fa-trash'></i></span>";}echo"</td>
                                                    </tr>
                                                    ";
                                                    $sn++;                                                
                                            }

                                            echo "<tr><td colspan=8><br></td></tr>";
                                            echo "<tr><td colspan=8 style='font-weight:bold;text-align:center;font-size:14px;'>Blocked Accounts</td></tr>";
                                            if(mysqli_num_rows($result1)==0){
                                                echo "<tr><td colspan=8>No Blocked accounts</td></tr>";
                                            }
                                            $snb=1;
                                            while(($acctsb = mysqli_fetch_assoc($result1)) !== null){
                                                $joindate = $acctsb['joindateraw'];
                                                
                                                    echo "
                                                    <tr class='devitem'>
                                                        <td>".$snb."</td>
                                                        <td class='itemname devitemname'>".ucfirst($acctsb['fname'])." ".ucfirst($acctsb['lname'])."</td>
                                                        <td class='devitemtype'><span>".$acctsb['email']."</span><span class=''><input class='acctuniquenum' id='' type='hidden' value='".$acctsb['uniqueid']."' /></span></td>
                                                        <td>".$acctsb['phone']."</td>
                                                        <td>";
                                                        if($acctsb['accttype']==0){
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
                                                    $snb++;
                                                
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