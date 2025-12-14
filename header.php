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
<style>
.navbar ul li a {
    border-radius: 50PX;

}
</style>

<header class="header">

    <div class="flex">

        <a href="home.php" class="logo">
            <img src="images/logo.png" style="
            height: 100px;
            width: 150px;
            object-fit: cover;
            margin-top: -20px;
            margin-left: -20px;
            margin-bottom: -20px;
            border-radius: 20px;
            background-color: #fff;
            padding: 10px;
            border: none;">
        </a>

        <nav class="navbar">
            <ul>
                <li><a href="home.php">Accueil</a></li>
                <li><a href="about.php">À propos</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="shop.php">Boutique</a></li>
                <li><a href="orders.php">Commandes</a></li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
                // Ensure $conn and $user_id are defined before using them
                if (isset($conn) && isset($user_id)) {
                    $select_wishlist_count = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'") or die('query failed');
                    $wishlist_num_rows = mysqli_num_rows($select_wishlist_count);
                } else {
                    $wishlist_num_rows = 0;
                }
            ?>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?php echo $wishlist_num_rows; ?>)</span></a>
            <?php
                $select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_num_rows = mysqli_num_rows($select_cart_count);
            ?>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?php echo $cart_num_rows; ?>)</span></a>
        </div>

        <div class="account-box">
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>

            <a href="logout.php" class="delete-btn">Déconnexion</a>
        </div>

    </div>

</header>