<?php
    //This file is the place to store all basic functions
    function confirm_query($result_set)
    {
        if(!$result_set)
        {
            die("Database query failed: ". mysql_error());
        }
    }
	/*Βρίσκει το επιθετο μέσω του foreign key*/
	function get_surname_from_professor_id($professor_id)
	{
		global $con;
		$query1 = "SELECT surname FROM users WHERE id='$professor_id'";
		$result_set1 = mysql_query($query1,$con);
		confirm_query($result_set1);
		$row1 = mysql_fetch_assoc($result_set1);
		return $row1;
	}
	/*Βρίσκει το ακαδημαϊκό έτος μέσω του foreign key*/
	function get_ayear_from_academic_year_id($academic_year_id)
	{
		global $con;
		$query2 = "SELECT ayear FROM academic_year WHERE id='$academic_year_id'";
		$result_set2 = mysql_query($query2,$con);
		confirm_query($result_set2);
		$row2 = mysql_fetch_assoc($result_set2);
		return $row2;
	}
	function get_current_year()
	{
		global $con;
		$query="SELECT id FROM academic_year WHERE is_current=true";
		$result_set = mysql_query($query,$con);
		confirm_query($result_set);
		$year = mysql_fetch_assoc($result_set);
		return $year;
	}
    
    function get_user_info($user_id)
    {
        global $con;
		$query = "SELECT * FROM users WHERE id = '$user_id'";
        $result_set = mysql_query("$query",$con);
        confirm_query($result_set);
		$user_info = mysql_fetch_assoc($result_set);
        return $user_info;
		
    }
?>