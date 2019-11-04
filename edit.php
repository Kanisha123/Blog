<!--
 * 
 * Script: edit.php
 * Provides a form where the user can edit a specific post title and contents.
 * Author: Kanisha Patel
 * Version: 1.0
 * Date Created: 27.09.2018
 * Last Updated: 27.09.2018
 *
 * -->


<?php

require ('authenticate.php');
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
    <title>Stung Eye - Edit Post </title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <h1><a href="index.php">Stung Eye - Edit Post</a></h1>
        </div> <!-- END div id="header" -->
<ul id="menu">
    <li><a href="index.php" >Home</a></li>
    <li><a href="create.php" >New Post</a></li>
</ul> <!-- END div id="menu" -->
<div id="all_blogs">
  <form action="process_post.php" method="post">
    <fieldset>
      <legend>Edit Blog Post</legend>
      <p>
        <label for="title">Title</label>
        <input name="title" id="title" value="<?= $singleblog['title'] ?>" />
      </p>
      <p>
        <label for="content">Content</label>
        <textarea name="content" id="content"><?= $singleblog['blog'] ?></textarea>
      </p>
      <p>
        <input type="hidden" name="id" value="<?= $singleblog['id'] ?>" />
        <input type="submit" name="command" value="Update" />
        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
      </p>
    </fieldset>
  </form>
</div>
        <div id="footer">
            Copywrong 2018 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
