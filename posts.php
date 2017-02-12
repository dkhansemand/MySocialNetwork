<?php
if(isset($_GET["profileId"]) && $_GET["profileId"] != ''){
    $profilePosts = "WHERE posts.submittedby = " . $_GET["profileId"];
}else{
    $profilePosts = "";
}
$conn = new dbconnector();
$query = $conn->newQuery("SELECT posts.id AS postID, posts.title, posts.post, posts.postPicture, DATE_FORMAT(posts.datecreated, '%d-%m-%Y %h:%i:%s') AS postDate,
                        posts.submittedby, pictures.filename AS postPicture, 
                        userdetails.firstname, userdetails.surname FROM posts 
                        LEFT JOIN pictures ON posts.postPicture = pictures.id 
                        INNER JOIN userdetails ON posts.submittedby = userdetails.userid
                        $profilePosts
                        ORDER BY posts.datecreated DESC");
$query->bindParam(':ID', $_SESSION["id"], PDO::PARAM_STR);
if($query->execute() && $query->rowCount() > 0){
    while ($posts = $query->fetch(PDO::FETCH_ASSOC)){
?>


    <div class="col s12 m7">
        <div class="card">
        <?php
            if($posts["postPicture"] != ''){
        ?>
            <div class="card-image">
                <img src="uploads/<?=$posts['postPicture']?>">
                
            </div>
            <?php
            }
            ?>
            <div class="card-content">

                <p>Titel: <?=$posts['title']?></p>
                <p>Oplæg: <?=$posts['post']?></p>
                <p>Oplæg oprettet: <?=$posts['postDate']?></p>
                <p>Posted af: <?=$posts["firstname"];?>&nbsp;<?=$posts["surname"];?></p>

            </div>
            <div class="card-action">
            <?php
            if($posts["submittedby"] == $_SESSION["id"]){
            ?>
               <a href="deletePost.php?postId=<?=$posts['postID'];?>&submittedby=<?=$posts['submittedby'];?>">Slet indlæg</a>
               <?php
            }
               ?>
            </div>
        </div>
    </div>

<?php
}
$conn = null;
}else{ ?>
</div>
    <div class="col s5 m4">
                <div class="card horizontal">
                    <div class="card-content">
                        <p>Der er ingen posts at vise.</p>
                    </div>
                </div>
          </div>
<?php
}
?>
</div>