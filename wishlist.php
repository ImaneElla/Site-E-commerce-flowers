<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'Produit déjà ajouté au panier';
    }else{

        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_wishlist_numbers) > 0){
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
        }

        mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'Produit ajouté au panier';
    }

}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$delete_id'") or die('query failed');
    header('location:wishlist.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
    header('location:wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="uploaded_img/favicon.ico">
    <title>Ma Liste de Souhaits</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php @include 'header.php'; ?>

    <section class="heading">
        <h3>Ma Liste de Souhaits</h3>
        <p> <a href="home.php">Accueil</a> / Liste de souhaits </p>
    </section>

    <section class="wishlist">

        <h1 class="title">Produits ajoutés</h1>

        <div class="box-container">

            <?php
        $grand_total = 0;
        $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_wishlist) > 0){
            while($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)){
    ?>
            <form action="" method="POST" class="box">
                <a href="wishlist.php?delete=<?php echo $fetch_wishlist['id']; ?>" class="fas fa-times"
                    onclick="return confirm('Supprimer ce produit de la liste de souhaits ?');"></a>
                <a href="view_page.php?pid=<?php echo $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
                <img src="uploaded_img/<?php echo $fetch_wishlist['image']; ?>" alt="" class="image">
                <div class="name"><?php echo $fetch_wishlist['name']; ?></div>
                <div class="price"><?php echo $fetch_wishlist['price']; ?> Dh</div>
                <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['pid']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">
                <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">

            </form>
            <?php
    $grand_total += $fetch_wishlist['price'];
        }
    }else{
        echo '<p class="empty">Votre liste de souhaits est vide</p>';
    }
    ?>
        </div>

        <div class="wishlist-total">
            <p>Total général : <span><?php echo $grand_total; ?> Dh</span></p>
            <a href="shop.php" class="option-btn">Continuer vos achats</a>
            <a href="wishlist.php?delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled' ?>"
                onclick="return confirm('Supprimer tous les produits de la liste de souhaits ?');">Tout supprimer</a>
        </div>

    </section>
    <style>
    .wishlist-total .option-btn {
        background-color: #0077ff79;
        /* اللون الأساسي */
        color: #fff;
        /* لون النص */
        border-radius: 25px;
        padding: 10px 20px;
        text-decoration: none;
        transition: all 0.3s ease;
        /* انتقال سلس للتأثير */
    }

    .wishlist-total .option-btn:hover {
        background-color: #0077ffba;
        /* لون أغمق عند hover */
        box-shadow: 0 4px 15px rgba(0, 119, 255, 0.4);
        /* ظل لطيف */
        transform: scale(1.05);
        /* يكبر قليلاً */
    }

    .wishlist-total .delete-btn {
        background-color: #ff000079;
        /* نفس اللون الأساسي */
        color: #fff;
        border-radius: 25px;
        padding: 10px 20px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .wishlist-total .delete-btn:hover {
        background-color: #ff4c4c;
        /* أحمر عند hover */
        box-shadow: 0 4px 15px rgba(255, 76, 76, 0.4);
        transform: scale(1.05);
    }
    </style>

    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>