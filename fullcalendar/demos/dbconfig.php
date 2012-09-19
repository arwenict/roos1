<?php
class DBConnection{
	function getConnection(){
	  //change to your database server/user name/password
		mysql_connect("localhost","arw49555_b4","@rwen1234") or
         die("Could not connect: " . mysql_error());
    //change to your database name
		mysql_select_db("arw49555_b5") or 
		     die("Could not select database: " . mysql_error());
	}
}
?>