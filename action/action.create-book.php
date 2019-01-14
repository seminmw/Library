<?php

require_once __DIR__ . '/../init.php';

$db = util_init_db();
$ui = new UiPageError( new UiLayout() );

$book = util_request_post_string('book');
$newAuthor = util_request_post_string('author');
$authorsIds = util_request_post('authors');
$checkBoxSwitch = util_request_post('addedAuthors');


// checking empty fields
if (empty($book) || empty($checkBoxSwitch) || empty($newAuthor) && empty($authorsIds)) {

    if (empty($book)) {
        $ui->addError("Book is empty");
    }

    if (empty($checkBoxSwitch)) {
        $ui->addError("Checkbox is empty");
    }

    if (empty($newAuthor)) {
        $ui->addError("Author is empty");
    }

    if (empty($authorsIds)) {
        $ui->addError("Authors is empty");
    }

    $ui->render();
    exit;
}

try {
    if (!in_array($checkBoxSwitch, ['new', 'selected'])) {
        $ui->addError('Checkbox is not selected');
        $ui->render();
    }

    $authorsIds = (empty($authorsIds) || $checkBoxSwitch === "new") ? [] : $authorsIds;

    $bookObj = new Book();

    $bookId = $bookObj->create($book);
    // create book
    if ($checkBoxSwitch === "new") {

        if (!empty($newAuthor)) {
            $authors = explode(',', $newAuthor);
            $authorObj = new Author();

            foreach($authors as $author) {
                $authorsIds[] = $authorObj->create(trim($author));
            }
        }
    }

    // create many to many
    foreach ($authorsIds as $authorId) {
        BooksAuthors::create($bookId, $authorId);
    }

    header("Location:/books.php?action=create");

} catch (Exception $e) {
    $ui->addError('Failed to create a book');
    $ui->render();
}