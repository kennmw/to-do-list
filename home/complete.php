<?php

use function PHPSTORM_META\type;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        date_default_timezone_set('Africa/Nairobi');
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=timo', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $id = $_POST['id'];
        $item = $_POST['message'];
        // var_dump($uname, $pword);

        $statement = $pdo->prepare('UPDATE activities SET complete=1 WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute(); 
        $user = $statement->fetchAll(PDO::FETCH_ASSOC);
        header('Location: http://localhost/timo/home?msg=Item Marked as complete: '.$item);

        
    
    }
    

?>