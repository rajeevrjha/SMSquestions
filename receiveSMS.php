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
//Read the message as soon as it arrives
$inbox = mysqli_query($dbc, "SELECT SenderNumber,TextDecoded FROM inbox ORDER BY ReceivingDateTime DESC LIMIT 1;");
$row = mysqli_fetch_array($inbox);
$senderNumber = $row['SenderNumber'];
$answer = $row['TextDecoded'];

//Find the student who answered the question
$data = mysqli_query($dbc, "SELECT * FROM students WHERE studentMobile=$senderNumber");
$row = mysqli_fetch_array($data);
$studentID = $row['studentID'];
$studentObjectiveID= $row['studentObjectiveID'];
$studentLevel= $row['studentLevel'];

//Find the question that the student answered
$q = mysqli_query($dbc, "SELECT questionID, questionAnswer FROM questions WHERE objectiveID=$questionObjectiveID AND questionLevel=$studentLevel");
$row = mysqli_fetch_array($q);
$questionAnswer = $row['questionAnswer'];
//Check the response
if ($answer==$questionAnswer){
	
	$response = 'yes';	
	if($studentLevel==0||$studentLevel==2){
		$studentObjectiveID++;
		$studentLevel=1;
	}
	else{
		$studentLevel++;
	}
	
}

else{
	$response = 'no';	
	if($studentLevel==0||$studentLevel==2){
		$studentObjectiveID++;
		$studentLevel=1;
	}
	else{
		$studentLevel--;
	}
	
}
//Record the attempt
$attempt = "INSERT INTO attempts(student_id, question_id, attemptFirst) VALUES($studentID,$questionID,$response)";
$sql= mysqli_query($dbc, $attempt);

//Update the student Level and objective
$update="UPDATE students SET studentObjectiveID=$studentObjectiveID, studentLevel=$studentLevel WHERE studentID=$studentID";
$run = mysqli_query($dbc,$update);

exit;
?>
