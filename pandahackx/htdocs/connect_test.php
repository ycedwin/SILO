<?php
$dbms='mysql';    
$host='localhost'; 
$dbName='product_web';    
$user='deco3801';      
$pass='ufeJZAecHvpShg2d';          
$dsn="$dbms:host=$host;dbname=$dbName";
$dbh = new PDO($dsn, $user, $pass);


$st = $dbh->prepare("SELECT * FROM test");
  $st->execute();
  while ($row = $st->fetch()) {
    print_r($row);
  }


/*	
	public function addSurvey($name, $id, $sex, $age, $email){
		$stmt = $dbh->prepare("INSERT INTO USER_SURVEY (name, id, sex, age, email_address) VALUES (:name, :id, :sex, :age, :email_address)");
		$stmt = $dbh->prepare("INSERT INTO test (name, value) VALUES (:name, :value)");
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':sex', $sex);
		$stmt->bindParam(':age', $age);
		$stmt->bindParam(':email', $email);
		$stmt->execute();
	}
	
	//public function readSurvey($table){		
	//}
	*/
?>
