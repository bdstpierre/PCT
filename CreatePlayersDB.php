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
        
		$table_players = "players_wed";
		$table_availability = "availability_wed";
		$table_play_dates = "play_dates_wed";
		$table_schedule = "schedule_wed";

//This is the information we initialize the database with.

        $first_name = "Barry";
        $last_name = "St. Pierre";
        $phone_1 = "734-994-5821";
        $phone_2 = "734-657-7730";
        $email = "barry@stpierre.com";
        $username = "barry";
        $password = "";
        

//Here is the schema for our database:
        
        $database_schema =  "CREATE table $table_players (
                player_id int(4) PRIMARY KEY AUTO_INCREMENT,
                first_name char(30),
                last_name char(30),
                email char(40),
                phone_1 char(20),
                phone_2 char(20),
                uname char(20),
                pword char(50)
        );";

        $dbh = mysql_connect($hostname,$admin, $adpass);

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
                
		$query = "DROP TABLE IF EXISTS $table_players;";
		$res = mysql_query($query, $dbh);

        //Tell MySQL to create our schema..
                
        $res = mysql_query($database_schema,$dbh);

        if (!$res) {
        	echo mysql_errno().": ". mysql_error ()."";
            return 0;
        }
                
        //This is how to add stuff to the database
                
        $query = "INSERT into $table_players
                       ( first_name,
                       last_name,
                       email,
                       phone_1,
                       phone_2,
                       uname,
                       pword)
        values (
                       '$first_name',
                       '$last_name',
                       '$email',
                       '$phone_1',
                       '$phone_2',
                       '$username',
                       '$password');";
                                
        $res = mysql_query ($query,$dbh);
                
        if (!$res) {
        	echo mysql_errno().": ". mysql_error ()."";
        	return 0;
        } else {
        //we added our first info to the database..
        echo "$first_name $last_name $email $phone_1 $phone_2 $username $password added.<BR>";
        }

        
        
        //"SELECT * FROM MYTABLE" is how you get EVERYTHING from one table
        
        $query = sprintf ("SELECT * FROM %s",$table_players);
        
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


?> 