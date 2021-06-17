<?php
#
#File: host_detais.php
#Desc generate host details from DB
#Error Code: 2.X

include "settings.php";
include "function.php";
$html_file .= '
  <hr>
  <div class="container">
    <div class="row">
      <div class="col-sm-10"><h1>Create EC host</h1><br /></div>
      <div class="col-sm-4">
        <form class="form" action="chg.php" method="post" id="add_ec">
          <button name="chg_type" value="ec_create" type="submit" class="btn btn-success">Create</button>
          <p>
          <label>Hostname</label><br />
          <input type="text" placeholder="eg.:host-for-fun" name="ec_hostname" autocomplete="off" required />
          <p>
          <label>Domain name</label><br />
          <select id="ec_inst_domain" name="ec_inst_domain" required>';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="ec_inst_domain" ORDER BY value ASC');
          while($row=mysqli_fetch_row($query)) {
            $html_file .='<option value="'.$row[0].'">'.$row[0].'</option>';
          }
          mysqli_free_result($query);
          $html_file .='
          </select>
          <p>
          <label>EC location</label><br />
          <select id="ec_location" name="ec_inst_location" required>';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="ec_location" ORDER BY value ASC');
          while($row=mysqli_fetch_row($query)) {
            $html_file .='<option value="'.$row[0].'">'.$row[0].'</option>';
          }
          mysqli_free_result($query);
          $html_file .='
          </select>
          <p>
          <label>IP address</label><br />
          <input type="text" placeholder="10.100.11.11" name="ec_inst_ip" autocomplete="off" required />
          <p>
          <label>Host type</label><br />
          <select id="inst_type" name="inst_type" required>';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="ec_inst_type" ORDER BY value ASC');
          while($row=mysqli_fetch_row($query)) {
            $html_file .='<option value="'.$row[0].'">'.$row[0].'</option>';
          }
          mysqli_free_result($query);
          $html_file .='
          </select>
          <p>
          <label>CPU cores  </label>
          <select id="ec_inst_cpu" name="ec_inst_cpu" required>';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="ec_inst_max_cpu" ORDER BY value ASC');
          $row=mysqli_fetch_row($query);
          for ($i = 1; $i <= $row[0]; $i++) {
            $html_file .='<option value="'.$i.'">'.$i.'</option>';
          }
          mysqli_free_result($query);
          $html_file .='
          </select>
          <p>
          <label>Memory in MB</label><br />
          <input type="number" placeholder="1024" name="ec_inst_memory" autocomplete="off" required />
          <p>
          <label>Disk Size in GB</label><br />
          <input type="number" placeholder="10" name="ec_inst_disk" autocomplete="off" required />
          <p>
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
