<?php

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
            }else{
                $conn = null;
                $success =  'Der skete en fejl og kunne ikke opdatere.';
            }
        }
    }else{
        $success =  'Ikke muligt at opdatere profil.';
    }
}

