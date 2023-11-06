<?php

class Post
{
    public $title;
    public $frenchCreationDate;
    public $content;
    public $identifier;
}

function getPosts() {
    $database = dbConnect();
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
    $database = dbConnect();
    $statement = $database->prepare(
        "SELECT id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS french_creation_date FROM posts WHERE id = ?"
    );
    $statement->execute([$identifier]);

    $row = $statement->fetch();
    $post = [
        'title' => $row['title'],
        'french_creation_date' => $row['french_creation_date'],
        'content' => $row['content'],
        'identifier' => $row['id'],
    ];

    return $post;
}