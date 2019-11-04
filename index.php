<!--
 * 
 * Script: index.php
 * Blog Home Page - Displays recent blogs to all users and
 * allows authenticated users to make modifications
 * Author: Kanisha Patel
 * Version: 1.0
 * Date Created: 27.09.2018
 * Last Updated: 27.09.2018
 *
 * -->

<?php

require ('connect.php');

$select_query = 'SELECT id, title, blog, blogDateTime FROM blogs ORDER BY blogDateTime DESC limit 5';

$statement = $db->prepare($select_query);
$statement->execute();

$blogs = [];

$blogs = $statement->fetchAll();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Stung Eye - Index</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - Index</a></h1>
        </div> <!-- END div id="header" -->

        <ul id="menu">
            <li><a href="index.php" class='active'>Home</a></li>
            <li><a href="create.php" >New Post</a></li>
        </ul> <!-- END div id="menu" -->

        <div id="all_blogs">
            <div class="blog_post">
                <?php foreach ($blogs as $blog): ?> 

                    <!-- Display title -->
                    <h2> <a href="show.php?id=<?= $blog['id'] ?>">
                        <?= $blog['title'] ?></a>
                    </h2>

                    <!-- Display date & time-->
                    <p>
                    <small>

                        <?php $date=date_create($blog['blogDateTime']) ?>
                        <?= date_format($date,"F d, Y, h:m a") ?>
                       
                        <a href="edit.php?id=<?= $blog['id'] ?>">edit</a>
                    </small>
                    </p>

                    <!-- Display Blog conten t-->
                    <div class='blog_content'>

                      <?php if (strlen($blog['blog']) > 200) :?>

                        <?= substr( $blog['blog'], 0, 200) ?>
                        <a href="show.php?id=<?= $blog['id'] ?>">Read Full Post</a>

                      <?php else :?>
                          <?= $blog['blog'] ?>
                      <?php endif ?>
                    </div>
                   
                    <?php endforeach ?>
            </div>
        </div>

        <div id="footer">
            Copywrong 2018 - No Rights Reserved
        </div> <!-- END div id="footer" -->

        </div> <!-- END div id="wrapper" -->
    </body>
</html>
