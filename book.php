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
$book = new Book();

$bookData = $book->getBook($id);

$authorsData = $book->getSelectedAuthors($id);


$ui = new UiPageEditBook( new UiLayout() );

$ui->addingAuthors($authorsData);

$ui->addingBook($bookData);

$ui->render();