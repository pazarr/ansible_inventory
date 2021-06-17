<?php
#
#File: host_detais.php
#Desc generate host details from DB
#Error Code: 2.X

include "settings.php";
include "function.php";

#host
$query = mysqli_query($link, 'SELECT * FROM hosts where host_id='.$_GET['q'].'') or die('Error 2.6 '.mysqli_error($link));
$host = mysqli_fetch_array($query);
#memberships
$memberships_query = mysqli_query($link, 'SELECT hostgroups.group_id, hostgroups.name, hostgroups.description FROM memberships INNER JOIN hostgroups ON memberships.group_id=hostgroups.group_id AND memberships.host_id='.$_GET['q'].'') or die('Error 2.7 '.mysqli_error($link));
#hostvars
$hostvars_query = mysqli_query($link, 'SELECT host_var, value FROM hostvars where host_id='.$_GET['q'].'') or die('Error 2.8 '.mysqli_error($link));
while($row = mysqli_fetch_row($hostvars_query)) {
  switch ($row[0]) {
    case inst_type:
        $inst_type = $row[1];
        break;
    case vpc_region:
        $location = $row[1];
        break;
    case inst_usage:
        $function = $row[1];
        break;
    case avail_zone:
        $avail_zone = $row[1];
        break;
    case inst_status:
        $status = $row[1];
        break;
    case jiraticket:
        $jiraticket = $row[1];
        break;
    case ansible_host:
        $host_ip = $row[1];
        break;
    case regal_installed:
        $regal_installed = $row[1];
        break;

  }
  $function != "" || $function = "NA";
  $status != "" || $status = "NA";
  $inst_type != "" || $inst_type = "NA";
  $location != "" || $location = "NA";
  $function != "" || $function = "NA";
  $avail_zone != "" || $avail_zone = "NA";
  $jiraticket != "" || $jiraticket = "NA";
  $host['host_id'] != "" || $host['host_id'] = "NA";
  $regal_installed != "" || $regal_installed = "NA";
}
$html_file .= '
  <hr>
  <div class="container">
    <div class="row">
      <div class="col-sm-10"><h1>'.$host['name'].'</h1><br /></div>
        <div class="row">
          <div class="col-sm-3"><!--left col-->
            <ul class="list-group">
            <li class="list-group-item text-muted">Details <i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Location</strong></span>'.$location.'</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>IP Addr</strong></span>'.$host_ip.'</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Zone</strong></span>'.$avail_zone.'</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Status</strong></span>'.$status.'</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Type</strong></span>'.$inst_type.'</li>';
if ($regal_installed != "NA") {
$html_file .= '            <li class="list-group-item text-right"><span class="pull-left"><strong>Lobby URL</strong></span><a href=https://'.$host['name'].'.realistic-dev.com target="_blank">'.$host['name'].'.realistic-dev.com</a></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>BO URL</strong></span><a href=http://bo-'.$host['name'].'.realistic-dev.com target="_blank">bo-'.$host['name'].'.realistic-dev.com</a></li>';
}
$html_file .= ' 
            </ul>
            <div class="panel panel-default">
            <div class="panel-heading">Additional Information</div>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Function</strong></span>'.$function.'</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>Ansible ID</strong></span>'.$host['host_id'].'</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>JIRA TCKT</strong></span><a href=https://intranet.rgli.uk/jira/browse/'.$jiraticket.' target=_blank>'.$jiraticket.'</a></li>
          </div>
        </div><!--/col-3-->
        <div class="col-sm-9">
          <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#memberships" data-toggle="tab">Memberships</a></li>
            <li><a href="#hostvars" data-toggle="tab">Host variables</a></li>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
          </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="memberships">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Id</th>
                  <th>Group name</th>
                  <th>Description</th>
                </tr>
              </thead>
            <tbody id="items">
  ';
