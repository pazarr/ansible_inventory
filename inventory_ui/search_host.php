<?php
include "settings.php";
include "function.php";
$text = $_POST['text'];
  if($_POST['text']){
  $query = mysqli_query($link, "SELECT * FROM hosts WHERE name LIKE '%$text%' LIMIT 8");
	if(mysqli_num_rows($query)>0){
    echo '<table class = "table table-striped table-hover">';
    while($row = mysqli_fetch_array($query)) {
  		echo '<tr role="button"; onclick=\'document.location = "host_details.php?q='.$row['host_id'].'";\'>';
  		echo '<td>'.$row["name"].'</td>';
  		echo '</tr>';
    }
    echo '</table>';

	}
}
else { die(); }
?>
