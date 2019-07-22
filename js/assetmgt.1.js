"use strict";
//var $ = $.noConflict();
$(document).ready(function(){
	var frms = Array.from(document.getElementsByTagName("form"));
	var frmInput = Array.from(document.getElementsByTagName("input"));
	var err = Array.from(document.getElementsByClassName('err'));

	$('#log-form').submit(function(e){
		e.preventDefault();
		frmHndl($(this), 'POST', 'scripts/dologin.php', function funca(data){
			$('.frm-chk').html('<div style="vertical-align:center;padding:50;text-align:center;">\
			<i class="fa fa-check fa-3x"></i><br>Logged In Successfully<br>Please Wait...<span class="fa fa-spinner fa-2x fa-spin"></span></div>');
			$('.frm-chk').slideDown(1000);
			setTimeout(function(){
				$('body').html(data);
			}, 4000);
		//	$('#log-form').find(".frm-chk").html("Okay Now<br>"+data);
		//	$('#log-form').find(".frm-chk").slideDown(1000);
		//	alert(data);
		});
	});

	$('#signup-form').submit(function(e){
		e.preventDefault();
/*		
		var errcont = [];
		for(var i=0;i<err.length;i++){
			if((err[i].textContent !== '')||(err[i].textContent !== ' ')||
			(err[i].textContent !== undefined)||(err[i].textContent !== 'undefined')){
				errcont[i] = err[i].textContent;
			}else{
				errcont[i]=' ';
			}
		//	alert(errcont);
		//	alert(err[i].textContent);
		//	alert(err[i].id + " IS " + err[i].textContent);
		}
		if ((errcont=='')||(errcont==' ')||(errcont==undefined)||(errcont=='undefined')){
		//	alert("NO errors" + errcont);
			frmHndl($(this), 'POST', 'scripts/crtact.php', function funca(data){
			$('#signup-form').find('.frm-chk').html('<span><i class="fa fa-check fa-4x"></i></span><br>Account Created Successfully');
			setTimeout(function(){
				$('#signup-form').html(data);
			}, 4000);
			});
		}else{
		//	alert("There's error" + errcont);
			errInd($('.frm-chk'));
			alert(errcont);
		}
//		addFrmCheck(frms);
/*		if($('.err').text()==''||$('.err').text()==undefined||$('.err').text()==' '){
			
//		}else{
			
			*/
//		}
		frmHndl($(this), 'POST', 'scripts/crtact.php', function funca(data){
			$('#signup-form').find('.frm-chk').html('<span><i class="fa fa-check fa-4x"></i></span><br>Account Created Successfully');
			$('#signup-form').find('.frm-chk').slideDown(1000);
			setTimeout(function(){				
				$('#signup-form').find('.frm-chk').html(data);
				document.getElementById('signup-form').reset();				
			}, 4000);
		});
	});

	$('#adasst-form').submit(function(e){
		e.preventDefault();
		frmHndl($(this), 'POST', 'scripts/adddevice.php', function funca(data){
			$('#adasst-form').find('.frm-chk').html('Device and User added Successfully');
			$('#adasst-form').find('.frm-chk').slideDown(1000);
			setTimeout(function(){
//				document.getElementById('adasst-form').reset();
//				$('#adasst-form').html(data);
				$('#adasst-form').find('.frm-chk').html(data);
				document.getElementById('adasst-form').reset();
			}, 5000);
		});
	});

	var usremail;
	var usr;
	
	if($('#asst-useremail,#asst-user')){
		usremail = $('#asst-useremail');
		usr = $('#asst-user');
		usr.on('keyup keydown change input', function(){
			var usrn;
			if(usr.val().split(' ').length>1){
				usrn = usr.val().split(' ');				
				usremail.val(usrn[0].toLowerCase()+'.'+usrn[1].toLowerCase()+'@');
			}
		});
	}
	

	addValIn(frmInput);
	addReValid(frmInput);

	var adusr;
	var adasst;
	var mgasst;
	var assttype;

	if(document.getElementById("adusr")){
		adusr = document.getElementById("adusr");
		adusr.onclick = function(){
			location.href = 'signup.php';
		}
	}

	if(document.getElementById("adasst")){
		adasst = document.getElementById("adasst");
		adasst.onclick = function(){
			location.href = 'newdevice.php';
		}
	}

	if(document.getElementById('mgasst')){
		mgasst = document.getElementById('mgasst');
		mgasst.onclick = function(){
			location.href = 'assetpanel.php';
		}
	}

	if(document.getElementById('assttype')){
		assttype = $('#assttype');
		assttype.change(function(){
			var sInd = this.selectedIndex;
			if(sInd > 0){
				$('#asst-brand,#asst-model,#asst-serialimei').removeAttr('disabled');
				$('#asst-brand,#asst-model,#asst-serialimei').css('background-color','white');
				$('#asstdetails-con').show(1500);
				document.getElementById('assetnum').value = 'ACI-' + this.options[sInd].value + "-XXXX";
	//			$('#assetnum').removeAttr('disabled');
			}
			if((this.options[sInd].text.startsWith('Laptop')) ||
				(this.options[sInd].text.startsWith('Desktop')) || 
				(this.options[sInd].text.match(/laptop|desktop/gi) ||
				(this.options[sInd].text == 'Server'))){
				$('#asst-pcprop-con').slideDown(1500);
			}else{
				$('#asst-pcprop-con').hide(1500);
			}
			//	alert(this.selectedIndex);
		});
	}
	
	var sidemenitem = Array.from(document.getElementsByClassName('sidenav-men-item'));
	for(var i=0;i<sidemenitem.length;i++){
		sidemenitem[i].onclick = function(){
			var asstHd = $('#asst-det-hd');			
			setTitle($(this),asstHd);
			for(var i=0;i<sidemenitem.length;i++){
				sidemenitem[i].classList.remove('activemenitem');
			}
			this.classList.add('activemenitem');
		}
	}

	var alldev;
	var devusers;
	var newdev;
	var dashbrd;
	var asstdetmaincon;

	var asstdetmain;
	if($('#asstdetmain')){
		asstdetmain = $('#asst-det-main');
		asstdetmaincon = asstdetmain.html();
	}

	if($('#alldev,#devusers,#newdev,#dashbrd')){
		alldev = $('#alldev,#alldev1');
		devusers = $('#devusers,#devusers1');
		newdev = $('#newdev');
		dashbrd = $('#dashbrd,#dashbrd1');
		newdev.click(function(){
			getFile('GET','newdevice.php',function funca(data){
				var newdat = data.split('<!--Section-->');
				asstdetmain.css('background-image','linear-gradient(to bottom right, #111, rgba(50,100,150,0.8), #111, rgba(50,100,150,0.8), #111, rgba(50,100,150,0.8), #111)');
				asstdetmain.html(newdat[2] + newdat[8]);				
			});
		});
		
		$('#newdev1').click(function(){
			getFile('GET','newdevice.php',function funca(data){
				var newdat = data.split('<!--Section-->');
				asstdetmain.css('background-image','linear-gradient(to bottom right, #111, #111, rgba(50,100,150,0.8), #111, #111)');
				asstdetmain.html(newdat[2] + newdat[8]);				
			});
		});

		alldev.click(function(){
			getFile('GET','scripts/getdevices.php',function funca(data){
				asstdetmain.css('background-image','linear-gradient(to bottom right, whitesmoke, white)');
				asstdetmain.html(data);
				moreAction();
			});
		});
		
		devusers.click(function(){
			getFile('GET','scripts/getusers.php',function funca(data){
				var newdat;
				asstdetmain.css('background-image','linear-gradient(to bottom left, whitesmoke, white)');
				asstdetmain.html(data);
				moreAction();
			});
		});

		dashbrd.click(function(){
//			window.history.back();
			location.href = 'dashboard.php';
		});
	}

	var devinfo, devdel, mgdev, devname, devasstnum;
	moreAction();

	function moreAction(){
		if($('.devinfo,devdel,mgdev')){
			devinfo = $('.devinfo');
			devdel = $('.devdel');
			mgdev = $('.mgdev');

			/** on click action for device info */
			for(var i=0;i<devinfo.length;i++){
				devinfo[i].onclick = function(){
					devname = $(this).parent().parent().find('.devitemname').html();
				//	var devname = this.parentElement.parentElement.getElementsByClassName('devitemname')[0].innerHTML;
					devasstnum = $(this).parent().parent().find('.devitemasstnum').html();
					getFile('GET','scripts/deviceinfo.php?devasstnum='+devasstnum,function funca(data){
						openModAsst(devname+" ("+devasstnum+") - Device Info",data,"<button type='button' class='btn btn-toolbar devinfmore' id='mordevinf' style='color:black;'>More Info</button>");
						
						var mordevinf = document.getElementById("mordevinf");
						mordevinf.onclick = function(){
							getFile('GET','scripts/fulldeviceinfo.php?devasstnum='+devasstnum,function funca(data){
								$('#modal-back').fadeOut(500);
								setTimeout(() => {
									asstdetmain.html(data);
								}, 3000);
							});							
						}
					});					
				}
			}

			/** on click action for manage device */
			for(var i=0;i<mgdev.length;i++){
				mgdev[i].onclick = function(){
					devname = $(this).parent().parent().find('.devitemname').html();
					devasstnum = $(this).parent().parent().find('.devitemasstnum').html();
					openModAsst(devname+" ("+devasstnum+") - Manage Device","\
					<div class='mgdev-con' id=''>\
					<div class='mgdev-men' id='mgdev-reasgn'>Return/ReAssign Device</div><br>\
					<div class='mgdev-men' id='mgdev-devinfo'>Get Full Device Info</div><br>\
					<div class='mgdev-men' id='mgdev-editdev'>Edit Device Info</div>\
					</div>\
					","");

					var reasgn = document.getElementById("mgdev-reasgn");
					reasgn.onclick = function(){
						getFile('GET','scripts/reassign.php?devasstnum='+devasstnum,function funca(data){
							var newdat = data.split('<!--Section-->');
							$('#modal-back').fadeOut(500);
							
							setTimeout(function(){
						//		asstdetmain.html(data);
								asstdetmain.css('background-image','linear-gradient(to bottom, white, whitesmoke, dimgray)');
								asstdetmain.html(newdat[2] + newdat[8]);
							},1000);						
						});						
					}

					var devinfo = document.getElementById("mgdev-devinfo");
					devinfo.onclick = function(){
						getFile('GET','scripts/fulldeviceinfo.php?devasstnum='+devasstnum,function funca(data){
							$('#modal-back').fadeOut(500);
							setTimeout(function(){
								asstdetmain.html(data);
							},1000);
						});						
					}
				}
			}			
		}
	}

	var retdev, retdevval, retdevvaldat, devuseremail, devasstnum;
	if(document.getElementById('retdev') && document.getElementById('retdevval') && document.getElementById('devuseremail') && document.getElementById('devasstnum')){
		retdev = document.getElementById('retdev');
		retdevval = document.getElementById('retdevval');
		devuseremail = document.getElementById('devuseremail').innerHTML;
		devasstnum = document.getElementById('devasstnum').innerHTML;

		retdevval.onchange = function(){
			if(retdevval.value==''){
				alert('You must select a valid date');
				$('#retdev').attr('disabled','');
			}else{
				$('#retdev').removeAttr('disabled');
				retdevvaldat = retdevval.value;
			}
		}

		retdev.onclick = function (){
			getFile('POST','scripts/devicehandler.php?devasstnum='+devasstnum+'&devuseremail='+devuseremail+'&datereturned='+retdevvaldat,function funca(data){
				var newdat = data.split('`');
				$('#updt').css('color','black')
					.slideDown(1000)
					.html("<span class='fa fa-spinner fa-spin'></span> Please Wait...");
				setTimeout(function(){
	//				$('#retdat').html(newdat[1]);
					if(newdat[0]=='Error'){
						$('#updt').html(newdat[1]);
					}else{
						$('#retdat').html(newdat[1]);
						$('#updt').html(newdat[0]);
					}						
					$('#devusertit').html('Last User');
					$('#crtBtn').removeClass('btn-warning')
						.addClass('btn-success')
						.css('background','navy')
						.html('<i class="fa fa-folder-plus"></i> ReAssign Device ')
						.removeAttr('disabled');
				},2000);
				setTimeout(function(){
					$('#updt').slideUp(1500);
				},3000);
			});
		}

		$('#reasgnasst-form').submit()
	}
	
	
	
	
});