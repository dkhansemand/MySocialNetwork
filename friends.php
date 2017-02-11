<?php
require './partials/header.php';

$conn = new dbconnector();


##List all friends requests
$queryRequests = $conn->newQuery("SELECT friends.Action_userId, friends.statusConfirm,
                                    userdetails.firstname, userdetails.surname, pictures.filename AS profilePicture
                                    FROM `friends`
                                    INNER JOIN userdetails ON friends.Action_userId = userdetails.UserId
                                    INNER JOIN pictures ON userdetails.profilePictureId = pictures.id
                                    WHERE (friends.userOneId = :ID OR friends.userTwoId = :ID)
                                    AND friends.statusConfirm = 0
                                    AND friends.Action_userId != :ID");
        $queryRequests->bindParam(":ID", $_SESSION["id"], PDO::PARAM_STR);
        if($queryRequests->execute() && $queryRequests->rowCount() > 0){
            ?>
            <h2>Anmodninger:</h2>
            <?php
            while($requests = $queryRequests->fetch(PDO::FETCH_ASSOC)){
                /*echo '<pre>';
                var_dump($requests);
                echo '</pre>';*/
                ?>
                 <div class="col s6 m4">
                    <div class="card horizontal">
                    <div class="card-image">
                        <img src="uploads/<?=$requests['profilePicture'];?>" height="110" width="110">
                    </div>
                    <div class="card-stacked">
                        <div class="card-content">
                        <p><?=$requests["firstname"];?>&nbsp;<?=$requests["surname"];?></p>
                        </div>
                        <div class="card-action">
                        <a href="friendRequest.php?id=<?=$requests['Action_userId']?>&accept">Accepter</a>
                        <a href="friendRequest.php?id=<?=$requests['Action_userId']?>&ignore">Fjern</a>
                        </div>
                    </div>
                    </div>
                </div>

                <?php
              
            }
        }else{
            echo 'Ingen nye anmodninger';
        }


##List all friends
$queryFriends = $conn->newQuery("SELECT friends.*
                                   
                                    FROM `friends`
                                    
                                    WHERE (friends.userOneId = :ID OR friends.userTwoId = :ID)
                                    AND friends.statusConfirm = 1");

                $queryFriends->bindParam(":ID", $_SESSION["id"], PDO::PARAM_STR);
                if($queryFriends->execute() && $queryFriends->rowCount() > 0){
                ?>
                <h2>Venner:</h2>
                <?php
                    while($friends = $queryFriends->fetch(PDO::FETCH_ASSOC)){
                        echo '<pre>';
                        var_dump($friends);
                        echo '</pre>';
                        /*
                        ?>
                        <div class="col s6 m4">
                            <div class="card horizontal">
                            <div class="card-image">
                                <img src="uploads/<?=$friends['profilePicture'];?>" height="110" width="110">
                            </div>
                            <div class="card-stacked">
                                <div class="card-content">
                                <p><?=$friends["firstname"];?>&nbsp;<?=$friends["surname"];?></p>
                                </div>
                                <div class="card-action">
                                <a href="./?profileId=<?=$friends['Action_userId']?>">Se profil</a>
                               
                                </div>
                            </div>
                            </div>
                        </div>

                        <?php
                        */
                    }
                    $conn = null;
                }else{
                    $conn = null;
                    echo 'Du har ingen venner.';
                }


require './partials/footer.php';
