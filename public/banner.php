<?php

use App\Persistence\PersistenceFactory;

require_once "../vendor/autoload.php";

// This part is hardcoded as I assume flexibility here is not a requirement for this task.
$filePath = "../data/images/dummy.jpg";
header('Content-Type: image/jpeg');
header('Content-Length: ' . filesize($filePath));
readfile($filePath);

try {
    $factory = new PersistenceFactory(new App\Config\Config("../config/config.php"));

    $writer = $factory->createWriter();

    $writer->insertOnDuplicateUpdate(
        'visits',
        [
            "ip_address" => $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'],
            "user_agent" => $_SERVER['HTTP_USER_AGENT'],
            "page_url" => $_GET['page_url'] ?? $_SERVER['REQUEST_URI']
        ],
        [
            "views_count" => "views_count+1"
        ]
    );
} catch (Exception $exception) {
    // Report an issue
}
