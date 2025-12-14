<?php
@include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);

   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){
         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');
         exit();
      } elseif($row['user_type'] == 'user'){
         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');
         exit();
      }
   } else {
      $message[] = ['type'=>'error','text'=>'Incorrect email or password!'];
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="uploaded_img/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        background: linear-gradient(135deg, #ffc0cb, #ff69b4);
        /* خلفية وردية متدرجة */
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        flex-direction: column;
        font-family: "Poppins", sans-serif;
    }



    .alert {
        position: relative;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 500;
        width: 380px;
        text-align: left;
        animation: slideDown 0.6s ease;
    }

    .alert.error {
        background: #ffe5e5;
        color: #d9534f;
        border-left: 6px solid #d9534f;
    }

    .alert.success {
        background: #e7f9ed;
        color: #28a745;
        border-left: 6px solid #28a745;
    }

    .alert i {
        position: absolute;
        top: 12px;
        right: 15px;
        cursor: pointer;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-container {
        background: #fff;
        padding: 2.5rem;
        border-radius: 20px;
        box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
        width: 400px;
        text-align: center;
        animation: fadeIn 1s ease-in-out;
    }

    .form-container h3 {
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
        color: #333;
    }

    .box {
        width: 100%;
        padding: 12px 15px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
        transition: 0.3s;
    }

    .box:focus {
        border-color: #ff69b4;
        box-shadow: 0px 0px 6px rgba(255, 102, 173, 0.5);
    }

    .btn {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        border: none;
        border-radius: 10px;
        background: linear-gradient(135deg, #ffc0cb, #ff69b4);
        color: #fff;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0px 6px 15px rgba(255, 102, 240, 0.4);
    }

    p {
        margin-top: 1rem;
        font-size: 0.9rem;
    }

    p a {
        color: #ff66c2ff;
        text-decoration: none;
        font-weight: 600;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>

    <?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="alert '.$msg['type'].'">
         <span>'.$msg['text'].'</span>
         <i class="fas fa-times" onclick="this.parentElement.style.display=\'none\';"></i>
      </div>
      ';
   }
}
?>

    <div class="form-container">
        <h3>Bienvenue</h3>
        <form action="" method="post">
            <input type="email" name="email" class="box" placeholder="Entrez votre e-mail" required>
            <input type="password" name="pass" class="box" placeholder="Entrez votre mot de passe" required>
            <input type="submit" class="btn" name="submit" value="Se connecter">
            <p>Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous</a>
            </p>
        </form>
    </div>


</body>

</html>