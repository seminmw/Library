<?php

class UiPageOverview extends UiPage {

  public $beginContent;

  public $table;

  public $layout;

  public $tableRow;

  public function __construct( $layout ) {
    $this->beginContent    = file_get_contents( __DIR__.'/../templates/first-content-authors.html' );
    $this->table           = file_get_contents( __DIR__.'/../templates/table.html' );
    $this->tableRow        = file_get_contents( __DIR__.'/../templates/inc-table-row.html' );
    $this->booksTable      = file_get_contents( __DIR__.'/../templates/books-table.html' );
    $this->bookTableRow    = file_get_contents( __DIR__.'/../templates/inc-book-table-row.html' );
    $this->authorsTable    = file_get_contents( __DIR__.'/../templates/authors-table.html' );
    $this->authorsTableRow = file_get_contents( __DIR__.'/../templates/inc-author-table-row.html' );
    $this->layout          = $layout;
  }

  public function generateFilterOptions($label, $items, $selected = '') {
    $count = count($items);
    $content =  $this->optionHtml("", "Все {$label} ({$count})");

    foreach ($items as $item) {
      $content .= $this->optionHtml($item, $item, $item === $selected);
    }

    return $content;
  }

  public function createAuthorFilter($authors, $selected = '') {
    $this->beginContent = $this->templateHtml($this->beginContent, [
      "authorOptions" => $this->generateFilterOptions("авторы", $authors, $selected)
    ]);
  }

  public function createStatusFilter($statuses, $selected = '') {
    $this->beginContent = $this->templateHtml($this->beginContent, [
      "statusOptions" => $this->generateFilterOptions("статусы", $statuses, $selected)
    ]);
  }

  public function createTableRow( $id, $book, $author) {
    return $this->templateText($this->tableRow, [
      "id" => $id,
      "book_title" => $book,
      "author" => $author,
    ]);
  }

  public function createTable($books) {
    $content = [];

    foreach( $books as $book ) {
      $content[] = $this->createTableRow($book['id'], $book['book_title'], $book['author']);
    }

    if (empty($content)) {
      $content[] = "<tr><td colspan='4'><div class='alert alert-info'>No results</td></tr>";
    }

    $this->table = str_replace("%rows%", implode('', $content), $this->table);
  }

  public function createPagination($pagination) {
    $this->table = str_replace("%pagination%", $pagination, $this->table);
  }

  public function render() {
    $this->layout->render($this->beginContent . $this->table);
  }
}