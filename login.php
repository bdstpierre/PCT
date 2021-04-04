<? 
session_start();

$userid = $_POST['userid'];
$password = $_POST['password'];
$passwordconf = $_POST['passwordconf'];

$valid_user = $_SESSION['valid_user'];


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
	

?>

<html>
<body>
<table>
<tr>
<td width= 150>

<?
// Fill out the navigation bar on the left side of the page
include("nav.php");
?>

</td>
<td>
<h1>Login Page</h1>

<?
$dbh = mysql_connect( "localhost", $admin, $adpass);
if(!$dbh)
{
	echo "Can't connect to MySQL Server.  Errorcode: ". mysql_errno(). ": ". mysql_error()."<br>\n";
	exit;
}
if (!mysql_select_db($database_name)) 
{
	echo "Can't Select $database_name";
}


if (!empty($userid) && isset($userid) && isset($password)  && !empty($password)  && isset($passwordconf))
{
	if ($password == $passwordconf)
	{

		// If the user has just tried to set their password
	
		$query = "update $table_players "
				 . "SET pword = password('$password') "
				 . "where uname = '$userid' ";
				 
//		echo "query = **$query**<br>\n";		 
				 
		
		$result = mysql_query( $query, $dbh);
		if (!$result)
		{
			echo "Saving Password: No Result returned " . mysql_errno().": ". mysql_error()."";
			return 0;
		}
		// If they are in the database register the user id
		echo "User is logged in!<br>\n";
		$valid_user = $userid;
		$_SESSION['valid_user'] = $valid_user;
//		mysql_free_result($result);
	}
	else
	{
		echo "You must enter the same password in both fields<br>\n";
		
		echo "<form method=post action=\"login.php\">\n";
		echo "<table>\n";
		echo "<tr><td>Userid:</td>\n";
		echo "<td><input type=text name=userid value=$userid></td></tr>\n";
		echo "<tr><td>Password:</td>\n";
		echo "<td><input type=password name=password></td></tr>\n";
		echo "<tr><td>Re-ener Password:</td>\n";
		echo "<td><input type=password name=passwordconf></td></tr>\n";
		echo "<tr><td colspan=2 align=center>\n";
		echo "<input type=submit value=\"Log In\"></td></tr>\n";
		echo "</table></form>\n";
		
		
	}
}
else if (!empty($userid) && isset($userid) && !empty($password) && isset($password))
{

	// If the user has just tried to log in
	
	$query = "select * from $table_players "
			 . "where uname = '$userid' "
			 . " and pword = password('$password')";
	$result = mysql_query( $query, $dbh);
	if (!$result)
	{
		echo "Authenticating User: No Result returned " . mysql_errno().": ". mysql_error()."";
		return 0;
	}

	if (mysql_num_rows($result) >0)
	{
		// If they are in the database register the user id
		
		$valid_user = $userid;

		$_SESSION['valid_user'] = $valid_user;
	  	echo "User <b>" . $_SESSION['valid_user'] . "</b> successfully logged in.<br>\n";
	}
	else
	{
		echo "That is not a valid userid and password. Please try again or contact the administrator<br>\n";
		echo "<form method=post action=\"login.php\">\n";
		echo "<table>\n";
		echo "<tr><td>Userid:</td>\n";
		echo "<td><input type=text name=userid></td></tr>\n";
		echo "<tr><td>Password:</td>\n";
		echo "<td><input type=password name=password></td></tr>\n";
		echo "<tr><td colspan=2 align=center>\n";
		echo "<input type=submit value=\"Log In\"></td></tr>\n";
		echo "</table></form>\n";
		
		
		
		
		
	}
//	mysql_free_result($result);
}
else if (!empty($userid) && isset($userid))
{

	$query = "select pword from $table_players "
			 . "where uname = '$userid' ";
	$result = mysql_query( $query, $dbh);
	if (!$result)
	{
		echo "Checking for Password: No Result returned " . mysql_errno().": ". mysql_error()."";
		return 0;
	}
	// Parse the result
	while ($thearray = mysql_fetch_array($result))
	{
		extract ($thearray);
	}
	if ($pword == "")
	{
	// They need to set a password

		echo "Please set a password\n";

		echo "<form method=post action=\"login.php\">\n";
		echo "<table>\n";
		echo "<tr><td>Userid:</td>\n";
		echo "<td><input type=text name=userid value=$userid></td></tr>\n";
		echo "<tr><td>Password:</td>\n";
		echo "<td><input type=password name=password></td></tr>\n";
		echo "<tr><td>Re-ener Password:</td>\n";
		echo "<td><input type=password name=passwordconf></td></tr>\n";
		echo "<tr><td colspan=2 align=center>\n";
		echo "<input type=submit value=\"Log In\"></td></tr>\n";
		echo "</table></form>\n";


	}
//	mysql_free_result($result);
	
	
}
else
{
	// they have not tried to log in yet
	echo "Please Log In<br>\n";
	
	echo "<form method=post action=\"login.php\">\n";
	echo "<table>\n";
	echo "<tr><td>Userid:</td>\n";
	echo "<td><input type=text name=userid></td></tr>\n";
	echo "<tr><td>Password:</td>\n";
	echo "<td><input type=password name=password></td></tr>\n";
	echo "<tr><td colspan=2 align=center>\n";
	echo "<input type=submit value=\"Log In\"></td></tr>\n";
	echo "</table></form>\n";
}
	

?>


</td>
</tr>
</table>
</body>
</html>
