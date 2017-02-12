<?php

session_start();

if(!isset($_SESSION["isLoggedIn"])){
    header('Location: login.php');
    exit();
}

require './lib/class.mysql.php';

if($_POST){
     if(!empty($_POST["userId"]) && $_POST["userId"] == $_SESSION['id']){
        $userId = $_POST["userId"];
        $conn = new dbconnector();
        $query = $conn->newQuery("DELETE FROM users WHERE users.id = :ID");
        $query->bindParam(":ID", $userId, PDO::PARAM_STR);
        if($query->execute()){
            $conn = null;
            session_destroy();
            echo 'Din bruger er nu slettet. Tak for denne gang!';
            header('Refresh: 5; url=./');
            exit;
        }
     }else{
         header('Location: ./');
         exit;
     }
}else{
    header('Location: ./');
    exit;
}

?>