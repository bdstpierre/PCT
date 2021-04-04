<? 
session_start();
?>

<html>
<body>

<?

$valid_user = $_SESSION['valid_user'];


?>
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
	
        $makecal=$_POST['makecal'];
        
?>

<table>
<tr valign='top'>
<td width=150>


<?
// Fill out the navigation bar on the left side of the page
include("nav.php");

$currentyear = date('Y');
$currentyearplus1  = date('Y', mktime(0, 0, 0, date("m"),  date("d"),  date("Y")+1));
$currentyearplus2  = date('Y', mktime(0, 0, 0, date("m"),  date("d"),  date("Y")+2));
$currentyearplus3  = date('Y', mktime(0, 0, 0, date("m"),  date("d"),  date("Y")+3));

?>
</td>
<td>
<?  if( $makecal == ''){  ?>
<form method = 'post' action = 'makecalendar.php'>

<table>
<tr><td colspan='3'>Select the first PCT meeting date:</td></tr>
<tr><td>
	<select name="startmonth">
		<option value='1'>January
		<option value='2'>February
		<option value='3'>March
		<option value='4'>April
		<option value='5'>May
		<option value='6'>June
		<option value='7'>July
		<option value='8'>August
		<option value='9'>September
		<option value='10'>October
		<option value='11'>November
		<option value='12'>December
	</select>
</td><td>
	<select name="startday">
		<option>1
		<option>2
		<option>3
		<option>4
		<option>5
		<option>6
		<option>7
		<option>8
		<option>9
		<option>10
		<option>11
		<option>12
		<option>13
		<option>14
		<option>15
		<option>16
		<option>17
		<option>18
		<option>19
		<option>20
		<option>21
		<option>22
		<option>23
		<option>24
		<option>25
		<option>26
		<option>27
		<option>28
		<option>29
		<option>30
		<option>31
	</select>
</td><td>
	<select name="startyear">
		<option><? echo $currentyear; ?>
		<option><? echo $currentyearplus1; ?>
		<option><? echo $currentyearplus2; ?>
		<option><? echo $currentyearplus3; ?>
	</select>
</td></tr>
<tr><td colspan='3'>Select the last PCT meeting date:</td></tr>
<tr><td>
	<select name="endmonth">
		<option value='1'>January
		<option value='2'>February
		<option value='3'>March
		<option value='4'>April
		<option value='5'>May
		<option value='6'>June
		<option value='7'>July
		<option value='8'>August
		<option value='9'>September
		<option value='10'>October
		<option value='11'>November
		<option value='12'>December
	</select>
</td><td>
	<select name="endday">
		<option>1
		<option>2
		<option>3
		<option>4
		<option>5
		<option>6
		<option>7
		<option>8
		<option>9
		<option>10
		<option>11
		<option>12
		<option>13
		<option>14
		<option>15
		<option>16
		<option>17
		<option>18
		<option>19
		<option>20
		<option>21
		<option>22
		<option>23
		<option>24
		<option>25
		<option>26
		<option>27
		<option>28
		<option>29
		<option>30
		<option>31
	</select>
</td><td>
	<select name="endyear">
		<option><? echo "$currentyear"; ?>
		<option><? echo "$currentyearplus1"; ?>
		<option><? echo "$currentyearplus2"; ?>
		<option><? echo "$currentyearplus3"; ?>
	</select>
</td></tr>
<tr>
<td colspan=3><INPUT type="submit" value="Create Date List"><INPUT type="hidden" name="makecal" value="datearray"></td>
</tr>
</table>

<?        
}

if( $makecal == 'datearray' ){
	
//	mktime(0, 0, 0, date("m"),  date("d"),  date("Y"))
	$startmonth=$_POST['startmonth'];
	$startday=$_POST['startday'];
	$startyear=$_POST['startyear'];
	$endmonth=$_POST['endmonth'];
	$endday=$_POST['endday'];
	$endyear=$_POST['endyear'];
	
	$test=1;
	$i=0;
	$endtime=mktime(0,0,0,$endmonth,$endday,$endyear);
	
	while ( $test > 0 ) {
		$days[$i] = date("Y-m-d", mktime(0,0,0,$startmonth,$startday+$i*7,$startyear));
		$plays[$i] = 1;
		$i++;
		if ( mktime(0,0,0,$startmonth,$startday+$i*7,$startyear) > $endtime )
			$test = 0;
	}

	echo "<form method = 'post' action = 'makecalendar.php'>\n";

	echo "<table>\n";
	echo "<tr><td align=center>Play</td><td align=center>Off</td><td>Date</td></tr>\n";
	for($i=0; $i < count($days); $i++)
	{
		echo "<tr><td align=center>\n";
		echo "<input type='radio' value='1' name=play$i checked>\n";
		echo "</td><td align=center>\n";
		echo "<input type='radio' value='0' name=play$i>\n";
		echo "</td><td>\n";
		echo "$days[$i]\n";
		echo "</td></tr>\n";
		echo "<input type='hidden' name=day$i value=$days[$i]>\n";
	}
	echo "<tr><td colspan=3><input type='submit' value=' Submit '></td></tr>\n";
	echo "</table>\n";
	echo "<input type='hidden' name='daycount' value=" . count($days) . ">\n";
	echo "<input type='hidden' name='makecal' value='makedates'>\n";
	echo "</form>\n";

}
if($makecal == 'makedates'){

//Drop the table
		$drop = "DROP TABLE IF EXISTS $table_play_dates;";
	
echo "Table Name = $table_play_dates<br>\n";

//Here is the schema for our database:
        
        $database_schema =  "CREATE table $table_play_dates (
                week_no int(4) PRIMARY KEY AUTO_INCREMENT,
                calender_date date,
                play int(4)
        );";

        $dbh = mysql_connect('localhost',$admin,$adpass);

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
        //Drop the table
        $res = mysql_query($drop,$dbh);
                
        //Tell MySQL to create our schema..
                
        $res = mysql_query($database_schema,$dbh);

        if (!$res) {
        	echo mysql_errno().": ". mysql_error ()."\n";
            //return 0;
        }
                
        //This is how to add stuff to the database
        $daycount = $_POST['daycount'];
        //Replace the following with a for loop to get the $days[$i]=$_POST['day$i'] data
        for($i=0; $i < $daycount; $i++){
        	$days[$i]=$_POST["day$i"];
        	$plays[$i]=$_POST["play$i"];
        }
        
	for($i=0; $i < count($days); $i++)
	{                
        $calender_date = $days[$i];
        $play = $plays[$i];
        $query = "INSERT into $table_play_dates
                       ( calender_date,
                       play)
        values (
                       '$calender_date',
                       '$play')";
                                
        $res = mysql_query ($query,$dbh);
                
        if (!$res) {
        	echo mysql_errno().": ". mysql_error ()."";
        	return 0;
        } else {
        //we added our first info to the database..
        echo "$k $calender_date $play added.<BR>";
        }

     }   
     
     echo "<form method = 'post' action = 'makecalendar.php'>\n";
     echo "	<input type='hidden' name='makecal' value=''>\n";
     echo "	<input type='submit' name='ok' value=' OK '>\n";
     
     echo "</form>\n";

//echo "Make Table<br>\n";
}        
?> 

</td>
</tr>
</table>
</body>
</html>