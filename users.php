<? 
session_start();
?>

<html>
<body>

<?

$valid_user = $_SESSION['valid_user'];

$table_players = "players_demo";
$table_availability = "availability_demo";
$table_play_dates = "play_dates_demo";
$table_schedule = "schedule_demo";


$newplayer = $_POST['newplayer'];
$dbadd = $_POST['dbadd'];
$update = $_POST['update'];
$dbupdate = $_POST['dbupdate'];
$player = $_POST['player'];
$delete = $_POST['delete'];

?>

<table>
<tr valign='top'>
<td width=150>

<?
// Fill out the navigation bar on the left side of the page
include("nav.php");
?>

</td>
<td>
<h3>PCT Members</h3>

<?

// List the pct members

	$dbh = mysql_connect("localhost",$admin,$adpass);
	mysql_select_db($database_name, $dbh);
	$query = "select uname, first_name, last_name from $table_players "
			 . "order by last_name";
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	}
//	echo "" . mysql_num_rows($result) . " row(s) of users<br>\n";
	
// Start the table
?>
<table>
<tr>
<th>First Name</th>
<th>Last Name</th>
<th>(Username)</th>
</tr>
<?
	// Parse the result
	while ($thearray = mysql_fetch_array($result))
	{
		extract ($thearray);
		echo "<tr><td>$first_name</td><td>$last_name</td><td>($uname)</td></tr><br>\n";
	}
// End the table
?>	
</table>
<p>

<? // If New Player is chosen
if ($newplayer)
{ 
?>
<form action = "users.php" method = "post">
<table>
<tr>
<td colspan = 2>
<b>Please fill out the form:</b>
</td>
</tr>
<tr>
<td>First Name:</td>
<td><input type = "text" size = 30 name = "first_name"></td>
</tr>
<tr>
<td>Last Name:</td>
<td><input type = "text" size = 30 name = "last_name"></td>
</tr>
<tr>
<td>Email Address:</td>
<td><input type = "text" size = 40 name = "email"></td>
</tr>
<tr>
<td>Home Phone Number:</td>
<td><input type = "text" size = 20 name = "phone_1"></td>
</tr>
<tr>
<td>Cell Phone Number:</td>
<td><input type = "text" size = 20 name = "phone_2"></td>
</tr>
<tr>
<td>Enter Username:</td>
<td><input type = "text" size = 20 name = "uname"></td>
</tr>
<input type = 'hidden' value = 0 name = "newplayer">
<tr>
<td><input type = "submit" name = "xnewplayer" value = " Cancel "></td>
<td><input type = "submit" name = "dbadd" value = " Add "></td>
</tr>
</table>
</form>
<?
} 
else if ($update)
{
?>
<?
	echo "Updating player " . $_POST['player'] . "<br>\n";
	$dbh = mysql_connect("localhost",$admin,$adpass);
	mysql_select_db($database_name, $dbh);
	$query = "select first_name, last_name, email, phone_1, phone_2, uname from $table_players "
			 . "where uname = '" . $_POST['player'] ."' "
			 . "order by last_name";
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	}
	// Parse the result
	while ($thearray = mysql_fetch_array($result))
	{
		extract($thearray);
	}
	echo "<form action = 'users.php' method = 'post'>\n";
	echo "<table>\n";
	echo "<tr>\n";
	echo "<td spancol = 2>\n";
	echo "<b>Please edit the form:</b>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>First Name:</td>\n";
	echo "<td><input type = 'text' size = 30 name = 'first_name' value = '$first_name'></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Last Name:</td>\n";
	echo "<td><input type = 'text' size = 30 name = 'last_name' value = '$last_name']></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Email Address:</td>\n";
	echo "<td><input type = 'text' size = 40 name = 'email' value = '$email'></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Home Phone Number:</td>\n";
	echo "<td><input type = 'text' size = 20 name = 'phone_1' value = '$phone_1'></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Cell Phone Number:</td>\n";
	echo "<td><input type = 'text' size = 20 name = 'phone_2' value = '$phone_2'></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Username:</td>\n";
	echo "<td><input type = 'text' size = 20 name = 'uname' value = '$uname'></td>\n";
