<?php

class BlogPost
{

    public $id;
    public $title;
    public $post;
    public $author;
    public $tags;
    public $datePosted;

    function __construct($inId=null, $inTitle=null, $inPost=null, $inAuthorId=null, $inDatePosted=null)
    {

        $database = new Databases();

        if (!empty($inId))
        {
            $this->id = $inId;
        }
        if (!empty($inTitle))
        {
            $this->title = $inTitle;
        }
        if (!empty($inPost))
        {
            $this->post = $inPost;
        }

        if (!empty($inDatePosted))
        {
            $this->datePosted = $inDatePosted;
        }

        //if (!empty($inAuthorId))
        //{
            $database->query("SELECT first_name, last_name FROM people WHERE id = :id");
            $database->bind(":id", $inAuthorId);
            $rows = $database->resultSet();
            foreach($rows as $row) {
                $this->author = $row["first_name"] . " " . $row["last_name"];
            }

        //}

        $postTags = "No Tags";
        if (!empty($inId))
        {
            $database->query("SELECT tags.* FROM blog_post_tags LEFT JOIN (tags) ON (blog_post_tags.tag_id = tags.id) WHERE blog_post_tags.blog_post_id = " . $inId);
            $tagArray = array();
            $tagIDArray = array();
            while($row = $database->resultSet())
            {
                array_push($tagArray, $row["name"]);
                array_push($tagIDArray, $row["id"]);
            }
            if (sizeof($tagArray) > 0)
            {
                foreach ($tagArray as $tag)
                {
                    if ($postTags == "No Tags")
                    {
                        $postTags = $tag;
                    }
                    else
                    {
                        $postTags = $postTags . ", " . $tag;
                    }
                }
            }
        }
        $this->tags = $postTags;
    }

}

?>