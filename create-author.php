<?php
require_once 'init.php';

$db = util_init_db();

$book = new Book();
$book = $book->getAll();

$ui = new UiPageCreateAuthor( new UiLayout() );

$ui->addingBooks($book);

$ui->render();