?>
</tr>
<input type = 'hidden' value = 0 name = "newplayer">
<tr>
<td><input type = "submit" name = "xnewplayer" value = " Cancel "></td>
<td><input type = "submit" name = "dbupdate" value = " Update "></td>
<td><input type = "submit" name = "delete" value = " Delete "></td>
</tr>
</table>
</form>
<?
}
else if ($dbadd)
{
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phone_1 = $_POST['phone_1'];
	$phone_2 = $_POST['phone_2'];
	$username = $_POST['uname'];
	
	$dbh = mysql_connect("localhost",$admin,$adpass);
	mysql_select_db($database_name, $dbh);
        $query = "INSERT into $table_players
                       ( first_name,
                       last_name,
                       email,
                       phone_1,
                       phone_2,
                       uname)
        values (
                       '$first_name',
                       '$last_name',
                       '$email',
                       '$phone_1',
                       '$phone_2',
                       '$username');";
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	} else {
		echo "$first_name, $last_name, $email, $phone_1, $phone_2, $username added to the database.<br>\n";
	}
?>
<form action = 'users.php' method = 'post'>
<input type = "submit" name = "xnewplayer" value = " OK ">
</form>
<?
}
else if ($dbupdate)
{
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phone_1 = $_POST['phone_1'];
	$phone_2 = $_POST['phone_2'];
	$username = $_POST['uname'];
	
	$dbh = mysql_connect("localhost",$admin,$adpass);
	mysql_select_db($database_name, $dbh);
        $query = "UPDATE $table_players
                       SET first_name = '$first_name',
                           last_name = '$last_name',
                           email = '$email',
                           phone_1 = '$phone_1',
                           phone_2 = '$phone_2',
                           uname = '$username'
        where uname = '$uname'";
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	} else {
		echo "$first_name, $last_name, $email, $phone_1, $phone_2, $username updated in the database.<br>\n";
	}
?>
<form action = 'users.php' method = 'post'>
<input type = "submit" name = "xnewplayer" value = " OK ">
</form>
<?
}
else if ($delete)
{
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$phone_1 = $_POST['phone_1'];
	$phone_2 = $_POST['phone_2'];
	$username = $_POST['uname'];
	
	$dbh = mysql_connect("localhost",$admin,$adpass);
	mysql_select_db($database_name, $dbh);
        $query = "DELETE FROM $table_players
                       WHERE last_name = '$last_name'
                       LIMIT 1";
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	} else {
		echo "$first_name, $last_name, $email, $phone_1, $phone_2, $username deleted from the database.<br>\n";
	}
?>
<form action = 'users.php' method = 'post'>
<input type = "submit" name = "xnewplayer" value = " OK ">
</form>
<?
}
else
{ 
 // This is the ready state (maybe this should be last!)
?>
<form action = "users.php" method = "post">
<table>
<tr>
<td>
Click on <input type="submit" value= " New Player " name="newplayer">
or 
</td><td>
Select a Player to Modify: 
<select name = "player" size = 1>
<?
	$dbh = mysql_connect("localhost",$admin,$adpass);
	mysql_select_db($database_name, $dbh);
	$query = "select uname, first_name, last_name from $table_players "
			 . "order by last_name";
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	}
	// Parse the result
	while ($thearray = mysql_fetch_array($result))
	{
		extract ($thearray);
		echo "<option value = '$uname'>$first_name $last_name\n";
	}

	echo "</select>\n";
	echo "<br>\n";
	echo "<input type = 'submit' name = 'update' value = ' Update '>\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
}
?>



</td>
</tr>
</table>
</body>
</html>
