<style>
.card .card-image img{
    width: auto;
}
.card .card-image .card-title{
    color: #000;
}
</style>
<?php
if($_GET){
  if(!empty($_GET["profileId"]) && is_numeric($_GET["profileId"])){
    $userid = $_GET["profileId"];
  }
}else{
  $userid = $_SESSION["id"];
}
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
        $query->bindParam(':ID', $userid, PDO::PARAM_STR);
        if($query->execute() && $query->rowCount() > 0){
            $userDetail = $query->fetch(PDO::FETCH_ASSOC);
            $conn = null;
?>
     <div class="row">
        <div class="col s5 m4">
          <div class="card">
            <div class="card-image" >
              <img src="uploads/<?=$userDetail['profilePicture'];?>" alt="<?=$userDetail['pictureTitle'];?>" title="<?=$userDetail['pictureTitle'];?>" height="250" width="250">
            </div>
            <div class="card-content">
            <h3><?=$userDetail["firstname"];?>&nbsp;<?=$userDetail["surname"];?></h3>
            <p>Brugernavn: <?=$userDetail["username"];?></p>
            <p>E-mail: <?=$userDetail["email"];?></p>
            <p>Alder: <?=$userDetail["age"];?></p>
            <p>Køn: <?=$userDetail["gender"];?></p>
            <p>By: <?=$userDetail["city"];?></p>
            <p>Land: <?=$userDetail["country"];?></p>
            <p>Bruger oprettet: <?=$userDetail["dateCreated"];?></p>
              <p><?=$userDetail["profileText"];?></p>
            </div>
            <?php
              if($userid == $_SESSION["id"]){
            ?>
            <div class="card-action">
              <a class="waves-effect waves-light btn" href="editProfile.php?id=<?=$_SESSION['id'];?>">Rediger profil</a>
            </div>
            <?php
              }
            ?>
          </div>
        </div>
      </div>

<?php
        }else{
            echo 'Bruger findes ikke';
        }
?>

