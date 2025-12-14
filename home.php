<?php

$message = [];

require_once 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
   exit();
}

// Affichage des messages
if(!empty($message) && is_array($message)):
?>
<div class="messages">
    <?php foreach($message as $msg): ?>
    <p><?php echo $msg; ?></p>
    <?php endforeach; ?>
</div>
<?php
endif;   


// --- Add to Wishlist ---
if(isset($_POST['add_to_wishlist'])){

   $product_id = intval($_POST['product_id']);

   // Vérifier dans la base directement
   $check_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die('query failed');
   $product = mysqli_fetch_assoc($check_product);

   if($product){
      $check_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE pid = '$product_id' AND user_id = '$user_id'");
      $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE pid = '$product_id' AND user_id = '$user_id'");

      if(mysqli_num_rows($check_wishlist) > 0){
         $message[] = 'Déjà ajouté à la liste de souhaits ❤️';
      } elseif(mysqli_num_rows($check_cart) > 0){
         $message[] = 'Ce produit est déjà dans votre panier 🛒';
      } else {
         mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) 
            VALUES('$user_id', '{$product['id']}', '{$product['name']}', '{$product['price']}', '{$product['image']}')");
         $message[] = 'Produit ajouté à la liste de souhaits ✔️';
      }
   }
}

// --- Add to Cart ---
if(isset($_POST['add_to_cart'])){

   $product_id = intval($_POST['product_id']);
   $quantity = max(1, intval($_POST['product_quantity']));

   // Vérifier dans la base directement
   $check_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die('query failed');
   $product = mysqli_fetch_assoc($check_product);

   if($product){
      $check_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE pid = '$product_id' AND user_id = '$user_id'");

      if(mysqli_num_rows($check_cart) > 0){
         $message[] = 'Produit déjà dans le panier 🛒';
      } else {
         // Supprimer de la wishlist si déjà là
         mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$product_id' AND user_id = '$user_id'");
         
         mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) 
            VALUES('$user_id', '{$product['id']}', '{$product['name']}', '{$product['price']}', '$quantity', '{$product['image']}')");
         $message[] = 'Produit ajouté au panier ✔️';
      }
   }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="uploaded_img\favicon.ico">
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
        width: 8rem;
        height: 0.3rem;
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
    /* زر المنتجات يبقى كما هو */
    .products .box .option-btn,
    .products .box .btn {
        border: none;
        border-radius: 25px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
        padding: 8px 18px;
        background: linear-gradient(135deg, #ff9a9e, #fad0c4);
        color: #fff;
        box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
    }

    /* hover زر المنتجات */
    .products .box .option-btn:hover,
    .products .box .btn:hover {
        transform: scale(1.05);
        opacity: 0.9;
        background: linear-gradient(135deg, #ff6a88, #ff99ac);
        box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
    }

    /* زر السهم ↓ */
    /* زر السهم ↓ */
    .option-btn.down-arrow {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        /* دائري/بيضاوي */
        background: rgba(210, 81, 145, 1);
        /* وردي متدرج */
        color: #fff;
        font-size: 30px;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
        transition: all 0.3s ease;
    }

    /* hover */
    .option-btn.down-arrow:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
        background: white;
        color: black;
    }

    .home-contact {
        color: #ffffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        text-align: center;
    }

    .home-contact .btn {
        padding: 10px 20px;
        border-radius: 30px;
    }

    .home-contact .btn:hover {
        background: #ff69b4;
        box-shadow: 0 6px 20px rgba(255, 105, 180, 0.46);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* تطبيق الأنيميشن على العناصر */
    .delivery-info {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        padding: 3rem 1rem;
        gap: 2rem;
        flex-wrap: wrap;
        background: #fff0f5;
        /* خلفية وردية فاتحة */
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        animation: fadeIn 1s ease-in-out;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 2rem;

    }

    .delivery-box {
        background: #fff;
        border: 2px solid #ccc;
        /* border رمادي */
        border-radius: 15px;
        padding: 2rem;
        margin: 3rem;
        width: 100%;

        max-width: 700px;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        position: relative;
        margin: 1rem;
        animation: fadeIn 1s ease-in-out;
        flex: 1;
        transition: transform 0.3s ease, box-shadow 0.3s ease;

    }

    .delivery-box:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);


    }


    .delivery-box h3 {
        font-size: 2rem;
        color: #d25191;
        margin-bottom: 1rem;
    }

    .delivery-box p {
        font-size: 1.4rem;
        color: #555;
        line-height: 1.6;
    }

    .car-icon {
        font-size: 50px;
        color: #d25191;
        margin-bottom: 1rem;
    }

    .about {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        padding: 3rem 1rem;
        flex-wrap: wrap;
        /* خلفية وردية فاتحة */
        border-radius: 15px;
        animation: fadeIn 1s ease-in-out;
        margin-bottom: 2rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;


    }




    .about .image {
        flex: 1;
        min-width: 300px;
        max-width: 500px;
        text-align: center;
        animation: fadeIn 1s ease-in-out;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        border-radius: 15px;
        overflow: hidden;
        height: auto;
        width: 100%;
        max-height: 600px;
        object-fit: cover;
        object-position: center;
        margin-bottom: 1rem;
        background: #fff;
        padding: 10px;
        border: 2px transparent #ccc;
        /* border رمادي */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;

    }

    .about .image img {
        width: 100%;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: auto;
        max-height: 400px;
        object-fit: cover;
        object-position: center;
        display: block;
        margin: 0 auto;

    }

    .about .content {
        flex: 1;
        min-width: 300px;
        max-width: 600px;
        animation: fadeIn 1s ease-in-out;
        transition: transform 0.3s ease, box-shadow 0.3s ease;

    }

    .about .content h3 {
        font-size: 2.5rem;
        color: #d25191;
        margin-bottom: 1rem;
    }

    .about .content p {
        font-size: 1.4rem;
        color: #555;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .about .content .btn {
        padding: 10px 20px;
        border-radius: 30px;
        background: linear-gradient(135deg, #ff9a9e, #fad0c4);
        color: #fff;
        box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
        transition: all 0.3s ease;
    }

    .about .content .btn:hover {
        background: #ff69b4;
        box-shadow: 0 6px 20px rgba(255, 105, 180, 0.46);
    }
    </style>
</head>

<body>

    <?php @include 'header.php'; ?>

    <!-- Messages -->
    <?php if(!empty($message) && is_array($message)): ?>
    <div class="messages">
        <?php foreach($message as $msg): ?>
        <p><?php echo $msg; ?></p>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <section class="home">
        <div class="content">
            <h3>Nouvelles collections</h3>
            <p>Découvrez nos nouvelles collections tendance, avec une qualité exceptionnelle et des prix compétitifs.
            </p>
            <a href="about.php" class="btn">Découvrez</a>
        </div>
    </section>

    <section class="products">
        <h1 class="title">Derniers produits</h1>
        <div class="box-container">
            <?php
         $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6") or die('query failed');
         if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
      ?>
            <form action="" method="POST" class="box">
                <a href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
                <div class="price"><?php echo $fetch_products['price']; ?> Dh</div>
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <input type="number" name="product_quantity" value="1" min="1" class="qty">
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                <input type="submit" value="❤️" name="add_to_wishlist" class="option-btn">
                <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
            </form>
            <?php
         }
      } else {
         echo '<p class="empty">No products added yet!</p>';
      }
      ?>
        </div>
        <div class="more-btn">
            <a href="shop.php" class="option-btn down-arrow"><span style='font-size:30px; '>&#8595;</span></a>

        </div>
    </section>

    <!-- delivery info section starts  -->

    <section class="delivery-info">
        <div class="delivery-box">
            <i class="fas fa-shipping-fast car-icon"></i>
            <h3>Livraison rapide et fiable</h3>
            <p>
                Nous offrons une livraison rapide et fiable pour toutes vos commandes.
                Profitez de notre service de livraison express avec des options de suivi en temps réel.
                Recevez vos produits directement à votre porte, rapidement et en toute sécurité.
                Livraison gratuite à partir de 50€ d'achat.
        </div>
        <div class="delivery-box">
            <i class="fas fa-headset car-icon"></i>
            <h3>Service client 24/7</h3>
            <p>
                Notre équipe de service client est disponible 24 heures sur 24, 7 jours sur 7, pour répondre à toutes
                vos questions et préoccupations.
                N'hésitez pas à nous contacter par chat en direct, e-mail ou téléphone.
                Nous sommes là pour vous aider à chaque étape de votre expérience d'achat.
            </p>
        </div>
        <div class="delivery-box">
            <i class="fas fa-leaf car-icon"></i>
            <h3>Bio </h3>
            <p>
                Nous nous engageons à offrir des produits biologiques de haute qualité, cultivés sans pesticides ni
                produits chimiques nocifs.
                En choisissant nos produits bio, vous contribuez à la protection de l'environnement et à votre santé.
                Découvrez notre sélection de produits bio pour une alimentation saine et responsable.
            </p>
        </div>

    </section>
    <!-- delivery info section ends -->
    <!-- home contact section starts  -->


    <section class="home-contact" style="background: linear-gradient(135deg, #fc8ccaff, #ffb6b9);;">
        <div class="content">
            <h3>Vous avez des questions ou besoin d’aide ?</h3>
            <p style="color: #fff;">Notre équipe est toujours disponible pour répondre à vos questions et vous
                accompagner dans vos achats.
            </p>
            <a href="contact.php" class="btn">Contacter</a>
        </div>
    </section>
    <!-- home contact section ends -->


    <!--future update  -->
    <section class="about">
        <div class="image">
            <img src="uploaded_img\place.jpg" alt="">
        </div>
        <div class="content">
            <h3>Bienvenue chez Imane Flowers</h3>
            <p>
                Chez<strong style="color: #d25191;"> Imane Flowers</strong>, nous croyons que chaque fleur raconte une
                histoire unique. Depuis notre création,
                nous nous engageons à offrir des compositions florales exceptionnelles qui capturent l'essence de vos
                émotions et de vos moments spéciaux. Que ce soit pour une célébration joyeuse, un geste d'amour ou un
                hommage sincère, nos fleurs sont soigneusement sélectionnées et arrangées avec passion pour créer des
                souvenirs inoubliables.
                Notre équipe de fleuristes expérimentés met tout son savoir-faire au service de votre satisfaction, en
                proposant des créations personnalisées adaptées à chaque occasion. Nous privilégions la fraîcheur, la
                qualité et la diversité de nos fleurs pour vous garantir des bouquets éclatants et durables. Imane
                Flowers, c'est aussi un engagement envers l'environnement, avec une sélection de produits bio et
                respectueux de la nature.
                Faites confiance à <strong style="color: #d25191;"> Imane Flowers</strong> pour embellir vos moments
                précieux et transmettre vos plus belles
                émotions à travers le langage des fleurs.
            </p>
            <a href="about.php" class="btn">Lire plus</a>

        </div>

    </section>
    <h1 style="
         
                       Color: #292929ff;
                        font-size: 3rem;
                        font-weight: bold;
                        margin-bottom: 2rem;
                        text-align: center;
                        text-transform: uppercase;
         
                    
                    ">à venir</h1>
    <!-- Future Updates Section (side by side) -->
    <div class="future-updates-grid">
        <section class="about future-update">
            <div class="image">
                <img src="uploaded_img/future1.jpg" alt="">

                <div class="content">

                    <h3>Recommandations</h3>
                    <p>
                        Nous travaillons constamment à l'amélioration de notre site pour vous offrir une expérience
                        encore meilleure.
                        Bientôt, vous pourrez profiter de nouvelles fonctionnalités passionnantes telles que des
                        recommandations personnalisées,
                        un système de notation et d'avis, et bien plus encore !
                    </p>
                </div>
            </div>
        </section>

        <section class="about future-update">
            <div class="image">
                <img src="uploaded_img/future2.jpg" alt="">
                <div class="content">
                    <h3>Gagnez des Cadeaux</h3>
                    <p>
                        Participez à notre programme de fidélité pour gagner des points à chaque achat.
                        Échangez vos points contre des réductions, des cadeaux exclusifs et des offres spéciales.
                        Restez à l'écoute pour découvrir comment vous pouvez commencer à accumuler des points !</p>
                </div>
            </div>
        </section>

        <section class="about future-update">
            <div class="image">
                <img src="uploaded_img/future3.jpg" alt="">
                <div class="content">
                    <h3>Ateliers</h3>
                    <p>
                        Participez à nos ateliers de création florale en ligne et en personne pour apprendre l'art
                        d'arranger des fleurs.
                        Inscrivez-vous bientôt pour réserver votre place !
                    </p>
                </div>
            </div>
        </section>

        <section class="about future-update">
            <div class="image">
                <img src="uploaded_img/future4.jpg" alt="">
                <div class="content">
                    <h3>Événements</h3>
                    <p>
                        Découvrez nos événements floraux exclusifs, y compris des ventes privées, des lancements de
                        collections et des collaborations spéciales.
                        Restez informé pour ne rien manquer !
                    </p>
                </div>
            </div>
        </section>
    </div>

    <style>
    .future-updates-grid {
        background: linear-gradient(135deg, #ff9a9e, #fad0c4);
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        margin-bottom: 2rem;
        animation: moveImage 4s infinite alternate ease-in-out;
        cursor: default;
    }

    .future-update .image {
        position: relative;
        height: 400px;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(210, 81, 145, 0.1);
        padding: 10px;
        /* Animation: images move slowly left and right */
        object-fit: cover;
        width: 100%;
        display: block;
        transition: transform 0.4s ease, box-shadow 0.4s ease;

        /* سلاسة */
    }

    .future-update .image img:hover {
        transform: scale(1.05) rotate(1deg);
        /* تكبير بسيط + دوران خفييف */
        box-shadow: 0 6px 20px rgba(210, 81, 145, 0.25);
        /* ظل أقوى */
    }

    .future-update .image img {
        width: 100%;
        height: 100%;
        filter: brightness(70%);
        /* نخلي الصورة غامقة باش النص يبان */
        border-radius: 15px;
        transition: transform 0.3s ease;
        object-fit: cover;
        /* تغطية كاملة */
        object-position: center;
        display: block;
        margin: 0 auto;
        /* سلاسة */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        /* ظل خفيف */
        animation: moveImage 4s infinite alternate ease-in-out;
        cursor: default;



    }

    /* النص فوق الصورة */
    .future-update .content {

        position: absolute;
        bottom: 0;

        left: 0;
        right: 0;
        padding: 1.5rem;
        color: #fff;
        z-index: 2;
    }

    .future-update .content h3 {
        font-size: 2rem;

        margin-bottom: 0.5rem;
        color: #fff;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
    }

    .future-update .content p {
        font-size: 1.6em;

        margin-bottom: 1rem;
        color: #f1f1f1;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);

    }

    /* الزر */
    .future-update .btn {

        color: #000000ff;
        border-radius: 25px;
        padding: 6px 18px;
        font-size: 1rem;
        box-shadow: 0 2px 8px rgba(210, 81, 145, 0.2);
    }

    .future-update .btn:hover {
        background: #ff69b4;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .future-updates-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
    </style>




    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>
</body>

</html>