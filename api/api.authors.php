<?php

require_once __DIR__ . '/../init.php';

$db = util_init_db();

$id = util_request_post('id', false);

if(!$id) {
    die(json_encode([
        'status' => 'fail'
    ]));
}

$author = new Author();

$data = $author->getAuthorsBookById($id);

if(empty($data)) {
    die(json_encode([
        'status' => 'fail'
    ]));
}

die(json_encode([
  'status' => 'ok',
  'data' => $data
]));