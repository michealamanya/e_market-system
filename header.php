<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'E-Market'; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #1ef145;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #77aaff 3px solid;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header li {
            float: left;
            display: inline;
            padding: 0 20px 0 20px;
        }
        header li.active a {
            font-weight: bold;
        }
        nav ul {
            overflow: auto;
        }
        nav ul li:hover a {
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>E-Market</h1>
            <nav>
                <ul>
                    <li class="<?php if($page == 'home') echo 'active'; ?>"><a href="home.php">Home</a></li>
                    <li class="<?php if($page == 'products') echo 'active'; ?>"><a href="products.php">Products</a></li>
                    <li class="<?php if($page == 'contact') echo 'active'; ?>"><a href="contact.php">Contact</a></li>
                    <li class="<?php if($page == 'faq') echo 'active'; ?>"><a href="faq.php">FAQ</a></li>
                </ul>
            </nav>
        </div>
    </header>
