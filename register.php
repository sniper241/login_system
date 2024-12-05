<?php 
include "config.php";

if(isset($_POST["submit"])){
   
    $name      =mysqli_real_escape_string($conn,$_POST['name']);
    $email     =mysqli_real_escape_string($conn,$_POST['email']);
    $password  =mysqli_real_escape_string($conn,$_POST['password']);
    $cpassword =mysqli_real_escape_string($conn,$_POST['cpassword']);
    $image= $_FILES['image']['name'];
    $image_size= $_FILES['image']['size'];
    $image_tmp_name= $_FILES['image']['tmp_name'];
    $name_folder = "uploaded_images/".$image;

    $q ="SELECT * FROM user_form WHERE email='$email'  AND password ='$password' ";
    $select_r= mysqli_query($conn,$q) or die("quiery failed to select");
    
    if(mysqli_num_rows( $select_r) > 0){
        $message[]= "many rows in db";
    }else{
        echo 'test';
        if ($password != $cpassword){

            $message[]= "Password not match !";
        }elseif($image_size> 2000000){
            $message[]= "image size is too large";
        }else{
            $q= "INSERT INTO user_form (name,email,password, image) VALUES('$name','$email','$password','$image')";
            $insert_result= mysqli_query($conn,$q);
            if($insert_result){
                move_uploaded_file($image_tmp_name,$name_folder);
                $message[]= "register successfuly";
                header("location:login.php");
            }else{
                $message[]= "regestration faild to insert ";
            }
        }
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
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <h3> register now</h3>
            <?php 
            if(isset($message)){
                foreach($message as $msg){
                echo '<div class="message">'.$msg   .'</div>';
            }
            }?>
            <input type="text"     class="box" name="name"      placeholder="Enter Your Name" >
            <input type="email"    class="box" name="email"     placeholder="Enter Your Email" >
            <input type="password" class="box" name="password"  placeholder="Enter Your Password" >
            <input type="password" class="box" name="cpassword" placeholder="Confirm Your Password" >
            <input type="file"     class="box" name="image"   accept="image.jfif,image.jpg,image.jpeg,image.png,image.jpg " >
            <input type="submit"   class="btn" name="submit" value="register now" >
            <p> already have an account ? <a href="login.php">login now</a></p>

        </form>
    </div>
</body>
</html>