<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        date_default_timezone_set('Africa/Nairobi');
        $pdo = new PDO('mysql:host=localhost;port=3306;dbname=timo', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $id = $_POST['id'];
        $item = $_POST['message'];


        $statement = $pdo->prepare('DELETE FROM activities WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute(); 
        header('Location: http://localhost/timo/home?msg=Item Removed: '.$item);

    }
    

?>