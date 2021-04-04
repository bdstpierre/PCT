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
// Update the schedule table

//Get the number of weeks

	$query = "select week_no  
			from $table_play_dates
			order by week_no";
			
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	}

	while ($thearray = mysql_fetch_array($result))
	{
		extract ($thearray);
	}
	
	$total_weeks = mysql_num_rows($result);


//Get the number of players

	$query = "select player_id, 
	                first_name  
			from $table_players
			order by player_id";
			
	$result = mysql_query($query, $dbh);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	}
	$j = 1;
	while ($thearray = mysql_fetch_array($result))
	{
		extract ($thearray);
		$players[$j] = $player_id;
		$j++;
	}
		
// Now loop on players and weeks to do all the updates	
	
	for( $i = 1; $i <= $total_weeks; $i++)
	{
		foreach ($players as $key => $person)
		{
			$label = "week_" . $key  . "_" . $i;
			$week_play = $_POST[$label];
			$query = "UPDATE $table_schedule
					SET schedule = '$week_play'
					WHERE week_no = $i
					and player_id = '$person'";
			$up_res = mysql_query($query, $dbh);
		
			if(!$up_res)
			{
				echo mysql_errno().": ". mysql_error()."";
				return 0;
			}
// Test code
//			echo "$query</br>\n";
//			echo "***$week_play***</br>\n";
//			echo "***$label***</br>\n";
		}
	}



// End table update


// Build the update table
	echo "<form method = 'post' action = 'scheduleupdate.php'>\n";
	echo "<table border = 1>\n";
	echo "<tr><th>Week No</th><th>Date</th>\n";


// Get the first name of the user
	$dbh = mysql_connect("localhost",$admin,$adpass);
	mysql_select_db($database_name, $dbh);
	$query = "select player_id, first_name, last_name from $table_players order by player_id";
	$result = mysql_query($query, $dbh);
// Get the number of players
	$num_players = mysql_num_rows($result);
	
	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	}
	while ($thearray = mysql_fetch_array($result))
	{
		extract ($thearray);
		echo "<th>$first_name<br>$last_name</th>\n";
		$player_count[$player_id] = 0;
	}
	echo "<th>Count</th></tr>\n";
	
// Get the number of weeks

	$query = "select distinct week_no from $table_play_dates";
	
	$result = mysql_query($query, $dbh);
	$total_weeks = mysql_num_rows($result);

// For each week ...	
	for($i = 1; $i <= $total_weeks; $i++)
	{	
		echo "<tr>\n";
		$weekly_count = 0;
	
// Get the Date

		$query = "select calender_date, play from $table_play_dates where week_no = $i";
		$result = mysql_query($query, $dbh);
		while ($thearray = mysql_fetch_array($result))
		{
			extract ($thearray);
// Print the week and date
			echo "<td align = 'center'>$i</td><td>$calender_date</td>\n";
			if (!$play)
			{
				echo "<td colspan = $num_players><b>No PCT This Week!</b></td>\n";
			} else {
// Get one row of availability

				$sub_query = "select  
					$table_players.first_name,
					$table_players.player_id as player,
					$table_availability.avail as avail
					from $table_availability, $table_players
					where week_no = $i 
					and $table_players.player_id = $table_availability.player_id
					order by $table_players.player_id";
			
				$sub_result = mysql_query($sub_query, $dbh);
	
				if (!$sub_result)
				{
					echo mysql_errno().": ". mysql_error()."";
					return 0;
				}
				while($the_sub_array = mysql_fetch_array($sub_result))
				{
					extract ($the_sub_array);
					$status[$player] = $avail;
				}
				
// Get one row of Schedule

				$sub_query = "select  
				    $table_players.first_name,
				    $table_schedule.player_id as player, 
					$table_schedule.schedule as schedule
					from $table_schedule, $table_players
					where $table_players.player_id = $table_schedule.player_id 
					and week_no = $i 
					order by $table_players.player_id";

				$sub_result = mysql_query($sub_query, $dbh);
	
				if (!$sub_result)
				{
					echo mysql_errno().": ". mysql_error()."";
					return 0;
				}
				while($the_sub_array = mysql_fetch_array($sub_result))
				{
					extract ($the_sub_array);
					$sched[$player] = $schedule;
				}
				
				foreach($sched as $key => $value)
				{
					$label = "week_" . $key  . "_" . $i;
// Print the status
					echo "<td>$status[$key] : \n";
// Print the schedule
					echo "<select name = '$label' size = 1>\n";
					switch ($value)
					{
					case "Unknown":
						echo "<option selected>Unknown\n";
						echo "<option>Unavailable\n";
						echo "<option>Available\n";
						echo "<option>Play\n";
						echo "<option>Play (Balls)\n";
						break;
					case "Unavailable":
						echo "<option>Unknown\n";
						echo "<option selected>Unavailable\n";
						echo "<option>Available\n";
						echo "<option>Play\n";
						echo "<option>Play (Balls)\n";
						break;
					case "Available":
						echo "<option>Unknown\n";
						echo "<option>Unavailable\n";
						echo "<option selected>Available\n";
						echo "<option>Play\n";
						echo "<option>Play (Balls)\n";
						break;
					case "Play":
						echo "<option>Unknown\n";
						echo "<option>Unavailable\n";
						echo "<option>Available\n";
						echo "<option selected>Play\n";
						echo "<option>Play (Balls)\n";
						$weekly_count++;
						$player_count[$key]++;
						break;
					case "Play (Balls)":
						echo "<option>Unknown\n";
						echo "<option>Unavailable\n";
						echo "<option>Available\n";
						echo "<option>Play\n";
						echo "<option selected>Play (Balls)\n";
						$weekly_count++;
						$player_count[$key]++;
						break;
					}
				echo "</select>\n";
				echo "</td>\n";
					
				} // End foreach
				echo "<td align = 'center'>$weekly_count</td></tr>\n";
			
			}  // End if(!play)
		} // End while(thearray)

	} // End for(each week)
	
	echo "<tr><td colspan = 2>&nbsp;</td>\n";

foreach($sched as $key => $value)
	{
		echo "<td align = 'center'>$player_count[$key]</td>\n";
	}
	echo "</tr>\n";
	echo "</table>\n";
	echo "<input type = 'submit' value = ' Update '>\n";
	echo "</form>\n";



?>
</td>
</tr>
</table>
</body>
</html>