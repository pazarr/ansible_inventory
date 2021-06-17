<?php
include "settings.php";
include "function.php";
if(empty($_GET)) {
  die(generateError("Missing parameter from the URI"));
}

switch ($_GET['q']) {
  case 'addHost':
    if(isset($_GET['hostname']) && isset($_GET['group'])) {
      addHost($_GET['hostname'],$_GET['group']);
    }
    else {
      die(generateError("Not valid URI"));
    }
    break;
  case 'removeHost':
    if(isset($_GET['hostname'])) {
      rmHost($_GET['hostname']);
    }
    else {
      die(generateError("Not valid URI"));
    }
    break;
  case 'addHostvar':
    if(isset($_GET['hostname']) && isset($_GET['hostvar']) && isset($_GET['value'])) {
      addHostvar($_GET['hostname'],$_GET['hostvar'],$_GET['value']);
    }
    else {
      die(generateError("Not valid URI"));
    }
    break;
    case 'rmFromGroup':
      if(isset($_GET['hostname']) && isset($_GET['group'])) {
        rmFromGroup($_GET['hostname'],$_GET['group']);
      }
      else {
        die(generateError("Not valid URI"));
      }
      break;
  case 'addGroupvar':
    if(isset($_GET['groupname']) && isset($_GET['groupvar']) && isset($_GET['value'])) {
      addGroupvar($_GET['groupname'],$_GET['groupvar'],$_GET['value']);
    }
    else {
      die(generateError("Not valid URI"));
    }
    break;
  default:
    die(generateError("Missing valid qurey ('q=') parameter from URI"));
    break;
}
?>
