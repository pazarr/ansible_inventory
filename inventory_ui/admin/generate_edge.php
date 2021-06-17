<?php
include "../settings.php";
include "../function.php";

$av_zones = $_POST['av_zones'];
$batch_name = uniqid('batch-'.$_POST['edge_pool'].'-');
$all_var = array("edge_number" => $_POST['edge_number'],
                  "hostgroup" => $_POST['hostgroup'],
                  "edge_pool" => $_POST['edge_pool'],
                  "inst_type" => $_POST['inst_type'],
                  "volume_size" => $_POST['volume_size'],
                  "cds_bin_ver" => $_POST['cds_bin_ver'],
                  "cds_config" => $_POST['cds_config']);
#Create batch as hostgroup
mysqli_query($link, 'INSERT INTO hostgroups VALUES(0,"'.$batch_name.'", "'.$_POST['description'].'")') or die('Error 1.1 '.mysqli_error($link));
$batchId=mysqli_insert_id($link);
#Add localhost to batch
mysqli_query($link, 'INSERT INTO memberships VALUES('.$batchId.',1)') or die('Error 1.2 '.mysqli_error($link));;
foreach($all_var as $edgeVar => $value) {
  mysqli_query($link,'INSERT INTO groupvars VALUES('.$batchId.',"'.$edgeVar.'","'.$all_var[$edgeVar].'")') or die('Error 1.3 '.mysqli_error($link));
}
$countAVZone = count($av_zones);
$loopCount = 1;
$edgeBatch = (int)($all_var['edge_number'] / $countAVZone);
$batchLeftover = ($all_var['edge_number'] % $countAVZone);
foreach($av_zones as $avZone){
  ++$loopCount;
  if($loopCount == $countAVZone) {
    mysqli_query($link, 'INSERT INTO groupvars VALUES('.$batchId.',"'.$avZone.'","'.($edgeBatch + $batchLeftover).'")') or die('Error 1.4 '.mysqli_error($link));
  }
  else {
    mysqli_query($link, 'INSERT INTO groupvars VALUES('.$batchId.',"'.$avZone.'","'.$edgeBatch.'")') or die('Error 1.5 '.mysqli_error($link));
  }
}
    header( 'Location: ../hostgroup.php?q='.$batchId.'' );
?>
