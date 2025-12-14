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
    <link rel="icon" type="image/x-icon" href="uploaded_img\favicon.ico">


    <title>about</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
    .heading {
        background: linear-gradient(135deg, #fc8ccaff, #ffb6b9);
    }

    .heading h3 {

        text-transform: uppercase;
    }

    .heading p a:hover {
        color: #fff;
    }

    .about .flex .image img {
        height: 100%;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 2px 8px rgba(233, 43, 144, 0.24);
        /* ظل خفيف */
        transition: transform 0.3s ease;

    }

    .about .flex .image img:hover {
        transform: scale(1.05);

    }

    .about .flex .content h3 {
        font-size: 2.5rem;
        color: #292929ff;
        text-transform: uppercase;
    }

    .about .flex .content p {
        font-size: 1.6rem;
        color: #555;
        padding: 1rem 0;
        line-height: 1.8;
    }

    .about .flex .content .btn {
        display: inline-block;
        margin-top: 1rem;
        background-color: var(--pink);
        color: var(--white);
        cursor: pointer;
        border: none;
        border-radius: 25px;
        /* بيضاوي */
        padding: 8px 18px;
        /* أصغر */
        font-size: 14px;
        text-transform: uppercase;
    }

    .about .flex .content .btn:hover {
        background-color: #ffb6b9;
    }

    .reviews .box-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(30rem, 1fr));
        gap: 1.5rem;
    }

    .reviews .box-container .box {
        border: none !important;
        /* نحيد البوردر */
        box-shadow: 0 2px 6px rgba(224, 30, 169, 0.28);
        /* ظل خفيف */
        border-radius: 12px;
        /* نعطي الشكل ناعم */
        padding: 20px;
        text-align: center;
    }

    .reviews .box-container .box img {
        height: 10rem;
        width: 10rem;
        object-fit: cover;
        border-radius: 50%;
        border: 0.5rem transparent var(--pink);
        padding: 0.3rem;
        margin-bottom: 1rem;
    }

    .reviews .box-container .box p {
        font-size: 1.4rem;
        color: #555;
        line-height: 1.8;
        margin-bottom: 1rem;
    }

    .reviews .box-container .box .stars {
        color: var(--pink);
        margin-bottom: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 1rem;
        margin-bottom: 1.5rem;
        gap: 0.3rem;
        border: solid #00000025 0.1rem;
        /* مسافة بين النجوم */
        flex-wrap: wrap;
        /* نجعل النجوم تنتقل للسطر التالي إذا لم يكن هناك مساحة كافية */
        font-size: 1.2rem;
        /* حجم النجوم */
        /* نجعل النجوم تنتقل للسطر التالي إذا لم يكن هناك مساحة كافية */
        /* نجعل النجوم تنتقل للسطر التالي إذا لم يكن هناك مساحة كافية */
        /* نجعل النجوم تنتقل للسطر التالي إذا لم يكن هناك مساحة كافية */

    }

    .reviews .box-container .box .stars i {
        font-size: 1.5rem;
        padding: 0 0.1rem;
        /* مسافة بين النجوم */
        color: var(--pink);
        /* نجعل النجوم تنتقل للسطر التالي إذا لم يكن هناك مساحة كافية */

    }

    .reviews .box-container .box h3 {
        font-size: 2rem;
        color: #292929ff;
        text-transform: uppercase;

        /* نجعل النجوم تنتقل للسطر التالي إذا لم يكن هناك مساحة كافية */
        margin-top: 0.5rem;
        /* مسافة بين النجوم */

    }
    </style>

</head>

<body>

    <?php @include 'header.php'; ?>

    <section class="heading">
        <h3>À propos de nous</h3>
        <p> <a href="home.php">Accueil</a> / À propos </p>
    </section>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="images/about-img-1.png" alt="">
            </div>

            <div class="content">
                <h3>Pourquoi nous choisir ?</h3>
                <p>Nous offrons des produits de qualité supérieure avec un service rapide et fiable. La satisfaction de
                    nos clients est notre priorité.</p>
                <a href="shop.php" class="btn">Achetez maintenant</a>
            </div>

        </div>

        <div class="flex">

            <div class="content">
                <h3>Que proposons-nous ?</h3>
                <p>Nous proposons une large gamme de produits soigneusement sélectionnés, adaptés à tous les goûts et
                    budgets.</p>
                <a href="contact.php" class="btn">Nous contacter</a>
            </div>

            <div class="image">
                <img src="images/about-img-2.jpg" alt="">
            </div>

        </div>

        <div class="flex">

            <div class="image">
                <img src="images/about-img-3.jpg" alt="">
            </div>

            <div class="content">
                <h3>Qui sommes-nous ?</h3>
                <p>Nous sommes une équipe passionnée, dédiée à offrir la meilleure expérience d’achat en ligne à nos
                    clients.</p>
                <a href="#reviews" class="btn">Avis des clients</a>
            </div>

        </div>

    </section>

    <section class="reviews" id="reviews">

        <h1 class="title">Avis des clients</h1>

        <div class="box-container">

            <div class="box">
                <img src="images/pic-1.png" alt="">
                <p>Excellent service ! Le site est facile à utiliser, la livraison a été rapide et le produit correspond
                    parfaitement à la description.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Karim El Amrani</h3>
            </div>

            <div class="box">
                <img src="images/pic-2.png" alt="">
                <p>Très satisfaite de mon achat. Les produits sont de bonne qualité et le service client a répondu
                    rapidement à mes questions.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h3>Sophie Martin</h3>
            </div>

            <div class="box">
                <img src="images/pic-3.png" alt="">
                <p>Livraison rapide et produit conforme à mes attentes. Je recommande vivement ce site à mes amis et ma
                    famille.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Mohamed Ali</h3>
            </div>

            <div class="box">
                <img src="images/pic-4.png" alt="">
                <p>Très bon rapport qualité-prix. L’emballage était soigné et j’ai reçu un petit cadeau en bonus. Merci
                    !</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h3>Julie Lambert</h3>
            </div>

            <div class="box">
                <img src="images/pic-5.png" alt="">
                <p>Une expérience d’achat agréable. Le site est clair et intuitif. Je commanderai à nouveau sans
                    hésitation.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Claire Dubois</h3>
            </div>

            <div class="box">
                <img src="images/pic-6.png" alt="">
                <p>Service client impeccable ! Ils m’ont aidée à suivre ma commande et à résoudre mon problème
                    rapidement.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <h3>Fatima Zahra</h3>
            </div>

        </div>
    </section>

    <section class="heading">
        <h3 style="text-transform: uppercase; text-align: center; padding: 2rem; font-size: 3rem;">
            Choisissez les fleurs qui vous représentent
        </h3>
        <a href="shop.php" class="btn">Cliquez ici !</a>
    </section>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>