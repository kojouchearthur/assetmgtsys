<?php
    session_start();
    if(!isset($_SESSION['logged-in'])){
      header('Location: index.php');
    }
    require 'assets/conf.php';
    require 'parts/head.php';
?>
<body id=''>
    <div class='dashcon' id='dshbkg'>
    <?php require 'parts/header.php'; ?>
        <div class='main-con' id='dash-con'>
            <div class='row' id=''>
            </div>
            <div class='row men' id=''>
                <div class='col-sm-3 col-md-4' id='sidemen'>
                    
                    <div class='men-itm frst-men' id='hom-men' style='padding:5px 8px;'>
                        <div class='men-itm-ico' id='' style='background-image:url("<?php echo $logo;?>"); min-height: 100px; min-width:135px; margin-bottom:2px;'>
                            <!-- <i class='fa fa-home fa-4x'></i> -->
                        </div>
                        <p class='men-itm-cap' id=''>
                            Home
                        </p>
                    </div>
                    <div class='men-sidenav' id='dash-sidenav'>
                        <div class='men-itm' id='logout' style='width:30px;height:35px;'>
                            <p class='men-itm-cap'>
                                <span><i class='fas fa-sign-out-alt'></i></span> Log Out
                            </p>
                        </div>
                    </div>
                </div>

                <div class='col-sm-9 col-md-8 men-co-in' id=''>
                    <div class='men-itm men-in' <?php if($_SESSION['logged-in'] == 'superadmin' || $_SESSION['logged-in'] == 'admin'){echo "id='adusr'"; } else {echo "id='' style='background-color:white;opacity:0.2;'";} ?>>
                        <div class='men-itm-ico usr' id=''>
                            <i class='fa fa-user-plus fa-5x'></i>
                        </div>
                        <p class='men-itm-cap' id=''>
                            Add Account
                        </p>
                    </div>
                    
                    <div class='men-itm men-in' id='adasst'>
                        <div class='men-itm-ico' id=''>
                            <i class='fa fa-laptop fa-5x'></i>
                        </div>
                        <p class='men-itm-cap' id=''>
                            Add Asset
                        </p>
                    </div>
                    
                    <div class='men-itm men-in' id='mgusr'>
                        <div class='men-itm-ico usr' id=''>
                            <i class='fa fa-users-cog fa-5x'></i>
                        </div>
                        <p class='men-itm-cap' id=''>
                            Manage Users
                        </p>
                    </div>

                    <div class='men-itm men-in' id='mgasst'>
                        <div class='men-itm-ico' id=''>
                            <i class='fa fa-cog fa-5x slow-fa-spin'></i>
                        </div>
                        <p class='men-itm-cap' id=''>
                            Manage Assets
                        </p>
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
    
    <?php require 'parts/footer.php'; ?>