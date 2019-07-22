<?php
//  require "assets/assetmgtconf.php";
//  require "assets/conf.php";
echo "
<div class='form-con' id='adasst-form-con-con'>
<div class='adasst-form-con' id='adasst-form-con'>
    <form class='' id='adasst-form' method='' action=''>
        <div class='formcontents' id=''>
            <div class='frm-hd' id=''>
                <h4 class='text-center'>Enter Device Details</h4>
                <hr>
            </div>
            <div class='frm-chk' id=''></div>
            <div class='' id=''>
                <div class='' id='assttype-con'>
                    <div class='input-group' id=''>
                        <span class='input-group-addon ico'>
                            <i class='fa fa-desktop'></i>&nbsp;
                            <i class='fa fa-print'></i>&nbsp;
                            <i class='glyphicon glyphicon-phone'></i>
                        </span>
                        <select class='form-control' id='assttype' name='devicetype' required >
                        ";
                //            <?php
                                echo '<option selected disabled>Select Device Type</option>';
                                foreach ($devicetype as $key => $value) {
                                    echo '<option value=\''.$key.'\'>'.$value.'</option>';
                                }
                           
                        /*  <!--  
                            <option selected disabled>Select Device Type</option>
                            <option value='LAP'> Laptop</option>
                            <option value='DSK'> Desktop PC (excluding Monitor, Mouse, Keyboard, etc)</option>
                            <option value='MON'> Monitor</option>
                            <option value='KBD'> Keyboard</option>
                            <option value='MSE'> Mouse</option>
                            <option value='PRT'> Printer</option>
                            <option value='SCN'> Scanner</option>
                            <option value='CPR'> Photocopier</option>
                            <option value='SVR'> Server</option>
                            <option value='ROU'> Router</option>
                            <option value='SWT'> Switch</option>
                            <option value='HUB'> Hub</option>
                            <option value='UPS'> UPS</option>
                            <option value='PHN'> Mobile Phone</option>
                            <option value='TEL'> Deskphone</option>
                            <option value='MDM'> Internet Modem</option>
                            <option value='MIF'> MiFi Device</option>
                            <option value='OTHR'>Other Device Type</option>
                        -->  ?>*/
