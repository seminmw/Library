<?php
require_once __DIR__ . '/../init.php';

$error = new UiPageError(new UiLayout());

//getting id of the data from url
$id = (int) util_request_get('id');

if (empty($id)) {
    $error->addError('Empty data');
    $error->render();
    exit;
}

$db = util_init_db();

$author = new Author();
$author->delete($id);

//redirecting to the display page (authors.php in our case)
header("Location:/authors.php?action=delete");