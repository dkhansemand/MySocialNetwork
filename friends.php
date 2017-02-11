<?php
session_start();
require './lib/class.mysql.php';
$connFriend = new dbconnector();
$queryFriend = $connFriend->newQuery("SELECT * FROM `friends`
                                        WHERE (`userOneId` = :ID OR `userTwoId` = :ID)
                                        AND `statusConfirm` = 0
                                        AND `Action_userId` != :ID");
        $queryFriend->bindParam(":ID", $_SESSION["id"], PDO::PARAM_STR);
        if($queryFriend->execute() && $queryFriend->rowCount() > 0){
            while($friends = $queryFriend->fetch(PDO::FETCH_ASSOC)){
                echo '<pre>';
                var_dump($friends);
                echo '</pre>';
                ?>
                <a href="friendRequest.php?id=<?=$friends['Action_userId']?>&accept">Accepter</a>
                -
                <a href="friendRequest.php?id=<?=$friends['Action_userId']?>&ignore">Fjern</a>
                <?php
              
            }
        }else{
            echo 'Ingen venne anmodninger';
        }
