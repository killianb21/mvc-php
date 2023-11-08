<?php

require_once('src/lib/database.php');

class Post
{
    public $title;
    public $frenchCreationDate;
    public $content;
    public $identifier;
}

class PostRepository
{
    public $database = null;

    public function getPost(string $identifier): Post
    {
        $statement = $this->connection->getConnection()->prepare(
             "SELECT id, title, content, DATE_FORMAT(creation_date,
             '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts
             WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $post = new Post();
        $post->title = $row['title'];
        $post->frenchCreationDate = $row['french_creation_date'];
        $post->content = $row['content'];
        $post->identifier = $row['id'];

        return $post;
    }

    public function getPosts(): array
    {
        $statement = $this->connection->getConnection()->query(
             "SELECT id, title, content, DATE_FORMAT(creation_date,
             '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts
             ORDER BY creation_date DESC LIMIT 0, 5"
        );
        $posts = [];
        while (($row = $statement->fetch())) {
            $post = new Post();
            $post->title = $row['title'];
            $post->frenchCreationDate = $row['french_creation_date'];
            $post->content = $row['content'];
            $post->identifier = $row['id'];

            $posts[] = $post;
        }

        return $posts;
    }
}
