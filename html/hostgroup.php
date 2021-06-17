<?php
#
#File:sgroup_details.php
#Desc: Lists selected sgroup's properties
#Query argument: $_GET['q']
#Error Code: 5.X

include "settings.php";
include"function.php";

$membercount_q = mysqli_query($link, 'SELECT count(host_id) FROM memberships WHERE group_id='.$_GET['q'].'');
$membercount = mysqli_fetch_row($membercount_q);

$query = mysqli_query($link, 'SELECT * FROM hostgroups WHERE group_id='.$_GET['q'].'') or die('Error 5.1 '.mysqli_error($link));
$group_details = mysqli_fetch_array($query);
$html_file .= '
  <hr>
  <div class="container">
    <div class="row">
      <div class="col-sm-10"><h1><text class="text-info">Host Group ~ </text>'.$group_details['name'].'</h1><br /></div>
        <div class="row">
          <div class="col-sm-3"><!--left col-->
            <ul class="list-group">
              <li class="list-group-item text-muted">Details <i class="fa fa-dashboard fa-1x"></i></li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>Number of members</strong></span>'.$membercount[0].'</li>
              <li class="list-group-item text-right"><span class="pull-left"><strong>Group ID</strong></span>'.$group_details['group_id'].' </li>
            </ul>
            <div class="panel panel-info">
              <div class="panel-heading">Description</div>
                <br />'.$group_details['description'].'
              </div>
            </div><!--/col-3-->
            <div class="col-sm-9">
              <ul class="nav nav-tabs" id="myTab">
                <li><a href="#parents" data-toggle="tab">Parent groups</a></li>
                <li class="active"><a href="#hosts" data-toggle="tab">Hosts</a></li>
                <li><a href="#groupvars" data-toggle="tab">Group variables</a></li>
                <li><a href="#settings" data-toggle="tab">Settings</a></li>
                <li><a href="#dismiss" data-toggle="tab">Dismiss</a></li>
              </ul>
              <div class="tab-content">


              <div class="tab-pane" id="parents">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Parent group name</th>
                      <th>Description</th>
                    </tr>
                  </thead>
                <tbody id="items">
              ';
              #Main tab - memberhips tab
              $memberships_query = mysqli_query($link, 'SELECT * FROM parentgroups WHERE parent_id IN (SELECT parent_id FROM parent_child WHERE group_id='.$group_details['group_id'].')');
              while($row = mysqli_fetch_row($memberships_query)) {
              $html_file .= '
              <tr role="button"; onclick=\'document.location = "parents.php?q='.$row['0'].'";\'>
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




                <div class="tab-pane active" id="hosts">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Hostname</th>
                      </tr>
                    </thead>
                    <tbody id="items">
';
$query = mysqli_query($link, 'SELECT hosts.host_id, hosts.name FROM memberships INNER JOIN hosts ON hosts.host_id=memberships.host_id AND memberships.group_id='.$_GET['q'].' ORDER BY hosts.name ASC') or die('Error 5.3 '.mysqli_error($link));
while($row = mysqli_fetch_array($query)) {
  #Criticality check
  $html_file .= '
    <tr role="button"; onclick="document.location = \'host_details.php?q='.$row['host_id'].'\';">
      <td>'.$row['host_id'].'</td>
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
                <input name="chg_type" value="chg_gvaddnew" type="hidden">
                <input name="group_id" value="'.$_GET['q'].'" type="hidden">
                <input class="form-control" placeholder="Variable name" name="group_var" type="text" autocomplete="off" required>
                <input class="form-control" placeholder="Value" name="gv_value" type="text" autocomplete="off" required>

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
  $groupvars_query = mysqli_query($link, 'SELECT group_var, value FROM groupvars where group_id='.$_GET['q'].'') or die('Error 2.8 '.mysqli_error($link));
  ##GroupVars
  while($row = mysqli_fetch_row($groupvars_query)) {
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
          <input name="group_var" value="'.$row[0].'" type="hidden">
          <input name="group_id" value="'.$_GET['q'].'" type="hidden">

          <input class="form-control" value="'.$row[1].'" name="gv_value" type="text" autocomplete="off" required>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" name="chg_type" value="chg_gvdelete" class="btn btn-danger">Delete</button>
          <button type="submit"  name="chg_type" value="chg_chggvar" class="btn btn-primary">Update</button>
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
    <form class="form" action="chg.php" method="post" id="update-hostgroup">
  <div class="form-group">
    <div class="col-xs-6">
      <label for="members"><h4>Members</h4></label><br />
        <select name="member_host[ ]" class="selectpicker" data-live-search="true" multiple data-actions-box="true" required>
';
$query = mysqli_query($link, 'SELECT * FROM hosts') or die('Error 5.8 '.mysqli_error($link));
while($row=mysqli_fetch_row($query)) {
	$aquery = mysqli_query($link, 'SELECT count(host_id) FROM memberships WHERE group_id='.$_GET['q'].' AND host_id='.$row[0].'') or die('Error 5.9 '.mysqli_error($link));
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
    <input class="form-control" name="group_description" value="'.$group_details['description'].'" type="text" autocomplete="off" required>
    </div>
  <div class="form-group">
    <div class="col-xs-12">
      <br>
      <input type="hidden" name="group_id" value="'.$group_details['group_id'].'" />
      <button class="btn btn-lg btn-success" name="chg_type" value="update_hostgroups" type="submit">Submit</button><h6>*fields cannot be empty</h6>
      <p /><hr>
      <h4>Options</h4>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newvarModal">Add variable to all member</button>  <abbr title="If the new variable already exists, it will be updated with the new value"><span class="glyphicon glyphicon-question-sign"></span></abbr>
    </div>
  </div>
  </form>
  </div>

  <div class="modal fade" id="newvarModal" tabindex="-1" role="dialog" aria-labelledby="newvar" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="newvar">Add new variable to all member</h5>
        </div>
        <div class="modal-body">
          <form class="form" action="chg.php" method="post">
          <input type="hidden" name="group_id" value="'.$group_details['group_id'].'" />
          <input class="form-control" placeholder="Variable name" name="host_var" type="text" autocomplete="off" required>
          <input class="form-control" placeholder="Value" name="value" type="text" autocomplete="off" required>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button name="chg_type" value="create_hostvaringroup" type="submit" class="btn btn-primary">Create</button>
      </form>
        </div>
      </div>
    </div>
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
                         <label>Check this box if you want delete all member host too</label>
                         <input class="form-control" name="delete_hosts" value="true" type="checkbox">
                         <h6>If you select select this option, all host associated with the group will be deleted from the database. This action cannot be undone</h6>
                         <input type="hidden" name="group_id" value="'.$group_details['group_id'].'" />
                     </div>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                         <button name="chg_type" value="delete_hostgroup" type="submit" class="btn btn-danger">Delete Now</button>
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
