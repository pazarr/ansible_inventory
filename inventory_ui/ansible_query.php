<?php
include "settings.php";
if(isset($_GET['name']) && $_GET['name'] !="" && isset($_GET['q']) && $_GET['q'] !="") {
  switch ($_GET['q']) {
    case "chg_hv":
        $_GET['value'] = $_GET['value'] ?: 'NULL';
        $query = mysqli_query($link,'SELECT host_id from hosts WHERE name="'.$_GET['name'].'"') or die("Error 4.1 ".mysqli_error($Link));
        $host_id = mysqli_fetch_row($query);
        mysqli_query($link,'UPDATE hostvars SET value="'.$_GET['value'].'" WHERE host_id='.$host_id[0].' AND host_var="'.$_GET['hostvar'].'"') or die(" error 4.2  ".mysqli_error($link));

        if(!mysqli_affected_rows($link)) {
          mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id[0].',"'.$_GET['hostvar'].'","'.$_GET['value'].'")') or die(" error 4.3  ".mysqli_error($link));
          mysqli_free_result($query);
          echo "New hostvars has been added";
        }
        else {
          echo "hostvar has been updated";
        }
    break;
    case "chg_gv":
    $_GET['value'] = $_GET['value'] ?: 'NULL';
    $query = mysqli_query($link, 'SELECT group_id FROM hostgroups WHERE name="'.$_GET['name'].'"');
    $group_id = mysqli_fetch_row($query);
    $query = mysqli_query($link, 'SELECT group_id FROM groupvars WHERE group_var="'.$_GET['var'].'" AND group_id='.$group_id[0].'')  or die(" error 4.4  ".mysqli_error($link));
    $isvalid = mysqli_num_rows($query);
    if($isvalid > 0) {
      mysqli_query($link, 'UPDATE groupvars SET value="'.$_GET['value'].'" WHERE group_id='.$group_id[0].' AND group_var="'.$_GET['var'].'" ')  or die(" error 4.5  ".mysqli_error($link));
      echo "UPDATE";
    }
    else {
      mysqli_query($link, 'INSERT INTO groupvars VALUES('.$group_id[0].',"'.$_GET['var'].'","'.$_GET['value'].'") ') or die(" error 4.6  ".mysqli_error($link));
      echo "INSERT";
    }
    break;
        case "chg_pv":
        $query = mysqli_query($link, 'SELECT parent_id FROM parentgroups WHERE name="'.$_GET['name'].'"');
        $parent_id = mysqli_fetch_row($query);
        $query = mysqli_query($link, 'SELECT parent_id FROM parentvars WHERE parent_var="'.$_GET['var'].'" AND parent_id='.$parent_id[0].'')  or die(" error 4.7  ".mysqli_error($link));
        $isvalid = mysqli_num_rows($query);
        if($isvalid > 0) {
          mysqli_query($link, 'UPDATE parentvars SET value="'.$_GET['value'].'" WHERE parent_id='.$parent_id[0].' AND parent_var="'.$_GET['var'].'" ')  or die(" error 4.8  ".mysqli_error($link));
          echo "UPDATE";
        }
        else {
          mysqli_query($link, 'INSERT INTO parentvars VALUES('.$parent_id[0].',"'.$_GET['var'].'","'.$_GET['value'].'") ') or die(" error 4.9  ".mysqli_error($link));
          echo "INSERT";
        }
    break;
    default:
         die('bad wolf');
  }
}
else {
	echo date("Y-m-d G:i:s")." ERROR: Can't regiter!\n";
}
mysqli_close($link);
?>
