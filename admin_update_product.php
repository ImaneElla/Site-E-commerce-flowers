<?php
@include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if(!isset($admin_id)){
   header('location:login.php');
}

// Mise à jour du produit
if(isset($_POST['update_product'])){

   $update_p_id = $_POST['update_p_id'];
   $name = mysqli_real_escape_string($conn, htmlspecialchars($_POST['name']));
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, htmlspecialchars($_POST['details']));
   $old_image = $_POST['update_p_image'];

   // Mettre à jour les informations de base
   mysqli_query($conn, "UPDATE `products` SET name = '$name', details = '$details', price = '$price' WHERE id = '$update_p_id'") or die('Échec de la requête');

   // Gestion de l'image
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];

   if(!empty($image)){
       $image_extension = pathinfo($image, PATHINFO_EXTENSION);
       $image_new_name = uniqid().'.'.$image_extension;
       $image_folder = 'uploaded_img/'.$image_new_name;

       if($image_size > 2000000){
           $message[] = 'La taille de l\'image est trop grande !';
       } else {
           mysqli_query($conn, "UPDATE `products` SET image = '$image_new_name' WHERE id = '$update_p_id'") or die('Échec de la requête');
           move_uploaded_file($image_tmp_name, $image_folder);
           if(file_exists('uploaded_img/'.$old_image)) unlink('uploaded_img/'.$old_image);
           $message[] = 'Image mise à jour avec succès !';
       }
   }

   $message[] = 'Produit mis à jour avec succès !';
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="icon" type="image/x-icon" href="uploaded_img\favicon.ico">

    <style>
    form {
        max-width: 500px;
        margin: 30px auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    form input[type="text"],
    form input[type="number"],
    form textarea,
    form input[type="file"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    form input[type="submit"],
    form a {
        padding: 10px 20px;
        margin-top: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        color: #fff;
    }

    form input[type="submit"] {
        background-color: #28a745;
    }

    form input[type="submit"]:hover {
        background-color: #218838;
    }

    form a {
        background-color: #007bff;
    }

    form a:hover {
        background-color: #0056b3;
    }

    h2 {
        text-align: center;
        margin-top: 20px;
        color: #333;
    }

    .message {
        text-align: center;
        margin: 10px auto;
        padding: 10px;
        border-radius: 5px;
        max-width: 500px;
    }

    .message p {
        margin: 0;
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        padding: 10px;
        border-radius: 5px;
    }

    .message p.error {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
    }

    img {
        display: block;
        margin: 10px auto;
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 5px;
        background-color: #fff;
    }
    </style>
</head>

<body>

    <?php @include 'admin_header.php'; ?>

    <h2>Modifier le Produit</h2>

    <?php
if(isset($message) && is_array($message)){
   foreach($message as $msg){
      echo '<div class="message"><p>'.$msg.'</p></div>';
   }
}

$update_id = $_GET['update'];
$select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('Échec de la requête');

if(mysqli_num_rows($select_products) > 0){
   $fetch_products = mysqli_fetch_assoc($select_products);

   $image_path = 'uploaded_img/'.$fetch_products['image'];
   if(!file_exists($image_path) || empty($fetch_products['image'])){
       $image_path = 'uploaded_img/default.png'; // image par défaut
   }
?>

    <form action="" method="post" enctype="multipart/form-data">
        <img src="<?php echo $image_path; ?>" alt="Image du produit" width="150"><br><br>
        <input type="hidden" value="<?php echo $fetch_products['id']; ?>" name="update_p_id">
        <input type="hidden" value="<?php echo $fetch_products['image']; ?>" name="update_p_image"><br>

        <label>Nom du produit :</label><br>
        <input type="text" value="<?php echo $fetch_products['name']; ?>" required name="name"><br><br>

        <label>Prix du produit :</label><br>
        <input type="number" min="0" value="<?php echo $fetch_products['price']; ?>" required name="price"><br><br>

        <label>Détails du produit :</label><br>
        <textarea name="details" required cols="30"
            rows="5"><?php echo $fetch_products['details']; ?></textarea><br><br>

        <label>Changer l'image :</label><br>
        <input type="file" accept="image/jpg, image/jpeg, image/png" name="image"><br><br>

        <input type="submit" value="Mettre à jour le produit" name="update_product">
        <a href="admin_products.php">Retour</a>
    </form>

    <?php
} else{
   echo '<p class="message"><p>Aucun produit sélectionné pour modification.</p></p>';
}
?>

</body>

</html>