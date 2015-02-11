<?php

//Define database user, name, password and host
DEFINE ('DBUSER', 'root'); 
DEFINE ('DBPW', 'heroatlas'); 
DEFINE ('DBHOST', 'localhost'); 
DEFINE ('DBNAME', 'sms');

//Connect to the database
$dbc = mysqli_connect(DBHOST,DBUSER,DBPW);
if (!$dbc) {
    die("Database connection failed: " . mysqli_error($dbc));
    exit();
}

$dbs = mysqli_select_db($dbc, DBNAME);
if (!$dbs) {
    die("Database selection failed: " . mysqli_error($dbc));
    exit(); 
}

//Get list of all the students to whom sms is to be sent 
$studentList = mysqli_query($dbc, "SELECT * FROM students");
$numberOfRows = mysqli_num_rows($studentList);
echo $numberOfRows;

//Send SMS to every student
for($i=0; $i<$numberOfRows; $i++)
{
	$row = mysqli_fetch_array($studentList);
	$studentObjectiveID = $row['studentObjectiveID'];
	$studentMobile = $row['studentMobile'];
	$studentLevel = $row['studentLevel'];

	$question = mysqli_query($dbc, "SELECT question FROM questions WHERE objectiveID=$studentObjectiveID AND questionLevel=$studentLevel");
	
	$var = '/home/john/testSMS/sendSMS.sh '.$studentMobile.' '.$question;
	exec($var);

	
	
}

exit;
?>
