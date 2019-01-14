<?php

class UiPageCreateBook extends UiPage {

  public $content;

  public $layout;

  function __construct($layout) {
    $this->content = file_get_contents( __DIR__ . '/../templates/create-book.html' );
    $this->layout = $layout;
  }

  public function addingAuthors($authors) {
    $content = "";

    foreach($authors as $author) {
      $id = $author['id'];
      $name = $author['name'];

      $content .= $this->optionHtml($id, $name);
    }

    $this->content = $this->templateHtml($this->content, [
      "authorsOptions" => $content
    ]);
  }

  public function render() {
    $this->layout->render($this->content);
  }
}