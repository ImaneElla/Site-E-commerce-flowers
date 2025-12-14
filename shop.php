<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_wishlist_numbers) > 0){
        $message[] = 'Produit déjà dans wishlist ❤️';
    }elseif(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'Produit déjà dans le panier 🛒';
    }else{
        mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'Produit ajouté au wishlist ✔️';
    }

}

if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'Produit déjà dans le panier 🛒';
    } else {
        // Supprimer de la wishlist si déjà là
        mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = '$product_id' AND user_id = '$user_id'");

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) 
            VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')");
        $message[] = 'Produit ajouté au panier ✔️';
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
    <title>Boutique</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
    .heading {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        background: linear-gradient(135deg, #fc8ccaff, #ffb6b9);
        ;
        /* تدرج خلفية */
        text-align: center;
        min-height: 25vh;
        position: relative;
        overflow: hidden;
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

    .heading p a {
        color: var(--pink);
        font-weight: 500;
        position: relative;
        text-decoration: none;

    }

    .heading p a {
        color: var(--pink);
        font-weight: 500;
        position: relative;
        text-decoration: none;
        transition: color 0.3s;
    }

    .heading p a::after {
        content: "";
        position: absolute;
        width: 0;
        height: 0.2rem;
        bottom: -0.2rem;
        left: 0;
        background-color: var(--pink);
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 2px;
    }

    .heading p a:hover {
        color: #fff;
    }

    .heading p a:hover::after {
        width: 0%;
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
        padding: 8px 18px;

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
        background: linear-gradient(135deg, #fc8ccaff, #ffb6b9);
        color: #fff;
        border: 2px solid #fff;


    }
    </style>
</head>

<body>
    <?php 
    @include 'header.php';
    ?>

    <section class="heading">

        <h3>Notre Boutique</h3>
        <p><a href="home.php">Accueil </a>/ Boutique </p>

    </section>
    <section class="products">
        <h1 class="title">Produits Populaires</h1>
        <div class="box-container"><?php $select_products=mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');

    if(mysqli_num_rows($select_products) > 0) {
        while($fetch_products=mysqli_fetch_assoc($select_products)) {
            ?><form action="" method="POST" class="box"><a
                    href="view_page.php?pid=<?php echo $fetch_products['id']; ?>" class="fas fa-eye"></a>
                <div class="price"><?php echo $fetch_products['price'];
            ?> Dh</div><img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                <div class="name"><?php echo $fetch_products['name'];
            ?></div><input type="number" name="product_quantity" value="1" min="0" class="qty"><input type="hidden"
                    name="product_id" value="<?php echo $fetch_products['id']; ?>"><input type="hidden"
                    name="product_name" value="<?php echo $fetch_products['name']; ?>"><input type="hidden"
                    name="product_price" value="<?php echo $fetch_products['price']; ?>"><input type="hidden"
                    name="product_image" value="<?php echo $fetch_products['image']; ?>"><input type="submit" value="❤️"
                    name="add_to_wishlist" class="option-btn"><input type="submit" value="Ajouter au panier"
                    name="add_to_cart" class="btn">
            </form><?php
        }
    }

    else {
        echo '<p class="empty">no products added yet!</p>';
    }

    ?></div>
    </section><?php @include 'footer.php';
    ?><script src="js/script.js"></script>
</body>

</html>