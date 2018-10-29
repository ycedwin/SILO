<?php
$dbms='mysql';    
$host='localhost'; 
$dbName='product_web';    
$user='deco3801';      
$pass='ufeJZAecHvpShg2d';          
$dsn="$dbms:host=$host;dbname=$dbName";
$dbh = new PDO($dsn, $user, $pass);


		$st = $dbh->prepare("INSERT INTO user_survey (name, id, gender, age, job, email, comment) VALUES (:name, :id, :gender, :age, :job, :email, :comment)");
		
		$st->bindParam(':name', $name);
		$st->bindParam(':id', $id);
		$st->bindParam(':gender', $gender);
		$st->bindParam(':age', $age);
		$st->bindParam(':job', $job);
		$st->bindParam(':email', $email);
		$st->bindParam(':comment', $comment);
		
		$name = $_POST["name"];
		$id = md5(time().mt_rand());
		$gender = $_POST["gender"];
		$age = $_POST["age"];
		$job = $_POST["job"];
		$email = $_POST["email"];
		$comment = $_POST["comment"];
		$st->execute();          
		
?>
