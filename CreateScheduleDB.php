<? 
session_start();
?>

<html>
<body>

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


		$table_players = "players_wed";
		$table_availability = "availability_wed";
		$table_play_dates = "play_dates_wed";
		$table_schedule = "schedule_wed";
	

//Drop the table
		$drop = "DROP TABLE IF EXISTS $table_schedule;";


//Here is the schema for our database:
        
        $database_schema =  "CREATE table $table_schedule (
                row int(4) PRIMARY KEY AUTO_INCREMENT,
                week_no int(4),
                player_id int(4),
                schedule char(20)
        );";

        $dbh = mysql_connect("localhost",$admin,$adpass);

//Try to select CONTACT database. If we can't, try to create database.

        if (!mysql_select_db($database_name)) {
                
                //We don't have a database so make one
                
                if (mysql_create_db($database_name)) {
                        echo "Database Created.<BR>";
                } else {
                        echo mysql_errno().": ". mysql_error ()."";
                }
        }        
                
        //OK, database should be created now, so select it..

        if (!mysql_select_db($database_name)) {
                        echo "Can't Select $database_name";
        }
                
        //Drop the old table if it exists
                
        $res = mysql_query($drop,$dbh);

        //Tell MySQL to create our schema..
                
        $res = mysql_query($database_schema,$dbh);

        if (!$res) {
        	echo mysql_errno().": ". mysql_error ()."";
        //    return 0;
        }
                
        //This is how to add stuff to the database (we need to get this data from the player's list
        
        $query="SELECT player_id FROM $table_players;";
        $res = mysql_query ( $query, $dbh);
        
        if (!$res) {
          	echo mysql_errno().": ". mysql_error ()."";
        	return 0;
        } else {
                $i = 1;
				while($the_sub_array = mysql_fetch_array($res))
				{
					extract ($the_sub_array);
					$players[$i] = $player_id;
					$i++;
				}
                $total_players = mysql_num_rows($res);
       	}
        
        
// Get the number of weeks

	$query = "select distinct week_no from $table_play_dates";
	
	$result = mysql_query($query, $dbh);
	$total_weeks = mysql_num_rows($result);
	
	for($i = 1; $i <= $total_weeks; $i++)
	{   
		for($j=1; $j <= $total_players; $j++)
		{             
	        $week_no = $i;
	        $player = $players[$j];
	        $query = "INSERT into $table_schedule
	                       ( week_no,
	                       player_id,
	                       schedule)
	        values (
	                       '$week_no',
	                       '$player',
	                       'Unknown')";
	                                
	        $res = mysql_query ($query,$dbh);
	                
	        if (!$res) {
	        	echo mysql_errno().": ". mysql_error ()."";
	        	return 0;
	        } else {
	        //we added our first info to the database..
	        echo "$i $week_no $player added.<BR>";
        	}
		}
     }   
        
/*        //"SELECT * FROM MYTABLE" is how you get EVERYTHING from one table
        
        $query = sprintf ("SELECT * FROM %s",$table_schedule);
        
        $res = mysql_query($query, $dbh);
        
        if (!$res) {
                echo mysql_errno().": ". mysql_error ()."";
                return 0;
        }
        //print out everything in our database.
        while ($thearray = mysql_fetch_array($res)) {
                extract ($thearray);
                printf ("%s %s %s %s %s %s %s retrieved from database.<BR>",
                        $first_name, $last_name, $email, $phone_1, $phone_2, $username, $password);
         }

*/
?>
</td>
</tr>
</table>
</body>
</html>