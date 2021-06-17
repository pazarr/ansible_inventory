<?php
#
#File: function.php

$html_file = '
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <title>'.$versionnumber.'</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Font Awesome CDN link -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" />
      <script src="https://use.fontawesome.com/1547ee36e3.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.css" />
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/js/bootstrap-select.js"></script>
      <meta name="google-signin-scope" content="profile email">
      <meta name="google-signin-client_id" content="870420787081-41avu7v3pfbhpll8k9714784krvkqpbb.apps.googleusercontent.com">
      <script src="https://apis.google.com/js/platform.js" async defer></script>
      <script type="text/javascript" src="search_host.js"></script>
      <script type="text/javascript" src="search_group.js"></script>
      <script type="text/javascript" src="addfield.js"></script>
      <script type="text/javascript" src="ip_check.js"></script>
      <link rel="stylesheet" href="css/search_group.css" />
      <link rel="stylesheet" href="css/flowing-tables.css" />
   </head>
   <body>
    <nav class="navbar navbar-inverse">
     <div class="container-fluid">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <li class="navbar-brand"><img src="css/'.$logo_name.'" title="Version '.$versionnumber.'">'.$versionnumber.'</li>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="/index.php">Home</a></li>
          <li role="presentation" class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Deploy</a>
                  <ul class="dropdown-menu">
                  <li><a href="addHost.php">addHost</a></li>
                  </ul>
          </li>
          <li><a href="faq.html">FAQ</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin</a>
                <ul class="dropdown-menu">
                  <li class="dropdown-header">Server management</li>
                  <li><a href="sql_admin.php">SQL admin</a></li>
                  <li><a href="/">Ansible admin</a></li>
                  <li class="dropdown-header">Debug tools</li>
                  <li><a href="">Log admin</a></li>
                  <li role="separator" class="divider"></li>
                </ul>
        </li>
        </ul>
      </div>
    </div>
  </nav>';

##Api functions
function generateError($errorMSG) {
  $currTime = date("Y.m.d h:i:s");
  $genOut = array('date' => $currTime, 'Status' => "Error", 'Msg' => $errorMSG);
  return json_encode($genOut);
}

function generateMsg($outputMsg) {
  $currTime = date("Y.m.d h:i:s");
  $genOut = array('date' => $currTime, 'Status' => "OK", 'Msg' => $outputMsg);
  return json_encode($genOut);
}

function addHost($hostname,$hostgroup) {
  global $link;
  $query_hostId = mysqli_query($link, 'SELECT host_id FROM hosts where name="'.$hostname.'"') or die(generateError($link." Connection error 1"));
  $hostId = mysqli_fetch_row($query_hostId);
  $query_groupId = mysqli_query($link, "SELECT group_id FROM hostgroups WHERE group_id=".$hostgroup."") or die(generateError($link." Connection error 2"));
  $hostgroupId = mysqli_fetch_row($query_groupId);
###if the gropu is not valid
  if($hostgroupId[0] != $hostgroup) {
    mysqli_free_result($query_hostId);
    mysqli_free_result($query_groupId);
    die(generateError("Host group id ".$hostgroup." is not valid"));
  }
  if(!empty($hostId[0])) {
    $query_Memberships = mysqli_query($link, "SELECT host_id FROM memberships WHERE host_id=".$hostId[0]." AND group_id=".$hostgroup."");
    $isMember = mysqli_num_rows($query_Memberships);
    if($isMember == 0) {
      mysqli_query($link, "INSERT INTO memberships VALUES(".$hostgroup.",".$hostId[0].")") or die(generateError($link." Connection error 4"));
      mysqli_free_result($query_hostId);
      mysqli_free_result($query_groupId);
      mysqli_free_result($query_Memberships);
      die(generateMsg($hostname." was added to the group"));
    }
    else {
      mysqli_free_result($query_hostId);
      mysqli_free_result($query_groupId);
      mysqli_free_result($query_Memberships);
      die(generateMsg($hostname." is already member of the group"));
    }
  }
  else {
    mysqli_query($link, "INSERT INTO hosts VALUES(0, '".$hostname."')") or die(generateError("Can't add ".$hostname)) or die(generateError($link." Connection error 5"));
    $host_id = mysqli_insert_id($link);
    mysqli_query($link, "INSERT INTO memberships VALUES(".$hostgroup.",".$host_id.")") or die(generateError("Can't add memberships"));
    mysqli_free_result($query_hostId);
    mysqli_free_result($query_groupId);
    die(generateMsg($hostname." has been uploaded with id ".$host_id." and added to group ".$hostgroup));
  }
}

function rmHost($hostname) {
  global $link;
  $query = mysqli_query($link, 'SELECT host_id from hosts WHERE name="'.$hostname.'"');
  $host_id = mysqli_fetch_row($query);
  if(!is_null($host_id[0])) {
    mysqli_query($link, 'DELETE FROM hosts WHERE host_id='.$host_id[0]) or die(generateError($link." Can't connect"));
    die(generateMsg($hostname." has been deleted"));
  }
  die(generateError("host does not exit: ".$hostname));
}

function addHostvar($hostname,$hostvar,$value) {
  global $link;
  $query_hostId = mysqli_query($link, 'SELECT host_id FROM hosts where name="'.$hostname.'"') or die(generateError($link." Connection error 6"));
  $hostId = mysqli_fetch_row($query_hostId);
  $queryResult = mysqli_query($link, 'SELECT value FROM hostvars WHERE host_id='.$hostId[0].' AND host_var="'.$hostvar.'"') or die(generateError($link." Connection error 7"));
  if(mysqli_num_rows($queryResult) == 0) {
    mysqli_query($link, 'INSERT INTO hostvars VALUES('.$hostId[0].', "'.$hostvar.'", "'.$value.'")')  or die(generateError($link." Connection error 8"));
    mysqli_free_result($queryResult);
    die(generateMsg($hosvar." host variable is added"));
  }
  else {
    mysqli_query($link, 'UPDATE hostvars set value="'.$value.'" WHERE host_id='.$hostId[0].' AND host_var="'.$hostvar.'" ');
    mysqli_free_result($queryResult);
    die(generateMsg($hosvar." host variable is updated"));
  }
}

function addGroupvar($groupname,$groupvar,$value) {
  global $link;
  $query_groupId = mysqli_query($link, 'SELECT group_id FROM hostgroups where name="'.$groupname.'"') or die(generateError($link." Connection error 9"));
  $groupId = mysqli_fetch_row($query_groupId);
  $queryResult = mysqli_query($link, 'SELECT value FROM groupvars WHERE group_id='.$groupId[0].' AND group_var="'.$groupvar.'"') or die(generateError($link." Connection error 10"));
  if(mysqli_num_rows($queryResult) == 0) {
    mysqli_query($link, 'INSERT INTO groupvars VALUES('.$groupId[0].', "'.$groupvar.'", "'.$value.'")')  or die(generateError($link." Connection error 11"));
    mysqli_free_result($queryResult);
    die(generateMsg($groupvar." group variable is added"));
  }
  else {
    mysqli_query($link, 'UPDATE groupvars set value="'.$value.'" WHERE group_id='.$groupId[0].' AND group_var="'.$groupvar.'" ');
    mysqli_free_result($queryResult);
    die(generateMsg($groupvar." group variable is updated"));
  }
}

############

?>
