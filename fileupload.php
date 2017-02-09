<!-- <form action="" enctype="multipart/form-data" method="post">
        <label>Title</label>
        <input type="text" name="title" placeholder="Title"><br>
        <label>Beskrivelse</label>
        <input type="text" name="pictureDesc" placeholder="Beskrivelse"><br><br>
        <label>Vælg dit billede</label><br>
        <input name="file" type="file"><br>
        <label>Profil billede: 
        <input type="checkbox" name="profilePic" value="1" id="profilePic"></label><br>
        <input name="submit" type="submit" value="Upload">
    </form>-->



<?php
session_start();
require "lib/class.mysql.php";
if($_POST){
    if(!empty($_POST["title"]) && !empty($_POST["pictureDesc"]) && !empty($_FILES["file"])){
         $_SESSION["upload"]["msg"] = '';
            if(preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $_FILES["file"]["name"])){
                if($_FILES["file"]["size"] < 1536000 && $_FILES["file"]["error"] == 0){
                    $filename = date("dmyHisu") . $_FILES["file"]["name"];

                    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
                    $description = filter_var($_POST['pictureDesc'], FILTER_SANITIZE_STRING);
                    $uploaddir = 'uploads/';
                    
                    $conn = new dbconnector();

                    if($_POST["profilePic"] == 1){
                        $query = $conn->newQuery("INSERT INTO pictures  (title, pictureDesc, filename, owner)  VALUES (:title, :pictureDesc, :filename, :owner);
                                                UPDATE userdetails SET userdetails.ProfilePictureId = 
                                                (SELECT id FROM pictures WHERE filename = :filename) 
                                                WHERE userdetails.UserId = :owner;");
                    }else{
                        $query = $conn->newQuery("INSERT INTO pictures  (title, pictureDesc, filename, owner)  VALUES (:title, :pictureDesc, :filename, :owner) ");
                    }

                    $query->bindParam(":title",$title);
                    $query->bindParam(":pictureDesc",$description);
                    $query->bindParam(":filename",$filename);
                    $query->bindParam(":owner",$_SESSION['id']);

                    if($query->execute()){
                        $_SESSION["upload"]["msg"] = "<div class='alert alert-success' role='alert'>Billede er korrekt lagt op</div>";
                        header('Location: editProfile.php?id='.$_SESSION["id"]);
                    }else{
                        $_SESSION["upload"]["msg"] = "<div class='alert alert-danger' role='alert'>Det var ikke muligt at uplaod billede.</div>";
                        header('Location: editProfile.php?id='.$_SESSION["id"]);
                    }
                    
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $filename)) {
                         $_SESSION["upload"]["msg"] = "Dit billede er nu uploaded.\n";
                        header('Location: editProfile.php?id='.$_SESSION["id"]);
                    } else {
                         $_SESSION["upload"]["msg"] = "Possible file upload attack!\n";
                         header('Location: editProfile.php?id='.$_SESSION["id"]);
                    }
                }else{
                    $_SESSION["upload"]["msg"] =  'størrelse max 1.5MB';
                    header('Location: editProfile.php?id='.$_SESSION["id"]);
                }
            }else{
                $_SESSION["upload"]["msg"] = 'Filtype er begrænset til .jpg, .jpeg, .png, .gif. ';
                header('Location: editProfile.php?id='.$_SESSION["id"]);
            }
    }else{
         $_SESSION["upload"]["msg"] = 'Alle felter skal udfyldes';
         header('Location: editProfile.php?id='.$_SESSION["id"]);
    }
}
?>

