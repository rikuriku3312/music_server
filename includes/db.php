<?php

$dbname = 'music_server';
$host = 'localhost';
$username = 'riku';
$password = 'password';

try{
    $pdo = new PDO ("mysql:dbname=$dbname;host=$host;", $username, $password);
}catch (PDOException $e){
    exit('Error:'.$e->getMessage());
}