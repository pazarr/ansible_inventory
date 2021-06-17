<?php
#
#
include "settings.php";
include "function.php";
switch ($_POST['chg_type']) {
    case "chg_hvaddnew":
        mysqli_query($link, 'INSERT INTO hostvars VALUES('.$_POST['host_id'].',"'.strtolower($_POST['host_var']).'","'.$_POST['hv_value'].'")') or die('Error 3.1 '.mysqli_error($link));
        break;
    case "chg_hvdelete":
       mysqli_query($link, 'DELETE FROM hostvars WHERE host_id='.$_POST['host_id'].' AND host_var="'.$_POST['host_var'].'"') or die('Error 3.2 '.mysqli_error($link));
       break;
    case "chg_chgvar":
       mysqli_query($link, 'UPDATE hostvars SET value="'.$_POST['hv_value'].'" WHERE host_id='.$_POST['host_id'].' AND host_var="'.$_POST['host_var'].'"') or die('Error 3.3 '.mysqli_error($link));
       break;
##groupvars
    case "chg_gvaddnew":
        mysqli_query($link, 'INSERT INTO groupvars VALUES('.$_POST['group_id'].',"'.strtolower($_POST['group_var']).'","'.$_POST['gv_value'].'")') or die('Error 3.1 '.mysqli_error($link));
        break;
    case "chg_gvdelete":
       mysqli_query($link, 'DELETE FROM groupvars WHERE group_id='.$_POST['group_id'].' AND group_var="'.$_POST['group_var'].'"') or die('Error 3.2 '.mysqli_error($link));
       break;
    case "chg_chggvar":
       mysqli_query($link, 'UPDATE groupvars SET value="'.$_POST['gv_value'].'" WHERE group_id='.$_POST['group_id'].' AND group_var="'.$_POST['group_var'].'"') or die('Error 3.3 '.mysqli_error($link));
       break;
##EndOfGroupvars
##Parentvars
    case "chg_pvaddnew":
        mysqli_query($link, 'INSERT INTO parentvars VALUES('.$_POST['parent_id'].',"'.strtolower($_POST['parent_var']).'","'.$_POST['pv_value'].'")') or die('Error 3.1 '.mysqli_error($link));
        break;
    case "chg_pvdelete":
       mysqli_query($link, 'DELETE FROM parentvars WHERE parent_id='.$_POST['parent_id'].' AND parent_var="'.$_POST['parent_var'].'"') or die('Error 3.2 '.mysqli_error($link));
       break;
    case "chg_chgpvar":
       mysqli_query($link, 'UPDATE parentvars SET value="'.$_POST['pv_value'].'" WHERE parent_id='.$_POST['parent_id'].' AND parent_var="'.$_POST['parent_var'].'"') or die('Error 3.3 '.mysqli_error($link));
       break;
##EndOfParentvars
##Create/Delete parentgroups
case "create_parentgroup":
 mysqli_query($link, 'INSERT INTO parentgroups VALUES(0,"'.strtolower($_POST['name']).'","'.$_POST['description'].'")') or die('Error 3.10 '.mysqli_error($link));
break;
case "update_parentgroups":
   if(isset($_POST['member_hostgroups'])) {
   mysqli_query($link, 'DELETE FROM parent_child WHERE parent_id='.$_POST['parent_id'].'') or die('Error 3.5 '.mysqli_error($link));
    foreach($_POST['member_hostgroups'] as $group_id) {
      mysqli_query($link, 'INSERT INTO parent_child VALUES('.$_POST['parent_id'].','.$group_id.')') or die('Error 3.6 '.mysqli_error($link));
    }
   }
   if(isset($_POST['parent_description'])) {
     mysqli_query($link, 'UPDATE parentgroups SET description="'.$_POST['parent_description'].'" WHERE parent_id='.$_POST['parent_id'].'') or die('Error 3.7 '.mysqli_error($link));
   }
 break;
case "delete_parentgroup":
  mysqli_query($link, 'DELETE FROM parent_child WHERE parent_id='.$_POST['parent_id'].'') or die('Error 3.8 '.mysqli_error($link));
  mysqli_query($link, 'DELETE FROM parentgroups WHERE parent_id='.$_POST['parent_id'].'') or die('Error 3.9 '.mysqli_error($link));
  header( 'Location: index.php' );
  die();
 break;
##End
    case "update_hostgroups":
       if(isset($_POST['member_host'])) {
       mysqli_query($link, 'DELETE FROM memberships WHERE group_id='.$_POST['group_id'].'') or die('Error 3.5 '.mysqli_error($link));
        foreach($_POST['member_host'] as $host_id) {
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$_POST['group_id'].','.$host_id.')') or die('Error 3.6 '.mysqli_error($link));
        }
       }
       if(isset($_POST['group_description'])) {
         mysqli_query($link, 'UPDATE hostgroups SET description="'.$_POST['group_description'].'" WHERE group_id='.$_POST['group_id'].'') or die('Error 3.7 '.mysqli_error($link));
       }
     break;
    case "delete_hostgroups":
      mysqli_query($link, 'DELETE FROM memberships WHERE group_id='.$_POST['group_id'].'') or die('Error 3.8 '.mysqli_error($link));
      mysqli_query($link, 'DELETE FROM hostgroups WHERE group_id='.$_POST['group_id'].'') or die('Error 3.9 '.mysqli_error($link));
      header( 'Location: index.php' );
      die();
     break;
    case "create_hostvaringroup":
      ##Update existing hostvars
      $query = mysqli_query($link, 'SELECT * FROM hosts WHERE host_id IN (SELECT host_id FROM memberships WHERE group_id='.$_POST['group_id'].') AND host_id IN (SELECT host_id FROM hostvars WHERE host_var="'.$_POST['host_var'].'" )') or die('Error 3.10 '.mysqli_error($link));
      while($row = mysqli_fetch_row($query)) {
       mysqli_query($link, 'UPDATE hostvars SET value="'.$_POST['value'].'" WHERE host_id='.$row[0].' AND host_var="'.$_POST['host_var'].'"') or die('Error 3.11 '.mysqli_error($link));
      }
     ##Create new where it doesn't exist
     $query = mysqli_query($link, 'SELECT * FROM hosts WHERE host_id IN (SELECT host_id FROM memberships WHERE group_id='.$_POST['group_id'].') AND host_id NOT IN (SELECT host_id FROM hostvars WHERE host_var="'.$_POST['host_var'].'" )') or die('Error 3.12 '.mysqli_error($link));
     while($row = mysqli_fetch_row($query)) {
       mysqli_query($link, 'INSERT INTO hostvars VALUES('.$row[0].',"'.strtolower($_POST['host_var']).'", "'.$_POST['value'].'") ') or die('Error 3.13 '.mysqli_error($link));
     }
     break;
    case "create_hostgroup":
     mysqli_query($link, 'INSERT INTO hostgroups VALUES(0,"'.strtolower($_POST['name']).'","'.$_POST['description'].'")') or die('Error 3.10 '.mysqli_error($link));
    break;
    case "delete_hostgroup":
      if($_POST['delete_hosts']) {
        mysqli_query($link,'DELETE FROM hosts WHERE host_id IN (SELECT host_id FROM memberships WHERE group_id='.$_POST['group_id'].')');

      }
      mysqli_query($link,'DELETE FROM hostgroups WHERE group_id='.$_POST['group_id'].'');
      header( 'Location: index.php' );
      die();
     break;
    case "delete_host":
      mysqli_query($link,'DELETE FROM hosts WHERE host_id='.$_POST['host_id'].'') or die('Cant delete host '.mysqli_error($link));;
      header( 'Location: index.php' );
      die();
     break;
    case "add_ui_var":
      mysqli_query($link,'INSERT INTO ui_vars VALUES("'.strtolower($_POST['ui_var']).'","'.$_POST['new_value'].'")') or die('Cant add add UI var '.mysqli_error($link));
     break;
     case "ec_create":
      mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$_POST['ec_hostname'].'")') or die('Error 3.195'.mysqli_error($link));
      $hostid_echost=mysqli_insert_id($link);
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_echost.',"ec_inst_dn","'.$_POST['ec_inst_domain'].'")') or die('Error 3.196 '.mysqli_error($link));
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_echost.',"vpc_region","EveryCity")') or die('Error 3.197 '.mysqli_error($link));
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_echost.',"avail_zone","'.$_POST['ec_inst_location'].'")') or die('Error 3.202 '.mysqli_error($link));
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_echost.',"ec_inst_ip","'.$_POST['ec_inst_ip'].'")') or die('Error 3.198 '.mysqli_error($link));
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_echost.',"ec_inst_cpu","'.$_POST['ec_inst_cpu'].'")') or die('Error 3.199 '.mysqli_error($link));
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_echost.',"ec_inst_mem","'.$_POST['ec_inst_memory'].'")') or die('Error 3.200 '.mysqli_error($link));
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_echost.',"ec_inst_disk","'.$_POST['ec_inst_disk'].'")') or die('Error 3.201 '.mysqli_error($link));
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_echost.',"inst_type","'.$_POST['inst_type'].'")') or die('Error 3.201 '.mysqli_error($link));
      mysqli_close($link);
      header( 'Location: host_details.php?q='.$hostid_echost.'' );
      die();
      break;
    case "add_new_host":
      mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$_POST['host_name'].'")') or die('Error 3.195'.mysqli_error($link));
      $hostid_host=mysqli_insert_id($link);
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_host.',"ansible_host","'.$_POST['ip_addr'].'")') or die('Error 3.203 '.mysqli_error($link));
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_host.',"alert_priority","'.$_POST['alert_priority'].'")') or die('Error 3.206 '.mysqli_error($link));
      mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_host.',"runtime_env","'.$_POST['runtime_env'].'")') or die('Error 3.205 '.mysqli_error($link));
      foreach($_POST['hostgroup'] as $group_id) {
        mysqli_query($link, 'INSERT INTO memberships VALUES('.$group_id.','.$hostid_host.')') or die('Error 3.204 '.mysqli_error($link));
      }
      header( 'Location: host_details.php?q='.$hostid_host.'');
      die();
      break;
   default:
        die('bad wolf');
}
mysqli_close($link);
header( 'Location: '.$_SERVER['HTTP_REFERER'].'' );
die();
?>
