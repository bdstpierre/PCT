<?

	If ( $_SERVER["HTTP_HOST"] == 'www.annarbortennis.com') {
		$admin = 'annarb12_bstpierr';
		$adpass = 'myaccess';
		$database_name = 'annarb12_tennis';
	} else {
		$admin = 'root';
		$adpass = 'myaccess';
		$database_name = 'tennis';
	}	


	$table_players = "players_demo";
	$table_availability = "availability_demo";
	$table_play_dates = "play_dates_demo";
	$table_schedule = "schedule_demo";
	
	echo "<table border = 1>\n";
	echo "<tr><th>Week No</th><th>Date</th>\n";


// Get the first name of the user
	$dbh = mysql_connect("localhost",$admin,$adpass);
	mysql_select_db($database_name, $dbh);
	$query = "select player_id, first_name, last_name, uname from $table_players order by player_id";
	$result = mysql_query($query, $dbh);
// Get the number of players
	$num_players = mysql_num_rows($result);

	if (!$result)
	{
		echo mysql_errno().": ". mysql_error()."";
		return 0;
	}
// Create the header row for the schedule table
	while ($thearray = mysql_fetch_array($result))
	{
		extract ($thearray);
		echo "<th>$first_name<br>$last_name</th>\n";
// Initialize the keyed array of how many weeks each player plays
		$player_count[$player_id] = 0;
	}
	echo "<th>Count</th></tr>\n";
	
// Get the number of weeks

	$query = "select distinct week_no from $table_play_dates";
	
	$result = mysql_query($query, $dbh);
	$total_weeks = mysql_num_rows($result);
	
// Create the body of the schedule table
    for($i = 1; $i <= $total_weeks; $i++)
	{	
		echo "<tr>\n";
// Initialize the count for each week
        $weekly_count = 0;
	
// Get the Date

// Get the date of the ith week
        $query = "select calender_date, play from $table_play_dates where week_no = $i";
		$result = mysql_query($query, $dbh);
		while ($thearray = mysql_fetch_array($result))
		{
			extract ($thearray);

// The Current Time:
			$cur_time = mktime() - 5*3600;
			
//			echo "Today is: " . $cur_time . "<br />\n";
//			echo "Today is: " . date("d M o H:i:s", $cur_time) . "<br />\n";
			
// PCT Time:
			$pct_sec = 0;
			$pct_min = 00;
			$pct_hour = 21;
			$pct_cal = explode("-", $calender_date);
			$pct_year = $pct_cal[0];
			$pct_month = $pct_cal[1];
			$pct_day = $pct_cal[2];
			$pct_time = mktime($pct_hour, $pct_min, $pct_sec, $pct_month, $pct_day, $pct_year);
			$pct_diff = ($pct_time-$cur_time);
			
//			echo "PCT Date is: " . $pct_time . "<br />\n";
//			echo "Date Difference is: " . $pct_diff . "<br /><br />\n";
			
			
			if($pct_diff > 0 && $pct_diff < 604800)
			{
// Set the date to a green background if it is the next play date
                echo "<td align = 'center' bgcolor = 'ltgreen'>$i</td><td bgcolor = 'ltgreen'>$calender_date</td>\n";
			} else {
				echo "<td align = 'center'>$i</td><td>$calender_date</td>\n";
			}

// If it is a week with no play, span the columns with message
			if (!$play)
			{
				echo "<td colspan = $num_players align = 'center'><b>No PCT This Week!</b></td>\n";
			} else {
// Get one row of Schedule

				$sub_query = "select  
				    $table_players.player_id,
				    $table_players.first_name,
					$table_schedule.schedule 
					from $table_schedule, $table_players
					where $table_players.player_id = $table_schedule.player_id and week_no = $i 
					order by player_id";
			
				$sub_result = mysql_query($sub_query, $dbh);
	
				if (!$sub_result)
				{
					echo mysql_errno().": ". mysql_error()."";
					return 0;
				}
				while($the_sub_array = mysql_fetch_array($sub_result))
				{
					extract ($the_sub_array);
					$sched[$player_id] = $schedule;
				}
				
				foreach($sched as $key => $value)
				{
					$label = "week_" . $key  . "_" . $i;
					if($value == 'Play' || $value == 'Play (Balls)')
					{
						$weekly_count++;
						$player_count[$key]++;
						echo "<td align = 'center' bgcolor = 'yellow'>$value</td>";
					} else {
						echo "<td align = 'center'>$value</td>";						
					}	
					
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

//	echo "sched, key, value, player_count[key]</br>\n";
//	foreach($sched as $key => $value)
//	{
//		echo "$sched, $key, $value, $player_count[$key]</br>\n";
//	}












	if ($_SESSION['valid_user'])
	{
// Print contact info
		
	}
	
	
?>