<?php
require_once __DIR__ . '/../init.php';

$error = new UiPageError(new UiLayout);

//getting id of the data from url
$id = (int) util_request_get('id');

if (empty($id)) {
    $error->addError('Empty data');
    $error->render();
    exit;
}

$db = util_init_db();

$book = new Book();
$book->delete($id);

//redirecting to the display page (books.php in our case)
header("Location:/books.php?action=delete");