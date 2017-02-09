 <form action="" enctype="multipart/form-data" method="post">
        <label>Title</label>
        <input type="text" name="title" placeholder="Title"><br>
        <label>Beskrivelse</label>
        <input type="text" name="pictureDesc" placeholder="Beskrivelse"><br><br>
        <label>Vælg dit billede</label><br>
        <input name="file" type="file"><br>
        <input name="submit" type="submit" value="Upload">
    </form>



<?php
session_start();
require "lib/class.mysql.php";
if($_POST){
    if(!empty($_POST["title"]) && !empty($_POST["pictureDesc"]) && !empty($_FILES["file"])){

            if(preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $_FILES["file"]["name"])){
                if($_FILES["file"]["size"] < 1536000 && $_FILES["file"]["error"] == 0){
                    $filename = $_FILES["file"]["name"];

                    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
                    $description = filter_var($_POST['pictureDesc'], FILTER_SANITIZE_STRING);
                    $uploaddir = 'uploads/';
                    
                    $conn = new dbconnector();
                    $query = $conn->newQuery("INSERT INTO pictures  (title, pictureDesc, filename, owner)  VALUES (:title, :pictureDesc, :filename, :owner)");
                    $query->bindParam(":title",$title);
                    $query->bindParam(":pictureDesc",$description);
                    $query->bindParam(":filename",$filename);
                    $query->bindParam(":owner",$_SESSION['id']);

                    if($query->execute()){
                        echo "<div class='alert alert-success' role='alert'>Billede er korrekt lagt op</div>";
                    }else{
                        die("<div class='alert alert-danger' role='alert'>Det var ikke muligt at uplaod billede.</div>");
                    }
                    echo '<pre>';
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $filename)) {
                        echo "File is valid, and was successfully uploaded.\n";
                    } else {
                        echo "Possible file upload attack!\n";
                    }
                }else{
                    echo 'størrelse max 1.5MB';
                }
            }else{
                echo 'Filtype er begrænset til .jpg, .jpeg, .png, .gif. ';
            }
    }else{
        echo 'Alle felter skal udfyldes';
    }
}
?>
<br />
## ID, Filename, Title, PictureDesc, Owner, DateAdded
