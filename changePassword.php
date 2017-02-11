<?php

require './partials/header.php';

if($_POST){
    if(!empty($_POST["passwordOne"]) && !empty("passwordTwo")){
        if($_POST["passwordOne"] == $_POST["passwordTwo"]){
            $options  = array('cost' => 10);
            $hash = password_hash($_POST["passwordOne"], PASSWORD_BCRYPT, $options);
            $conn = new dbconnector();
            $query = $conn->newQuery("UPDATE users SET password = :HASH WHERE id = :ID");
            $query->bindParam(":HASH", $hash);
            $query->bindParam(":ID", $_SESSION["id"]);
            if($query->execute()){
                ?>
                <h2>Dit password er nu skiftet!</h2>
                <?php
                session_destroy();
                header('Refresh: 5; url=login.php');
            }
        }else{
            $_SESSION["password"]["msg"] = 'Password er ikke ens!';
             header('Location: editProfile.php?id='.$_SESSION["id"]);
        }
    }
}else{  
    header('Location: ./');
}

require './partials/footer.php';
