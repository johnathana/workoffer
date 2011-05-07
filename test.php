<html> 
<head> 
<title>Test1</title> 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
 
</head> 

<body>

<?php

$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

//mysql_query("set names 'utf8'", $link);
//mysql_query("set character set 'utf8'", $link);


$db_selected = mysql_select_db('workoffer', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}

$result = mysql_query("SELECT * FROM users");


echo "<table>\n";

while ($row = mysql_fetch_assoc($result))
{
    echo "<tr><td>".$row['name']."</td><td>".$row['surname']."</td></tr>\n";
}

echo "</table>\n";


// Free the resources associated with the result set
// This is done automatically at the end of the script
mysql_free_result($result);


mysql_close($link);


?>

</body>
</html>
