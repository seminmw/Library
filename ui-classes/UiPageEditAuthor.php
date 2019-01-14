<?php

class UiPageEditAuthor extends UiPage {

    public $content;

    public $layout;

    function __construct($layout) {
      $this->content = file_get_contents( __DIR__ . '/../templates/edit-author.html' );
      $this->layout = $layout;
    }

    public function addingBooks($books) {
      $content = "";

      foreach($books as $book) {
        $id = $book['id'];
        $name = $book['title'];
        $selected = $book['selected'];

        $content .= $this->optionHtml($id, $name, $selected);
    }

      $this->content = $this->templateHtml($this->content, [
        "booksOptions" => $content
      ]);
    }

    public function addingAuthor($author) {
        $this->content = $this->templateHtml($this->content, [
            "author_id" => $author['id'],
            "author"    => $author['name']
        ]);
    }

    public function render() {
      $this->layout->render($this->content);
    }
  }