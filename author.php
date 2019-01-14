<?php

require_once 'init.php';

$db = util_init_db();

$id = util_request_get('id', false);

$error = new UiPageError(new UiLayout());

if(!$id) {
    $error->addError('Empty data');
    $error->render();
    exit;
}

$author = new Author();

$authorData = $author->getAuthor($id);

$booksData = $author->getSelectedBooks($id);

$ui = new UiPageEditAuthor( new UiLayout() );

$ui->addingBooks($booksData);

$ui->addingAuthor($authorData);

$ui->render();