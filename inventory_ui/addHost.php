<?php
#
#File: host_detais.php
#Desc generate host details from DB
#Error Code: 2.X

include "settings.php";
include "function.php";
$html_file .= '
<body onload="document.add_host.ip_addr.focus()">
  <hr>
  <div class="container">
    <div class="row">
      <div class="col-sm-10"><h1>Add new host to inventory</h1><br /></div>
      <div class="col-sm-4">
        <form class="form" action="chg.php" method="post" name="add_host" id="add_host">
          <button name="chg_type" value="add_new_host" type="submit" class="btn btn-success" onclick="ValidateIPaddress(document.add_host.ip_addr)">Create</button>
          <br/>
          <label>Hostname</label><br/>
          <input type="text" placeholder="eg.:euw2-dev-something01" name="host_name" autocomplete="off" required />
          <p/>
          <label>Member of </label><br/>
          <select name="hostgroup[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" required>
          ';
          $query = mysqli_query($link, 'SELECT name, group_id FROM hostgroups') or die('Error 1.1 '.mysqli_error($link));
          while($row=mysqli_fetch_row($query)) {
                $html_file .= '<option data-tokens="'.$row[0].'" value="'.$row[1].'">'.$row[0].'</option>';
          }
          $html_file .= '
          </select>
          <br/>
	  <label>Runtime Environment </label><br/>
          <select name="runtime_env" class="selectpicker" data-live-search="false" data-actions-box="true" required>
          <option value="dev">Development</option>
          <option value="uat">UAT</option>
          <option value="prod">Production</option>
          </select>
          <br/>
    <label>Alert priority</label><br/>
          <select name="alert_priority" class="selectpicker" data-live-search="false" data-actions-box="true" required>
          ';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="alert_priority"') or die('Error 1.2 '.mysqli_error($link));
          while($row=mysqli_fetch_row($query)) {
                $html_file .= '<option value="'.$row[0].'">'.$row[0].'</option>';
          }
          $html_file .='
          </select>
    <br/>
    <label>IP of the host</label><br/>
          <input type="text" placeholder="10.100.10.123" name="ip_addr" autocomplete="off" required />
    <br/>
          <hr/>
          <div id="fillcontainer"/>
        </form>
  </div><!--/col-sm-3-->
  </div><!--/row-->
  </div><!--/container-->
  </body>
  </html>
';
echo $html_file;
mysqli_free_result($query);
mysqli_close($link);
?>
