<?php
require_once 'init.php';

$db = util_init_db();


$author = new Author();
$authors = $author->getAllRows();

$ui = new UiPageCreateBook( new UiLayout() );

$ui->addingAuthors($authors);

$ui->render();