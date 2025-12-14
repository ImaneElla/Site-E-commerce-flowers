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
/* body style */

body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: #f5f6fa;
    color: #2f3640;
    line-height: 1.6;
}

/* header style */
.header {
    background: #fff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.header .flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin: auto;
    padding: 15px 20px;
}

.header .logo {
    font-size: 24px;
    font-weight: 700;
    color: #2f3640;
    text-decoration: none;
}

.header .navbar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
}

.header .navbar a {
    margin: 0 10px;
    text-decoration: none;
    color: #2f3640;
    font-weight: 500;
    transition: color 0.5s;
}

.header .navbar a:hover {
    color: #ffffffff;
    background-color: #d441a0ff;
    border-radius: 50px;
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 3px;
    padding-bottom: 3px;
    text-decoration: none;
}

@media (max-width: 768px) {
    .header .navbar {
        display: none;
    }

    .header .icons #menu-btn {
        display: block;
    }
}

@media (min-width: 769px) {
    .header .icons #menu-btn {
        display: none;
    }
}
</style>
<link rel="icon" type="image/x-icon" href="uploaded_img\favicon.ico">
<header class="header">

    <div class="flex">

        <a href="admin_page.php" class="logo">Panneau<span>Admin</span></a>

        <nav class="navbar">
            <a href="admin_page.php">Accueil</a>
            <a href="admin_products.php">Produits</a>
            <a href="admin_orders.php">Commandes</a>
            <a href="admin_users.php">Utilisateurs</a>
            <a href="admin_contacts.php">Messages</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <p>Nom d’utilisateur : <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>Email : <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">Se déconnecter</a>
        </div>

    </div>

</header>