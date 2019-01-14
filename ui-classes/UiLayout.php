<?php

class UiLayout {

  public $contentLayout;

  public function __construct() {
    $this->contentLayout = file_get_contents( __DIR__.'/../templates/layout.html' );
  }

  public function render($content) {
    echo str_replace('%content%', $content, $this->contentLayout);
  }

}