<?php

require_once __DIR__ . '/../../config/bootstrap.php';

$body = file_get_contents("php://input");

$data = json_decode($body, true);

$search = $data["searchValue"];

$selection = autocompletionSearch($pdo, $search);

echo json_encode($selection);

