<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'message sent already!';
    }else{
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
        $message[] = 'message sent successfully!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="uploaded_img\favicon.ico">
    <title>Contact</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
    .contact {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 3rem 1rem;
        height: 100VH;
    }

    .contact form {
        background: #ffffffff;
        /* رمادي غامق */
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        /* ظل ناعم */
        max-width: 500px;
        width: 100%;
        border: 1px solid rgba(255, 182, 193, 0.4);
        /* حدود وردية ناعمة */
    }

    .contact form h3 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #000000b1;
        /* وردي فاتح */
    }

    .contact form .box,
    .contact form textarea {
        width: 100%;
        padding: .8rem 1rem;
        margin: .6rem 0;
        border: 1px solid rgba(255, 182, 193, 0.5);
        /* حدود وردية فاتحة */
        border-radius: 8px;
        background: #ffffffff;
        /* رمادي أفتح قليلاً */
        color: #00000091;
        transition: border 0.3s ease, box-shadow 0.3s ease;
    }

    .contact form .box:focus,
    .contact form textarea:focus {
        border-color: #ff6f91;
        box-shadow: 0 0 10px rgba(255, 182, 193, 0.5);
        outline: none;
    }

    .contact form .btn {
        width: 100%;
        background: linear-gradient(135deg, #fc8ccaff, #ffb6b9);
        /* وردي جميل */
        border: none;
        padding: .9rem;
        border-radius: 8px;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(255, 111, 145, 0.4);
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .contact form .btn:hover {
        background: #ff4f7d;
        /* وردي أدكن عند hover */
        transform: translateY(-2px);
    }

    .heading p a:hover {
        color: #fff;
    }
    </style>

</head>

<body>

    <?php @include 'header.php'; ?>
    <section class="heading">
        <h3>Contactez-nous</h3>
        <p> <a href="home.php">Accueil</a> / Contact </p>
    </section>

    <section class="contact">

        <form action="" method="POST">
            <h3>Envoyez-nous un message !</h3>
            <input type="text" name="name" placeholder="Entrez votre nom" class="box" required>
            <input type="email" name="email" placeholder="Entrez votre email" class="box" required>
            <input type="number" name="number" placeholder="Entrez votre numéro" class="box" required>
            <textarea name="message" class="box" placeholder="Entrez votre message" required cols="30"
                rows="10"></textarea>
            <input type="submit" value="Envoyer" name="send" class="btn">
        </form>

    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>