echo "                  </select>
                    </div>
                    <div class='err text-err'></div>
                </div><br>
                <div class='' id='asst-brand-con'>
                    <div class='input-group' id=''>
                        <span class='input-group-addon'><i class='fa fa-tachometer-alt'></i></span>
                        <input type='text' list='egBrand' class='form-control' id='asst-brand' name='brand' placeholder='Device Brand, e.g: HP, Samsung, etc' required disabled />
                    </div>
                    <div class='err text-err'></div>
                    <datalist id='egBrand'>
                            <option value='HP'>
                            <option value='IBM'>
                            <option value='Lenovo'>
                            <option value='Tecno'>
                            <option value='Infinix'>
                            <option value='Samsung'>
                            <option value='Nokia'>
                    </datalist>
                </div>
                <div class='' id='asst-model-con'>
                    <div class='input-group' id=''>
                        <span class='input-group-addon'><i class='fas fa-stream'></i></span>
                        <input type='text' class='form-control' id='asst-model' name='model' placeholder='Device Model, e.g Pavilion, Spark, Camon X, etc' required disabled />
                    </div>
                    <div class='err text-err'></div>
                </div>
                <div class='' id='asst-serialimei-con'>
                    <div class='input-group' id=''>
                        <span class='input-group-addon'><i class='glyphicon glyphicon-barcode'></i></span>
                        <input type='text' class='form-control' id='asst-serialimei' name='serialimei' placeholder='Device Serial or IMEI No., e.g 35XXXXXXXXXX, 1254XXXXXX, etc' required disabled />
                    </div>
                    <div class='err text-err'></div>
                </div><br>
                <div class='' id='asst-pcprop-con'>
                    <div class='input-group' id='' style='text-align: justify;'>
                        <span class='input-group-addon ico' style=''>
                            <i class='fa fa-memory'></i>&nbsp;
                            <i class='fa fa-hdd'></i>&nbsp;
                            <i class='fas fa-microchip'></i>
                        </span>
                        <span class=''>
                        <input type='text' class='col-xs-3 input-sm prop' id='asst-ram' name='ram' placeholder='RAM size' />
                        <input type='text' class='col-xs-4 input-sm prop' id='asst-hdd' name='hdd' placeholder='Hard Disk Size' />
                        <input type='text' class='col-xs-5 input-sm prop' id='asst-processor' name='processor' placeholder='Processor' style=''/>
                        </span>
                    </div>
                    <div class='' id=''></div>
                </div>
                <div class='' id='asstdetails-con'>
                    <div class='input-group'>
                        <span class='input-group-addon'><i class='fa fa-edit'></i></span>
                        <textarea type='text' class='form-control' id='asstdetails' name='devicedetails' placeholder='Enter other Device details, E.g. Color, etc' required></textarea>
                    </div>
                    <div class='err text-err'></div>
                    <br>
                </div>                                    
                
                <fieldset>
                    <legend style='font-size: 16px;'>Vendor</legend>
                    <div class='' id='vendor-con'>
                      <div class='' id='vendor-name-con'>
                         <div class='input-group' id=''>
                            <span class='input-group-addon'><i class='fa fa-handshake'></i></span>
                            <input type='text' class='form-control' id='vendor' name='vendor' placeholder='Name of Vendor' required />                                                
                         </div>
                         <div class='err text-err'></div>
                      </div>
                      <div class='' id='vendor-details-con'>
                        <div class='input-group'>
                        <span class='input-group-addon'><i class='fa fa-city'></i></span>
                        <textarea type='text' class='form-control' id='vendordetails' name='vendordetails' placeholder='Enter Vendor Address and other details' required></textarea>
                        </div>
                        <div class='err text-err'></div>
                      </div>
                    </div>
                    <div class='' id='asstcost-con'>
                        <div class='input-group'>
                            <span class='input-group-addon'><i class='fas fa-money-check-alt'></i></span>
                            <input type='text' class='form-control' id='asstcost' name='devicecost' placeholder='Enter Cost of Device' required />
                        </div>
                        <div class='err text-err'></div>
                    </div>
                    
                    <div class='' id='purchase-date-con'>
                        <label class='frm-label' style=''>Date of Purchase: </label>
                        <div class='input-group' id=''>
                            <span class='input-group-addon'><i class='far fa-calendar'></i></span>
                            <input type='date' class='form-control' id='purchasedate' name='purchasedate' placeholder='Enter Date Purchased' value='" .Date("Y-m-d")."' required />
                        </div>
                        <div class='err text-err'></div>
                    </div>
                    <div class='' id='asst-buyer-con'>
                        <div class='input-group'>
                            <span class='input-group-addon'><i class='far fa-handshake'></i></span>
                            <input type='text' class='form-control' id='asst-buyer' name='boughtby' placeholder='Name of Buyer' required />
                        </div>
                        <div class='err text-err'></div>
                    </div>
                    <br>
                </fieldset>
                <fieldset>
                    <legend style='font-size: 16px;'>Device User</legend>
                    <div class='' id=''>
                        <div class='' id='asst-user-con'>
                            <div class='input-group'>
                                <span class='input-group-addon'><i class='fa fa-user'></i></span>
                                <input type='text' class='form-control' id='asst-user' name='deviceuser' placeholder='Device User' required />
                            </div>
                            <div class='err text-err'></div>
                        </div>
                        <div class='' id='asst-userlocation-con'>
                            <div class='input-group'>
                                <span class='input-group-addon'><i class='fa fa-map-marker'></i></span>
                                <input type='text' list='userlocation' class='form-control' id='asst-userlocation' name='deviceuserlocation' placeholder='Enter User Location' required />
                            </div>
                            <div class='err text-err'></div>
                            <datalist id='userlocation'>
                                <option value='Lagos (H/O)'>
                                <option value='Oghara'>
                                <option value='PHC'>
                            </datalist>
                        </div>
                        <div class='' id='asst-userdesignation-con'>
                            <div class='input-group'>
                                <span class='input-group-addon'><i class='fa fa-briefcase'></i></span>
                                <input type='text' class='form-control' id='asst-userdesignation' name='deviceuserdesignation' placeholder='Enter User Designation, e.g GHR, Head Audit, Accountant, etc' required />
                            </div>
                            <div class='err text-err'></div>
                        </div>
                        <div class='' id='assigned-date-con'>
                            <label class='frm-label' style=''>Date Assigned: </label>
                            <div class='input-group'>
                                <span class='input-group-addon'><i class='fa fa-calendar-alt'></i></span>
                                <input type='date' class='form-control' id='assigned-date' name='dateassigned' placeholder='Enter Date User received Device' value='". date("Y-m-d")."' required/>
                            </div>
                            <div class='err text-err'></div>
                        </div>
                        <div class='' id='assetnum-con'>
                            <label class='frm-label' style=''>Asset Number: </label>
                            <div class='input-group'>
                                <span class='input-group-addon'><i class='fa fa-stamp'></i></span>
                                <input type='text' class='form-control' id='assetnum' name='assetnum' placeholder='Enter Asset Number, if any' value='" .siteaccr."-"."' disabled />
                            </div>
                            <div class='err text-err'></div>
                        </div>
                    </div>
                </fieldset><br>
                <div class='' id=''>
                    <div class='input-group'>
                        <span class='input-group-btn'>
                            <button type='submit' id='crtBtn' class='btn btn-success btns btn-block' style='background:navy;float:right; font-size:3 em;'><i class='fa fa-folder-plus'></i> Add Device </button><br>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>";
?>