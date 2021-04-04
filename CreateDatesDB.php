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
                
        //Tell MySQL to create our schema..
                
        $res = mysql_query($database_schema,$dbh);

        if (!$res) {
        	echo mysql_errno().": ". mysql_error ()."\n";
            //return 0;
        }
                
        //This is how to add stuff to the database
        
        $days = array(	'2006-09-07', 
        				'2006-09-14', 
        				'2006-09-21', 
        				'2006-09-28', 
        				'2006-10-05', 
        				'2006-10-12', 
        				'2006-10-19', 
        				'2006-10-26', 
        				'2006-11-02', 
        				'2006-11-09', 
        				'2006-11-16', 
        				'2006-11-23', 
        				'2006-11-30', 
        				'2006-12-07', 
        				'2006-12-14', 
        				'2006-12-21', 
        				'2006-12-28', 
        				'2007-01-04');
        $plays = array( 1, 
        				1, 
        				1, 
        				1,
        				1, 
        				1, 
        				1, 
        				1,
        				1, 
        				1, 
        				1, 
        				0, 
        				1, 
        				1, 
        				1, 
        				1, 
        				1, 
        				1);	
        
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
        
?> 