<?php
include_once 'phpmailer-master/mail.php';
session_start();

//validation input
function validate($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if(!empty($_POST['email'])){
    try{
        $email = validate($_POST["email"]);
        $db= new PDO("mysql:host=localhost;dbname=gestion_plastic", "root", "");
        $stm = $db->prepare("SELECT * FROM `user` WHERE email=:email");
        $stm->bindParam(":email", $email);
        $stm->execute();

        if($stm->rowCount() <= 0){
            echo "Email doesn't exist!";
        }else{
            $mail->setFrom('nassirans01@gmail.com','plasticCollection');
            $mail->addAddress($email);
            $mail->Subject = "Validation Code";
            $code = rand(100000, 999999);
            $_SESSION["code"] = $code;
            $_SESSION["email"] = $email;
            $mail->Body = "Email address validation code : <h3 style='color:blue;'>$code</h3>";
            $mail->send();
            echo "true";

        }
    }catch(PDOException $e){
        echo $e->getMessage();
    }
}else{
    echo "Please fill out all this field!";
}
?>