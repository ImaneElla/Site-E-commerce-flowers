<?php

include 'config.php';

// لا حاجة لجلسة أو تسجيل دخول
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Visitor</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
    /* Basic reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f5f6fa;
        color: #2f3640;
        line-height: 1.6;
    }

    .header .flex .account-box {
        position: absolute;
        top: 120%;
        right: 2rem;
        background-color: var(--white);
        border: var(--border);
        text-align: center;
        box-shadow: var(--box-shadow);
        padding: 2rem;
        border-radius: 0.5rem;
        width: 33rem;
        display: none;
        animation: fadeIn 0.2s linear;
    }

    .header .flex .account-box.active {
        display: block;
    }

    .header .flex .account-box p {
        padding-bottom: 1rem;
        font-size: 2rem;
        color: var(--light-color);
        line-height: 1.5;
    }

    .header .flex .account-box p span {
        color: var(--pink);
    }

    .header .flex .account-box .delete-btn {
        margin-top: 0.5rem;
    }

    .home {
        min-height: 60vh;
        background: url(../images/home-bg.png) no-repeat;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }


    .visitor-content {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .box-container {
        display: flex;
        gap: 30px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .box {
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 300px;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .box:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .box h3 {
        font-size: 22px;
        color: #2f3640;
        margin-bottom: 15px;
    }

    .box p {
        font-size: 16px;
        color: #718093;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #d441a0ff;
        color: #fff;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.3s;
    }

    .btn:hover {
        background-color: #c23616;
        transform: scale(1.05);
    }

    form {
        max-width: 500px;
        margin: 20px auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    form input[type="text"],
    form input[type="email"],
    form input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    form input[type="text"]:focus,
    form input[type="email"]:focus,
    form input[type="password"]:focus {
        border-color: #9c88ff;
        box-shadow: 0 0 5px rgba(156, 136, 255, 0.5);
        outline: none;
    }

    form input[type="submit"]:hover,
    form a:hover {
        opacity: 0.9;
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
    }

    p {
        text-align: center;
        color: red;
        font-weight: bold;
        margin-top: 10px;
        margin-bottom: 10px;
    }

    img {
        display: block;
        margin: 10px auto;
        border-radius: 10px;
        border: 1px solid #ccc;
        padding: 5px;
        background-color: #fff;
    }

    /* dashboard styles */
    .dashboard {
        max-width: 1200px;
        margin: 40px auto;
        padding: 20px;
    }
    </style>
</head>

<body>
    <?php include  'header.php'; ?>

    <section class="heading">
        <h3>Welcome Visitor!</h3>
        <p><a href="home.php">Home</a> / Visitor</p>
    </section>

    <section class="visitor-content">
        <div class="box-container">
            <div class="box">
                <h3>Our Products</h3>
                <p>Here you can browse all our amazing products without login!</p>
                <button class="btn">Explore Now</button>
            </div>
            <div class="box">
                <h3>About Us</h3>
                <p>Learn more about our store and offerings as a visitor.</p>
                <button class="btn">Learn More</button>
            </div>
        </div>
    </section>
    <?php @
include 'footer.php'; ?>

    <script>
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.transform = 'scale(1.05)';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'scale(1)';
        });
    });

    // إضافة تأثير التمرير الناعم للروابط
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', e => {
            if (link.hash !== '') {
                e.preventDefault();
                const hash = link.hash;
                document.querySelector(hash).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    </script>
</body>

</html>