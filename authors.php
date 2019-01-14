<?php

require_once 'init.php';

$db = util_init_db();
$page = (int) util_request_get('page', 1);

$isAction = util_request_get('action');

if ($page <= 0) {
    $page = 1;
}

$author = new Author();
$author->setPage($page);
$authors = $author->getItemsPerPage();
$resultsCount = $author->getResultsCount();


$url = 'authors.php?';
$pagination = pagination($resultsCount, $author->getPage(), $author->getPerPage(), $url);

$ui = new UiPageAuthor( new UiLayout() );

if(!empty($isAction)) {
    $ui->addAlert($isAction);
}

$ui->createTable($authors);
$ui->createPagination($pagination);

$ui->render();

