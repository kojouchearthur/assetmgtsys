"use strict";
var err = false;
var error = '<i class="fa fa-exclamation-triangle"></i>';
var chkerr = ' Check Error(s)';
var initPwd;
var subbtn;
var errct = 0;

function vInput(e) {

    function errInd(e) {
        //set and display error message at the top of form
        e.parentsUntil(".form-con", "form").find(".frm-chk").html('<span style="color: red;">' +
            error + '</span><p style="font-size: 14px; color:;">This form contains some error(s)</p>');
        e.parentsUntil(".form-con", "form").find(".frm-chk").slideDown(1000);

        //set the border and border radius of the target element to indicate error
        e.css('border', 'solid orangered 1.5px')
            .css('border-radius', '4px');

        //set and display error message below target element
        e.parent().next().slideDown(1000);
        e.parentsUntil(".form-con", "form").find(":submit,.btns").addClass("btns-err");
        e.parentsUntil(".form-con", "form").find(":submit,.btns").attr("disabled", "");
    }

    subbtn = e.parentsUntil(".form-con", "form").find(":submit,.btns").html();

    e.val(e.val().trim());
    if ((e.attr("required")) && (e.val() == "") || (e.val() == " ")) {
        e.parent().next().html(error + ' This field cannot be empty');
        errInd(e);
        err = true;
    } else {

        if ((e.attr("type") == "text") && (e.attr("required"))) {
            if ((e.val().length < 2)) {
                e.parent().next().html(error + ' Kindly enter real data');
                errInd(e);
                err = true;
            }
        }

        if ((e.attr("type") == "text") && (e.hasClass("names"))) {
            var nam = e.val().split(" ");
            if ((nam.length < 2) || (nam[0].length < 2) || (nam[1].length < 2)) {
                e.parent().next().html(error + ' Kindly enter full name');
                errInd(e);
                err = true;
            }
        }

        if ((e.attr("type") == "password") && (!e.hasClass("re-type"))) {
            if (e.val().length < 6) {
                e.parent().next().html(error + ' Password too short');
                errInd(e);
                err = true;
            } else {
                initPwd = e.val();
            }
        }

        if ((e.attr("type") == "password") && e.hasClass("re-type")) {
            var confPwd = e.val();
            if (confPwd !== initPwd) {
                e.parent().next().html(error + ' Passwords don\'t match');
                errInd(e);
                err = true;
            }
        }

        if ((e.attr("type") == "email")) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if ((!regex.test(e.val())) || ((e.val().length - (e.val().lastIndexOf('.'))) < 3) ||
                (e.val().indexOf('@')) < 2) {
                e.parent().next().html(error + ' Invalid Email Address');
                errInd(e);
                err = true;
            }
        }

        if ((e.attr("type") == "tel")) {
            var phnRegex = /[^0-9|+|\-]/g;
            if ((e.val() !== "") && (e.val().length < 11)) {
                e.parent().next().html(error + ' Check Phone Number length');
                errInd(e);
                err = true;
            }
            if ((phnRegex.test(e.val())) || (e.val().indexOf("+") > 0) ||
                (Math.abs(e.val().indexOf("-")) < 1) || (e.val().endsWith("-"))) {
                e.parent().next().html(error + ' Invalid Phone Number');
                errInd(e);
                err = true;
            }
        }

        if (e.attr("type") == "date" || e.attr("type") == "month") {
            if (e.val() == "" || e.val() == " ") {
                e.parent().next().html(error + " Enter a Valid Date");
                errInd(e);
                err = true;
            }
        }
    }
    return err;
}

function reValid(e) {
    //	if(err == true){
    $("form").find(".frm-chk").slideUp(1000);
    $("form").find(".frm-chk").removeClass("err");
    e.parent().next().slideUp(1000);
    e.css('border', '')
        .css('border-radius', '');
    e.parentsUntil(".form-con", "form").find(":submit").removeClass("btns-err");
    e.parentsUntil(".form-con", "form").find(":submit").removeAttr("disabled");
    //	e.parentsUntil(".form-con","form").find(":submit").html(subbtn);
    err = false;
    //	}
}

function checkKey(ev, e) {
    if (ev.getModifierState('CapsLock')) {
        e.parent().next().slideDown(1000);
        e.parent().next().html("CAPSLock is ON");
    } else {
        e.parent().next().html("");
    }
}

function frmCheck(e) {
    e.preventDefault();
    var input = Array.from(e.find("input"));
    for (var i = 0; i < input.length; i++) {
        vInput($(input[i]));
    }

    if (err == true) {
        return false;
        /*	
        	e.find(".frm-chk").html('<i class="fa fa-check fa-3x"></i>');
        	e.find(".frm-chk").slideDown(1000);
        */
    }
}

function addFrmHndl(e) {
    for (var i = 0; i < e.length; i++) {
        e[i].onsubmit = function(nE) {
            nE.preventDefault();
            frmHndl($(this));
        };
    }
}

function frmHndl(e, mtd, url, func) {
    var sBtn = e.find(":submit").html();
    e.find(":submit").html("<span class=''><i class='fa fa-spinner fa-spin'></i></span> Please Wait...");
    var formData = e.serialize();
    $.ajax({
        type: mtd,
        url: url,
        data: formData
    }).done(function(response) {
        var res = response.split("`");
        if ((res[0].startsWith("Error")) || (response.includes("Unknown Error"))) {
            e.find(".frm-chk").html(res[1]);
            e.find(".frm-chk").slideDown(1000);
        } else {
            func(response);
        }
        //	e.html("<div style='text-align:center;'><span><i class='fa fa-check fa-3x'></i></span><br>Operation Successful" + response+"</div>");	
    }).fail(function(data) {
        alert("Error " + data);
    }).always(function() {
        //alert(typeof(func));
        e.find(":submit").html(sBtn);
    });
}

