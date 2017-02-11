<?php
require './partials/header.php';

 $conn = new dbconnector();
        $query = $conn->newQuery("SELECT 
        users.id AS user_ID, users.username, users.email,
        userDetails.firstname, userDetails.surname, userDetails.age, userDetails.gender,
        userDetails.city, userDetails.country, userDetails.profileText,
        DATE_FORMAT(userdetails.DateCreated, '%d-%m-%Y %h:%i:%s') AS dateCreated, userdetails.ProfilePictureId,
        pictures.filename AS profilePicture, pictures.title AS pictureTitle, pictures.pictureDesc
        FROM `users` 
        INNER JOIN userdetails ON users.id = userdetails.UserId AND users.id = :ID
        INNER JOIN pictures ON userdetails.ProfilePictureId = pictures.id");
        $query->bindParam(':ID', $_SESSION["id"], PDO::PARAM_STR);
        if($query->execute() && $query->rowCount() > 0){
            $userDetail = $query->fetch(PDO::FETCH_ASSOC);
            $conn = null;
        }

if($_POST){
    if(!empty($_POST["userId"]) && $_POST["userId"] == $_SESSION['id']){
        $errCount = 0;
        $userID = $_POST["userId"];
        
        #validerEmail
        if ( empty($_POST['email']) ) { // test om variablen er tom
            $errEmail = 'Du skal udfylde feltet';
            ++$errCount;
        } else if ( !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ) { // test om varibel er en email
            $errEmail = "Emailen er ikke skrevet korrekt.";
            ++$errCount;
        } else { // success
            $email = $_POST['email'];
        }
        #validerNavn
        if (empty($_POST['firstname'])){ // test om variablen er tom
            $errFirstname = 'Du skal udfylde feltet';
            ++$errCount;
        }else if (preg_match('/\d/', $_POST['firstname']) ) { // test om varibel indeholder tal
            $errFirstname = "Feltet må ikke indeholde tal.";
            ++$errCount;
        } else {//success
            $firstname = $_POST['firstname'];
        }

        #validerEfternavn
        if (empty($_POST['surname'])){ // test om variablen er tom
            $errSurname = 'Du skal udfylde feltet';
            ++$errCount;
        }else if (preg_match('/\d/', $_POST['surname']) ) { // test om varibel indeholder tal
            $errSurname = "Feltet må ikke indeholde tal.";
            ++$errCount;
        } else {//success
            $surname = $_POST['surname'];
        }

        #validerAlder
        if (empty($_POST['age'])){ // test om variablen er tom
            $errAge = 'Du skal skrive din alder';
        }elseif (!is_numeric($_POST['age'])){
            $errAge = 'Du må kun skrive tal her';
            ++$errCount;
        }else {//success
            $age = $_POST['age'];
        }

        $gender = $_POST["gender"]; //No validation required for now.

        #validerCIty
        if (empty($_POST['city'])){ // test om variablen er tom
            $errCity = 'Du skal udfylde feltet';
            ++$errCount;
        }else if (preg_match('/\d/', $_POST['city']) ) { // test om varibel indeholder tal
            $errCity = "By navn kan ikke indholde tal";
            ++$errCount;
        } else {//success
            $city = $_POST['city'];
        }

        #validerCountry
        if (empty($_POST['country'])){ // test om variablen er tom
            $errCountry = 'Du skal udfylde feltet';
            ++$errCount;
        }else if (preg_match('/\d/', $_POST['country']) ) { // test om varibel indeholder tal
            $errCountry = "By navn kan ikke indholde tal";
            ++$errCount;
        } else {//success
            $country = $_POST['country'];
        }

        if (empty($_POST['profileText'])){ // test om variablen er tom
            $errProfiletext = 'Du skal udfylde feltet';
            ++$errCount;
        }elseif (strlen($_POST['profileText']) <= 20){ //tjekker længden på strengen
            $errProfiletext = 'Du skal bruge mere en 20 tegn';
            ++$errCount;
        }else { // success
            $profileText = $_POST['profileText'];
        }
        

        if($errCount === 0){
            $conn = new dbconnector();
            $query = $conn->newQuery("UPDATE users, userdetails 
            SET users.email = :EMAIL, userdetails.firstname = :FIRSTNAME, userdetails.surname = :SURNAME,
            userdetails.age = :AGE, userdetails.gender = :GENDER, userdetails.city = :CITY,
            userdetails.country = :COUNTRY, userdetails.profileText = :PROFILETEXT
            WHERE userdetails.UserId = :ID and users.id = :ID");

            $query->bindParam(":ID", $userID, PDO::PARAM_INT);
            $query->bindParam(":EMAIL", $email, PDO::PARAM_STR);
            $query->bindParam(":FIRSTNAME", $firstname, PDO::PARAM_STR);
            $query->bindParam(":SURNAME", $surname, PDO::PARAM_STR);
            $query->bindParam(":AGE", $age, PDO::PARAM_INT);
            $query->bindParam(":GENDER", $gender, PDO::PARAM_STR);
            $query->bindParam(":CITY", $city, PDO::PARAM_STR);
            $query->bindParam(":COUNTRY", $country, PDO::PARAM_STR);
            $query->bindParam(":PROFILETEXT", $profileText, PDO::PARAM_STR);

            if($query->execute()){
                $conn = null;
                $success = 'Profil er blevet opdateret!';
                header('Refresh: 5; url=./');
            }else{
                $conn = null;
                $success =  'Der skete en fejl og kunne ikke opdatere.';
            }
        }
    }else{
        $success =  'Ikke muligt at opdatere profil.';
    }
}


    if($_GET["id"] == $_SESSION['id']){
      
       if(isset($_SESSION["upload"]["msg"])){
            $uploadError = $_SESSION["upload"]["msg"];
            $_SESSION["upload"]["msg"] = '';
       }
       if(isset($_SESSION["password"]["msg"])){
            $passwordErr = $_SESSION["password"]["msg"];
            $_SESSION["password"]["msg"] = '';
       }
?>
<div class="row"></div>
<div class="container left">
<div class="row">
    <div class="col s8 m8 offset-s1 offset-m1">
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
        <div class="row">
         <div class="input-field col s12">
            <select name="gender">
            <option value="Male">Mand</option>
            <option value="Female">Kvinde</option>
            <option value="Other">Andet</option>
            </select>
            <label>Køn</label>
        </div>
        </div>
        <br>
        <label>By</label>
        <input type="text" name="city" placeholder="By" value="<?=$userDetail['city'];?>"><br>
        <p style="color: red;"><?=@$errCity;?></p>
        <label>Land</label>
        <input type="text" name="country" placeholder="Land" value="<?=$userDetail['country'];?>"><br>
        <p style="color: red;"><?=@$errCountry;?></p>

           
            <div class="row">
                <div class="input-field col s12">
                <label for="textarea1">Profil tekst</label>
                <textarea id="textarea1" class="materialize-textarea" name="profileText"><?=$userDetail['profileText'];?></textarea>
                </div>
                <p style="color: red;"><?=@$errProfiletext;?></p>
            </div>
<div class="row">
                <div class="input-field col s12">
        <input type="hidden" name="userId" value="<?=$userDetail['user_ID'];?>">
        <button type="submit" class="waves-effect waves-light btn">Gem</button>
        </div></div>
    </form>

    <div class="row">
    <form action="deleteUser.php" method="post" id="deleteUser">
        <input type="hidden" name="userId" value="<?=$userDetail['user_ID'];?>">
        <button type="submit" onclick="return confirm('Er du helt sikker?')" class="waves-effect waves-light btn red">Slet bruger</button>
    </form>
    </div>
    <br>
    </div>
    <div class="col s2 m2 offset-s1 offset-m1">
    <img src="uploads/<?=$userDetail['profilePicture'];?>" alt="<?=$userDetail['pictureTitle'];?>" title="<?=$userDetail['pictureTitle'];?>" height="250" width="250">
    <p>Skift profil billede:</p>

     <form action="fileupload.php" enctype="multipart/form-data" method="post">
        <label>Titel</label>
        <input type="text" name="title" placeholder="Title" value="<?=$userDetail['pictureTitle'];?>"><br>
        <label>Beskrivelse</label>
        <input type="text" name="pictureDesc" placeholder="Beskrivelse" value="<?=$userDetail['pictureDesc'];?>"><br><br>
        <label>Vælg dit billede</label><br>
        <input name="file" type="file"><br>
        <input type="hidden" name="profilePic" value="1" ><br>
        <input name="submit" type="submit" class="waves-effect waves-light btn" value="Skift billede">
        <p style="color:red;"><?=@$uploadError;?></p>
    </form>
    </div>
    <div class="col s2 m2 offset-s1 offset-m1">
    <p>Skift password:</p>
    <form action="changePassword.php" method="post">
        <label for="">Nyt password</label>
        <input type="password" name="passwordOne" placeholder="Password" required><br>
        <label for="">Gentag password</label>
        <input type="password" name="passwordTwo" placeholder="Gentag password" required><br>
        <button type="submit" class="waves-effect waves-light btn">Skift</button>
         <p style="color:red;"><?=@$passwordErr;?></p>
    </form>
    </div>
</div>
</div>
<script>
 $(document).ready(function() {
    $('select').material_select();
  });
</script>
<?php
}else {
    header('Location: ./');
}

require_once './partials/footer.php';
