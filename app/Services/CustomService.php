<?php

namespace App\Services;

class CustomService
{
    public function execute($data)
    {
        // Example logic
        file_put_contents(storage_path('logs/service.log'), "Executing with data: $data\n", FILE_APPEND);
    }
}
