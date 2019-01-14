<?php

require_once __DIR__ . '/../init.php';

$db = util_init_db();
$ui = new UiPageError( new UiLayout() );

$bookId = (int) util_request_post('book_id');
$bookTitle = util_request_post_string('book_title');
$newAuthor = util_request_post_string('author');
$authorsIds = util_request_post('authors');
$checkBoxSwitch = util_request_post('addedAuthors');

// checking empty fields
if (empty($bookId) || empty($bookTitle) ||  empty($checkBoxSwitch)  || empty($newAuthor) && empty($authorsIds)) {

    if (empty($bookId)) {
        $ui->addError("Book is empty");
    }

    if (empty($bookTitle)) {
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

    // edit author
    $bookObj = new Book();
    $bookObj->update($bookId, $bookTitle);

    if ($checkBoxSwitch === "new") {
        if (!empty($newAuthor)) {
            $authors = explode(',', $newAuthor);
            $authorObj = new Author();

            foreach($authors as $author) {
                $authorsIds[] = $authorObj->create(trim($author));
            }
        }
    }

    // delete all books
    BooksAuthors::deleteAllBooks($bookId);
    // create many to many
    foreach ($authorsIds as $authorId) {
        BooksAuthors::create($bookId, $authorId);
    }

    header("Location:/books.php?action=create");

} catch (Exception $e) {
    $ui->addError('Failed to edit a book');
    $ui->render();
}
