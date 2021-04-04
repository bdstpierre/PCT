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
<?
// Get the first name of the user
	$dbh = mysql_connect("localhost",$admin,$adpass);
	mysql_select_db($database_name, $dbh);
	$query = "select first_name, last_name from $table_players "
			 . "where uname = '" . $valid_user . "' ";
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	}
	if (mysql_num_rows($result) <> 1)
	{
		echo "Unable to find a unique user with that ID";
		return 0;
	}
	
	// Parse the result
	while ($thearray = mysql_fetch_array($result))
	{
		extract ($thearray);
	}
	
//Get the user's availability

	$query = "select $table_play_dates.week_no, 
			$table_play_dates.calender_date, 
			$table_play_dates.play, 
			$table_availability.player_id, 
			$table_availability.avail,
			$table_players.first_name
			from $table_availability,  $table_play_dates, $table_players
			where $table_play_dates.week_no = $table_availability.week_no 
			and $table_availability.player_id = $table_players.player_id
			and $table_players.first_name = '". $first_name ."'
			order by week_no";
			
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	}
	
	// Parse the result

	echo "$first_name please review your current availability and update if necessary.<br>\n";
	echo "<form method = 'post' action = 'availupdate.php'>\n";
	echo "<table border = 1>\n";
	echo "<tr><th>Week No</th><th>Date</th><th>Availability</th></tr>\n";
	
	while ($thearray = mysql_fetch_array($result))
	{
		extract ($thearray);
		echo "<tr><td align = 'center'>$week_no</td><td>$calender_date</td>";
		if($play)
		{
			echo "<td>\n";
			echo "<select name = 'week_$week_no' size = 1>\n";
			switch ($avail)
			{
			case "Unknown":
				echo "<option selected>Unknown\n";
				echo "<option>Unavailable\n";
				echo "<option>Available\n";
				break;
			case "Unavailable":
				echo "<option>Unknown\n";
				echo "<option selected>Unavailable\n";
				echo "<option>Available\n";
				break;
			case "Available":
				echo "<option>Unknown\n";
				echo "<option>Unavailable\n";
				echo "<option selected>Available\n";
				break;
			}
			echo "</select>\n";
			echo "</td></tr>\n";
		} else {
			echo "<td><b>No PCT This Week</b></td></tr>\n";
		}
	}
	echo "</tr>\n</table>\n";
	echo "<input type = 'submit' value = ' Update '>\n";
	echo "</form>\n";



?>
</td>
</tr>
</table>
</body>
</html>