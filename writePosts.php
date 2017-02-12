<?php
if ($_POST){
    require_once 'lib/class.mysql.php';
    session_start();
    if(!empty($_POST["title"]) && !empty($_POST["post"])){
        $errCount = 0;
        if($_FILES["file"]["name"] != ''){
            if(preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $_FILES["file"]["name"])) {
                if ($_FILES["file"]["size"] < 1536000 && $_FILES["file"]["error"] == 0) {
                    $uploaddir = 'uploads/';
                    $filename = date("dmyHisu") . $_FILES["file"]["name"];
                    $sql = "INSERT INTO pictures (filename, owner)  VALUES ('$filename', :SubmittedBy); 
                            INSERT INTO posts (Title, Post, SubmittedBy, PostPicture) 
                            VALUES 
                            (:Title, :Post, :SubmittedBy, (SELECT id FROM pictures WHERE filename = '$filename'))";
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploaddir . $filename)) {
                        $_SESSION["postpost"]["msg"] = "Dit billede er nu uploaded.\n";
                       
                    } else {
                        $_SESSION["postpost"]["msg"] = "Possible file upload attack!\n";
                        header('Location: ./');
                        exit;
                    }
                }
            }
        }else{
            $sql = 'INSERT INTO posts (Title, Post, SubmittedBy)VALUES(:Title, :Post, :SubmittedBy)';
        }
        
       
            $title = $_POST["title"];
            $post = $_POST["post"];
        
        if($errCount === 0){
            $conn = new dbconnector();
            $query = $conn->newQuery($sql);
            $query->bindParam(":Title", $title);
            $query->bindParam(":Post", $post);
            $query->bindParam(":SubmittedBy", $_SESSION['id']);
            if ($query->execute()) {
                $conn = null;
                $_SESSION["postpost"]["msg"] += "<div class='alert alert-success' role='alert'>Din post er korrekt lagt op</div>";
                header('Location: index.php');
                exit;
            } else {
                $conn = null;
                $_SESSION["postpost"]["msg"] += "<div class='alert alert-danger' role='alert'>Det var ikke muligt at tilføje din post.</div>";
                header('Location: ./');
                exit;
            }
        }else{
            $_SESSION["postpost"]["msg"] += "<div class='alert alert-danger' role='alert'>Det var ikke muligt at tilføje din post.</div>";
            header('Location: index.php');
                exit;
        }
    }else{
        $_SESSION["postpost"]["msg"] += "<div class='alert alert-danger' role='alert'>Felterne skal udfyldes</div>";
        header('Location: index.php');
                exit;
    }
}
if (isset($_SESSION['postpost']["msg"])){
    $postUploadError = $_SESSION["postpost"]["msg"];
    $_SESSION['postpost']["msg"] = '';
}
?>

<script>tinymce.init({ selector:'textarea' });</script>
    <div class="col s12 m6">
        <div class="card">
            <p style="color:red;"><?=@$postUploadError;?></p>
            <form action="writePosts.php" method="post" enctype="multipart/form-data">
                <label>Titel</label>
                <input type="text" name="title" placeholder="Overskrift"><br> 
                <label>Upload et billede til din post:</label>
                <input type="file" name="file">
                
                <textarea name="post" id="post" placeholder="Skriv din besked her..." cols="30" rows="10"></textarea>
                <button type="submit" class="waves-effect waves-light btn">Post din besked</button>
            </form>
        </div>
    </div>
