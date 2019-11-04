<!--
 * 
 * Script: process_post.php
 * Processes the data from previous form input
 * Update/Modify database using sanitized data
 * Displays error message if any validation fails
 * Author: Kanisha Patel
 * Version: 1.0
 * Date Created: 27.09.2018
 * Last Updated: 27.09.2018
 *
 * -->

<?php
    
$isValid = false;

// Sanitize user input to escape HTML entities and filter out dangerous characters.
$title  = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id      = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

function insert_data($title, $content)    
{
    require ('connect.php');
    
    //Build the parameterized SQL query and bind to the above sanitized values.
    $query     = "INSERT INTO blogs (title, blog, blogDateTime) values (:title, :content, now())";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);        
    $statement->bindValue(':content', $content);

    // // Execute the INSERT.
    $statement->execute();

    // // Determine the primary key of the inserted row.
     $insert_id = $db->lastInsertId();
}  


function update_data($title, $content, $id)    
{
    require ('connect.php');
    
    //Build the parameterized SQL query and bind to the above sanitized values.
    $query     = "UPDATE blogs SET title = :title, blog = :content WHERE id = :id";;
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);        
    $statement->bindValue(':content', $content);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    // // Execute the UPDATE.
    $statement->execute();
}  


function delete_data($id)    
{
    require ('connect.php');
    // Sanitize user input to escape HTML entities and filter out dangerous characters.
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    
    //Build the parameterized SQL query and bind to the above sanitized values.
    $query = "DELETE FROM blogs WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    // // Execute the INSERT.
    $statement->execute();
}  

//Check if not empty, make changes to the database
if (! empty($_POST['title']) && ! empty($_POST['content']) ) 
{
     $isValid = true;

     if ( $_POST['command'] === 'Create') {   
        insert_data($title, $content) ;
     }

    if ( $_POST['command'] === 'Update') {   
        update_data($title, $content, $id) ;
     }

     header("Location: index.php");             
} 

else {  
   $isValid = false;
};

// Delete post
if ( $_POST['command'] === 'Delete') 
{ 
        $isValid = true;   
        delete_data($id) ;
        header("Location: index.php");
     } ;
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title> Stung Eye</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="wrapper">
        <div id="header">
            <!-- <h1><a href="index.php"></a></h1> -->
        </div> <!-- END div id="header" -->

    <?php if (! $isValid) :?>

        <h1>An error occured while processing your post.</h1>
        <p> Both the title and content must be at least one character.  </p>
        <a href="index.php">Return Home</a> 
        
    <?php endif ?>

        <div id="footer">
            Copywrong 2018 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>