function addValIn(e) {
    for (var i = 0; i < e.length; i++) {
        e[i].onblur = function() {
            vInput($(this));
        };
        e[i].onkeypress = function() {
            reValid($(this));
        };
        e[i].onkeydown = function() {};
        e[i].onchange = function() {
            reValid($(this));
        };
        e[i].onfocus = function() {
            reValid($(this));
        };
        e[i].oninput = function() {
            reValid($(this));
        }
    }
}

function addReValid(e) {
    /*
    for(var i = 0; i < e.length; i++){
    	e[i].onkeypress = function(){
    		reValid($(this));
    	};
    	e[i].onchange = function(){
    		reValid($(this));
    	};
    	e[i].onfocus = function(){
    		reValid($(this));
    	};
    }
    */
}

function addFrmCheck(e) {
    for (var i = 0; i < e.length; i++) {
        e[i].onsubmit = function() {
            frmCheck($(this));
        };
    }
}


/* //allow only numeric characters
$('input[name="number"]').keyup(function(e){
  if (/\D/g.test(this.value))
  {
    // Filter non-digits from input value.
    this.value = this.value.replace(/\D/g, '');
  }
});

*/

function openModal(origin, hd, bd, ft) {
    modalBack.addClass("modal-" + origin);
    if (modalBack.hasClass("modal-left")) {
        modalBack.toggleClass("modal-left modal-right");
        modalBack.show(1200, function() {});
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
        /*			
        			$("form").submit(function(){
        				frmCheck($(this));
        			});		
        		/*	alert(modalBack.attr("class"));
        				modalFt.click(function(){				
        				openModal("left",crtAcct[0],crtAcct[1],crtAcct[2]);				
        			}); 
        */
    } else if (modalBack.hasClass("modal-right")) {
        modalBack.toggleClass("modal-right modal-left");
        modalBack.show(1200, function() {});
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
        /*			
        			$("form").submit(function(){
        				frmCheck($(this));
        			});		
        		/*	modalFt.click(function(){
        				//alert();
        				openModal("right",signIn[0],signIn[1],signIn[2]);
        			});
        */
    } else {
        modalBack.fadeIn(1000, function() {});
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

        /*			
        	$("form").submit(function(event){
        		event.preventDefault();
        		frmCheck($(this));
        	});		
        */
    }
}

function getFile(mtd, url, func) {
    $.ajax({
        type: mtd,
        url: url
    }).done(function(data) {
        func(data);
    }).fail(function() {
        alert("Unable to get content");
    });
}

function setTitle(sorc, dest) {
    dest.html(sorc.html());
}

if (document.getElementById('modal-back')) {
    var modalBack = $('#modal-back');
    var modalHd = $('#modal-hd');
    var modalCon = $('#modal-con');
    var modalBd = $('#modal-bd');
    var modalFt = $('#modal-ft');
}


function openModAsst(hd, bd, ft) {
    modalBack.fadeIn(1000);
    modalHd.html(hd);
    modalBd.html(bd);
    modalFt.html(ft);
    //	addPwdToggle();
    //	addHover();
    var frms = Array.from(document.getElementsByTagName("form"));
    var frmInput = Array.from(document.getElementsByTagName("input"));
    addValIn(frmInput);
    addReValid(frmInput);
    addFrmHndl(frms);
}

window.onclick = function wClose(e) {
    if (e.target == document.getElementById('modal-cls')) {
        closeModal();
    }
};
$('#modal-cls').on("click", closeModal);


function closeModal() {
    if (modalBack.hasClass("modal-right")) {
        modalBack.toggleClass("modal-right");
        modalBack.addClass("modal-left");
        modalBack.hide(1000, function() {
            modalBack.removeClass("modal-left");
            addPwdToggle();
            addHover();
        });
    } else if (modalBack.hasClass("modal-left")) {
        modalBack.removeClass("modal-left");
        modalBack.addClass("modal-right");
        modalBack.hide(1000, function() {
            modalBack.removeClass("modal-right");
            addPwdToggle();
            addHover();
        });
    } else {
        modalBack.fadeOut(500, function() {});
        addPwdToggle();
        addHover();
    }
}

var psh = "<i class='fa fa-eye'></i>";
var nsh = "<i class='fa fa-eye-slash'></i>";

addHover();

function addHover() {
    $("#rem-tip").hover(function() {
        $("#rem-tip-txt").css("visibility", "visible")
    }, function() {
        $("#rem-tip-txt").css("visibility", "hidden")
    });

    $("#pass-show,#pass-show0,#pass-show00").hover(function() {
        $("#pass-tip").css("visibility", "visible")
    }, function() {
        $("#pass-tip").css("visibility", "hidden")
    });
}

addPwdToggle();

function addPwdToggle() {
    $("#pass-show,#pass-show0,#pass-show00").on("click", function() { pwdToggle(this); });
}

function pwdToggle(e) {
    if ($(e).hasClass("nsh")) {
        $(e).toggleClass("nsh psh");
        //		$(e).addClass("psh");
        $(e).html(psh);
        $(e).parent().find("input").attr("type", "text");
        $("#pass-tip").html("Click to hide password");
    } else {
        $(e).toggleClass("psh nsh");
        //		$(e).addClass("nsh");
        $(e).html(nsh);
        $(e).parent().find("input").attr("type", "password");
        $("#pass-tip").html("Click to see password");
    }
}