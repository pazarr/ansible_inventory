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
      <div class="col-sm-10"><h1>Provision edge</h1><br /></div>
      <div class="col-sm-4">
        <form class="form" action="admin/generate_edge.php" method="post" id="add_edge">
          <button name="chg_type" value="create_edge" type="submit" class="btn btn-success">Create</button>
          <p/>
          <label>Number of instance</label><br/>
          <input type="number" name="edge_number" class="form-control" autocomplete="off" required />
          <p/>
          <label>Description</label><br/>
          <input type="text" class="form-control" placeholder="eg.:fun in the EU" name="description" autocomplete="off" required />
          <br/>
          <label>Hostgroup</label><br/>
          <select name="hostgroup" class="selectpicker" data-live-search="true" data-actions-box="true" required>
          ';
          $query = mysqli_query($link, 'SELECT * FROM hostgroups') or die('Error 1.4 '.mysqli_error($link));
          while($row=mysqli_fetch_row($query)) {
                $html_file .= '<option data-tokens="'.$row[0].'" value="'.$row[1].'">'.$row[1].'</option>';
          }
          $html_file .= '
          </select>
          <br/>
          <label>Edge pool</label><br/>
          <select name="edge_pool" class="selectpicker" data-live-search="true" data-actions-box="true" required>
          ';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="edge_pool"') or die('Error 1.5 '.mysqli_error($link));
          while($row=mysqli_fetch_row($query)) {
                $html_file .= '<option data-tokens="'.$row[0].'" value="'.$row[0].'">'.$row[0].'</option>';
          }
          $html_file .= '
          </select>
          <br/>
          <label>Zone</label><br/>
          <select name="av_zones[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" required>
          ';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="aws_av_zone"') or die('Error 1.1 '.mysqli_error($link));
          while($row=mysqli_fetch_row($query)) {
          			$html_file .= '<option data-tokens="'.$row[0].'" value="'.$row[0].'">'.$row[0].'</option>';
          }
          $html_file .= '
          </select>
          <br/>
          <label>Instance type</label><br/>
          <select name="inst_type" class="selectpicker" data-live-search="true" data-actions-box="true" required>
          ';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="aws_instance_type"') or die('Error 1.2 '.mysqli_error($link));
          while($row=mysqli_fetch_row($query)) {
          			$html_file .= '<option data-tokens="'.$row[0].'" value="'.$row[0].'">'.$row[0].'</option>';
          }
          $html_file .= '
          </select>
          <br/>
          <label>Instance Volume Size</label><br/>
          <input type="number" name="volume_size" class="form-control" autocomplete="off" required />
          <label>CDS Release</label><br/>
          <select name="cds_bin_ver" class="selectpicker" data-live-search="true" data-actions-box="true" required>
          ';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="cds_software_ver"') or die('Error 1.3 '.mysqli_error($link));
          while($row=mysqli_fetch_row($query)) {
          			$html_file .= '<option data-tokens="'.$row[0].'" value="'.$row[0].'">'.$row[0].'</option>';
          }
          $html_file .= '
          </select>
          <br/>
          <label>CDS Configuration</label><br/>
          <input type="text" class="form-control" placeholder="bln1-production-seamtedgej8" name="cds_config" autocomplete="off" required />
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
