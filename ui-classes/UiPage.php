<?php

abstract class UiPage {

  public function optionHtml($val, $label = "", $isSelected = false) {
    return $this->templateText('<option value="%value%" %selected%>%label%</option>', [
      "value" => $val,
      "label" => $label === "" ? $val : $label,
      "selected" => $isSelected ? "selected" : ""
    ]);
  }

  public function templateText($content, $params) {
    $find = $this->prepareTemplateFindKeys(array_keys($params));

    $replace = array_map(function ($item) {
      return htmlspecialchars($item);
    }, array_values($params));

    return str_replace($find, $replace, $content);
  }

  public function templateHtml($content, $params) {
    $find = $this->prepareTemplateFindKeys(array_keys($params));

    $replace = array_values($params);

    return str_replace($find, $replace, $content);
  }

  private function prepareTemplateFindKeys($keys) {
    return array_map(function ($item) {
      return '%' . $item . '%';
    }, $keys);
  }

  abstract function render();
}