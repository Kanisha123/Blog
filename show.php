<!--
 * 
 * Script: show.php
 * Displays a full content of the blog.
 * Author: Kanisha Patel
 * Version: 1.0
 * Date Created: 27.09.2018
 * Last Updated: 27.09.2018
 *
 * -->

<?php

require ('connect.php');

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$select_query = 'SELECT id, title, blog, blogDateTime FROM blogs WHERE id = :id';

$statement = $db->prepare($select_query);
$statement->bindValue(':id', $id, PDO::PARAM_INT);
$statement->execute();

$singleblog = [];

$singleblog = $statement->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Stung Eye - <?= $singleblog['title'] ?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - <?= $singleblog['title'] ?></a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create.php" >New Post</a></li>
</ul> <!-- END div id="menu" -->
  <div id="all_blogs">
    <div class="blog_post">

      <h2>
     		<?= $singleblog['title'] ?>
  	  </h2>
      <p>
        <small>

          <?php $date=date_create($singleblog['blogDateTime']) ?>
          <?= date_format($date,"F d, Y, h:m a") ?>		
          <a href="edit.php?id=<?= $singleblog['id'] ?>">edit</a>
        </small>
      </p>
      <div class='blog_content'>
      		<?= $singleblog['blog'] ?>
      </div>
    </div>
  </div>
        <div id="footer">
            Copywrong 2018 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
