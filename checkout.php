<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'flat no. '. $_POST['flat'].', '. $_POST['street'].', '. $_POST['city'].', '. $_POST['country'].' - '. $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if($cart_total == 0){
        $message[] = 'your cart is empty!';
    }elseif(mysqli_num_rows($order_query) > 0){
        $message[] = 'order placed already!';
    }else{
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'order placed successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/x-icon" href="uploaded_img\favicon.ico">
    <style>
    .checkout {
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        gap: 2rem;
        text-align: center;
        margin: 0;
        box-sizing: border-box;
        width: 100%;
        height: auto;
        border: 2px transparent #0000003e;
        margin: auto;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(233, 30, 135, 0.12);
        /* ظل خفيف */
    }

    .checkout form {
        background-color: #f9f9f9;
        padding: 2rem;
        border-radius: 10px;
        border: #0000003e 2px solid;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .checkout form h3 {
        font-size: 2.5rem;
        color: #333;
        background-color: #f9f9f9;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        padding: 10px;
        border-radius: 8px;
        /* ظل خفيف */
        /* حدود وردية */
        text-align: center;
        font-weight: bold;
        letter-spacing: 1px;
        font-family: 'Arial', sans-serif;
        /* خط واضح */
        transition: background-color 0.3s, color 0.3s;

    }

    .checkout form .flex {
        display: flex;
        border: none;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1rem;
        justify-content: space-between;
        align-items: center;
        text-align: left;
        box-sizing: border-box;
    }

    .checkout form .flex .inputBox {
        flex: 1 1 200px;
        display: flex;
        flex-direction: column;
        text-align: left;
        gap: 0.5rem;
        font-size: 1.4rem;
        font-weight: 500;
        color: #333;
        font-family: 'Arial', sans-serif;
        /* خط واضح */
        box-sizing: border-box;
        margin-bottom: 10px;
        padding: 0 5px;
        transition: transform 0.3s ease;

    }

    .checkout form .flex .inputBox:hover {
        transform: scale(1.05);
        color: #0000003e;
    }

    .checkout form .flex .inputBox span {
        margin-bottom: 0.5rem;
        color: #555;
        font-family: 'Arial', sans-serif;
        /* خط واضح */
    }

    .checkout form .flex .inputBox input,
    .checkout form .flex .inputBox select {
        width: 100%;
        padding: 0.8rem 1rem;
        font-size: 1.4rem;
        border: 1px solid #cccccc78;
        border-radius: 5px;
        outline: none;
        font-family: 'Arial', sans-serif;
        /* خط واضح */
        transition: border-color 0.3s, box-shadow 0.3s;
        box-shadow: 0 2px 5px rgba(149, 6, 111, 0.18);
    }

    .checkout form .flex .inputBox input:focus,
    .checkout form .flex .inputBox select:focus {
        border-color: #ff6f91;
        box-shadow: 0 0 5px rgba(255, 111, 145, 0.5);
    }

    .checkout form .btn {
        width: 50%;
        padding: 1rem;
        font-size: 1.6rem;
        color: #333;
        background-color: #ffb6b9;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        transition: background 0.3s, transform 0.3s, box-shadow 0.3s;
        box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
        font-family: 'Arial', sans-serif;
        /* خط واضح */
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-top: 10px;
        box-sizing: border-box;
        /* حدود وردية */
        text-align: center;

    }

    .checkout form .btn:hover {
        background: linear-gradient(135deg, #ff6f91, #ff9a9e);
        color: #fff;
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
    }

    .grand-total {
        margin: 4rem;
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        font-family: 'Arial', sans-serif;
        /* خط واضح */
        padding: 10px;
        border-radius: 8px;
        background-color: #f9f9f9;
        border: 2px solid #00000027;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);

    }

    .grand-total span {
        color: #ff6f91;
        font-size: 2.5rem;
        font-weight: bold;
        font-family: 'Arial', sans-serif;
        /* خط واضح */
        letter-spacing: 1px;

    }
    </style>


</head>

<body>

    <?php @include 'header.php'; ?>

    <section class="heading">
        <h3>checkout order</h3>
        <p> <a href="home.php">home</a> / checkout </p>
    </section>

    <section class="display-order">
        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>
        <p> <?php echo $fetch_cart['name'] ?>
            <span>(<?php echo '$'.$fetch_cart['price'].'/-'.' x '.$fetch_cart['quantity']  ?>)</span>
        </p>
        <?php
        }
        }else{
            echo '<p class="empty">your cart is empty</p>';
        }
    ?>

    </section>

    <section class="checkout">

        <form action="" method="POST">

            <h3>Passer votre commande</h3>

            <div class="flex">
                <div class="inputBox">
                    <span>Nom complet :</span>
                    <input type="text" name="name" placeholder="Entrez votre nom">
                </div>
                <div class="inputBox">
                    <span>Numéro de téléphone :</span>
                    <input type="number" name="number" min="0" placeholder="Entrez votre numéro">
                </div>
                <div class="inputBox">
                    <span>Email :</span>
                    <input type="email" name="email" placeholder="Entrez votre email">
                </div>
                <div class="inputBox">
                    <span>Méthode de paiement :</span>
                    <select name="method">
                        <option value="cash on delivery">Paiement à la livraison</option>
                        <option value="credit card">Carte bancaire</option>
                        <option value="paypal">PayPal</option>
                        <option value="paytm">Paytm</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Adresse ligne 01 :</span>
                    <input type="text" name="flat" placeholder="Ex : Appartement n°">
                </div>
                <div class="inputBox">
                    <span>Adresse ligne 02 :</span>
                    <input type="text" name="street" placeholder="Ex : Rue">
                </div>
                <div class="inputBox">
                    <span>Ville :</span>
                    <input type="text" name="city" placeholder="Ex : Casablanca">
                </div>
                <div class="inputBox">
                    <span>Région :</span>
                    <input type="text" name="state" placeholder="Ex : Grand Casablanca">
                </div>
                <div class="inputBox">
                    <span>Pays :</span>
                    <input type="text" name="country" placeholder="Ex : Maroc">
                </div>
                <div class="inputBox">
                    <span>Code postal :</span>
                    <input type="number" min="0" name="pin_code" placeholder="Ex : 20000">
                </div>
            </div>

            <input type="submit" name="order" value="Valider la commande" class="btn">

        </form>

    </section>


    <div class="grand-total" style="margin: 20PX;">Total : <span><?php echo $grand_total; ?> Dh</span></div>



    <?php @include 'footer.php'; ?>

    <script src="js/script.js"></script>

</body>

</html>