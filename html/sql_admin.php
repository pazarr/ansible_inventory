<?php
#
#File: index.php
include "settings.php";
include "function.php";


$html_file .='
  <div>
  <div class="container">
    <div class="row">';

####START OF UI VARS#####
$html_file .= '
      <div class="col-md-4">
      <h3>UI variables</h3>
      <li role="button" class="btn btn-success" data-toggle="modal" data-target="#newuivar" data-whatever="@getbootstrap">new variable</li>
      <div class="modal fade" id="newuivar" tabindex="-1" role="dialog" aria-labelledby="newvar" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="new_ui_var">Add UI variable</h5>
            </div>
            <div class="modal-body">
              <form class="form" action="chg.php" method="post">
              <input class="form-control" placeholder="Variable name" name="ui_var" type="text" autocomplete="off" required>
              <input class="form-control" placeholder="Value" name="new_value" type="text" autocomplete="off" required>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button name="chg_type" value="add_ui_var" type="submit" class="btn btn-primary">Create</button>
          </form>
            </div>
          </div>
        </div>
      </div>

    <table class = "table table-striped table-bordered">
      <thead>
        <tr>
  	      <th>Variable</th>
          <th>Number of item</th>
        </tr>
      </thead>
      <tbody class="slist">
      ';

$query = mysqli_query($link, 'SELECT count(ui_var) as counted_item, ui_var from ui_vars GROUP BY ui_var') or die('Error 6.1 '.mysqli_error($link));
while($row = mysqli_fetch_array($query)) {
$html_file .= '

      <tr role="button" data-toggle="modal" data-target="#'.$row['ui_var'].'Modal">
        <td>'.$row['ui_var'].'</td>
        <td>'.$row['counted_item'].'</td>
      </tr>
      <div class="modal fade" id="'.$row['ui_var'].'Modal" tabindex="-1" role="dialog" aria-labelledby="'.$row['ui_var'].'window" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <label class="modal-title" id="'.$row['ui_var'].'window">Variable '.$row['ui_var'].'</label>
            </div>
            <div class="modal-body pre-scrollable">
              <form class="form" action="chg.php" method="post">';
              $inner_query = mysqli_query($link, 'SELECT value FROM ui_vars WHERE ui_var="'.$row['ui_var'].'"') or die('Error 6.2 '.mysqli_error($link));
              while($inrow = mysqli_fetch_row($inner_query)) {
                $html_file .= '
                  <ul>
                    <li>'.$inrow[0].'</li>
                  </ul>';
              }
              mysqli_free_result($inner_query);

$html_file .='
            </div>
            <div class="modal-footer">
              <input type="text" placeholder="new value" name="new_value"  autocomplete="off" required>
              <input type="hidden" name="ui_var" value="'.$row['ui_var'].'">
              <button name="chg_type" value="add_ui_var" type="submit" class="btn btn-primary">Add</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

          </form>
            </div>
          </div>
        </div>
      </div>
      ';

}
$html_file .= '
          </tbody>
        </table>
        </div> <!--col-md-4-->';
####END OF UI VARS#####

#### START OF HOSTVARS###
$html_file .= '
      <div class="col-md-4">
      <h3>Host variables</h3>
    <table class="table  table-striped table-bordered">
      <thead>
        <tr>
  	      <th>Variable</th>
          <th>Number of item</th>
        </tr>
      </thead>
      <tbody>
      ';

$query = mysqli_query($link, 'SELECT count(host_var) as counted_item, host_var from hostvars GROUP BY host_var') or die('Error 6.3 '.mysqli_error($link));
while($row = mysqli_fetch_array($query)) {
$html_file .= '

      <tr role="button" data-toggle="modal" data-target="#'.$row['host_var'].'Modal">
        <td>'.$row['host_var'].'</td>
        <td>'.$row['counted_item'].'</td>
      </tr>
      <div class="modal fade" id="'.$row['host_var'].'Modal" tabindex="-1" role="dialog" aria-labelledby="'.$row['host_var'].'window" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <label class="modal-title" id="'.$row['host_var'].'window">Variable '.$row['host_var'].'</label>
            </div>
            <div class="modal-body pre-scrollable">
              <form class="form" action="chg.php" method="post">';
              $inner_query = mysqli_query($link, 'SELECT value FROM hostvars WHERE host_var="'.$row['host_var'].'"') or die('Error 6.4 '.mysqli_error($link));
              while($inrow = mysqli_fetch_row($inner_query)) {
                $html_file .= '
                  <ul>
                    <li>'.$inrow[0].'</li>
                  </ul>';
              }
              mysqli_free_result($inner_query);

$html_file .='
            </div>
            <div class="modal-footer">
              <input type="text" placeholder="new value" name="new_value"  autocomplete="off" required>
              <input type="hidden" name="ui_var" value="'.$row['host_var'].'">
              <button name="chg_type" value="add_ui_var" type="submit" class="btn btn-primary">Add</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>

          </form>
            </div>
          </div>
        </div>
      </div>
      ';

}
$html_file .= '
          </tbody>
        </table>
        </div> <!--col-md-4-->';
#### END OF HOSTVARS####

$html_file .= '
        </div> <!-- row-->
      </div>
    </body>
  </html>';
echo $html_file;
mysqli_free_result($query);
mysqli_close($link);
?>
