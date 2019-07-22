"use strict";
//var $ = $.noConflict();
$(document).ready(function(){
/* 
	var regForm = '<form class="" id="signup-form" action="" method="">\
                    <div class="" id="">\
                        <h4 class="acct-txt text-center">Enter Your Credentials</h4>\
                        <hr>\
                    </div>\
                    <div class="frm-chk" id=""></div>\
                    <div class="user-con" id="">\
                        <div class="input-group">\
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>\
                            <input class="form-control names" type="text" id="names" name="names" required placeholder="Your Name"/>\
                        </div>\
                        <div class="err txt-err" id="names-err"></div>\
                    </div><br>\
                    <div class="email-con" id="">\
                        <div class="input-group">\
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>\
                            <input class="form-control" type="email" id="email" name="email" required placeholder="Your Email"/>\
                        </div>\
                        <div class="err txt-err" id="email-err"></div>\
                    </div><br>\
                    <div class="phone-con">\
                        <div class="input-group">\
                            <span class="input-group-addon"><i class="fa fa-phone"></i></span>\
                            <input class="form-control" type="tel" id="phone" name="phone" placeholder="Enter Phone (Optional)" />\
                        </div>\
                        <div class="err txt-err" id="phone-err"></div>\
                    </div><br>\
                    <div class="pass-con">\
                        <div class="input-group">\
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>\
                            <input class="form-control" type="password" id="pass" name="pass" placeholder="Enter Password" required />\
                        </div>\
                        <div class="txt-err err" id="pass-err"></div>\
                    </div><br>\
                    <div class="pass-conf-con">\
                        <div class="input-group">\
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>\
                            <input class="form-control re-type" type="password" id="pass-conf" name="pass-conf" placeholder="Enter Password" required />\
                        </div>\
                        <div class="txt-err err" id="pass-conf-err"></div>\
                    </div>\
                    <div class="" id="">\
                        <span class="tip-txt" id="rem-tip-txt">Do not check this on a shared computer</span>\
                        <div class="input-group">\
                            <input class="" id="rem-pass" type="checkbox" /> Remember me <span id="rem-tip" class="tips"><i class="fa fa-info-circle"></i></span>\
                            <span class="input-group-btn">\
                                <button type="submit" id="crtBtn" class="btn btn-success btns" style=""><i class="glyphicon glyphicon-log-in"></i> Sign In </button><br>\
                            </span>\
                        </div>\
                    </div><br>\
                    <!--\
                    <div class="text-center" id="acct-ft">\
                        <span id="acct-ft1" class="text-center acct">New Member? Create Account</span> <span class="" id="rPass"></span>\
                    </div> -->\
				</form>';
				 */
/*			
	var logForm = $("#log-form-con").html();
	var regFormc = $("#reg-form-con");
	var regFormcc;
	var acctFt1 = $("#acct-ft1");
	var rPass = $("#rPass");
	var regFt = 'Already a Member? Sign In';
	
	acctFt1.on("click", flipAll);
*/	
/* 
	var logTxt = "Enter your login details in the form below";
  	var regTxt = 'Fill out the form below to create an account';
	var logFt = 'New Member? Create Account';
	var rPassw = ' | Forgot Password';
	 */
/*	
	function flipAll(){    
		if($("#acct-txt-in").html() == logTxt){
			$("#acct-txt-in").html(regTxt);		
			$("#acct-form-con").html(regFormc.html(regForm));
			$("#acct-ft1").html(regFt);
			rPass.html(" ");
			addPwdToggle();
			addHover();
			var frmInput = Array.from(document.getElementsByTagName("input"));
			var frms = Array.from(document.getElementsByTagName("form"));
			addValIn(frmInput);
			addReValid(frmInput);
			addFrmHndl(frms);
/*		
				$("form").submit(function(){
					frmCheck($(this));
				});
*/
/*
      }else{
				$("#acct-txt-in").html(logTxt);		
        $("#acct-form-con").html(logForm);
				$("#acct-ft1").html(logFt);
				rPass.html(rPassw);
				addPwdToggle();
				addHover();
				var frmInput = Array.from(document.getElementsByTagName("input"));
				var frms = Array.from(document.getElementsByTagName("form"));
				addValIn(frmInput);
				addReValid(frmInput);
				addFrmHndl(frms);
/*		
		$("form").submit(function(){
			alert(errct);
			frmCheck($(this));
		});
*/
/*
      }
    }
*/	
/* 
//	alert($("#pass-show").attr("class"));	
	var psh = "<i class='fa fa-eye'></i>";
	var nsh = "<i class='fa fa-eye-slash'></i>";

	addHover();	
	function addHover(){	
		$("#rem-tip").hover(function(){
			$("#rem-tip-txt").css("visibility","visible")
		},function(){
			$("#rem-tip-txt").css("visibility","hidden")
		});
		
		$("#pass-show,#pass-show0,#pass-show00").hover(function(){
			$("#pass-tip").css("visibility", "visible")
		}, function(){
			$("#pass-tip").css("visibility", "hidden")
		});
	}

	addPwdToggle();
	function addPwdToggle(){
		$("#pass-show,#pass-show0,#pass-show00").on("click", function(){pwdToggle(this);});
	}

	function pwdToggle(e){
		if($(e).hasClass("nsh")){
			$(e).toggleClass("nsh psh");
//		$(e).addClass("psh");
			$(e).html(psh);
			$(e).parent().find("input").attr("type", "text");
			$("#pass-tip").html("Click to hide password");	
		}else{
			$(e).toggleClass("psh nsh");
//		$(e).addClass("nsh");
			$(e).html(nsh);
			$(e).parent().find("input").attr("type","password");
			$("#pass-tip").html("Click to see password");		
		}
	}
	
	var rPassFrm = '<div class="form-con" id="recov-form-con">\
		<form class="" id="rPass-form">\
		<div class="" id="">\
		  <p class="" id="" style="font-size:13px; text-align:center;">Enter your account email address to reset password</p>\
		</div>\
		<div class="frm-chk" id=""></div>\
		<div class="input-group" id="">\
		  <input type="email" class="form-control" id="uemail" name="uemail" placeholder="Email Address" required/>\
		  <span class="input-group-btn" id="">\
		    <button class="btn btn-success btns" id="" type="submit"><i class="fa fa-arrow-right"></i></button>\
		  </span>\
		</div>\
		<div class="err txt-err" id="email-err"></div>\
		</form>\
		</div>';
 */		
/*	
	var rPassElem = ["center","Recover Password",rPassFrm,"&copy; CMS Records"];
	var signIn = ["right","Log In",logForm,"&copy; CMS Records"];
	var crtAcct = ["left","Create Account",regForm,"&copy; CMS Records"];
*/
/* 
	var modalBack = $("#modal-back");
	var modalHd = $('#modal-hd');
	var modalBd = $('#modal-bd');
	var modalFt = $('#modal-ft');
	 */	
//	window.addEventListener("load",addOpenModal);
/*	
	addOpenModal();
	function addOpenModal(){
		document.getElementById("rPass").onclick = function(){
			openModal(rPassElem[0],rPassElem[1],rPassElem[2],rPassElem[3])
			};
		document.getElementById("signin").onclick = function(){
			openModal(signIn[0],signIn[1],signIn[2],signIn[3])
			};
		document.getElementById("signup").onclick = function(){
			openModal(crtAcct[0],crtAcct[1],crtAcct[2],crtAcct[3])
			};
	}	
*/
/* 
	function openModal(origin,hd,bd,ft){		
		modalBack.addClass("modal-"+origin);
		if(modalBack.hasClass("modal-left")){
			modalBack.toggleClass("modal-left modal-right");
			modalBack.show(1200,function(){});
			modalHd.html(hd);
			modalBd.html('<div class="form-con back" id="">' + bd + '</div>');
			modalFt.html(ft);
			addPwdToggle();
			addHover();
			var frms = Array.from(document.getElementsByTagName("form"));
			var frmInput = Array.from(document.getElementsByTagName("input"));
			addValIn(frmInput);
			addReValid(frmInput);
			addFrmHndl(frms);

			modalFt.click(function(){				
				openModal("left",crtAcct[0],crtAcct[1],crtAcct[2]);				
			});

		}else if(modalBack.hasClass("modal-right")){
			modalBack.toggleClass("modal-right modal-left");		
			modalBack.show(1200,function(){});
			modalHd.html(hd);
			modalBd.html('<div class="form-con back" id="">' + bd + '</div>');
			modalFt.html(ft);			
			addPwdToggle();
			addHover();
			var frms = Array.from(document.getElementsByTagName("form"));
			var frmInput = Array.from(document.getElementsByTagName("input"));
			addValIn(frmInput);
			addReValid(frmInput);
			addFrmHndl(frms);
		}else{					
			modalBack.fadeIn(1000, function(){});
			modalHd.html(hd);
			modalBd.html(bd);
			modalFt.html(ft);
			addPwdToggle();
			addHover();
			var frms = Array.from(document.getElementsByTagName("form"));
			var frmInput = Array.from(document.getElementsByTagName("input"));
			addValIn(frmInput);
			addReValid(frmInput);
			addFrmHndl(frms);
		}	
	} */
/*
	var mgusr;
	
	var adusr;
	var adasst;

	if(document.getElementById("adusr")){
		adusr = document.getElementById("adusr");
		adusr.onclick = function(){
			location.href = 'signup.php';
		}
	}
	

	if(document.getElementById("adasst")){
		adasst = document.getElementById("adasst");
		adasst.onclick = function() {
			location.href = 'newdevice.php';
		}
	}
	
*/
/*
	if(document.getElementById("mgusr")){
		mgusr = document.getElementById("mgusr");
		mgusr.onclick = function(){
		openMod("Manage User","\
		<div class='mgusr-con' id=''>\
		<div class='mgusr-men' id='mgusr-sys'>Manage System User</div><br>\
		<div class='mgusr-men' id='mgusr-asst'>Manage Asset/Device User</div>\
		</div>\
		","");
		
		$('#signup-form').submit(function(e){
			e.preventDefault();
			frmHndl($(this), 'POST', 'scripts/crtact.php', function func(data){
				$('#signup-form').find('.frm-chk').html('Account Created Successfully');
				$('#signup-form').html(data);
			});
		});
		
		
		document.getElementById('adusr-sys').onclick = function(){
		modalHd.html("Add New System User");
		modalBd.html("signup.php .form-con");
		var frmInput = Array.from(document.getElementById('form-con').getElementsByTagName("input"));
		addValIn(frmInput);
		alert(frmInput.length);
			
			/*
			getFile("GET","signup.php",function funca(data){			
				openMod("Add System User", load("signup.php form"), "");
			});
			
		}
		}
	}
*/	
	
/* 
	function openMod(hd,bd,ft){
		modalBack.fadeIn(1000, function(){});
		modalHd.html(hd);
		modalBd.html(bd);
		modalFt.html(ft);
		addPwdToggle();
		addHover();
		var frms = Array.from(document.getElementsByTagName("form"));
		var frmInput = Array.from(document.getElementsByTagName("input"));
		addValIn(frmInput);
		addReValid(frmInput);
		addFrmHndl(frms);
	}


	
	window.onclick = function wClose(e){
		if(e.target == document.getElementById('modal-cls')){
			closeModal();
		}
	};
	$('#modal-cls').on("click",closeModal);
	

	function closeModal(){				
		if (modalBack.hasClass("modal-right")){
			modalBack.removeClass("modal-right");
			modalBack.addClass("modal-left");
			modalBack.hide(1000, function(){
			modalBack.removeClass("modal-left");
			addPwdToggle();
			addHover();
			});
		}else if (modalBack.hasClass("modal-left")){
			modalBack.removeClass("modal-left");
			modalBack.addClass("modal-right");
			modalBack.hide(1000, function(){
			modalBack.removeClass("modal-right");
			addPwdToggle();
			addHover();
			});
		}else{
			modalBack.fadeOut(500, function(){});
			addPwdToggle();
			addHover();	
		}			
	} */
/*
	moreAction();
	
	var	devinfo, devdel, mgdev;


	function moreAction(){
		if($('.devinfo,devdel,mgdev')){
			devinfo = Array.from(document.getElementsByClassName('devinfo'));
			devdel = $('.devdel');
			mgdev = $('.mgdev');

			for(var i=0;i<devinfo.length;i++){
				devinfo[i].onclick = function(){
					openMod("Header Test","Body check","");
				//	alert('Info Click');
				};
			}
		}
	}



/*
	var frms = Array.from(document.getElementsByTagName("form"));
	var frmInput = Array.from(document.getElementsByTagName("input"));
	
	for(var i=0; i<frms.length; i++){
		frms[i].onsubmit = function(e){
			e.preventDefault();
			frmHndl($(this));
		};
	}

//	addFrmHndl(frms);
	$('#log-form').submit(function(e){
		e.preventDefault();
		frmHndl($(this), 'POST', 'scripts/dologin.php');
	});

	$('#signup-form').submit(function(e){
		e.preventDefault();
		frmHndl($(this), 'POST', 'scripts/crtact.php');
	});

	addValIn(frmInput);
	addReValid(frmInput);	
*/
});


	
