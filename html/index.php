<?php
#
#File: index.php
include "settings.php";
include "function.php";


$html_file .='
  <div>
  <div class="container">
  <h2> Hosts </h2>
  <div class="search">
    <input type="text" class="searchTerm" placeholder="Search host" />
    <p />
    <div class="search_host_box">
    </div>
  </div>
  <br/>
  <hr/>

  <h2>Parent groups</h2>
  <br /><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newparentModal">
      New Parent group
  </button>
   <p />
   <br />

<div class="modal fade" id="newparentModal" tabindex="-1" role="dialog" aria-labelledby="newparent" aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="newparent">Create Parent group</h5>
    </div>
    <div class="modal-body">
      <form class="form" action="chg.php" method="post">
      <input class="form-control" placeholder="New parent group name" name="name" type="text" autocomplete="off" required>
      <input class="form-control" placeholder="Brief description" name="description" type="text" autocomplete="off" required>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      <button name="chg_type" value="create_parentgroup" type="submit" class="btn btn-primary">Create</button>
  </form>
    </div>
  </div>
</div>
</div>



  <table class = "table table-striped table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody class="slist">
    ';

$query = mysqli_query($link, 'SELECT * from parentgroups ORDER BY name') or die('Error 1.1 '.mysqli_error($link));
while($row = mysqli_fetch_array($query)) {
    $html_file .= '

        <tr role="button"; onclick=\'document.location = "parents.php?q='.$row['parent_id'].'";\'>
          <td>'.$row['parent_id'].'</td>
          <td>'.$row['name'].'</td>
          <td>'.$row['description'].'</td>
        </tr>';

}
$html_file .= '
        </tbody>
      </table>
  <hr/>
    <h2>Host groups</h2>
    <br /><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newgroupModal">
        New Host group
    </button>
     <p />
     <br />
    <form id="live-search" action="" class="styled" method="post">
      <fieldset>
        <input type="text" class="text-input" id="filter" autocomplete="off" placeholder="Search groups" value="" />
        <span id="filter-count"></span>
      </fieldset>
    </form>

<div class="modal fade" id="newgroupModal" tabindex="-1" role="dialog" aria-labelledby="newgroup" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newgroup">Create new group</h5>
      </div>
      <div class="modal-body">
        <form class="form" action="chg.php" method="post">
        <input class="form-control" placeholder="New group name" name="name" type="text" autocomplete="off" required>
        <input class="form-control" placeholder="Brief description" name="description" type="text" autocomplete="off" required>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button name="chg_type" value="create_hostgroup" type="submit" class="btn btn-primary">Create</button>
    </form>
      </div>
    </div>
  </div>
</div>



    <table class = "table table-striped table-hover">
      <thead>
        <tr>
  	     <th>ID</th>
  	      <th>Host Group name</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody class="slist">
      ';

$query = mysqli_query($link, 'SELECT * from hostgroups ORDER BY name') or die('Error 1.1 '.mysqli_error($link));
while($row = mysqli_fetch_array($query)) {
	$html_file .= '

      <tr role="button"; onclick=\'document.location = "hostgroup.php?q='.$row['group_id'].'";\'>
        <td>'.$row['group_id'].'</td>
        <td>'.$row['name'].'</td>
        <td>'.$row['description'].'</td>
      </tr>';

}
$html_file .= '
          </tbody>
        </table>
      </div>
    </body>
  </html>
  ';
echo $html_file;
mysqli_free_result($query);
//mysqli_free_result($aquery);
mysqli_close($link);
?>
