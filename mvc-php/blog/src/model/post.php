<?php

class Post
{
    public $title;
    public $frenchCreationDate;
    public $content;
    public $identifier;
}

class PostRepository
{
    public ?PDO $database = null;

    function getPosts() {
        $postRepository = new PostRepository;
        dbConnect($postRepository);
        $database = $postRepository->database;
        $statement = $database->query(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts ORDER BY creation_date DESC LIMIT 0, 5"
        );
        $posts = [];
        while (($row = $statement->fetch())) {
            
            $post = new Post();
            $post->frenchCreationDate = $row['french_creation_date'];
            $post->title = $row['title'];
            $post->content = $row['content'];
            $post->identifier = $row['id'];

            $posts[] = $post;
        }

        return $posts;
    }

    function getPost($identifier) {
        $postRepository = new PostRepository;
        dbConnect($postRepository)
        $database = $postRepository->database;
        $statement = $database->prepare(
            "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
        );
        $statement->execute([$identifier]);

        $row = $statement->fetch();
        $post = new Post();
            $post->frenchCreationDate = $row['french_creation_date'];
            $post->title = $row['title'];
            $post->content = $row['content'];
            $post->identifier = $row['id'];

        return $post;
    }
}
function dbConnect(PostRepository $repository)
{
    if ($repository->database === null) {
        $repository->database = new PDO('mysql:host=localhost;
        dbname=blog;charset=utf8', 'blog', 'password');
    }
}