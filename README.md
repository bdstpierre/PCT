# PCT

## Description
I pay a lot of tennis.  Part of my tennis is weekly tennis with friends at the tennis club I belong to.  They offer 
a service they call Permanent Court Time (PCT).  You sign a contract commiting to using the same court every week at the same time.
This agreement is in effect from just after Labor Day to the first week in May.  I have had several of these PCTs and
the way my groups typically set these up is we overbook the number of players.  I given night will have four players on the court 
but we will have five in the group so we have enough when some of the memebrs of the group are unable to make it due to a conflict.
Someties we have even more than five if there are a lot of conflicts for the members.

I created this website to manage the information of who is available which weeks and then scheduling and publishing the schedule.

The website was originally written in PHP version 5.6 (or earlier) and does not use CSS but does use MySQL.  I am slowly working to convert it to version 7.3 functions.  To aid in this
I have creaeted a variable named $php_flag.  If this variable is 'TRUE' then the version 5.3 instructions are run, otherwise the 7.3 version instructions
are run.  The converted files are not deployed yet.

## Table of Contents
If your README is long, add a table of contents to make it easy for users to find what they need.
- [Installation](#installation)
- [Usage](#usage)
- [Credits](#credits)
- [License](#license)

## Installation
The webiste consists of a number of files that I list here with the functions they provide:

### index.php
The index.php file sets up the resting state of the website.  It checks to see if a valid user is logged in and if so puts their session id in the variable $valid_user.  It then uses <table> tags to create the layout of the page (this was written in 2006 or earlier and with out CSS!).  The file pulls in the navigation menu using an include statement on the nav.php file.  The file then displays the current schedule by including the displayschedule.php file.  I have several PCT court times and my web host that I had allowed one MySQL database.  To get around this issue, I created multiple versions of the files and tables, one set each for Monday, Wednesdsay and Thursday.  (Did I mention I play a lot of tennis?)  index.php displays links to the three different websites at the bottom of the page to make navigation between the three more convenient.
  
### nav.php  
The file nav.php sets up the menu bar that is displayed along the left side of the screen.  The first thing nav.php does is to check the to see if the server host is the production server or the local test server.  Based on which server is detected, it sets the values in the variables for database access.  These variables incluse $admin for username, $adpass for user password, $database_name for the database name and sets the variable $psp_flag for the level of PHP used.  My production server still supports the older version of PHP but my dvelopment server no longer does.   

Now that nav.php knows the information to connect to the database server, it creates that connection, with error checking to make sure it was successful.  After the connection is made to the database server, the proper database is selected.  Once all of that is successfully run, a query is made to select the player names.  

There are four levels of access to the schedule.  Anyone can view the schedule.  No login is required.  In the state, the navigation bar displays the following menu items: *Login*, *Home*, *Log out* (this one should be removed since the program knows you are not logged in).  Players who are in the list of players in the database can log in by clicking that link.  

If the player is logged in, the site enters the second level of access. The menu bar adds two additional selections called *Availability* and *Printer Friendly*.  This Availability link allows the user to go to a page to indicate their availability (whether they are *Available*, *Unavailable*, or *Unknown* (the default setting when the database table for availability was created)).  The printer Friendly link opens a new tab with just the schedule and none of the navigation items. 

The third level of access is scheduling access.  This is determined by the name of the user and is coded in the nav.php file.  If the user is allowed access to the scheduling functions, they get two additional menu items that are used for managing the data.  These items are *Make Schedule*, and *Manage Users*.  The *Manage Schedules* item allows the scheduler to indicate who is playing on each date through a matrix of drop down menus.  The *Manage Users* item is intended to enable the scheduler to add and remove players.  I have founbd there are issues with this function so I don't currently use it.  I edit the players table directly using phpMyAdmin.  I need to look into this further.

The fourt level of access is full access.  This is also controlled by the name of the person logged in.  If the person has full access they will get three more menu items:  *Create Play Dates*, *Creaete Availability DB*, and *Create Schedule DB*.  The person with this access can create the databases that hold the schedule data.  These funtions will overwrite the existing databases.

### displayschedule.php

The file displayschedule.php does the work of displaying the schedule.  At the beginning of the file displayschedule.php has the same logic as nav.php for setting the variables for accessing the database and creates the connection.  

Once display schedule.php has access to the database, it gets the names and IDs of the players from the player table.  Next it gets the number of weeks from the table play_dates.  Once it has the number of weeks it loops through the weeks getting the data for each row and fillinig in as it goes.

For each week it first calulatesthe current data and time.  It will use this to compare with the dates in the schedule so the next week that is played is highlighted green so it stands out.  I added this because sometimes players would look at the wrong date and either show up when they were not suppose to, or worse, not show up when they were suppose to.  Once it has the current date figured out, it queries the schedule table to pull the player_id and schedule from the table for the week as requested in the for loop.  It then generates the HTML to fill out the table and colors the cell yellow if the player is scheduled to play that week.  This is repeated until all of the weekshave been queried and displayed.  The program also keepssome counts so it can displayhow many people are scheduled to play each week (if it isn't four than some action needs to be taken to make it four!) and how many times each player is scheduled to play for the session.

### avail.php


### availupdate.php


### schedule.php


### scheduleupdate.php


### login.php


### logout.php


### users.php


### makecalendar.php


### CreateAvailabilityDB.php


### CreateScheduleDB.php




## Usage
Provide instructions and examples for use. Include screenshots as needed.
To add a screenshot, create an `assets/images` folder in your repository and upload your screenshot to it. Then, using the relative filepath, add it to your README using the following syntax:
    ```md
    ![alt text](assets/images/screenshot.png)
    ```

## Credits


## License
MIT License

Copyright (c) [2021] [Barry St. Pierre]

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


