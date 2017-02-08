<?php
session_start();

if(!isset($_SESSION["isLoggedIn"])){
    header('Location: login.php');
    exit();
}

require './lib/class.mysql.php';
require_once 'editProfile.php';

if($_GET){
    if(!empty($_GET["id"]) && is_numeric($_GET["id"])){
        $conn = new dbconnector();
        $query = $conn->newQuery("SELECT 
        users.id AS user_ID, users.username, users.email,
        userDetails.firstname, userDetails.surname, userDetails.age, userDetails.gender,
        userDetails.city, userDetails.country, userDetails.profileText,
        DATE_FORMAT(userdetails.DateCreated, '%d-%m-%Y %h:%i:%s') AS dateCreated, userdetails.ProfilePictureId,
        pictures.filename AS profilePicture, pictures.title AS pictureTitle
        FROM `users` 
        INNER JOIN userdetails ON users.id = userdetails.UserId AND users.id = :ID
        INNER JOIN pictures ON userdetails.ProfilePictureId = pictures.id");
        $query->bindParam(':ID', $_GET["id"], PDO::PARAM_STR);
        if($query->execute() && $query->rowCount() > 0){
            $userDetail = $query->fetch(PDO::FETCH_ASSOC);
            $conn = null;
?>
<pre>
<?=print_r($userDetail, true);?>
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
<?php
    if(@$userDetail["user_ID"] == $_SESSION['id']){
        require_once 'friends.php';
?>
<p><?=@$success;?></p>
<h2>Rediger din profil</h2>
<form action="" method="post">
    <label>E-mail:</label>
    <input type="email" name="email" value="<?=$userDetail['email'];?>"><br>
    <p style="color: red;"><?=@$errEmail;?></p>
    <label>Fornavn</label>
    <input type="text" name="firstname" placeholder="Fornavn" value="<?=$userDetail['firstname'];?>"><br>
    <p style="color: red;"><?=@$errFirstname;?></p>
    <label>Efternavn</label>
    <input type="text" name="surname" placeholder="Efternavn" value="<?=$userDetail['surname'];?>"><br>
    <p style="color: red;"><?=@$errSurname;?></p>
    <label>Alder</label>
    <input type="number" name="age" max="99" value="<?=$userDetail['age'];?>"><br>
    <p style="color: red;"><?=@$errAge;?></p>
    <label>Køn</label>
    <select name="gender" autofocus="<?=$userDetail['gender'];?>">
        <option value="Male">Mand</option>
        <option value="Female">Kvinde</option>
        <option value="Other">Andet</option>
    </select><br>
    <label>By</label>
    <input type="text" name="city" placeholder="By" value="<?=$userDetail['city'];?>"><br>
    <p style="color: red;"><?=@$errCity;?></p>
    <label>Land</label>
    <input type="text" name="country" placeholder="Land" value="<?=$userDetail['country'];?>"><br>
    <p style="color: red;"><?=@$errCountry;?></p>
    <label>Profil tekst</label><br>
    <textarea rows="5" cols="30" name="profileText"><?=$userDetail['profileText'];?></textarea><br>
    <p style="color: red;"><?=@$errProfiletext;?></p>
    <input type="hidden" name="userId" value="<?=$userDetail['user_ID'];?>">
    <button type="submit">Gem</button>
</form>

<form action="deleteUser.php" method="post">
    <input type="hidden" name="userId" value="<?=$userDetail['user_ID'];?>">
    <button type="submit">Slet bruger</button>
</form>
<?php
}else {
?>
<form action="friendRequest.php" method="post">
    <input type="hidden" name="userId" value="<?=$userDetail['user_ID'];?>">
    <button type="submit">Anmod om venskab</button>
</form>
<?php
}
