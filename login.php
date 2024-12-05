<?php 
include "config.php";
session_start();
if(isset($_POST["submit"])){
    $email     =mysqli_real_escape_string($conn,$_POST['email']);
    $password  =mysqli_real_escape_string($conn,$_POST['password']);

    $q ="SELECT * FROM user_form WHERE email='$email'  AND password ='$password' ";
    $select_r= mysqli_query($conn,$q) or die("quiery failed to select");
    if(mysqli_num_rows( $select_r) > 0){
        $row = mysqli_fetch_array($select_r);
        $message[]= "login successfully";
        $_SESSION['user_id']=$row["id"];
        header('location:home.php');
    }else{
        $message[]= "incorrect email or password";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="form-container">
        <form action="login.php" method="POST" enctype="multipart/form-data">
            <h3> login now</h3>
            <?php 
            if(isset($message)){
                foreach($message as $msg){
                echo '<div class="message">'.$msg   .'</div>';
            }
            }?>
            <input type="email"    class="box" name="email"     placeholder="Enter Your Email" >
            <input type="password" class="box" name="password"  placeholder="Enter Your Password" >
            <input type="submit"   class="btn" name="submit" value="login now" >
            <p> do not have an account ? <a href="register.php">register now</a></p>

        </form>
    </div>
</body>
</html>