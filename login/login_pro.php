<?php

use function PHPSTORM_META\type;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        date_default_timezone_set('Africa/Nairobi');
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=timo', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $uname = $_POST['uname'];
        $pword = $_POST['pword'];
        // var_dump($uname, $pword);

        $statement = $pdo->prepare('SELECT * FROM users WHERE username = :uname');
        $statement->bindValue(':uname', $uname);
        $statement->execute(); 
        $user = $statement->fetchAll(PDO::FETCH_ASSOC);

        // If user exists continue otherwise exit with an error
        if ($user){
            // If password is correct continue otherwise abort
            if ($pword==$user[0]['password']){
                // session staff
                session_start();
                $_SESSION['first_name'] = $user[0]['fname'];
                $_SESSION['last_name'] = $user[0]['lname'];
                $_SESSION['username'] = $user[0]['username'];
                // Check whetheruser is in the password_attempt table
                header('Location: ../home');
  
            }else{
                // Check wether user entered wrong passwword  again
               
                header('Location: index.php?err=Wrong Pasword');

            }
        }
        else {
            header('Location: index.php?err=Wrong Credentials');
            
        }
    
    }
    

?>