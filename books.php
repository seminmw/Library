<?php
require_once 'init.php';

$db = util_init_db();
$page = (int) util_request_get('page', 1);

$isAction = util_request_get('action');

if ($page <= 0) {
    $page = 1;
}

$book = new Book();
$book->setPage($page);
$books = $book->getItemsPerPage();
$resultsCount = $book->getResultsCount();

$url = 'books.php?';
$pagination = pagination($resultsCount, $book->getPage(), $book->getPerPage(), $url);

$ui = new UiPageBook( new UiLayout() );

if(!empty($isAction)) {
    $ui->addAlert($isAction);
}

$ui->createTable($books);
$ui->createPagination($pagination);

$ui->render();