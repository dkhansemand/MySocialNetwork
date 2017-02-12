<?php
session_start();
require_once './lib/class.mysql.php';

if($_GET){
    if(!empty($_GET["postId"]) && !empty($_GET["submittedby"])){
        if($_GET["submittedby"] == $_SESSION["id"]){
            $conn = new dbconnector();
            $query = $conn->newQuery("DELETE FROM posts WHERE id = :POSTID AND submittedby = :OWNER");
            $query->bindParam(":POSTID", $_GET["postId"]);
            $query->bindParam(":OWNER", $_SESSION["id"]);
            if($query->execute()){
                $conn = null;
                header('Location: index.php');
                exit;
            }

        }else{
            header('Location: index.php');
            exit;
        }
    }else{
        header('Location: index.php');
        exit;
    }
}else{
    header('Location: index.php');
    exit;
}