<?php

if (!function_exists('runBackgroundJob')) {
    function runBackgroundJob($className, $methodName, $parameters = [])
    {
        $command = PHP_BINARY . ' ' . base_path('JobRunner.php') . ' '
            . escapeshellarg($className) . ' '
            . escapeshellarg($methodName) . ' '
            . escapeshellarg(json_encode($parameters));

        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen("start /B " . $command, "r"));
        } else {
            exec($command . " > /dev/null 2>&1 &");
        }
    }
}
