<?php

function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(!empty($_POST['email'])  && !empty($_POST['password'])){

        $email = validate($_POST['email']);
        $password = validate($_POST['password']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format";
        }else {
            try{
                $db= new PDO("mysql:host=localhost;dbname=gestion_plastic", "root", "");
                $stm = $db->prepare("SELECT * FROM `user` WHERE `email`=:email AND `password`=:password");
                $stm->bindParam(":email", $email);
                $stm->bindParam(":password", $password);
                $stm->execute();
    
                if($stm->rowCount() <= 0){
                    echo "Password or email incorrect";
                }else{
                    echo "true";
                }
                
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
  
}else{
    echo "Please fill out all the fields!";
}




