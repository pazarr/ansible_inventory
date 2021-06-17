<?php
#
#File: host_detais.php
#Desc generate host details from DB
#Error Code: 2.X

include "../settings.php";
include "../function.php";
$html_file .= '
  <hr>
  <div class="container">
    <div class="row">
      <div class="col-sm-10"><h1>Create Harro host</h1><br /></div>
      <div class="col-sm-4">
        <form class="form" action="admin/generate_harro.php" method="post" id="add_harro">
          <button name="chg_type" value="create_harro" type="submit" class="btn btn-success">Create</button>
          <br/>
          <label>Harro Name</label><br/>
          <input type="text" placeholder="eg.:harro-fun-eu-west" name="harro_name" autocomplete="off" required />
          <p/>
          <label>Description</label><br/>
          <input type="text" placeholder="eg.:fun in the EU" name="harro_description" autocomplete="off" required />
          <br/>
          <label>AV Zone</label><br/>
          <select name="av_zones[]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" required>
          ';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="aws_av_zone"') or die('Error 1.1 '.mysqli_error($link));
          while($row=mysqli_fetch_row($query)) {
                $html_file .= '<option data-tokens="'.$row[0].'" value="'.$row[0].'">'.$row[0].'</option>';
          }
          $html_file .= '
          </select>
          <br/>
          <label>IP range</label><br/>
          <input type="text" placeholder="10.100.XXX.0/24" name="ip_block" autocomplete="off" required />
          <br/>
          <hr/>
          <button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#conf_jumpbox">Configure jumpbox</button>
          <div id="conf_jumpbox" class="collapse">
          <label>Instance type</label><br/>
          <select id="vpc_region" name="jmpbox_inst_type" required>';
          $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="aws_instance_type"');
          while($row=mysqli_fetch_row($query)) {
            $html_file .='<option value="'.$row[0].'">'.$row[0].'</option>';
          }
          mysqli_free_result($query);
          $html_file .='
          </select>
            <br/>
            <label>Termination protection</label>
            <select id="jmpbox_term_protection" name="jmpbox_term_protection">
              <option value="yes" selected>Yes</option>
              <option value="no">No</option>
            </select>
            <br/>
            <label>Delete EBS on termination</label>
            <select id="jmpbox_delete_ebs" name="jmpbox_delete_ebs">
              <option value="yes" selected>Yes</option>
              <option value="no">No</option>
            </select>
            <br/>
            <label>Public IP</label>
            <select id="jmpbox_pub_ip" name="jmpbox_pub_ip">
              <option value="yes" selected>Yes</option>
              <option value="no">No</option>
            </select>
            <br/>
            <label>AMI image</label><br/>
            <input type="text" name="jmpbox_ami" autocomplete="off" required /><a href="https://wiki.yospace.com/index.php/AWS_AMI#Available_AMI_images" target="_blank">  help</a>
            <br/>
            <label>EBS size</label><br/>
            <input type="text" name="jmpbox_ebs_size" autocomplete="off" required />
          </div>

          <hr/>
          <button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#conf_origin">Configure Origins/Receviers</button>
          <div id="conf_origin" class="collapse">
            <label>Instance type</label><br/>
            <select id="vpc_region" name="origin_inst_type" required>';
            $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="aws_instance_type"');
            while($row=mysqli_fetch_row($query)) {
              $html_file .='<option value="'.$row[0].'">'.$row[0].'</option>';
            }
            mysqli_free_result($query);
            $html_file .='
            </select>
            <input type="hidden" name="receiver_inst_type" value="'.$row[0].'"/>
            <br/>
            <label>Termination protection</label>
            <select id="origin_term_protection" name="origin_term_protection">
              <option value="yes" selected>Yes</option>
              <option value="no">No</option>
            </select>
            <br/>
            <label>Delete EBS on termination</label>
            <select id="origin_delete_ebs" name="origin_delete_ebs">
              <option value="yes" selected>Yes</option>
              <option value="no">No</option>
            </select>
            <br/>
            <label>Public IP</label>
            <select id="jmpbox_pub_ip" name="origin_pub_ip">
              <option value="yes">Yes</option>
              <option value="no" selected>No</option>
            </select>
            <br/>
            <label>AMI image</label><br/>
            <input type="text" name="origin_ami"" autocomplete="off" required /><a href="https://wiki.yospace.com/index.php/AWS_AMI#Available_AMI_images" target="_blank">  help</a>
            <br/>
            <label>EBS size</label><br/>
            <input type="text" name="origin_ebs_size" autocomplete="off" required />
          </div>
          <hr/>

          <button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#conf_telemetry">Configure Telemetry/API</button>
          <div id="conf_telemetry" class="collapse">
            <label>Instance type</label><br/>
            <select id="vpc_region" name="telemetry_inst_type" required>';
            $query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="aws_instance_type"');
            while($row=mysqli_fetch_row($query)) {
              $html_file .='<option value="'.$row[0].'">'.$row[0].'</option>';
            }
            mysqli_free_result($query);
            $html_file .='
            </select>
            <br/>
            <label>Termination protection</label>
            <select id="telemetry_term_protection" name="telemetry_term_protection">
              <option value="yes" selected>Yes</option>
              <option value="no">No</option>
            </select>
            <br/>
            <label>Delete EBS on termination</label>
            <select id="telemetry_delete_ebs" name="telemetry_delete_ebs">
              <option value="yes" selected>Yes</option>
              <option value="no">No</option>
            </select>
            <br/>
            <label>Public IP</label>
            <select id="jmpbox_pub_ip" name="telemetry_pub_ip">
              <option value="yes">Yes</option>
              <option value="no" selected>No</option>
            </select>
            <br/>
            <label>AMI image</label><br/>
            <input type="text" name="telemetry_ami" autocomplete="off" required /><a href="https://wiki.yospace.com/index.php/AWS_AMI#Available_AMI_images" target="_blank">  help</a>
            <br/>
            <label>EBS size</label><br/>
            <input type="text" name="telemetry_ebs_size" autocomplete="off" required />
          </div>
          <hr/>

          <label>Number of availability zone:</label>
          <select id="av_zones" name="av_zones" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
          <br />
          <a href=# class="btn btn-primary" id="filldetails" onclick="addFields()">Add subnets</a>
          <br />
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
