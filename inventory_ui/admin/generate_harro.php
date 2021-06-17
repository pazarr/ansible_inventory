<?php
include "../settings.php";
include "../function.php";

#Make america great ag...no, make harro name lowercase
$harroname = $_POST['harro_name'];
$harroname = strtolower($harroname);
$avZoneA = $_POST['av_zones'];
$vpc_region = substr("$avZoneA[0]", 0, -1);
echo $vpc_region." - ".$avZoneA;
$res = mysqli_query($link,'SELECT value FROM ui_vars WHERE ui_var="cds_nagios_groups"') or die('Error 1.00 '.mysqli_error($link));;
$cds_nagios_group = mysqli_fetch_row($res);
$res = mysqli_query($link,'SELECT value FROM ui_vars WHERE ui_var="def_nagios_groups"') or die('Error 1.00 '.mysqli_error($link));;
$def_nagios_group = mysqli_fetch_row($res);
#Generate New Parent group
mysqli_query($link, 'INSERT INTO parentgroups VALUES(0,"'.$harroname.'","'.$_POST['harro_description'].'")') or die('Error 1.1 '.mysqli_error($link));
$parent_id=mysqli_insert_id($link);
##Populate parentvars
mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"vpc_name","'.$harroname.'")')or die('Error 1.5 '.mysqli_error($link));
mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"ip_block","'.$_POST['ip_block'].'")')or die('Error 1.5 '.mysqli_error($link));
mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"vpc_region","'.$vpc_region.'")')or die('Error 1.5 '.mysqli_error($link));
mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"vpc_region","'.$avZoneA.'")')or die('Error 1.5 '.mysqli_error($link));

#Generate hostgroups
  mysqli_query($link, 'INSERT INTO hostgroups VALUES(0,"'.$harroname.'-platform","'.$_POST['harro_description'].' - nagios")') or die('Error 1.21 '.mysqli_error($link));
  $group_id = mysqli_insert_id($link);
  mysqli_query($link,'INSERT INTO parent_child VALUES('.$parent_id.','.$group_id.')')or die('Error 1.2.1 '.mysqli_error($link));
  mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$harroname.'-nagiosremote")') or die('Error 1.23 '.mysqli_error($link));
  $nagios_id = mysqli_insert_id($link);
  mysqli_query($link, 'INSERT INTO memberships VALUES('.$group_id.','.$nagios_id.')')or die('Error 1.4 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$nagios_id.',"inst_usage","nagios")')or die('Error 1.31 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$nagios_id.',"inst_type","'.$_POST['jmpbox_inst_type'].'")')or die('Error 1.32 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$nagios_id.',"inst_ami","'.$_POST['jmpbox_ami'].'")')or die('Error 1.33 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$nagios_id.',"inst_pub_ip","no")')or die('Error 1.34 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$nagios_id.',"inst_protect","'.$_POST['jmpbox_term_protection'].'")')or die('Error 1.35 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$nagios_id.',"avail_zone","a")')or die('Error 1.36 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$nagios_id.',"inst_vol_size","'.$_POST['jmpbox_ebs_size'].'")')or die('Error 1.37 '.mysqli_error($link));
  mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$harroname.'-jumpbox")') or die('Error 1.38 '.mysqli_error($link));
  $jumpbox_id = mysqli_insert_id($link);
  mysqli_query($link, 'INSERT INTO memberships VALUES('.$group_id.','.$jumpbox_id.')')or die('Error 1.4 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$jumpbox_id.',"inst_usage","jumpbox")')or die('Error 1.41 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$jumpbox_id.',"inst_type","'.$_POST['jmpbox_inst_type'].'")')or die('Error 1.42 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$jumpbox_id.',"inst_ami","'.$_POST['jmpbox_ami'].'")')or die('Error 1.43 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$jumpbox_id.',"inst_pub_ip","'.$_POST['jmpbox_pub_ip'].'")')or die('Error 1.44 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$jumpbox_id.',"inst_protect","'.$_POST['jmpbox_term_protection'].'")')or die('Error 1.45 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$jumpbox_id.',"avail_zone","a")')or die('Error 1.46 '.mysqli_error($link));
  mysqli_query($link,'INSERT INTO hostvars VALUES('.$jumpbox_id.',"inst_vol_size","'.$_POST['jmpbox_ebs_size'].'")')or die('Error 1.47 '.mysqli_error($link));


