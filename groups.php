
<?php
	
	include 'dbcon.php';
	$grpsql = mysqli_query($dbcon, "SELECT * FROM grp ") or die(mysqli_error());
    $group = mysqli_fetch_array($grpsql);

    $group_rows = mysqli_num_rows($grpsql);
    $groupNo = $group['grpNo'];
    //var_dump($groupNo);
    ?>

    <table class="w3-table w3-hoverable">
	<thead>
	  <tr class="w3-light-grey">
	    <th>Group No.</th>
	    <th>Members</th>
	    <th>Title</th>
	    <th>Supervisor</th>
	   
	  </tr>
	</thead>
	<tr>
	  <td><?php echo $groupNo ?></td>
	  <td>

	<?php
    /*$membersql = mysqli_query($dbcon, "SELECT regNo FROM members where grpNo= '$groupNo'") or die(mysqli_error()); 
    $members = mysqli_fetch_array($membersql);
    $members_rows = mysqli_num_rows($membersql);

    $memberNo = $members['regNo'];
    var_dump($memberNo);
 */
	//$membersql = "SELECT * FROM student WHERE regNo IN (SELECT regNo FROM members where grpNo = '$groupNo')";

	$membersql = mysqli_query($dbcon, "SELECT regNo, fName, mName, lName FROM student WHERE regNo IN (SELECT regNo FROM members where grpNo = '$groupNo')") or die(mysqli_error()); 
	
	$rows = 1;
	while($rows <= mysqli_num_rows($membersql)) {
		//echo "This is ".$rows. "<br />";
		$members = mysqli_fetch_assoc($membersql);
		//var_dump($members);
		$memberNo = $members['regNo'];

		$member = mysqli_query($dbcon, "SELECT * FROM student WHERE regNo = '$memberNo'") or die(mysqli_error());
		$member_row = mysqli_fetch_array($member);
		$memberName = $member_row['lName'].", ".$member_row['mName']." ".$member_row['fName'];
		echo $memberName. "<br />";

		//var_dump($memberName);
	
		$rows++;
		
	}

	$supId =  "SELECT * FROM `supervisor` WHERE empId = (SELECT empId FROM grp WHERE grpNo = '$groupNo')";
    $supIdsql = mysqli_query($dbcon,$supId) or die(mysqli_error());
    $sup_row = mysqli_fetch_array($supIdsql);

    $supervisor = $sup_row['fName']." ".$sup_row['lName'];
    //var_dump($supervisor);

 	$projectsql = mysqli_query($dbcon, "SELECT projectTitle FROM project WHERE grpNo = '$groupNo'") or die(mysqli_error());
 	$project_row = mysqli_fetch_array($projectsql);
	$title = $project_row['projectTitle'];
	//var_dump($title);

 	?>
	 </td>
	  <td><?php echo $title ; ?></td>
	  <td><?php echo $supervisor; ?>
	<?php //} ?>
</table>