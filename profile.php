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
        userdetails.firstname, userdetails.surname, userdetails.age, userdetails.gender,
        userdetails.city, userdetails.country, userdetails.profileText,
        DATE_FORMAT(userdetails.datecreated, '%d-%m-%Y %h:%i:%s') AS dateCreated, userdetails.profilepictureId,
        pictures.filename AS profilePicture, pictures.title AS pictureTitle,
        friends.statusconfirm AS isFriends
        FROM users 
        INNER JOIN userdetails ON users.id = userdetails.UserId AND users.id = :ID
        INNER JOIN pictures ON userdetails.ProfilePictureId = pictures.id
        LEFT JOIN friends ON (friends.UserOneId = :ID AND friends.UserTwoId = :SESSIONID) OR (friends.UserOneId = :SESSIONID AND friends.UserTwoId = :ID)");
        $query->bindParam(':ID', $userid, PDO::PARAM_STR);
        $query->bindParam(':SESSIONID', $_SESSION["id"], PDO::PARAM_STR);
        if($query->execute() && $query->rowCount() > 0){
            $userDetail = $query->fetch(PDO::FETCH_ASSOC);
            $conn = null;
            
?>
 
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
              }else{
                ?>
                  <div class="card-action">
                  <?php
                    if($userDetail["isFriends"] == ''){
                     
                  ?>
                        <a class="waves-effect waves-light btn" href="friendRequest.php?id=<?=$userDetail['user_ID'];?>&add">Anmod om venskab</a>
                    <?php
                      }elseif($userDetail["isFriends"] == 0){
                    ?>
                    <a class="waves-effect waves-light btn disabled" href="#">Anmodning sendt</a>
                <?php
                    }elseif($userDetail["isFriends"] == 1){
                      ?>
                    <a href="friendRequest.php?id=<?=$userDetail['user_ID'];?>&removeFriend">Fjern ven</a>
                      <?php

                    }
              }
            ?>
                  </div>
          </div>
         <?php
         if($userid == $_SESSION["id"]){
          require_once 'writePosts.php';
         }
          ?>
         <?php 
         require_once 'posts.php';
         ?>
          </div>
    

<?php
        }else{
            echo 'Bruger findes ikke';
        }
        require_once './partials/footer.php';
?>

