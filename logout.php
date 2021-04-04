<? 
session_start();

$valid_user = $_SESSION['valid_user'];

// echo "valid_user = **$valid_user**<br>\n";

?>

<html>
<body>
<table>
<tr valign='top'>
<td width=150>

<?
// Fill out the navigation bar on the left side of the page
include("nav.php");
?>

</td>
<td>

<h1>Log Out</h1>
<?

$old_user = $valid_user;  //store to test if they were logged in
unset($_SESSION['valid_user']);
session_destroy();

if (!empty($old_user))
{
	if($result)
	{
		// if they were logged in they are now logged out
		echo "Logged out.<br>\n";
	}
	else
	{
		// they were loggged in and could not be logged out
		echo "Could not log you out.<br>\n";
	}
}
else
{
	//if they were not logged in but came to this page somehow
	echo "You were not logged in, and so you have not been logged out.<br>\n";
}

include('displayschedule.php');
?>



</td>
</tr>
</table>
</body>
</html>


