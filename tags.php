<?php
require_once ("database.php");

class Tags extends Databases
{
    public function resultset()
    {
        $posts = parent::resultset();


        if (is_array($posts) && count($posts)) {
            foreach ($posts as &$post) {
                $tags = [];
                $sql = 'SELECT t. name FROM blog_post_tags bpt LEFT JOIN tags t ON bpt.tag_id=t.id WHERE bpt.blog_post_is = :blogid';

                parent::query($sql);
                parent::bind(':blodid', $post['id']);
                $blogTags = parent::resultset();

                foreach ($blogTags as $btag) {
                    array_push($tags, $btag['name']);
                }
                $post['tags'] = implode(',', $tags);
            }
            return $posts;
        }else{
                return [];
            }
        }


    }
