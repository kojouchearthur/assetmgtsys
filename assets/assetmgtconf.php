<?php

$devicetype = array('LAP'=>'Laptop','DSK'=>'Desktop PC (exluding Monitor, Mouse, Keyboard, etc)','MON'=>'Monitor','KBD'=>'Keyboard',
'MSE'=>'Mouse','PTR'=>'Printer','SCN'=>'Scanner','CPR'=>'Photocopier','SVR'=>'Server','ROU'=>'Router','SWT'=>'Switch','HUB'=>'Hub',
'UPS'=>'UPS','PHN'=>'Mobile Phone','TEL'=>'Deskphone','MDM'=>'Internet Modem','MIF'=>'MiFi Device','OTHR'=>'Other Device' );

function getdevicetype($devtype){
    global $devicetype;
    $type='';
    foreach($devicetype as $key => $value){
        $type = getdevicename($key,$value,$devtype);
    }
    return $type;
}

function getdevicename($k,$v,$dv){
    switch ($k) {
        case $dv:
            return $v;
            break;
        
        default:
            return 'Unknown Device';
    }
}
?>