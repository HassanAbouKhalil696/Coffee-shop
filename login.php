<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['username'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['user_id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['username'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['user_id'];
         header('location:home.php');

      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <style>
      /* login form style  */
      body{
         margin: 0;
         padding: 0;
         display: flex;
         justify-content: center;
         align-items: center;
         min-height: 100vh;
         background: #f1f1f1;
      }
      .form-container{
         width: 100%;
         max-width: 380px;
         padding: 25px;
         background: #fff;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
         border-radius: 5px;
      }
      .form-container h3{
         text-align: center;
         font-weight: 500;
         color: #333;
      }
      .form-container form .box{
         width: 100%;
         padding: 8px;
         margin: 8px 0;
         border: 1px solid #ccc;
         outline: none;
         font-size: 16px;
         border-radius: 5px;
      }
      .form-container form .btn{
         width: 100%;
         padding: 8px;
         border: none;
         outline: none;
         background: #333;
         color: #fff;
         font-size: 16px;
         border-radius: 5px;
         cursor: pointer;
      }
      .form-container form .btn:hover{
         background: #444;
      }
      .form-container form p{
         margin-top: 10px;
         text-align: center;
         font-size: 16px;
         color: #333;
      }
      .form-container form a{
         text-decoration: none;
         color: #333;
         font-weight: 500;
      }
      .message{
         position: fixed;
         top: 10px;
         right: 10px;
         background: #333;
         color: #fff;
         padding: 10px 15px;
         border-radius: 5px;
         display: flex;
         align-items: center;
         justify-content: space-between;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
      }
      .message i{
         color: #fff;
         font-size: 18px;
         cursor: pointer;
      }
      
   </style>
</head>
<body >

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="submit" name="submit" value="login now" class="btn">
      <p>don't have an account? <a href="register.php">register now</a></p>
   </form>

</div>

</body>
</html>