#Main tab - memberhips tab
while($row = mysqli_fetch_row($memberships_query)) {
	$html_file .= '
    <tr role="button"; onclick=\'document.location = "hostgroup.php?q='.$row['0'].'";\'>
      <td>'.$row[0].'</td>
      <td>'.$row[1].'</td>
      <td>'.$row[2].'</td>
    </tr>
  ';
}
$html_file .= '
  </tbody>
    </table>
      <hr>
        <div class="row">
          <div class="col-md-4 col-md-offset-4 text-center">
          	<ul class="pagination" id="myPager"></ul>
          </div>
          </div><!--/table-resp-->
          <hr>
        </div><!--/tab-pane-->



        <div class="tab-pane" id="hostvars">
          <ul class="list-group">
            <li role="button" class="list-group-item list-group-item-success" data-toggle="modal" data-target="#hv_addnew" data-whatever="@getbootstrap">Add new variable</li>
            <div class="modal fade" id="hv_addnew" tabindex="-1" role="dialog" aria-labelledby="hostvar" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="newgroup">Add new variable</h5>
                  </div>
                  <div class="modal-body">
                    <form class="form" action="chg.php" method="post">
                    <input name="chg_type" value="chg_hvaddnew" type="hidden">
                    <input name="host_id" value="'.$_GET['q'].'" type="hidden">
                    <input class="form-control" placeholder="Variable name" name="host_var" type="text" autocomplete="off" required>
                    <input class="form-control" placeholder="Value" name="hv_value" type="text" autocomplete="off" required>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
                  </div>
                </div>
              </div>
            </div>
';
$hostvars_query = mysqli_query($link, 'SELECT host_var, value FROM hostvars where host_id='.$_GET['q'].'') or die('Error 2.8 '.mysqli_error($link));
##Hostvars
while($row = mysqli_fetch_row($hostvars_query)) {
  $html_file .= '
    <li role="button" class="list-group-item" data-toggle="modal" data-target="#hv'.$row[0].'" data-whatever="@getbootstrap">'.$row['0'].' == '.$row['1'].'</li>
      <div class="modal fade" id="hv'.$row[0].'" tabindex="-1" role="dialog" aria-labelledby="hostvar" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="newgroup">Modify <u>'.$row[0].'</u> variable</h5>
            </div>
            <div class="modal-body">
              <form class="form" action="chg.php" method="post">
              <input name="host_var" value="'.$row[0].'" type="hidden">
              <input name="host_id" value="'.$_GET['q'].'" type="hidden">

              <input class="form-control" value="'.$row[1].'" name="hv_value" type="text" autocomplete="off" required>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" name="chg_type" value="chg_hvdelete" class="btn btn-danger">Delete</button>
              <button type="submit"  name="chg_type" value="chg_chgvar" class="btn btn-primary">Update</button>
          </form>
            </div>
          </div>
        </div>
      </div>
  ';
}
#Host Settings and updated tab
#
#
$html_file .= '
  </ul>
  </div><!--/tab-pane-->

  <div class="tab-pane" id="settings">
    <hr>
    <div class="col-md-4 col-md-offset-4 text-center">
          <br />
          <button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#DismissModal">Dismiss</button><h6>*Yeah, dismiss very much...</h6>
                  <div class="modal fade" id="DismissModal" tabindex="-1" role="dialog" aria-labelledby="dismiss" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="newgroup">Create new group</h5>
                        </div>
                       <div class="modal-body">
                         <form class="form" action="chg.php" method="post">
                           <b>You really want to delete this host from teh database?.
                            This action cannot be undone<b>

                           <input type="hidden" name="host_id" value="'.$_GET['q'].'" />
                       </div>
                       <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                           <button name="chg_type" value="delete_host" type="submit" class="btn btn-danger">Delete Now</button>
                        </form>
                       </div>
                      </div> <!-- modal content -->
                    </div> <!-- /modal-dialog -->
                  </div> <!-- /modal fade -->
  </div>
';
$html_file .= '  </div><!--/tab-content-->
  </div><!--/col-9-->
  </div><!--/row-->
  </body>
  </html>
';
echo $html_file;
mysqli_free_result($query);
mysqli_close($link);
?>
