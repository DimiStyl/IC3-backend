<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// connect to the database
$db = new PDO('sqlite:group/test/api/db/login.sqlite');

// retrieve the form data
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$name=$_POST['name'];
$status=$_POST['status'];
$user_type=$_POST['user_type'];

//hash password
$encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
// insert the new user into the database
$stmt = $db->prepare('INSERT INTO account (username, password, email,name,status,user_type) 
VALUES (:username, :password, :email, :name, :status, :user_type)');
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $encryptedPassword);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':status', $status);
$stmt->bindParam(':user_type', $user_type);
$stmt->execute();
?>
