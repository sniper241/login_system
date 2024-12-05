<?php 
include "config.php";
session_start();
$user_id =$_SESSION['user_id'];
if(!isset($user_id)){
    header('location:login.php');
}
if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div class="container">
        <div class="profile">
            <?php 
                $q ="SELECT * FROM user_form WHERE id=$user_id" or die("quiery faild from profile");
                $r=mysqli_query($conn,$q);
                if(mysqli_num_rows($r)> 0){
                    $fetch=mysqli_fetch_assoc($r);
                }
                if($fetch['image']==''){?>
                    <img src="images/face2.jfif" alt="wrong path">
                <?php
                }else{
                    echo '<img src="uploaded_images/'.$fetch['image'].'" >';
                }
            ?>
            <h3><?php echo $fetch['name'];  ?></h3>
            <a href="update_profile.php" class="btn"> update profile</a>
            <a  href="home.php?logout=<?php echo $user_id;?>" class="btn"> logout</a>
            <p>new <a href="login.php">login</a> or <a href="register.php">register</a></p>
        </div>
    </div>
</body>
</html> 










