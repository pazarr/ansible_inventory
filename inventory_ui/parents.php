<?php
#
#File:sgroup_details.php
#Desc: Lists selected sgroup's properties
#Query argument: $_GET['q']
#Error Code: 5.X

include "settings.php";
include"function.php";

$childcount_query = mysqli_query($link, 'SELECT count(group_id) FROM parent_child WHERE parent_id='.$_GET['q'].'');
$childcount = mysqli_fetch_row($childcount_query);

$query = mysqli_query($link, 'SELECT * FROM parentgroups WHERE parent_id='.$_GET['q'].'') or die('Error 5.1 '.mysqli_error($link));
$parent_details = mysqli_fetch_array($query);
$html_file .= '
  <hr>
  <div class="container">
    <div class="row">
      <div class="col-sm-10"><h1><text class="text-info">Parent Group ~ </text>'.$parent_details['name'].'</h1><br /></div>
        <div class="row">
          <div class="col-sm-3"><!--left col-->
            <ul class="list-group">
              <li class="list-group-item text-muted">Details <i class="fa fa-dashboard fa-1x"></i></li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>Number of members</strong></span>'.$childcount[0].'</li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>Group ID</strong></span>'.$parent_details['parent_id'].' </li>
            </ul>
            <div class="panel panel-info">
              <div class="panel-heading">Description</div>
                <br />'.$parent_details['description'].'
              </div>
            </div><!--/col-3-->
            <div class="col-sm-9">
              <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#child_groups" data-toggle="tab">Host groups</a></li>
                <li><a href="#groupvars" data-toggle="tab">Group variables</a></li>
                <li><a href="#settings" data-toggle="tab">Settings</a></li>
                <li><a href="#dismiss" data-toggle="tab">Dismiss</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="child_groups">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Hostname</th>
                      </tr>
                    </thead>
                    <tbody id="items">
