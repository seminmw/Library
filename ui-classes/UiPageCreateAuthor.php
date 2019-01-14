<?php

class UiPageCreateAuthor extends UiPage {

    public $content;

    public $layout;

    function __construct($layout) {
      $this->content = file_get_contents( __DIR__ . '/../templates/create-author.html' );
      $this->layout = $layout;
    }

    public function addingBooks($books) {
      $content = "";

      foreach($books as $book) {
        $id   = $book['id'];
        $name = $book['title'];

        $content .= $this->optionHtml($id, $name);
      }

      $this->content = $this->templateHtml($this->content, [
        "booksOptions" => $content
      ]);
    }

    public function render() {
      $this->layout->render($this->content);
    }
}