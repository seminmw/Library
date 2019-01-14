<?php

class UiHomePage extends UiPage {

    public $content;

    public $layout;

    function __construct($layout) {
        $this->content = file_get_contents( __DIR__ . '/../templates/home-page.html' );
        $this->layout = $layout;
    }

    public function addAmountAuthorsAndBooks($books, $authors) {
        $this->content = $this->templateHtml($this->content, [
            "books" => $books,
            "authors" => $authors
        ]);
    }

    public function render() {
        $this->layout->render($this->content);
    }
}