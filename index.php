<?php
require "database.php";
require "tags.php";
$database = new Databases;

$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

if(@$_POST['delete']){
    $delete_id = $_POST['delete_id'];
    $database->query('DELETE FROM blog_posts WHERE id = :id');
    $database->bind(':id', $delete_id);
    $database->execute();
}

if(@$post['submit']){
    $title = $post['title'];
    $post=$post['post'];

    $database->query('INSERT INTO blog_posts (title, post) VALUES(:title, :post)');
    $database->bind(':title', $title);
    $database->bind(':post', $post);
    $database->execute();
    if($database->lastInsertId()){
        echo '<p>Post Added!</p>';
    }
}

$database->query('SELECT * FROM blog_posts');
$rows = $database->resultset();



?>

<!DOCTYPE html>

<html>
<head>

    <title>My Blog</title>
    <link rel="stylesheet" href="style.css">
    <link href = "bootstrap/css/bootstrap.min.css" rel = "stylesheet">
    <link href = "bootstrap/css/bootstrap-theme.min.css" rel = "stylesheet">
</head>

<body>
<div id="form">
<h1 style="text-decoration: underline; margin-left: 70px">Add Post</h1>

<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">

    <div class="form-group">
        <label >Post Title</label>
        <input type="text" class="form-control" name="title"  placeholder="Enter Post Title">
    </div>
    <div class="form-group">
        <label>Post Body</label>
        <textarea name="post" class="form-control" placeholder="Post Body"></textarea>
    </div>
    <input type="submit" name="submit" value="Submit" />
</form>
</div>


<h1 id="header">My Blog</h1>

<div id="main">
    <div id="blogPosts">
        <?php
        include ("include.php");

        $blogPosts = GetBlogPosts();

        foreach ($blogPosts as $post) {
            echo "<div class='post'>";
            echo "<h2>" . $post->title . "</h2>";
            echo "<p>" . $post->post . "</p>";
            echo "<span class='footer'>Posted By: " . $post->author . " Posted On: " . $post->datePosted . " Tags: " . $post->tags . "</span>";
            echo "</div>";
            echo "<form method='post'><input type='hidden' name='delete_id' value='". $post->id ."'> <input type='submit' name='delete' value='Delete'></form>";
        }
        ?>

    </div>
</div>

</body>

</html>