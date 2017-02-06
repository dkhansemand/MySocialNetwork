<?php
session_start();

if(!isset($_SESSION["isLoggedIn"])){
    header('Location: login.php');
    exit();
}

require './lib/class.mysql.php';

if($_GET){
    if(!empty($_GET["id"]) && is_numeric($_GET["id"])){
        $conn = new dbconnector();
        $query = $conn->newQuery(" 
        SELECT 
        users.id AS user_ID, users.username, users.email,
        userDetails.firstname, userDetails.surname, userDetails.age, userDetails.gender,
        userDetails.city, userDetails.country, userDetails.profileText,
        userdetails.DateCreated, userdetails.ProfilePictureId,
        pictures.filename AS profilePicture, pictures.title AS pictureTitle
        FROM `users` 
        INNER JOIN userdetails ON users.id = userdetails.UserId AND users.id = :ID
        INNER JOIN pictures ON userdetails.ProfilePictureId = pictures.id");
        $query->bindParam(':ID', $_GET["id"], PDO::PARAM_STR);
        if($query->execute() && $query->rowCount() > 0){
            $userDetail = $query->fetch(PDO::FETCH_ASSOC);
?>
<pre>
<?=print_r($userDetail)?>
</pre>
<?php
        }else{
            echo 'Bruger findes ikke';
        }
    }else{
        header('Location: ./');
    }
}

?>