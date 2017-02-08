<?php

$connFriend = new dbconnector();
$queryFriend = $connFriend->newQuery("SELECT 
        friends.Id AS requestId, DATE_FORMAT(friends.RequestDate, '%d-%m-%Y %h:%i:%s') AS dateRequest, friends.StatusConfirm,
        friends.UserOneId, friends.UserTwoId,  DATE_FORMAT(friends.ConfirmDate, '%d-%m-%Y %h:%i:%s') AS dateConfirm,
        userDetails.firstname, userDetails.surname, 
        userdetails.ProfilePictureId,
        pictures.filename AS profilePicture, pictures.title AS pictureTitle
        FROM `friends` 
        INNER JOIN userdetails ON friends.UserOneId = userdetails.UserId AND friends.UserTwoId = :ID
        INNER JOIN pictures ON userdetails.ProfilePictureId = pictures.id");
        $queryFriend->bindParam(":ID", $_GET["id"], PDO::PARAM_STR);
        if($queryFriend->execute() && $queryFriend->rowCount() > 0){
            while($friends = $queryFriend->fetch(PDO::FETCH_ASSOC)){
                /*echo '<pre>';
                print_r($friends);
                echo '</pre>';*/

                if($friends["StatusConfirm"] == 0){
                ?>
                    Anmodning om venskab fra 
                    <p>
                    <?=$friends["firstname"]?>&nbsp;<?=$friends["surname"]?> <a href="friendRequest.php?id=<?=$friends["requestId"]?>&confirm">Bekræft</a> 
                    - <a href="friendRequest.php?id=<?=$friends["requestId"]?>&ignore">Ignorér</a> 
                    </p>
                <?php
                }elseif($friends["StatusConfirm"] == 1){
                ?>
                <p>
                    Ven - <?=$friends["firstname"]?>&nbsp;<?=$friends["surname"]?> (Blev venner - <?=$friends["dateConfirm"]?>)
                </p>
                <?php
                }
            }
        }else{
            echo 'Ingen anmodninger/Venner';
        }
