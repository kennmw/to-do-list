<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
date_default_timezone_set('Africa/Nairobi');

    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=timo', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Details submitted by user 
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $username = $_POST['uname'];
    $pword1 = $_POST['pword'];
    $pword2 = $_POST['pword1'];
   
    // Confirm whether user exists in the database
    $username_ = $pdo->prepare("SELECT * from users where username = :username");
    $username_->bindValue(':username', $username);
    $username_->execute();
    $username_result = $username_->fetchAll(PDO::FETCH_ASSOC);

    if($username_result){
        header('Location: http://localhost/timo/login?msg=Username exist in database');exit;
    }
    

    // Confirm whether pass is real
    if ($pword1 != $pword2){
        header('Location: index.php?err=PasswordMissmatch');
    }
    $date_= date('Y-m-d H:i:s');


    $state_basic_info = $pdo->prepare("INSERT INTO users (fname, lname,username, password,date_reg)
                VALUES (:fname, :lname,:username, :password,:date_reg)");
    $state_basic_info->bindValue(':fname', $first_name);
    $state_basic_info->bindValue(':lname', $last_name);
    $state_basic_info->bindValue(':username', $username);
    $state_basic_info->bindValue(':password', $pword1);  
    $state_basic_info->bindValue(':date_reg', $date_); 
    $state_basic_info->execute();


    if(true){
        header('Location: ../login/index.php?msg=Please Login to your account');
    }




}
?>