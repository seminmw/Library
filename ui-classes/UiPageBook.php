<?php
class UiPageBook extends UiPage {

    public function __construct($layout) {
        $this->beginContent    = file_get_contents( __DIR__.'/../templates/first-content-books.html' );
        $this->content = file_get_contents( __DIR__ . '/../templates/inc-author.html' );
        $this->alert = file_get_contents(__DIR__. '/../templates/alert.html');
        $this->table    = file_get_contents( __DIR__.'/../templates/books-table.html' );
        $this->tableRow = file_get_contents( __DIR__.'/../templates/inc-book-table-row.html' );
        $this->layout = $layout;
    }

    public function updateMenu($text) {
        $this->content = str_replace('%menu%', $text, $this->content);
    }

    public function createTableRow( $id, $book, $authors) {
        return $this->templateText($this->tableRow, [
          "id" => $id,
          "book" => $book,
          "authors" => $authors
        ]);
    }

    public function createTable($books) {
        $content = [];

        foreach( $books as $book ) {
          $content[] = $this->createTableRow($book['id'], $book['title'], $book['count_authors']);
        }

        if (empty($content)) {
          $content[] = "<tr><td colspan='4'><div class='alert alert-info'>No results</td></tr>";
        }

        $this->table = str_replace("%rows%", implode('', $content), $this->table );
    }

    public function createPagination($pagination) {
        $this->table = str_replace("%pagination%", $pagination, $this->table);
    }

    public function addAlert($key) {
        $textMap = [
            'create' => 'New book has been created',
            'edit'   => 'Book has been edited',
            'delete' => 'Book has been deleted'
        ];

        if(!array_key_exists($key,$textMap)) {
            return false;
        }

        $this->beginContent .= $this->templateText($this->alert, [
            'text' => $textMap[$key]
        ]);
    }

    public function render() {
        $this->layout->render($this->beginContent . $this->table);
    }
}