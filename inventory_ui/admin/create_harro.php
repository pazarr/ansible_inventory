<?php
#
#
include "settings.php";
include "function.php";
    mysqli_query($link, 'INSERT INTO hostgroups VALUES(0,"'.strtolower($_POST['harro_name']).'","'.$_POST['harro_description'].'")') or die('Error 3.14 '.mysqli_error($link));
    $harro_groupid=mysqli_insert_id($link);
    #Check Additional variables
    $res=mysqli_query($link,'SELECT value FROM ui_vars WHERE ui_var="cds_nagios_groups"');
    $cds_nagios_group=mysqli_fetch_row($res);
    $res=mysqli_query($link,'SELECT value FROM ui_vars WHERE ui_var="def_nagios_groups"');
    $def_nagios_group=mysqli_fetch_row($res);

    #Create jumpbox
    mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.strtolower($_POST['harro_name']).'-jumpbox1")') or die('Error 3.15 '.mysqli_error($link));
    $hostid_jmpbox=mysqli_insert_id($link);
    #Set memberships
    mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_jmpbox.')') or die('Error 3.16 '.mysqli_error($link));
    #Install host variables
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"inst_usage","JUMPBOX")') or die('Error 3.171 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"vpc_name","'.strtolower($_POST['harro_name']).'")') or die('Error 3.172 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.173 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"inst_type","'.$_POST['jmpbox_inst_type'].'")') or die('Error 3.174 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"ami","'.$_POST['jmpbox_ami'].'")') or die('Error 3.175 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"avail_zone","a")') or die('Error 3.176 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"vol_size","'.$_POST['jmpbox_ebs_size'].'")') or die('Error 3.177 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"pub_ip","'.$_POST['jmpbox_pub_ip'].'")') or die('Error 3.178 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"term_protect","'.$_POST['jmpbox_term_protection'].'")') or die('Error 3.179 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"vpc_subnet","pub")') or die('Error 3.180 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"ip_block","'.$_POST['ip_block'].'")') or die('Error 3.181 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"nagios_group","'.$def_nagios_group[0].'")') or die('Error 3.219 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-JUMPBOX",'.$harro_groupid.','.$hostid_jmpbox.')') or die('Error 3.203 '.mysqli_error($link));
    #Create Nagios
    mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.strtolower($_POST['harro_name']).'-nagios")') or die('Error 3.185 '.mysqli_error($link));
    $hostid_nagios=mysqli_insert_id($link);
    #Set memberships
    mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_nagios.')') or die('Error 3.186 '.mysqli_error($link));
    #Install host variables
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"inst_usage","NAGIOS")') or die('Error 3.187 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"vpc_name","'.strtolower($_POST['harro_name']).'")') or die('Error 3.188 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.189 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"inst_type","'.$_POST['jmpbox_inst_type'].'")') or die('Error 3.190 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"ami","'.$_POST['jmpbox_ami'].'")') or die('Error 3.191 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"avail_zone","a")') or die('Error 3.176 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"vol_size","'.$_POST['jmpbox_ebs_size'].'")') or die('Error 3.192 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"pub_ip","no")') or die('Error 3.217 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"term_protect","'.$_POST['jmpbox_term_protection'].'")') or die('Error 3.193 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"vpc_subnet","priv")') or die('Error 3.194 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_nagios.',"nagios_group","'.$def_nagios_group[0].'")') or die('Error 3.220 '.mysqli_error($link));
    mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-NAGIOS",'.$harro_groupid.','.$hostid_nagios.')') or die('Error 3.204 '.mysqli_error($link));

    #Create CDS hosts
    for($i=1;$i<=$_POST['av_zones'];$i++) {
      switch ($i) {
        case 1:
        ##Add pub and priv zones
        mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"pub_zone_a","'.$_POST['pub_zone_a'].'")') or die('Error 3.182 '.mysqli_error($link));
        mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"priv_zone_a","'.$_POST['priv_zone_a'].'")') or die('Error 3.183 '.mysqli_error($link));
        ##ORIGIN1
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$_POST['harro_name'].'-origin1")') or die('Error 3.17'.mysqli_error($link));
          $hostid_origin1=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_origin1.')') or die('Error 3.18 '.mysqli_error($link));
            #Install host variables
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"inst_usage","ORIGIN")') or die('Error 3.19 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"vpc_name","'.strtolower($_POST['harro_name']).'")') or die('Error 3.20 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.21 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"inst_type","'.$_POST['origin_inst_type'].'")') or die('Error 3.22 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"ami","'.$_POST['origin_ami'].'")') or die('Error 3.23 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"avail_zone","a")') or die('Error 3.24 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"vol_size","'.$_POST['origin_ebs_size'].'")') or die('Error 3.25 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"pub_ip","'.$_POST['origin_pub_ip'].'")') or die('Error 3.26 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"term_protect","'.$_POST['origin_term_protection'].'")') or die('Error 3.27 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"vpc_subnet","priv")') or die('Error 3.28 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"lb_id","on")') or die('Error 3.29 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin1.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.221 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-ORIGIN",'.$harro_groupid.','.$hostid_origin1.')') or die('Error 3.205 '.mysqli_error($link));
            ##RECEIVER1
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$_POST['harro_name'].'-receiver1")') or die('Error 3.30'.mysqli_error($link));
          $hostid_receiver1=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_receiver1.')') or die('Error 3.31 '.mysqli_error($link));
           #Install host variable
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"inst_usage","RECEIVER")') or die('Error 3.32 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"vpc_name","'.$_POST['harro_name'].'")') or die('Error 3.33 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.34 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"inst_type","'.$_POST['origin_inst_type'].'")') or die('Error 3.35 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"ami","'.$_POST['origin_ami'].'")') or die('Error 3.36 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"avail_zone","a")') or die('Error 3.37 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"vol_size","'.$_POST['origin_ebs_size'].'")') or die('Error 3.38 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"pub_ip","'.$_POST['origin_pub_ip'].'")') or die('Error 3.39 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"term_protect","'.$_POST['origin_term_protection'].'")') or die('Error 3.40 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"vpc_subnet","priv")') or die('Error 3.41'.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"lb_id","rx")') or die('Error 3.42'.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver1.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.222 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-RECEIVER",'.$harro_groupid.','.$hostid_receiver1.')') or die('Error 3.206 '.mysqli_error($link));
           ##TELEMETRY1
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$_POST['harro_name'].'-telemetry1")') or die('Error 3.43'.mysqli_error($link));
          $hostid_telemetry1=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_telemetry1.')') or die('Error 3.44 '.mysqli_error($link));
            #Install host variable
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"inst_usage","TELEMETRY")') or die('Error 3.45 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"vpc_name","'.$_POST['harro_name'].'")') or die('Error 3.46 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.47 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"inst_type","'.$_POST['telemetry_inst_type'].'")') or die('Error 3.48 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"ami","'.$_POST['telemetry_ami'].'")') or die('Error 3.49 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"avail_zone","a")') or die('Error 3.11 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"vol_size","'.$_POST['telemetry_ebs_size'].'")') or die('Error 3.50 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"pub_ip","'.$_POST['telemetry_pub_ip'].'")') or die('Error 3.51 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"term_protect","'.$_POST['telemetry_term_protection'].'")') or die('Error 3.52 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"vpc_subnet","priv")') or die('Error 3.53 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"lb_id","to")') or die('Error 3.54 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry1.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.223 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-TELEMETRY",'.$harro_groupid.','.$hostid_telemetry1.')') or die('Error 3.207 '.mysqli_error($link));
            ##TELEMETRY API1
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$_POST['harro_name'].'-telemetryapi1")') or die('Error 3.55'.mysqli_error($link));
          $hostid_telemetryapi1=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_telemetryapi1.')') or die('Error 3.56 '.mysqli_error($link));
            #Install host variable
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"inst_usage","TELEMETRYAPI")') or die('Error 3.57 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"vpc_name","'.$_POST['harro_name'].'")') or die('Error 3.58 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.59 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"inst_type","'.$_POST['telemetry_inst_type'].'")') or die('Error 3.60 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"ami","'.$_POST['telemetry_ami'].'")') or die('Error 3.61'.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"avail_zone","a")') or die('Error 3.62'.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"vol_size","'.$_POST['telemetry_ebs_size'].'")') or die('Error 3.63'.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"pub_ip","'.$_POST['telemetry_pub_ip'].'")') or die('Error 3.64'.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"term_protect","'.$_POST['telemetry_term_protection'].'")') or die('Error 3.65 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"vpc_subnet","priv")') or die('Error 3.66'.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"lb_id","tm")') or die('Error 3.67'.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi1.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.224 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-TELEMETRYAPI",'.$harro_groupid.','.$hostid_telemetryapi1.')') or die('Error 3.208 '.mysqli_error($link));
            break;
        case 2:
        ##Add pub and priv zones
        mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"pub_zone_b","'.$_POST['pub_zone_b'].'")') or die('Error 3.184 '.mysqli_error($link));
        mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"priv_zone_b","'.$_POST['priv_zone_b'].'")') or die('Error 3.185 '.mysqli_error($link));
          ##ORIGIN2
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.strtolower($_POST['harro_name']).'-origin2")') or die('Error 3.68'.mysqli_error($link));
          $hostid_origin2=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_origin2.')') or die('Error 3.69'.mysqli_error($link));
            #Install host variables
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"inst_usage","ORIGIN")') or die('Error 3.70'.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"vpc_name","'.$_POST['harro_name'].'")') or die('Error 3.71 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.72 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"inst_type","'.$_POST['origin_inst_type'].'")') or die('Error 3.73 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"ami","'.$_POST['origin_ami'].'")') or die('Error 3.74 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"avail_zone","b")') or die('Error 3.75 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"vol_size","'.$_POST['origin_ebs_size'].'")') or die('Error 3.75 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"pub_ip","'.$_POST['origin_pub_ip'].'")') or die('Error 3.76 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"term_protect","'.$_POST['origin_term_protection'].'")') or die('Error 3.77 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"vpc_subnet","priv")') or die('Error 3.78 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"lb_id","on")') or die('Error 3.79 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin2.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.225 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO child_groups VALUES("'.$_POST['harro_name'].'-ORIGIN",'.$harro_groupid.','.$hostid_origin2.')') or die('Error 3.209 '.mysqli_error($link));
          ##RECEIVER2
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.strtolower($_POST['harro_name']).'-receiver2")') or die('Error 3.80'.mysqli_error($link));
          $hostid_receiver2=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_receiver2.')') or die('Error 3.83 '.mysqli_error($link));
           #Install host variable
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"inst_usage","RECEIVER")') or die('Error 3.84 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"vpc_name","'.strtolower($_POST['harro_name']).'")') or die('Error 3.85 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.86 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"inst_type","'.$_POST['origin_inst_type'].'")') or die('Error 3.87 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"ami","'.$_POST['origin_ami'].'")') or die('Error 3.88 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"avail_zone","b")') or die('Error 3.89 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"vol_size","'.$_POST['origin_ebs_size'].'")') or die('Error 3.90 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"pub_ip","'.$_POST['origin_pub_ip'].'")') or die('Error 3.91 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"term_protect","'.$_POST['origin_term_protection'].'")') or die('Error 3.92 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"vpc_subnet","priv")') or die('Error 3.93 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"lb_id","rx")') or die('Error 3.94 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver2.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.226 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-RECEIVER",'.$harro_groupid.','.$hostid_receiver2.')') or die('Error 3.210 '.mysqli_error($link));
          ##TELEMETRY2
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.strtolower($_POST['harro_name']).'-telemetry2")') or die('Error 3.95'.mysqli_error($link));
          $hostid_telemetry2=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_telemetry2.')') or die('Error 3.96 '.mysqli_error($link));
            #Install host variable
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"inst_usage","TELEMETRY")') or die('Error 3.97 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"vpc_name","'.strtolower($_POST['harro_name']).'")') or die('Error 3.98 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.99 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"inst_type","'.$_POST['telemetry_inst_type'].'")') or die('Error 3.100 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"ami","'.$_POST['telemetry_ami'].'")') or die('Error 3.101 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"avail_zone","b")') or die('Error 3.102 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"vol_size","'.$_POST['telemetry_ebs_size'].'")') or die('Error 3.103 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"pub_ip","'.$_POST['telemetry_pub_ip'].'")') or die('Error 3.104 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"term_protect","'.$_POST['telemetry_term_protection'].'")') or die('Error 3.105 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"vpc_subnet","priv")') or die('Error 3.106 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"lb_id","to")') or die('Error 3.17'.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry2.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.227 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-TELEMETRY",'.$harro_groupid.','.$hostid_telemetry2.')') or die('Error 3.211 '.mysqli_error($link));
          ##TELEMETRYAPI2
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.strtolower($_POST['harro_name']).'-telemetryapi2")') or die('Error 3.108'.mysqli_error($link));
          $hostid_telemetryapi2=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_telemetryapi2.')') or die('Error 3.109 '.mysqli_error($link));
            #Install host variable
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"inst_usage","TELEMETRYAPI")') or die('Error 3.110 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"vpc_name","'.strtolower($_POST['harro_name']).'")') or die('Error 3.111 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.112 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"inst_type","'.$_POST['telemetry_inst_type'].'")') or die('Error 3.113 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"ami","'.$_POST['telemetry_ami'].'")') or die('Error 3.114 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"avail_zone","b")') or die('Error 3.115 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"vol_size","'.$_POST['telemetry_ebs_size'].'")') or die('Error 3.116 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"pub_ip","'.$_POST['telemetry_pub_ip'].'")') or die('Error 3.117 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"term_protect","'.$_POST['telemetry_term_protection'].'")') or die('Error 3.118 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"vpc_subnet","priv")') or die('Error 3.119 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"lb_id","tm")') or die('Error 3.120'.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi2.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.228 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-TELEMETRYAPI",'.$harro_groupid.','.$hostid_telemetryapi2.')') or die('Error 3.212 '.mysqli_error($link));
            break;
        case 3:
        ##Add pub and priv zones
        mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"pub_zone_c","'.$_POST['pub_zone_c'].'")') or die('Error 3.186 '.mysqli_error($link));
        mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_jmpbox.',"priv_zone_c","'.$_POST['priv_zone_c'].'")') or die('Error 3.187 '.mysqli_error($link));
        ##ORIGIN3
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.strtolower($_POST['harro_name']).'-origin3")') or die('Error 3.121'.mysqli_error($link));
          $hostid_origin3=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_origin3.')') or die('Error 3.122 '.mysqli_error($link));
            #Install host variables
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"inst_usage","ORIGIN")') or die('Error 3.123 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"vpc_name","'.strtolower($_POST['harro_name']).'")') or die('Error 3.124 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.125 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"inst_type","'.$_POST['origin_inst_type'].'")') or die('Error 3.126 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"ami","'.$_POST['origin_ami'].'")') or die('Error 3.127 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"avail_zone","c")') or die('Error 3.11 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"vol_size","'.$_POST['origin_ebs_size'].'")') or die('Error 3.128 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"pub_ip","'.$_POST['origin_pub_ip'].'")') or die('Error 3.129 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"term_protect","'.$_POST['origin_term_protection'].'")') or die('Error 3.130 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"vpc_subnet","priv")') or die('Error 3.131 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"lb_id","on")') or die('Error 3.132 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_origin3.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.229 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO child_groups VALUES("'.$_POST['harro_name'].'-ORIGIN",'.$harro_groupid.','.$hostid_origin3.')') or die('Error 3.213 '.mysqli_error($link));
          ##RECEIVER3
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.strtolower($_POST['harro_name']).'-receiver3")') or die('Error 3.133'.mysqli_error($link));
          $hostid_receiver3=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_receiver3.')') or die('Error 3.134 '.mysqli_error($link));
           #Install host variable
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"inst_usage","RECEIVER")') or die('Error 3.135 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"vpc_name","'.strtolower($_POST['harro_name']).'")') or die('Error 3.136 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.137 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"inst_type","'.$_POST['origin_inst_type'].'")') or die('Error 3.138 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"ami","'.$_POST['origin_ami'].'")') or die('Error 3.139 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"avail_zone","c")') or die('Error 3.140 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"vol_size","'.$_POST['origin_ebs_size'].'")') or die('Error 3.141'.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"pub_ip","'.$_POST['origin_pub_ip'].'")') or die('Error 3.142 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"term_protect","'.$_POST['origin_term_protection'].'")') or die('Error 3.143 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"vpc_subnet","priv")') or die('Error 3.144 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"lb_id","rx")') or die('Error 3.145 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_receiver3.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.230 '.mysqli_error($link));
           mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-RECEIVER",'.$harro_groupid.','.$hostid_receiver3.')') or die('Error 3.214 '.mysqli_error($link));
          ##TELEMETRY3
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.strtolower($_POST['harro_name']).'-telemetry3")') or die('Error 3.146'.mysqli_error($link));
          $hostid_telemetry3=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_telemetry3.')') or die('Error 3.147 '.mysqli_error($link));
            #Install host variable
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"inst_usage","TELEMETRY")') or die('Error 3.148 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"vpc_name","'.strtolower($_POST['harro_name']).'")') or die('Error 3.149 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.150 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"inst_type","'.$_POST['telemetry_inst_type'].'")') or die('Error 3.151 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"ami","'.$_POST['telemetry_ami'].'")') or die('Error 3.152 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"avail_zone","c")') or die('Error 3.152 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"vol_size","'.$_POST['telemetry_ebs_size'].'")') or die('Error 3.153 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"pub_ip","'.$_POST['telemetry_pub_ip'].'")') or die('Error 3.154 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"term_protect","'.$_POST['telemetry_term_protection'].'")') or die('Error 3.155 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"vpc_subnet","priv")') or die('Error 3.156 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"lb_id","to")') or die('Error 3.157 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetry3.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.231 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO child_groups VALUES("'.strtolower($_POST['harro_name']).'-TELEMETRY",'.$harro_groupid.','.$hostid_telemetry3.')') or die('Error 3.215 '.mysqli_error($link));
          ##TELEMETRYAPI3
          mysqli_query($link, 'INSERT INTO hosts VALUES(0,"'.$_POST['harro_name'].'-telemetryapi3")') or die('Error 3.158'.mysqli_error($link));
          $hostid_telemetryapi3=mysqli_insert_id($link);
          #Set memberships
          mysqli_query($link, 'INSERT INTO memberships VALUES('.$harro_groupid.','.$hostid_telemetryapi3.')') or die('Error 3.159'.mysqli_error($link));
            #Install host variable
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"inst_usage","TELEMETRYAPI")') or die('Error 3.160 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"vpc_name","'.$_POST['harro_name'].'")') or die('Error 3.161 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"vpc_region","'.$_POST['vpc_region'].'")') or die('Error 3.162 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"inst_type","'.$_POST['telemetry_inst_type'].'")') or die('Error 3.163 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"ami","'.$_POST['telemetry_ami'].'")') or die('Error 3.164 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"avail_zone","c")') or die('Error 3.165 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"vol_size","'.$_POST['telemetry_ebs_size'].'")') or die('Error 3.166 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"pub_ip","'.$_POST['telemetry_pub_ip'].'")') or die('Error 3.167 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"term_protect","'.$_POST['telemetry_term_protection'].'")') or die('Error 3.168 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"vpc_subnet","priv")') or die('Error 3.169 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"lb_id","tm")') or die('Error 3.170 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostid_telemetryapi3.',"nagios_group","'.$cds_nagios_group[0].'")') or die('Error 3.232 '.mysqli_error($link));
            mysqli_query($link, 'INSERT INTO child_groups VALUES("'.$_POST['harro_name'].'-TELEMETRYAPI",'.$harro_groupid.','.$hostid_telemetryapi3.')') or die('Error 3.216 '.mysqli_error($link));
            break;
      }
    }
    mysqli_close($link);
    header( 'Location: hostgroup.php?q='.$harro_groupid.'' );
    die();
?>
