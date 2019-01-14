<?php

class UiPageError extends UiPage {

  public $alertText;

  public $alerts = [];

  public function __construct($layout) {
    $this->alertText = file_get_contents( __DIR__ . '/../templates/inc-alert.html' );
    $this->layout = $layout;
  }

  public function addError($error) {
    $this->alerts[] = $this->templateText($this->alertText, [
      'type' => 'danger',
      'error' => $error
    ]);
  }

  public function backButtonHtml() {
    return "<p><a href='javascript:self.history.back();'>Go Back</a></p>";
  }

  public function render() {
    $this->layout->render(implode('', $this->alerts) . $this->backButtonHtml());
  }
}