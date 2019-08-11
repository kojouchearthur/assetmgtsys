"use strict";
//var $ = $.noConflict();
$(document).ready(function() {

    var frms, frmInput, err;

    if (document.getElementsByTagName("form")) {
        var frms = Array.from(document.getElementsByTagName("form"));
    }

    if (document.getElementsByTagName("input")) {
        var frmInput = Array.from(document.getElementsByTagName("input"));
    }

    if (document.getElementsByClassName('err')) {
        var err = Array.from(document.getElementsByClassName('err'));
    }

    addValIn(frmInput);
    addReValid(frmInput);

    var usremail, usr, assttype, purchasedate, assigneddate, asstcost;
    if ($('#asst-useremail,#asst-user')) {
        usremail = $('#asst-useremail');
        usr = $('#asst-user');
        usr.on('keyup keydown change input', function() {
            var usrn;
            if (usr.val().split(' ').length > 1) {
                usrn = usr.val().split(' ');
                usremail.val(usrn[0].toLowerCase() + '.' + usrn[1].toLowerCase() + '@');
            }
        });
    }

    if ($('#asstcost')) {
        asstcost = $('#asstcost');
        asstcost.on('keyup blur change input', function() {
            var cstRegex = /[^0-9|.]/g;
            var astcst = asstcost.val();
            if ((astcst !== "") && (cstRegex.test(astcst))) {
                $(this).val(astcst.trim());
                $(this).val(astcst.replace(/[^0-9|.]/g, ''));
            }
        });
    }

    if (document.getElementById('assttype')) {
        assttype = $('#assttype');
        assttype.change(function() {
            var sInd = this.selectedIndex;
            if (sInd > 0) {
                $('#asst-brand,#asst-model,#asst-serialimei').removeAttr('disabled');
                $('#asst-brand,#asst-model,#asst-serialimei').css('background-color', 'white');
                $('#asstdetails-con').show(1500);
                document.getElementById('extassetnum').placeholder = 'Format: ACI-' + this.options[sInd].value + "-XXXX";
                document.getElementById('assetnum').value = 'ACI-' + this.options[sInd].value + "-XXXX";
                //			$('#assetnum').removeAttr('disabled');
            }
            if ((this.options[sInd].text.startsWith('Laptop')) ||
                (this.options[sInd].text.startsWith('Desktop')) ||
                (this.options[sInd].text.match(/laptop|desktop/gi) ||
                    (this.options[sInd].text == 'Server'))) {
                $('#asst-pcprop-con').slideDown(1500);
            } else {
                $('#asst-pcprop-con').hide(1500);
            }
        });
    }

    if (document.getElementById('purchasedate') && document.getElementById('assigned-date')) {
        purchasedate = $('#purchasedate');
        assigneddate = $('#assigned-date');
        purchasedate.on('blur change input', function() {
            assigneddate.attr("min", purchasedate.val());
        });

        assigneddate.on('blur', function() {
            if (assigneddate.val() < purchasedate.val()) {
                $(this).parent().next().slideDown(500);
                $(this).parent().next().html("<span class='fa fa-exclamation-triangle'></span> Assigned Date cannot be earlier than Purchase date");
            }
        });
    }

    $('#log-form').submit(function(e) {
        e.preventDefault();
        frmHndl($(this), 'POST', 'scripts/dologin.php', function funca(data) {
            $('.frm-chk').html('<div style="vertical-align:center;padding:50;text-align:center;">\
			<i class="fa fa-check fa-3x"></i><br>Logged In Successfully</div>');
            $('.frm-chk').slideDown(1000);
            setTimeout(() => {
                $('.frm-chk').html('<div style="vertical-align:center;padding:50;text-align:center;">\
				<span class="fa fa-spinner fa-spin"></span> Please Wait...</div>');
            }, 2000);
            setTimeout(function() {
                $('body').html(data);
            }, 3000);
        });
    });

    $('#signup-form').submit(function(e) {
        e.preventDefault();
        frmHndl($(this), 'POST', 'scripts/crtact.php', function funca(data) {
            $('#signup-form').find('.frm-chk').html('<span><i class="fa fa-check fa-4x"></i></span><br>' + data + ' Your Account has been created Successfully');
            $('#signup-form').find('.frm-chk').slideDown(1000);
            setTimeout(function() {
                //				$('#signup-form').find('.frm-chk').html(data);
                document.getElementById('signup-form').reset();
            }, 3000);
        });
    });

    $('#adasst-form').submit(function(e) {
        e.preventDefault();
        frmHndl($(this), 'POST', 'scripts/adddevice.php', function funca(data) {
            $('#adasst-form').find('.frm-chk').html(data + '<br>Device and User added Successfully');
            $('#adasst-form').find('.frm-chk').slideDown(1000);
            setTimeout(function() {
                //				$('#adasst-form').find('.frm-chk').html(data);
                document.getElementById('adasst-form').reset();
            }, 3000);
        });
    });

    var adusr, adasst, mgasst, mgusr;

    if (document.getElementById("adusr")) {
        adusr = document.getElementById("adusr");
        adusr.onclick = function() {
            location.href = 'signup.php';
        }
    }

    if (document.getElementById("adasst")) {
        adasst = document.getElementById("adasst");
        adasst.onclick = () => {
            location.href = 'newdevice.php';
        }
    }

    if (document.getElementById("mgusr")) {
        mgusr = document.getElementById("mgusr");
        mgusr.onclick = () => {
            openModAsst("Manage User", "\
			<div class='mgusr-con' id=''>\
			<div class='mgusr-men' id='mgusr-acct'>Manage User Accounts</div><br>\
			<div class='mgusr-men' id='mgusr-asst'>Manage Device User</div>\
			</div>\
			", "");

            $('#mgusr-acct').click(() => {
                location.href = 'useraccts.php';
            });

            $('#mgusr-asst').click(() => {
                location.href = 'assetpanel.php';
            });
        }
    }

    if (document.getElementById('mgasst')) {
        mgasst = document.getElementById('mgasst');
        mgasst.onclick = function() {
            location.href = 'assetpanel.php';
        }
    }

    if (document.getElementById('logout')) {
        var logout = document.getElementById('logout');
        logout.onclick = () => {
            location.href = 'logout.php';
        }
    }

    var sidemenitem = Array.from(document.getElementsByClassName('sidenav-men-item'));
    for (var i = 0; i < sidemenitem.length; i++) {
        sidemenitem[i].onclick = function() {
            var asstHd = $('#asst-det-hd');
            setTitle($(this), asstHd);
            for (var i = 0; i < sidemenitem.length; i++) {
                sidemenitem[i].classList.remove('activemenitem');
            }
            this.classList.add('activemenitem');
        }
    }

    var alldev, devusers, newdev, dashbrd, asstdetcon, asstdetmaincon,
        asstnavbartog, asstdetmain, asstnavbar, alldevsub;
    if ($('#asst-navbar')) {
        asstnavbar = $('#asst-navbar');
    }

    if ($('#asst-navbar-tog')) {
        asstnavbartog = $('#asst-navbar-tog');
    }

    if ($('#alldev-sub') || $('#alldev-sub1')) {
        alldevsub = $('#alldev-sub,#alldev-sub1');
    }

    if ($('#asstdetmain')) {
        asstdetmain = $('#asst-det-main');
        asstdetmaincon = asstdetmain.html();
    }

    if ($('#asst-det-con')) {
        asstdetcon = $('#asst-det-con');
    }

    $('#newdev1').click(() => {
        asstnavbar.slideUp(1000);
        window.location.href = 'newdevice.php';
    });

    asstdetcon.click(() => {
        asstnavbar.slideUp(1000);
    });

    asstnavbartog.click(() => {
        asstnavbar.slideToggle(1000);
    });

    if ($('#alldev,#devusers,#newdev,#dashbrd')) {
        alldev = $('#alldev,#alldev1');
        devusers = $('#devusers,#devusers1');
        newdev = $('#newdev');
        dashbrd = $('#dashbrd,#dashbrd1');
        newdev.click(() => {
            asstnavbar.slideUp(1000);
            alldevsub.slideUp(1000);
            $('#asst-search').css('visibility', 'hidden');
            asstdetmain.css('background-image', 'linear-gradient(to bottom, white, whitesmoke)');
            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
            setTimeout(() => {
                getFile('GET', 'newdevice.php', function funca(data) {
                    var newdat = data.split('<!--Section-->');
                    asstdetmain.css('background-image', 'linear-gradient(to bottom right, #009, #efef, #008, #009)');
                    asstdetmain.html('<br>' + newdat[2] + newdat[8]);
                });
            }, 3000);
        });

        alldev.click(function() {
            asstnavbar.slideUp(1000);
            alldevsub.slideDown(1000);
            $('#asst-search').attr('placeholder', 'Search All Devices')
                .css('visibility', 'visible');
            asstdetmain.css('background-image', 'linear-gradient(to bottom right, whitesmoke, white)');
            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
            setTimeout(() => {
                getFile('GET', 'scripts/getdevices.php', function funca(data) {
                    asstdetmain.html(data);
                    moreAction();
                });
            }, 2000);
        });

        var asgndev = $('#asgndev,#asgndev1');
        var unasgndev = $('#unasgndev,#unasgndev1');

        asgndev.click(function() {
            asstnavbar.slideUp(1000);
            $('#asst-search').attr('placeholder', 'Search Assigned Devices').
            css('visibility', 'visible');
            asstdetmain.css('background-image', 'linear-gradient(to bottom left, whitesmoke, white)');
            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
            setTimeout(() => {
                getFile('GET', 'scripts/getassigneddev.php', function funca(data) {
                    asstdetmain.html(data);
                    moreAction();
                });
            }, 2000);
        });

        unasgndev.click(function() {
            asstnavbar.slideUp(1000);
            $('#asst-search').attr('placeholder', 'Search Unassigned Devices')
                .css('visibility', 'visible');
            asstdetmain.css('background-image', 'linear-gradient(to bottom left, whitesmoke, white)');
            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
            setTimeout(() => {
                getFile('GET', 'scripts/getreturneddev.php', function funca(data) {
                    if (data == '' || data == ' ') {
                        asstdetmain.html('<div style="text-align:center;">There are no unassigned devices at this time.<br>All Devices are in use.</div>');
                    } else {
                        asstdetmain.html(data);
                        moreAction();
                    }
                });
            }, 2000);
        });

        devusers.click(() => {
            asstnavbar.slideUp(1000);
            alldevsub.slideUp(1000);
            $('#asst-search').attr('placeholder', 'Search All Users')
                .css('visibility', 'visible');
            asstdetmain.css('background-image', 'linear-gradient(to bottom left, whitesmoke, white)');
            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
            setTimeout(() => {
                getFile('GET', 'scripts/getusers.php', function funca(data) {
                    asstdetmain.html(data);
                    devUserAction();
                });
            }, 2000);
        });

        dashbrd.click(function() {
            //		window.history.back();
            location.href = 'dashboard.php';
        });
    }

    var devinfo, devdel, mgdev, devname, devasstnum;
    moreAction();

    function moreAction() {
        if ($('.devinfo,.mgdev')) {
            devinfo = $('.devinfo');
            devdel = $('.devdel');
            mgdev = $('.mgdev');

            /** on click action for device info */
            for (var i = 0; i < devinfo.length; i++) {
                devinfo[i].onclick = function() {
                    devname = $(this).parent().parent().find('.devitemname').text();
                    //	var devname = this.parentElement.parentElement.getElementsByClassName('devitemname')[0].innerHTML;
                    devasstnum = $(this).parent().parent().find('.devitemasstnum').text();
                    getFile('GET', 'scripts/deviceinfo.php?devasstnum=' + devasstnum, function funca(data) {
                        openModAsst(devname + " (" + devasstnum + ") - Device Info", data, "<button type='button' class='btn btn-toolbar devinfmore' id='mordevinf' style='color:black;'>More Info</button>");
                        var mordevinf = document.getElementById("mordevinf");
                        mordevinf.onclick = function() {
                            getFile('GET', 'scripts/fulldeviceinfo.php?devasstnum=' + devasstnum, function funca(data) {
                                $('#modal-back').fadeOut(500);
                                setTimeout(() => {
                                    asstdetmain.html(data);
                                }, 2000);
                            });
                        }
                    });
                }
            }

            /** on click action for manage device */
            for (var i = 0; i < mgdev.length; i++) {
                mgdev[i].onclick = function() {
                    devname = $(this).parent().parent().find('.devitemname').text();
                    devasstnum = $(this).parent().parent().find('.devitemasstnum').text();
                    openModAsst(devname + " (" + devasstnum + ") - Manage Device", "\
					<div class='mgdev-con' id=''>\
					<div class='mgdev-men' id='mgdev-reasgn'>Return/ReAssign Device</div><br>\
					<div class='mgdev-men' id='mgdev-devinfo'>Get Full Device Info</div><br>\
					<div class='mgdev-men' id='mgdev-editdev'>Edit Device Info</div>\
					</div>\
					", "");

                    var reasgn = document.getElementById("mgdev-reasgn");
                    reasgn.onclick = function() {
                        getFile('GET', 'scripts/reassign.php?devasstnum=' + devasstnum, function funca(data) {
                            var newdat = data.split('<!--Section-->');
                            $('#modal-back').fadeOut(500);
                            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
                            setTimeout(() => {
                                asstdetmain.css('background-image', 'linear-gradient(to bottom, whitesmoke, white, whitesmoke, dimgray)');
                                asstdetmain.html(newdat[2] + newdat[8]);
                            }, 1000);
                        });
                    }

                    var devinfo = document.getElementById("mgdev-devinfo");
                    devinfo.onclick = function() {
                        getFile('GET', 'scripts/fulldeviceinfo.php?devasstnum=' + devasstnum, function funca(data) {
                            $('#modal-back').fadeOut(500);
                            setTimeout(function() {
                                asstdetmain.html(data);
                            }, 1000);
                        });
                    }
                }
            }
        }
    }

    var retdev, retdevval, retdevvaldat, devuseremail, devasstnum;
    if (document.getElementById('retdat') && document.getElementById('devuseremail') &&
        document.getElementById('devasstnum')) {

        if (document.getElementById('retdev') && document.getElementById('retdevval')) {
            retdev = document.getElementById('retdev');
            retdevval = document.getElementById('retdevval');

            retdevval.onchange = function() {
                if (retdevval.value == '' || retdevval.value == ' ') {
                    alert('You must select a valid date');
                    $('#retdev').attr('disabled', '');
                } else {
                    $('#retdev').removeAttr('disabled');
                    retdevvaldat = retdevval.value;
                }
            }

            retdev.onclick = function() {
                let ctrlgrp = $('#reasgncontents,#crtBtn,#devstock,#devcond');
                getFile('POST', 'scripts/devicehandler.php?devasstnum=' + devasstnum + '&devuseremail=' +
                    devuseremail + '&datereturned=' + retdevvaldat,
                    function funca(data) {
                        var newdat = data.split('`');
                        $('#updt').css('color', 'black')
                            .slideDown(500)
                            .html("<span class='fa fa-spinner fa-spin'></span> Please Wait...");
                        setTimeout(function() {
                            if (newdat[0].includes('Error')) {
                                $('#updt').html(newdat[1]);
                            } else {
                                $('#retdat').html(newdat[1]);
                                $('#assigned-date').attr('min', newdat[2]);
                                $('#updt').html(newdat[0]);
                            }
                            $('#devusertit').html('Last User');
                            ctrlgrp.removeAttr('disabled');
                            /* 						$('#crtbtn-con').html('<button type="submit" id="crtBtn" class="btn btn-success btns btn-block" style="background:navy;float:right;font-size:3 em;">\
                            						<i class="fas fa-folder-plus"></i> ReAssign Device</button>'); */
                        }, 2000);
                        setTimeout(function() {
                            $('#updt').slideUp(1000);
                        }, 4000);
                    });
            }
        }

        devuseremail = document.getElementById('devuseremail').textContent;
        devasstnum = document.getElementById('devasstnum').textContent;

        /* if(document.getElementById('testsold')){
        	alert(document.getElementById('testsold').classList);
        } */

        $('#devcond').click(() => {
            let devstat = $('#devcond').attr('data-devstat');
            let ctrlgrp = $('#reasgncontents,#crtBtn');
            $('#devcond').parent().find('.ams-busy').fadeIn(500);
            getFile('POST', 'scripts/devicehandler.php?assetnum=' + devasstnum + '&devcond=' + devstat, function funca(data) {
                let newdat = data.split('`');
                setTimeout(() => {
                    $('#devcond').attr('data-devstat', newdat[1]);
                    $('#devcondtog').css('color', newdat[2]);
                    $('#devcondtog').html(newdat[3]);
                    if (ctrlgrp.attr('disabled')) {
                        ctrlgrp.removeAttr('disabled');
                    } else {
                        ctrlgrp.attr('disabled', '');
                    }
                    $('#devcond').parent().find('.ams-busy').fadeOut(500);
                }, 1000);
                // alert(data);
            });
        });

        $('#devstock').click(() => {
            if (confirm('Are you sure this device is sold?\nNOTE: You cannot undo this action')) {
                let devstat = $('#devstock').attr('data-devstat');
                let ctrlgrp = $('#reasgncontents,#crtBtn,#devstock,#devcond');
                $('#devstock').parent().find('.ams-busy').fadeIn(500);
                getFile('POST', 'scripts/devicehandler.php?assetnum=' + devasstnum + '&devstock=' + devstat, function funca(data) {
                    let newdat = data.split('`');
                    setTimeout(() => {
                        $('#devstock').attr('data-devstat', newdat[1]);
                        $('#devstocktog').css('color', newdat[2]);
                        $('#devstocktog').html(newdat[3]);
                        if (!(ctrlgrp.attr('disabled'))) {
                            ctrlgrp.attr('disabled', '');
                        }
                        $('#devstock').parent().find('.ams-busy').fadeOut(500);
                    }, 1000);
                    // alert(data);
                });
            }
        });

        $('#reasgnasst-form').submit(function(e) {
            e.preventDefault();
            var assetnum = $('#assetnum').val();
            var asgdat = $('#assigned-date').val();
            var asgdatmax = $('#assigned-date').attr('max');

            frmHndl($(this), 'POST', 'scripts/devicehandler.php?devuseremail=' + devuseremail + '&assetnum=' + assetnum, function funca(data) {
                var newdat = data.split('`');
                $('#reasgnasst-form').find('.frm-chk').html('<span style="color:green;"><i class="fa fa-check fa-3x"></i></span><br>' + newdat[0]);
                $('#reasgnasst-form').find('.frm-chk').slideDown(1000);
                setTimeout(function() {
                    $('#devusertit').html('Current User');
                    $('#devusername').html(newdat[1]);
                    $('#devuseremail').html(newdat[2]);
                    $('#devuserdesignation').html(newdat[3]);
                    $('#devuserlocation').html(newdat[4]);
                    $('#devdateassigned').html(newdat[5]);
                    $('#retdat').html("<div class='input-group input-group-sm' id=''>\
							<span class='input-group-addon'><i class='fa fa-calendar'></i></span>\
							<input type='date' class='form-control' placeholder='' id='retdevval' min='" + asgdat + "'max='" + asgdatmax + "' value='" + asgdatmax + "'>\
							<div class='input-group-btn'><button type='button' id='retdev' class='btn btn-success btn-xs' disabled>\
							<i class='fa fa-check'></i></button></div></div>");
                    $('#crtbtn-con').html('<div type="submit" id="crtBtn" class="btn btn-success btns btn-block" style="background:navy;float:right; font-size:3 em;">\
					<i class="fas fa-folder-plus"></i> ReAssign Device</div>');
                    document.getElementById('reasgnasst-form').reset();
                }, 4000);
            });
        });
    }

    /** On Click Action for Device User Info*/
    var devusrinfo, devusrdel, devusrn, devusrmail, devusrid;

    function devUserAction() {
        if ($('.usrinfo')) {
            devusrinfo = $('.usrinfo');
        }
        if ($('.usrdel')) {
            devusrdel = $('.usrdel');
        }
        for (var i = 0; i < devusrinfo.length; i++) {
            devusrinfo[i].onclick = function() {
                devusrn = $(this).parent().parent().find('.devusrname').text();
                devusrmail = $(this).parent().parent().find('.devusrmail').text();
                devusrid = $(this).parent().parent().find('.devusrid').val();
                getFile('GET', 'scripts/devuserinfo.php?userid=' + devusrid + '&useremail=' + devusrmail, function funca(data) {
                    openModAsst(devusrn + " - User Info", data, "<button type='button' class='btn btn-toolbar devinfmore' id='morusrinf' style='color:black;'>More Info</button>");
                    var morusrinf = document.getElementById('morusrinf');
                    morusrinf.onclick = function() {
                        getFile('GET', 'scripts/fulldevuserinfo.php?userid=' + devusrid + '&useremail=' + devusrmail, function funca(data) {
                            $('#modal-back').fadeOut(500);
                            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
                            setTimeout(() => {
                                asstdetmain.html(data);
                            }, 2000);
                        });
                    }
                });
            }
        }
        for (var i = 0; i < devusrdel.length; i++) {
            devusrdel[i].onclick = function() {
                devusrid = $(this).parent().parent().find('.devusrid').val();
                devusrmail = $(this).parent().parent().find('.devusrmail').text();
                if (confirm('Are you sure this user is no longer with the organization?')) {
                    getFile('POST', 'scripts/devicehandler.php?devuserid=' + devusrid + '&devuseremail=' + devusrmail, function funca(data) {
                        var newdat = data.split("`");
                        openModAsst('Notice', newdat[1], '');
                        setTimeout(() => {
                            getFile('GET', 'scripts/getusers.php', function funca(data) {
                                asstdetmain.html(data);
                                devUserAction();
                            });
                        }, 1000);
                    });
                }
            }
        }
    }

    userAction();
    var allacct, newacct;
    if ($('#allacct') && $('#newacct')) {
        allacct = $('#allacct,#allacct1');
        newacct = $('#newacct,#newacct1');
        allacct.click(() => {
            asstnavbar.slideUp(1000);
            $('#asst-search').attr('placeholder', 'Search All Accounts')
                .css('visibility', 'visible');
            asstdetmain.css('background-image', 'linear-gradient(to bottom left, whitesmoke, white)');
            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
            setTimeout(() => {
                getFile('GET', 'scripts/getuseraccts.php', function funca(data) {
                    asstdetmain.html(data);
                    userAction();
                });
            }, 2000);
        });

        newacct.click(() => {
            location.href = 'signup.php';
        });
    }

    var acctinfo, acctdel, mgacct, acctname, acctuniquenum, acctstatevalue;

    function userAction() {
        if ($('.acctinfo,.acctdel,.mgacct')) {
            acctinfo = $('.acctinfo');
            acctdel = $('.acctdel');
            mgacct = $('.mgacct');
            acctlock();

            /** on click action for user account info */
            for (var i = 0; i < acctinfo.length; i++) {
                acctinfo[i].onclick = function() {
                    acctname = $(this).parent().parent().find('.itemname').text();
                    //	var devname = this.parentElement.parentElement.getElementsByClassName('devitemname')[0].innerHTML;
                    acctuniquenum = $(this).parent().parent().find('.acctuniquenum').val();
                    getFile('GET', 'scripts/acctinfo.php?uniqueid=' + acctuniquenum, function funca(data) {
                        openModAsst(acctname + " - Account Info", data, "<button type='button' class='btn btn-toolbar devinfmore' id='moracctinf' style='color:black;'>More Info</button>");
                        var mordevinf = document.getElementById("moracctinf");
                        mordevinf.onclick = function() {
                            getFile('GET', 'scripts/fullacctinfo.php?uniqueid=' + acctuniquenum, function funca(data) {
                                $('#modal-back').fadeOut(500);
                                asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
                                setTimeout(() => {
                                    asstdetmain.html(data);
                                    acctlock();
                                }, 2000);
                            });
                        }
                    });
                }
            }

            /** on click action to manage user accounts */
            for (var i = 0; i < mgacct.length; i++) {
                mgacct[i].onclick = function() {
                    acctname = $(this).parent().parent().find('.itemname').text();
                    acctuniquenum = $(this).parent().parent().find('.acctuniquenum').val();
                    openModAsst(acctname + " - Manage Account", "\
					<div class='mgdev-con' id=''>\
					<div class='mgdev-men' id='mgacct-acctpwd'>Manage Account</div><br>\
					<div class='mgdev-men' id='mgacct-acctinfo'>View Account Info</div><br>\
					</div>\
					", "");

                    var acctpwd = document.getElementById("mgacct-acctpwd");
                    acctpwd.onclick = function() {
                        getFile('GET', 'scripts/mgacct.php?uniqueid=' + acctuniquenum, function funca(data) {
                            var newdat = data.split('<!--Section-->');
                            $('#modal-back').fadeOut(500);
                            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
                            setTimeout(() => {
                                asstdetmain.css('background-image', 'linear-gradient(to bottom, white, whitesmoke)');
                                asstdetmain.html(newdat[2] + newdat[8]);
                            }, 1000);
                        });
                    }

                    var mgacctinfo = document.getElementById("mgacct-acctinfo");
                    mgacctinfo.onclick = function() {
                        getFile('GET', 'scripts/fullacctinfo.php?uniqueid=' + acctuniquenum, function funca(data) {
                            $('#modal-back').fadeOut(500);
                            asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
                            setTimeout(function() {
                                asstdetmain.html(data);
                                acctlock();
                            }, 1000);
                        });
                    }
                }
            }

            if (document.getElementById('chgpwd-form')) {
                // var newpwd = $('#newpwd'), confnewpwd = $('#confnewpwd');
                acctuniquenum = $('.acctuniquenum').val();
                $('#chgpwd-form').submit(function(e) {
                    e.preventDefault();
                    frmHndl($(this), 'POST', 'scripts/mgaccttask.php?uniqueid=' + acctuniquenum, function funca(data) {
                        $('#chgpwd-form').find('.frm-chk').html('<span style="color:green;"><i class="fa fa-check fa-3x"></i></span><br>' + data);
                        $('#chgpwd-form').find('.frm-chk').slideDown(2000);
                        setTimeout(() => {
                            document.getElementById('chgpwd-form').reset();
                        }, 3000);
                    });
                });
            }

            function acctlock() {
                if (document.getElementById('acctstate')) {
                    var acctstate = document.getElementById('acctstate');
                    acctstate.onclick = function() {
                        $(this).parent().find('.ams-busy').fadeIn(500);
                        acctstatevalue = $('#acctstate').attr('data-state');
                        getFile('POST', 'scripts/mgaccttask.php?uniqueid=' + acctuniquenum + '&acctstate=' + acctstatevalue, function funca(data) {
                            var newdat = data.split('`');
                            setTimeout(() => {
                                $('#acctstate').parent().find('.ams-busy').fadeOut(500, function() {
                                    $('#acctstate').toggleClass('btn-success btn-default');
                                    $('#acctstate').attr('data-state', newdat[2]);
                                    acctstate.innerHTML = newdat[3];
                                });
                            }, 1000);
                        });
                    }
                }
            }
        }
    }

    /* Code block for search */
    var srch;
    if ($('#asst-search')) {
        srch = $('#asst-search');
        srch.on('change input', function() {
            setTimeout(() => {
                var srchval = srch.val().trim();
                var srchsrc = srch.attr('placeholder');
                if (srchval.length > 1) {
                    asstdetmain.html('<div style="text-align:center;"><br><span class="fa fa-spinner fa-spin"></span> Loading Data...</div>');
                    setTimeout(() => {
                        getFile('GET', 'assets/search.php?q=' + srchval + '&dsr=' + srchsrc, function funca(data) {
                            asstdetmain.html(data);
                            userAction();
                            moreAction();
                            devUserAction();
                            // console.log(data);
                            // alert(data);
                        });
                    }, 1000);
                }
            }, 2500);
        });
    }

});