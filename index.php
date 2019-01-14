<?php
require_once 'init.php';

$conn = util_init_db();

$ui = new UiHomePage( new UiLayout() );

$book = new Book();
$amountBook = $book->getResultsCount();

$author = new Author();
$amountAuthor = $author->getResultsCount();


$ui->addAmountAuthorsAndBooks($amountBook, $amountAuthor);
$ui->render();