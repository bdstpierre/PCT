<?
// Navigation Bar

if ($_SESSION['valid_user'])
{

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
	
	// Get the real name of the user
	
	
	if(!$dbh = mysql_connect( "localhost", $admin, $adpass))
	{
		echo "Can't connect to MySQL Server.  Errorcode: ". mysql_errno(). ": ". mysql_error()."<br>\n";
		exit;
	}

    if (!mysql_select_db($database_name)) 
    {
		echo "Can't Select $database_name";
    }

	$query = "select first_name, last_name from $table_players "
			 . "where uname = '" . $_SESSION['valid_user'] . "' ";
	
	$result = mysql_query( $query, $dbh);
	
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
	
	echo "Welcome<br>$first_name $last_name<br>\n";
	echo "<a href = 'index.php'>Home</a><br>\n";
	echo "<a href = 'avail.php'>Availability</a><br>\n";
	if ( $_SESSION['valid_user'] == 'barry'||  $_SESSION['valid_user'] == 'bob')
	{
		echo "<a href = 'schedule.php'>Make Schedule</a><br>\n";
		echo "<a href = 'users.php'>Manage Users</a><br>\n";
	}
	if ( $_SESSION['valid_user'] == 'barry')
	{
		echo "<a href = 'makecalendar.php'>Create Play Dates</a><br>\n";
		echo "<a href = 'CreateAvailDB.php'>Create Availability DB</a><br>\n";
		echo "<a href = 'CreateScheduleDB.php'>Create Schedule DB</a><br>\n";
	}
	echo "<a href = 'displayschedule.php' target = '_blank'>Printer Friendly</a><br>\n";
	echo "<a href = 'logout.php'>Log Out</a><br>\n";
} 
else 
{
	echo "<a href = 'login.php'>Login</a><br>\n";
	echo "<a href = 'index.php'>Home</a><br>\n";
//	echo "<a href = 'print.php'>Printer Friendly</a><br>\n";
//	echo "<a href = 'logout.php'>Log Out</a><br>\n";
}

//	mysql_free_result($result);

?>