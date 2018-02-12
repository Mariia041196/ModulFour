<?php
http_response_code(200);
header('content-type: application/json');
echo json_encode([
    'id' => rand(),
    'title' => 'Something'
]);