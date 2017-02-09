<?php
require_once './lib/class.mysql.php';
require './partials/header.php';
?>
<main>
       <div class="row">       
<?php
if($_POST){
    if(!empty($_POST["searchInput"])){

        $search = filter_var($_POST['searchInput'], FILTER_SANITIZE_STRING);
        
        $conn = new dbconnector();
        $query = $conn->newQuery("SELECT userdetails.Firstname, userdetails.Surname, userdetails.Age,
                                userdetails.City, userdetails.Country, userdetails.Gender, userdetails.Employment, userdetails.Hobbies,
                                userdetails.UserId, pictures.filename AS profilePicture, pictures.title AS pictureTitle,
                                users.id AS userID, users.Email, users.Username
                                FROM userdetails 
                                INNER JOIN users ON userdetails.UserId = users.Id
                                INNER JOIN pictures ON userdetails.profilePictureId = pictures.id
                                WHERE userdetails.Firstname LIKE :SEARCH
                                OR userdetails.Surname LIKE :SEARCH
                                OR userdetails.City LIKE :SEARCH
                                OR users.Email LIKE :SEARCH");
        $searchInput = '%'.$search.'%';
        $query->bindParam(":SEARCH", $searchInput, PDO::PARAM_STR);
        if($query->execute() && $query->rowCount() > 0){
            while($results = $query->fetch(PDO::FETCH_ASSOC)){
                if($results["userID"] != $_SESSION["id"]){
                ?>
        <div class="col s4 m3">
          <div class="card">
            <div class="card-image" >
              <img src="uploads/<?=$results['profilePicture'];?>" alt="<?=$results['pictureTitle'];?>" title="<?=$results['pictureTitle'];?>" height="250" width="250">
            </div>
            <div class="card-content">
            <h3><?=$results["Firstname"];?>&nbsp;<?=$results["Surname"];?></h3>
            <p>Brugernavn: <?=$results["Username"];?></p>
            <p>E-mail: <?=$results["Email"];?></p>
            <p>Alder: <?=$results["Age"];?></p>
            <p>Køn: <?=$results["Gender"];?></p>
            <p>By: <?=$results["City"];?></p>
            <p>Land: <?=$results["Country"];?></p>
            <p>Beskæftigelse: <?=$results["Employment"];?></p>
              <p>Hobby: <?=$results["Hobbies"];?></p>
            </div>
            <div class="card-action">
              <a class="waves-effect waves-light btn" href="./?profileId=<?=$results['userID'];?>">Se profil</a>
            </div>
          </div>
        </div>
            <?php
                }
            }
            ?>
        </div>
<?php
        }else{
            ?>
            <div class="col s5 m4">
                <div class="card">
                    <div class="card-content">
                        <p>Din søgning "<?=$search;?>" gav ingen resultater.</p>
                    </div>
                </div>
          </div>
            <?php
        }
    }else{
        echo 'Skriv et søgeord tak!';
    }
}

require './partials/footer.php';
?>
    
</main>