<?php

function util_init_db() {
  $db = new Database();
  $db->connect(DB_TYPE, DB_HOST, DB_PORT, DB_USER, DB_PASS, DB_NAME);

  return $db;
}

function util_arr_index_or_default($arr, $index, $default = '') {
  return isset($arr[$index]) ? $arr[$index] : $default;
}

function util_request_get($index, $default = '') {
  return util_arr_index_or_default($_GET, $index, $default);
}

function util_request_get_string($index, $default = '') {
  return urldecode(trim(util_request_get($index, $default)));
}

function util_request_post($index, $default = '') {
  return util_arr_index_or_default($_POST, $index, $default);
}

function util_request_post_string($index, $default = '') {
  return trim(util_request_post($index, $default));
}