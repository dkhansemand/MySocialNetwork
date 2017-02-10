<?php
$conn = new dbconnector();
$query = $conn->newQuery("SELECT posts.title, posts.post, posts.datecreated, pictures.filename AS postPicture, 
                        userdetails.firstname, userdetails.surname FROM posts 
                        INNER JOIN pictures ON posts.postpicture = pictures.id 
                        INNER JOIN userdetails ON posts.submittedby = userdetails.userid");
$query->bindParam(':ID', $_SESSION["id"], PDO::PARAM_STR);
if($query->execute() && $query->rowCount() > 0){
    while ($posts = $query->fetch(PDO::FETCH_ASSOC)){
?>

<div class="row">
    <div class="col s12 m7">
        <div class="card">
            <div class="card-image">
                <img src="images/sample-1.jpg">
                <span class="card-title">Card Title</span>
            </div>
            <div class="card-content">

                <p>Oplæg lavet: <?=$posts['datecreated']?></p>
                <p>Titel: <?=$posts['title']?></p>
                <p>Oplæg: <?=$posts['post']?></p>
                <p>Picture: <?=$posts['postPicture']?></p>

            </div>
            <div class="card-action">
                <a href="#">This is a link</a>
            </div>
        </div>
    </div>
</div>
<?php
}
$conn = null;
}else{ ?>
    <div class="col s5 m4">
                <div class="card">
                    <div class="card-content">
                        <p>Der er ingen posts at vise.</p>
                    </div>
                </div>
          </div>
<?php
}
?>