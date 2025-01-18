<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : "Default Title"; ?></title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../partials-front/menustyle.css">
</head>

<body style="background-color: aliceblue">
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="http://localhost/Annapurna/index.php" title="Logo">
                    <img src="images/logo1.png" class="img-responsive" style="height: 100px">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>">Home</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Categories</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>foods.php">Foods</a>
                    </li>
                    <li>
                        <a href="../../Annapurna/contact_index.php">Contact Us</a>
                    </li>
                    
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->