';
$query = mysqli_query($link, 'SELECT hostgroups.group_id, hostgroups.name FROM parent_child INNER JOIN hostgroups ON hostgroups.group_id=parent_child.group_id AND parent_child.parent_id='.$_GET['q'].'') or die('Error 5.3 '.mysqli_error($link));
while($row = mysqli_fetch_array($query)) {
  #Criticality check
  $html_file .= '
    <tr role="button"; onclick="document.location = \'hostgroup.php?q='.$row['group_id'].'\';">
      <td>'.$row['group_id'].'</td>
      <td>'.$row['name'].'</td>
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

    <div class="tab-pane" id="groupvars">
      <ul class="list-group">
        <li role="button" class="list-group-item list-group-item-success" data-toggle="modal" data-target="#gv_addnew" data-whatever="@getbootstrap">Add new variable</li>
        <div class="modal fade" id="gv_addnew" tabindex="-1" role="dialog" aria-labelledby="groupvars" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="newgroup">Add new variable</h5>
              </div>
              <div class="modal-body">
                <form class="form" action="chg.php" method="post">
                <input name="chg_type" value="chg_pvaddnew" type="hidden">
                <input name="parent_id" value="'.$_GET['q'].'" type="hidden">
                <input class="form-control" placeholder="Variable name" name="parent_var" type="text" autocomplete="off" required>
                <input class="form-control" placeholder="Value" name="pv_value" type="text" autocomplete="off" required>

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
  $parentvars_query = mysqli_query($link, 'SELECT parent_var, value FROM parentvars where parent_id='.$_GET['q'].' ORDER BY parent_var ASC') or die('Error 2.8 '.mysqli_error($link));
  ##GroupVars
  while($row = mysqli_fetch_row($parentvars_query)) {
  $html_file .= '
  <li role="button" class="list-group-item" data-toggle="modal" data-target="#gv'.$row[0].'" data-whatever="@getbootstrap">'.$row['0'].' == '.$row['1'].'</li>
  <div class="modal fade" id="gv'.$row[0].'" tabindex="-1" role="dialog" aria-labelledby="groupvars" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newgroup">Modify <u>'.$row[0].'</u> variable</h5>
        </div>
        <div class="modal-body">
          <form class="form" action="chg.php" method="post">
          <input name="parent_var" value="'.$row[0].'" type="hidden">
          <input name="parent_id" value="'.$_GET['q'].'" type="hidden">

          <input class="form-control" value="'.$row[1].'" name="pv_value" type="text" autocomplete="off" required>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" name="chg_type" value="chg_pvdelete" class="btn btn-danger">Delete</button>
          <button type="submit"  name="chg_type" value="chg_chgpvar" class="btn btn-primary">Update</button>
      </form>
        </div>
      </div>
    </div>
  </div>
  ';
  }
  ##END of Groupvars
  $html_file .= '
    </ul>
    </div><!--/tab-pane-->
    <div class="tab-pane" id="settings">
    <hr>
    <form class="form" action="chg.php" method="post" id="update-parentgroup">
  <div class="form-group">
    <div class="col-xs-6">
      <label for="members"><h4>Host groups</h4></label><br />
        <select name="member_hostgroups[ ]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" required>
';
$query = mysqli_query($link, 'SELECT * FROM hostgroups') or die('Error 5.8 '.mysqli_error($link));
while($row=mysqli_fetch_row($query)) {
	$aquery = mysqli_query($link, 'SELECT count(group_id) FROM parent_child WHERE parent_id='.$_GET['q'].' AND group_id='.$row[0].'') or die('Error 5.9 '.mysqli_error($link));
	$ismember = mysqli_fetch_row($aquery);
	if( $ismember[0] > 0 ) {
			$html_file .= '
       <option data-tokens="'.$row[1].'" value="'.$row[0].'" selected>'.$row[1].'</option>
      ';
  }
	else {
    $html_file .= '
      #<option data-tokens="'.$row[1].'" value="'.$row[0].'">'.$row[1].'</option>
    #';
  }
}
$html_file .= '
      </select>
    </div>
    <div class="col-xs-6">
      <label for="members"><h4>Group description</h4></label><br />
    <input class="form-control" name="parent_description" value="'.$parent_details['description'].'" type="text" autocomplete="off" required>
    </div>
  <div class="form-group">
    <div class="col-xs-12">
      <br>
      <input type="hidden" name="parent_id" value="'.$parent_details['parent_id'].'" />
      <button class="btn btn-lg btn-success" name="chg_type" value="update_parentgroups" type="submit">Submit</button><h6>*fields cannot be empty</h6>
      <p /><hr>
    </div>
  </div>
  </form>
  </div>

  </div><!--/tab-pane-->
  <div class="tab-pane" id="dismiss">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 text-center">
        <ul class="pagination" id="myPager"></ul>
        <hr>
        <button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#DismissModal">Dismiss</button><h6>*Yeah, dismiss very much...</h6>
                <div class="modal fade" id="DismissModal" tabindex="-1" role="dialog" aria-labelledby="dismiss" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="newgroup">Delete Group</h5>
                      </div>
                     <div class="modal-body">
                       <form class="form" action="chg.php" method="post">
                         <h6>If you select select this option, all host associated with the group will be deleted from the database. This action cannot be undone</h6>
                         <input type="hidden" name="parent_id" value="'.$parent_details['parent_id'].'" />
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                         <button name="chg_type" value="delete_parentgroup" type="submit" class="btn btn-danger">Delete Now</button>
                      </form>
                     </div>
                    </div> <!-- modal content -->
                  </div> <!-- /modal-dialog -->
                </div> <!-- /modal fade -->
      </div>
    </div><!--/table-resp-->
  <hr>
  </div><!--/tab-pane-->
  </div><!--/tab-content-->
  </div><!--/col-9-->
  </div><!--/row-->
  </body>
  </html>
';
echo $html_file;
mysqli_free_result($query);
mysqli_free_result($aquery);
mysqli_close($link);
?>