##Construct groups array
$hostgroups_array=array("origin","receiver","telemetryapi","telemetry");
##Populate hostgroups
foreach ($hostgroups_array as $hostgroup) {
  mysqli_query($link, 'INSERT INTO hostgroups VALUES(0,"'.$harroname.'-'.$hostgroup.'","'.$_POST['harro_description'].' - '.$hostgroup.'")') or die('Error 1.2 '.mysqli_error($link));
  $group_id = mysqli_insert_id($link);
  mysqli_query($link,'INSERT INTO parent_child VALUES('.$parent_id.','.$group_id.')')or die('Error 1.2.1 '.mysqli_error($link));
###Populate groupvars

##Add Create related hosts
  for($i=1;$i<=$_POST['av_zones'];$i++) {
    $hostname = $harroname."-".$hostgroup."".$i;
    mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$hostname.'")') or die('Error 1.3 '.mysqli_error($link));
    $host_id = mysqli_insert_id($link);
    mysqli_query($link, 'INSERT INTO memberships VALUES('.$group_id.','.$host_id.')')or die('Error 1.4 '.mysqli_error($link));
###Populate hostvars
    $inst_vol_size = $hostgroup."_ebs_size";
    $inst_type = $hostgroup."_inst_type";
    $inst_protect = $hostgroup."_term_protection";
    $inst_ami = $hostgroup."_ami";

#####Jumpbox specific variables
    $hostgroup == "jumpbox" ? $inst_pub_ip="yes" : $inst_pub_ip="no";
    $hostgroup == "jumpbox" ? $inst_subnet="pub" : $inst_pub_ip="priv";
#####Origin specific variables
    $hostgroup == "origin" ? mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"inst_lb_id","on")')or die('Error 1.5 '.mysqli_error($link)) : false;
#####Receiver specific variables
    if ($hostgroup == "receiver") {
      mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"inst_lb_id","rx")')or die('Error 1.6 '.mysqli_error($link));
      $inst_type = "origin_inst_type";
      $inst_ami = "origin_ami";
      $inst_vol_size = "origin_ebs_size";
      $inst_protect = "origin_term_protection";
###Add subnets
      switch($i) {
      case 1:
            mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"priv_zone_a","'.$_POST['priv_zone_a'].'")')or die('Error 1.13 '.mysqli_error($link));
            mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"pub_zone_a","'.$_POST['pub_zone_a'].'")')or die('Error 1.13 '.mysqli_error($link));
            $inst_zone = "a";
      break;
      case 2:
            mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"priv_zone_b","'.$_POST['priv_zone_b'].'")')or die('Error 1.13 '.mysqli_error($link));
            mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"pub_zone_b","'.$_POST['pub_zone_b'].'")')or die('Error 1.13 '.mysqli_error($link));
            $inst_zone = "b";
      break;
      case 3:
            mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"priv_zone_c","'.$_POST['priv_zone_c'].'")')or die('Error 1.13 '.mysqli_error($link));
            mysqli_query($link,'INSERT INTO parentvars VALUES('.$parent_id.',"pub_zone_c","'.$_POST['pub_zone_c'].'")')or die('Error 1.13 '.mysqli_error($link));
            $inst_zone = "c";
      break;
      }
  }
#####TelemetryAPI specific variables
    if ($hostgroup == "telemetryapi") {
      mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"inst_lb_id","tm")')or die('Error 1.7 '.mysqli_error($link));
      $inst_type = "telemetry_inst_type";
      $inst_ami = "telemetry_ami";
      $inst_vol_size = "telemetry_ebs_size";
      $inst_protect = "telemetry_term_protection";
    }
#####Add availablility Zone
    switch($i) {
    case 1:
          $inst_zone = "a";
    break;
    case 2:
          $inst_zone = "b";
    break;
    case 3:
          $inst_zone = "c";
    break;
    }
    mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"inst_usage","'.$hostgroup.'")')or die('Error 1.8 '.mysqli_error($link));
    mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"inst_type","'.$_POST[$inst_type].'")')or die('Error 1.9 '.mysqli_error($link));
    mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"inst_ami","'.$_POST[$inst_ami].'")')or die('Error 1.10 '.mysqli_error($link));
    mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"inst_pub_ip","'.$inst_pub_ip.'")')or die('Error 1.11 '.mysqli_error($link));
    mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"inst_protect","'.$_POST[$inst_protect].'")')or die('Error 1.12 '.mysqli_error($link));
    mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"avail_zone","'.$inst_zone.'")')or die('Error 1.13 '.mysqli_error($link));
    mysqli_query($link,'INSERT INTO hostvars VALUES('.$host_id.',"inst_vol_size","'.$_POST[$inst_vol_size].'")')or die('Error 1.14 '.mysqli_error($link));
  }
}
  #  header( 'Location: ../parents.php?q='.$parent_id.'' );
?>
