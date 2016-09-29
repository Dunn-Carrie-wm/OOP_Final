<?php
include 'blogpost.php';
require_once 'database.php';
$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


function GetBlogPosts($inId=null, $inTagId =null)
{
    $database = new Databases();

    if (!empty($inId))
    {
        $database->query("SELECT * FROM blog_posts WHERE id = " . $inId . " ORDER BY id ASC");
    }
    else if (!empty($inTagId))
    {
        $database->query("SELECT blog_posts.* FROM blog_post_tags LEFT JOIN (blog_posts) ON (blog_post_tags.blog_post_id = blog_posts.id) WHERE blog_post_tags.tag_id =" . $inTagId . " ORDER BY blog_posts.id DESC");
    }
    else
    {
        $database->query("SELECT * FROM blog_posts ORDER BY id ASC");
    }

    $postArray = array();
    $rows = $database->resultSet();
    foreach ($rows as $row){
        $myPost = new BlogPost($row["id"], $row['title'], $row['post'], $row["author_id"], $row['date_posted']);
        array_push($postArray, $myPost);
    }
    return $postArray;
}
?>


