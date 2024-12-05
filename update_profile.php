<?php 
include("config.php");
session_start();
$user_id =$_SESSION['user_id'];
if(isset($_POST['update_profile'])){
    $update_name=mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email=mysqli_real_escape_string($conn, $_POST['update_email']);
    $q = "UPDATE user_form SET name='$update_name', email ='$update_email'  WHERE id=$user_id"or die("query faild");
    $r = mysqli_query($conn, $q);  

    $old_password = $_POST['old_password'];
    $update_password= mysqli_real_escape_string( $conn, $_POST['update_password']); 
    $new_password= mysqli_real_escape_string( $conn, $_POST['new_password']); 
    $confirm_password= mysqli_real_escape_string( $conn, $_POST['confirm_password']);
    
    if(!empty($upate_password) || !empty($new_password) || !empty($confirm_password) ){
        if(  $old_password != $update_password){
            $message[]= "old Password not match !";

        }elseif(  $new_password != $confirm_password){
            $message[]= "confirm Password not match !";
        }
        else{
            $q = "UPDATE user_form SET password='$confirm_password'  WHERE id=$user_id"or die("query faild");
            $r = mysqli_query($conn, $q);           
            $message[]= "Password update successfuly!";   
        }
    }
    $update_image= $_FILES['update_image']['name'];
    $update_image_size= $_FILES['update_image']['size'];
    $update_image_tmp_name= $_FILES['update_image']['tmp_name'];
    $name_folder = "uploaded_images/".$update_image;
    if(! empty($update_image)){
        if(!empty($update_image_size> 2000000)){
            $message[]="image is too large";
        }else{
            $q = "UPDATE user_form SET image='$update_image'  WHERE id=$user_id"or die("query faild");
            $r = mysqli_query($conn, $q);
                
            $message[]= "image updated successfuly!";
        }  
    }
    


}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update profile</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <div class="update-profile">
    <?php 
        $q ="SELECT * FROM user_form WHERE id=$user_id" ;
        $r=mysqli_query($conn,$q)or die("Query failed: " . mysqli_error($conn));

        if(mysqli_num_rows($r)> 0){
            $fetch=mysqli_fetch_array ($r);
        }
        
        ?>
        <form action="update_profile.php" method="POST" enctype="multipart/form-data" >
            <?php 
                if($fetch['image']==''){
                    echo '<img src="images/face2.jfif" alt="wrong path">';
            
                }else{
                    echo '<img src="uploaded_images/'.$fetch['image'].'" >';
                } 
                if(isset($message)){
                    foreach($message as $msg){
                    echo '<div class="message">'.$msg   .'</div>';
                } 
            }
            ?>
            <div class="flex">
                <div class="inputbox">
                <form action="" enctype="multipart/form-data">
                    <span>username </span>
                    <input type="text" class="box" name="update_name"  
                    placeholder="update your name " value="<?php echo $fetch['name'];?>">
                    
                    <span>email</span>  
                    <input type="email" class="box" name="update_email" 
                    placeholder="update your email" value="<?php echo $fetch['email'];?>">
                    
                    <span>image</span>
                    <input type="file" class="box" name="update_image"
                     placeholder="update your image" value="<?php echo $fetch['image'];?>"> 
                </div>

                <div class="inputbox">
                <input type="hidden" class="box" name="old_password"
                 value="<?php echo $fetch['password'];?>" >           

                <span>old password</span>
                <input type="password" class="box" name="update_password"
                 placeholder="enter your previoud password"  >           

                <span>new password</span>
                <input type="password" class="box" name="new_password"
                 placeholder="enter your new password ">           
                
                <span>confirm password</span>
                <input type="password" class="box" name="confirm_password" 
                placeholder="confirm your password">           

                </div>
           </div>
            <input type="submit" class="btn" value="update profile" name="update_profile" >
            <a href="home.php" class="btn">go back to home page</a>   

        </form>   
 
    </div>
</body>
</html>
