<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="uploaded_img/favicon.ico">
    <title>Commandes</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
    .heading {
        background: linear-gradient(135deg, #fc8ccaff, #ffb6b9);
    }

    .heading h3 {
        font-size: 5.5rem;
        color: var(--white);
        text-transform: uppercase;
        z-index: 1;
    }

    .heading p {
        font-size: 2.5rem;
        color: var(--light-white);
        z-index: 1;
    }

    .heading::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        background-color: var(--pink);
        /* خط تحت العنوان */
        border-radius: 0.2rem;
    }

    .heading p a:hover {
        color: #fff;
    }

    .products .box {
        border: none !important;
        /* نحيد البوردر */
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        /* ظل خفيف */
        border-radius: 12px;
        /* نعطي الشكل ناعم */
        padding: 15px;
        text-align: center;
    }

    /* الأزرار */
    .products .box .btn,
    .products .box .option-btn {
        border: none;
        border-radius: 25px;
        /* بيضاوي */

        /* أصغر */
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
        background: linear-gradient(135deg, #ff9a9e, #fad0c4);
        color: #fff;
        box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);

    }

    /* تأثير hover */
    .products .box .btn:hover,
    .products .box .option-btn:hover {
        transform: scale(1.05);
        opacity: 0.9;
        box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);


    }
    </style>

</head>

<body>

    <?php @include 'header.php'; ?>


    <section class="heading">
        <h3>Vos Commandes</h3>
        <p> <a href="home.php">Acceuil </a> / Commandes </p>
    </section>

    <section class="placed-orders">

        <h1 class="title">Commandes Passées</h1>

        <div class="box-container">

            <?php
        $select_orders = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_orders) > 0){
            while($fetch_orders = mysqli_fetch_assoc($select_orders)){
    ?>
            <div class="box">
                <p>Passée le : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                <p>Nom : <span><?php echo $fetch_orders['name']; ?></span> </p>
                <p>Numéro : <span><?php echo $fetch_orders['number']; ?></span> </p>
                <p>Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                <p>Adresse : <span><?php echo $fetch_orders['address']; ?></span> </p>
                <p>Méthode de paiement : <span><?php echo $fetch_orders['method']; ?></span> </p>
                <p>Vos commandes : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                <p>Prix total : <span><?php echo $fetch_orders['total_price']; ?> Dh</span> </p>
                <p>Statut du paiement : <span
                        style="color:<?php if($fetch_orders['payment_status'] == 'pending'){echo 'tomato'; }else{echo 'green';} ?>">
                        <?php echo $fetch_orders['payment_status']; ?>
                    </span></p>
            </div>

            <?php
        }
    }else{
        echo '<p class="empty">Aucune commande passée pour le moment !</p>';
    }
    ?>
        </div>

    </section>







    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>