<?php
$nbrErr =0;
function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if(!empty($_POST['name'])  && !empty($_POST['tel'])  && !empty($_POST['email'])  && !empty($_POST['password'])  && !empty($_POST['passwordConf'])){
    if(!empty($_POST['latitude']) && !empty($_POST['longitude']) ){
        $name = validate($_POST['name']);
        $tel = validate($_POST['tel']);
        $email = validate($_POST['email']);
        $password = validate($_POST['password']);
        $passwordConf = validate($_POST['passwordConf']);
        $latitude = validate($_POST['latitude']);
        $longitude = validate($_POST['longitude']);
    
        // validate password
        if(strlen($password) < 8){
            $nbrErr++;
            echo "Password must be longer than 8 characters";
        }else if($password !=  $passwordConf){
            $nbrErr++;
            echo "Passwords do not match";
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //validate email
            $nbrErr++;
            echo "Invalid email format";
        }else{
            try{
                $db= new PDO("mysql:host=localhost;dbname=gestion_plastic", "root", "");
                $stm = $db->prepare("SELECT * FROM `user` WHERE email=:email");
                $stm->bindParam(":email", $email);
                $stm->execute();
    
                if($stm->rowCount() >0){
                    $nbrErr++;
                    echo "Email already exist!";
                }
                
    
                //insert data of user
    
                if($nbrErr<=0){
                    $stm = $db->prepare("INSERT INTO `user` (nameUser,tele,email,password,latitude,longitude) VALUES(:name, :tele, :email, :password, :latitude, :longitude)");
                    $stm->bindParam(":name", $name);
                    $stm->bindParam(":tele", $tel);
                    $stm->bindParam(":email", $email);
                    $stm->bindParam(":password", $password);
                    $stm->bindParam(":latitude", $latitude);
                    $stm->bindParam(":longitude", $longitude);
                    $stm->execute();
    
                    echo "true";
                }
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }

    
    }else{
        echo "Enabling geolocation is obligatory!";
    }
}else{
    echo "Please fill out all the fields!";
}


