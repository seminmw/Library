<?php

class UiPageEditBook extends UiPage {

    public $content;

    public $layout;

    function __construct($layout) {
      $this->content = file_get_contents( __DIR__ . '/../templates/edit-book.html' );
      $this->layout = $layout;
    }

    public function addingAuthors($authors) {
      $content = "";

      foreach($authors as $author) {
        $id = $author['id'];
        $name = $author['name'];
        $selected = $author['selected'];

        $content .= $this->optionHtml($id, $name, $selected);
    }

      $this->content = $this->templateHtml($this->content, [
        "authorsOptions" => $content
      ]);
    }

    public function addingBook($book) {
        $this->content = $this->templateHtml($this->content, [
            "book_id" => $book['id'],
            "book"    => $book['title']
        ]);
    }

    public function render() {
      $this->layout->render($this->content);
    }
  }