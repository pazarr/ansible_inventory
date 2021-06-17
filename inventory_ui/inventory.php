<?php
ini_set('mbstring.internal_encoding','UTF-8');
include "settings.php";


if(isset($_GET['q']) && $_GET['q'] == "list") {
##Create All group
	$all_query = mysqli_query($link, "SELECT name FROM hosts ORDER BY name ASC");
	while($host = mysqli_fetch_row($all_query)) {
		$rows['all']['hosts'][] = $host[0];
	}
	mysqli_free_result($all_query);

##Print Parent groups and members
	$parent_query = mysqli_query($link, 'SELECT parent_id, name FROM parentgroups');
	while($parentgroup = mysqli_fetch_array($parent_query)) {
		$parent_name = $parentgroup['name'];
		$parent_id = $parentgroup['parent_id'];
		$child_query = mysqli_query($link, 'SELECT name FROM hostgroups WHERE group_id IN (SELECT group_id FROM parent_child WHERE parent_id='.$parent_id.')');
		while($r = mysqli_fetch_row($child_query)) {
			$rows[''.$parent_name.'']['children'][] = $r[0];
		}
		##Parentvars
		$parentvars_query = mysqli_query($link, 'SELECT parent_var, value FROM parentvars WHERE parent_id='.$parent_id.'');
		while($parentvars = mysqli_fetch_array($parentvars_query)) {
			$rows[''.$parent_name.'']['vars'][''.$parentvars['parent_var'].''] = $parentvars['value'];
		}
	}
	mysqli_free_result($parentvars_query);
	mysqli_free_result($parent_query);
	mysqli_free_result($child_query);
##Print hostgroups and members and hostgroupvars
	$groups_query = mysqli_query($link, 'SELECT group_id,name FROM hostgroups');
	while($groups = mysqli_fetch_array($groups_query)) {

		$group_name = $groups['name'];
		$group_id = $groups['group_id'];
		$hostname_query	= mysqli_query($link, 'SELECT name FROM hosts WHERE host_id IN (SELECT host_id FROM memberships WHERE group_id='.$group_id.')');
		while($r = mysqli_fetch_row($hostname_query)) {
		$rows[''.$group_name.'']['hosts'][] = $r[0];
		}
		$groupvars_query = mysqli_query($link, 'SELECT group_var, value FROM groupvars WHERE group_id='.$group_id.'');
		while($groupvars = mysqli_fetch_array($groupvars_query)) {
			$rows[''.$group_name.'']['vars'][''.$groupvars['group_var'].''] = $groupvars['value'];
		}
	}
	mysqli_free_result($hostname_query);
	mysqli_free_result($groups_query);
	mysqli_free_result($groupvars_query);
#hostvariable build for remove load on inventory
	$all_host_query = mysqli_query($link, 'SELECT * from hosts');
	while($all_host = mysqli_fetch_array($all_host_query)) {
	        $hostvars_query = mysqli_query($link, 'SELECT host_var,value FROM hostvars WHERE host_id='.$all_host['host_id'].'');
		while($hostvars = mysqli_fetch_array($hostvars_query)) {
			$rows['_meta']['hostvars'][''.$all_host['name'].''][''.$hostvars['host_var'].''] = $hostvars['value'];
		}

	}
#Format end print out as json
	print json_encode($rows);
        mysqli_free_result($all_host_query);
        mysqli_free_result($hostvars_query);

}

if(isset($_GET['q']) && isset($_GET['hostname']) && $_GET['q'] == "host") {
	$hostvars_query = mysqli_query($link, 'SELECT host_var,value FROM hostvars WHERE host_id IN (SELECT host_id FROM hosts WHERE name="'.$_GET['hostname'].'")');
	$variable_num = mysqli_num_rows($hostvars_query);
	if($variable_num > 0){
		while($hostvars = mysqli_fetch_array($hostvars_query)) {
		        $rows[''.$hostvars['host_var'].''] = $hostvars['value'];
		}
	}
	else {
			$rows['_meta']['hostvars'] = "";
	}
	#Format end print out as json
	print json_encode($rows);
}

mysqli_close($link);
?>
