<?php
require_once './lib/class.mysql.php';

if($_POST){
    if(!empty($_POST["searchInput"])){

        $search = filter_var($_POST['searchInput'], FILTER_SANITIZE_STRING);
        
        $conn = new dbconnector();
        $query = $conn->newQuery("SELECT userdetails.Firstname, userdetails.Surname, userdetails.Age,
                                userdetails.City, userdetails.Gender, userdetails.Employment, userdetails.Hobbies,
                                userdetails.UserId, users.id AS userID, users.email, users.Username
                                FROM userdetails 
                                INNER JOIN users ON userdetails.UserId = users.Id
                                WHERE userdetails.Firstname LIKE :SEARCH
                                OR userdetails.Surname LIKE :SEARCH
                                OR userdetails.City LIKE :SEARCH
                                OR users.Email LIKE :SEARCH");
        $searchInput = '%'.$search.'%';
        $query->bindParam(":SEARCH", $searchInput, PDO::PARAM_STR);
        if($query->execute() && $query->rowCount() > 0){
            while($results = $query->fetch(PDO::FETCH_ASSOC)){
                echo '<pre>';
                var_dump($results);
                echo '</pre>';
            }
        }else{
            echo 'Din søgning "' . $search . '" gav ingen resultater.';
        }
    }else{
        echo 'Skriv et søgeord tak!';
    }
}

?>

<form action="" method="post">
    <input type="text" name="searchInput" placeholder="Søg...">
    <button type="submit">Søg</button>
</form>
