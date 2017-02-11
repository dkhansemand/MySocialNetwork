<?php

session_start();

if(!isset($_SESSION["isLoggedIn"])){
    header('Location: login.php');
    exit();
}

require './lib/class.mysql.php';

if($_GET){
    if(!empty($_GET["id"]) && isset($_GET["accept"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("UPDATE friends 
            SET friends.StatusConfirm = 1, friends.Action_userId = :USERTWO, friends.ConfirmDate = NOW()
            WHERE friends.userOneId = :ID AND friends.userTwoId = :USERTWO");
            $query->bindParam(":USERTWO", $_SESSION["id"], PDO::PARAM_STR);
        $query->bindParam(":ID", $_GET["id"], PDO::PARAM_STR);
        if($query->execute()){
            $conn = null;
            echo 'venskab accepteret.';
            header('Location: ./friends.php');
        }
    }elseif(!empty($_GET["id"]) && isset($_GET["removeReq"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("DELETE FROM friends WHERE friends.userOneId = :ID AND friends.userTwoId = :USERTWO");
        $query->bindParam(":USERTWO", $_SESSION["id"], PDO::PARAM_STR);
        $query->bindParam(":ID", $_GET["id"], PDO::PARAM_STR);
        if($query->execute()){
            $conn = null;
            echo 'Anmodning fjernet.';
            header('Location: ./friends.php');
        }
    }elseif(!empty($_GET["id"]) && isset($_GET["add"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("INSERT INTO `friends` (UserOneId, UserTwoId, Action_userId)VALUES(:USERONE, :USERTWO, :USERONE)");
        $query->bindParam(":USERONE", $_SESSION["id"], PDO::PARAM_STR);
        $query->bindParam(":USERTWO", $_GET["id"], PDO::PARAM_STR);
        if($query->execute()){
            echo 'Du har anmodet ' . $_GET["id"] . ' om venskab.';
            $conn = null;
            header('Location: ./?profileId=' . $_GET["id"]);
           
        }else{
            echo 'Anmodning allerede sendt til bruger.';
        }
    }elseif(!empty($_GET["id"]) && isset($_GET["removeFriend"])){
         $conn = new dbconnector();
        $query = $conn->newQuery("DELETE FROM friends WHERE
                                (friends.userOneId = :USERONE AND friends.userTwoId = :USERTWO)
                                 OR 
                                (friends.UserOneId = :USERTWO AND friends.UserTwoId = :USERONE)
                                 AND friends.StatusConfirm = 1");
        $query->bindParam(":USERONE", $_SESSION["id"], PDO::PARAM_STR);
        $query->bindParam(":USERTWO", $_GET["id"], PDO::PARAM_STR);
        if($query->execute()){
            echo 'venskab fjernet.';
            $conn = null;
             header('Location: ./friends.php');
        }
        
    }
}

