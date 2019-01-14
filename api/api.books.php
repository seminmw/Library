<?php

require_once __DIR__ . '/../init.php';

$db = util_init_db();

$id = util_request_post('id');


if(!$id) {
    die(json_encode([
        'status' => 'fail'
    ]));
}

$book = new Book();

$data = $book->getBooksByAuthorId($id);

if(empty($data)) {
    die(json_encode([
        'status' => 'fail'
    ]));
}

die(json_encode([
    'status' => 'ok',
    'data' => $data
]));