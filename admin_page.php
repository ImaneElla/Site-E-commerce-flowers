<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="icon" type="image/x-icon" href="uploaded_img/favicon.ico">
    <style>
    /* reset some default styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f5f6fa;
        color: #2f3640;
    }

    .dashboard .title {
        text-align: center;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        color: #2f3640;
    }

    .box-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .box-container .box {
        background: #fff;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: default;
    }

    .box-container .box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .box-container .box h3 {
        font-size: 24px;
        color: #00a8ff;
        margin-bottom: 10px;
    }

    .box-container .box p {
        font-size: 16px;
        color: #718093;
        font-weight: 500;
    }

    @media (max-width: 600px) {
        .box-container {
            grid-template-columns: 1fr;
        }
    }
    </style>
</head>

<body>

    <?php @include 'admin_header.php'; ?>

    <section class="dashboard">

        <h1 class="title">Tableau de bord</h1>

        <div class="box-container">

            <div class="box">
                <?php
            $total_pendings = 0;
            $select_pendings = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
            while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){
               $total_pendings += $fetch_pendings['total_price'];
            };
         ?>
                <h3><?php echo $total_pendings; ?> Dh</h3>
                <p>Paiements en attente</p>
            </div>

            <div class="box">
                <?php
            $total_completes = 0;
            $select_completes = mysqli_query($conn, "SELECT * FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
            while($fetch_completes = mysqli_fetch_assoc($select_completes)){
               $total_completes += $fetch_completes['total_price'];
            };
         ?>
                <h3><?php echo $total_completes; ?> Dh</h3>
                <p>Paiements complétés</p>
            </div>

            <div class="box">
                <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
                <h3><?php echo $number_of_orders; ?></h3>
                <p>Commandes passées</p>
            </div>

            <div class="box">
                <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            $number_of_products = mysqli_num_rows($select_products);
         ?>
                <h3><?php echo $number_of_products; ?></h3>
                <p>Produits ajoutés</p>
            </div>

            <div class="box">
                <?php
            $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
            $number_of_users = mysqli_num_rows($select_users);
         ?>
                <h3><?php echo $number_of_users; ?></h3>
                <p>Utilisateurs normaux</p>
            </div>

            <div class="box">
                <?php
            $select_admin = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
            $number_of_admin = mysqli_num_rows($select_admin);
         ?>
                <h3><?php echo $number_of_admin; ?></h3>
                <p>Utilisateurs admin</p>
            </div>

            <div class="box">
                <?php
            $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
            $number_of_account = mysqli_num_rows($select_account);
         ?>
                <h3><?php echo $number_of_account; ?></h3>
                <p>Comptes totaux</p>
            </div>

            <div class="box">
                <?php
            $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            $number_of_messages = mysqli_num_rows($select_messages);
         ?>
                <h3><?php echo $number_of_messages; ?></h3>
                <p>Nouveaux messages</p>
            </div>

        </div>

    </section>

    <script src="js/admin_script.js"></script>

</body>

</html>