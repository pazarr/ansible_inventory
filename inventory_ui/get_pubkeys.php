<?php
include "settings.php";
$html_file ="";
if(isset($_GET['access_group'])) {
    $query = mysqli_query($link,'SELECT pubkey FROM pubkeys WHERE access_group="'.$_GET['access_group'].'"') or die(mysqli_error($link));
    while($row=mysqli_fetch_row($query)) {
      $html_file .= $row[0]."\r\n";
    }
  }
  else {
    $query = mysqli_query($link,'SELECT pubkey FROM pubkeys');
    while($row=mysqli_fetch_row($query)) {
      $html_file .= $row[0]."\r\n";
    }
  }
echo $html_file;
?>
