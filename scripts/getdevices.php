<?php    
    require "../assets/conf.php";
    require "../assets/assetmgtconf.php";
    require "../assets/reuse.php";
    require "../lib/plug.php";

    $query = "SELECT * FROM assets";
    $result = mysqli_query($con,$query);
echo "
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
            <tbody style='font-size:11px; text-align:center;'>";
                
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
                            <td><span id='' class='devinfo info'><i class='fa fa-info-circle'></i></span>&nbsp;<span id='' class='mgset mgdev'><i class='fa fa-cog'></i></span>&nbsp;<span id='' class='del devdel'><i class='fa fa-trash' style='color:orangered;'></i></span></td>
                        </tr>
                        ";
                        $sn++;
                    }
                }
    echo "                                               
            </tbody>                                
        </table>
        ";
?>