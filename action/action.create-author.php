<?php

require_once __DIR__ . '/../init.php';

$db = util_init_db();
$ui = new UiPageError( new UiLayout() );

$author = util_request_post_string('author');
$newBook = util_request_post_string('book');
$booksIds = util_request_post('books');
$checkBoxSwitch = util_request_post('addedBooks');

// checking empty fields
if (empty($author) || empty($checkBoxSwitch) || empty($newBook) && empty($booksIds)) {

    if (empty($author)) {
        $ui->addError("Author is empty");
    }

    if (empty($checkBoxSwitch)) {
        $ui->addError("Checkbox is empty");
    }

    if (empty($newBook)) {
        $ui->addError("Book is empty");
    }

    if (empty($booksIds)) {
        $ui->addError("Books is empty");
    }

    $ui->render();
    exit;
}

try {
    if (!in_array($checkBoxSwitch, ['new', 'selected'])) {
        $ui->addError('Checkbox is not selected');
        $ui->render();
    }

    $booksIds = (empty($booksIds) || $checkBoxSwitch === "new") ? [] : $booksIds;

    // create author
    $authorObj = new Author();
    $authorId = $authorObj->create($author);

    if ($checkBoxSwitch === "new") {

        if (!empty($newBook)) {
            $books = explode(',', $newBook);
            $bookObj = new Book();

            foreach($books as $book) {
                $booksIds[] = $bookObj->create(trim($book));
            }
        }
    }

    // create many to many
    foreach ($booksIds as $bookId) {
        BooksAuthors::create($bookId, $authorId);
    }

    header("Location:/authors.php?action=create");

} catch (Exception $e) {
    $ui->addError('Failed to create a task');
    $ui->render();
}