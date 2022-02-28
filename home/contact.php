<?php

use function PHPSTORM_META\type;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $username = $_SESSION['username'];
        date_default_timezone_set('Africa/Nairobi');
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=timo', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $deadline = $_POST['deadline'];
        $dead_time = $_POST['time'];
        $message = $_POST['message'];
        
        $time = date("Y-m-d H:i:s");

        $res_state = $pdo->prepare("INSERT INTO activities(username, date, activity, deadline,time, complete)
                VALUES (:username, :date, :activity, :deadline,:dead_time,  :complete)");
        $res_state->bindValue(':username', $username); 
        $res_state->bindValue(':date', $time); 
        $res_state->bindValue(':activity', $message); 
        $res_state->bindValue(':deadline', $deadline); 
        $res_state->bindValue(':dead_time', $dead_time); 
        $res_state->bindValue(':complete', null); 
        $res_state->execute();
        // return to index file
        header('Location: index.php?msg=Event Added: '.$message);
        
}   
    

?>