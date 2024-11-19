<?php

require __DIR__ . '/vendor/autoload.php';

class JobRunner
{
    public static function execute($className, $methodName, $parameters = [])
    {
        try {
            // Validate and sanitize inputs
            if (!class_exists($className)) {
                throw new Exception("Class $className does not exist.");
            }

            if (!method_exists($className, $methodName)) {
                throw new Exception("Method $methodName does not exist in class $className.");
            }

            // Ensure only allowed classes can be executed
            $allowedClasses = require __DIR__ . '/config/background_jobs.php';
            if (!in_array($className, $allowedClasses['allowed_classes'])) {
                throw new Exception("Execution of class $className is not permitted.");
            }

            // Instantiate the class and call the method
            $instance = new $className();
            $result = call_user_func_array([$instance, $methodName], $parameters);

            // Log success
            self::logJob($className, $methodName, 'success', $parameters);
            return $result;
        } catch (Exception $e) {
            // Log failure
            self::logJob($className, $methodName, 'failure', $parameters, $e->getMessage());
            throw $e;
        }
    }

    protected static function logJob($class, $method, $status, $parameters, $error = null)
    {
        $logData = [
            'timestamp' => now(),
            'class'     => $class,
            'method'    => $method,
            'status'    => $status,
            'parameters' => json_encode($parameters),
            'error'     => $error,
        ];

        $logFile = $status === 'success' 
            ? storage_path('logs/background_jobs.log') 
            : storage_path('logs/background_jobs_errors.log');

        file_put_contents($logFile, json_encode($logData) . PHP_EOL, FILE_APPEND);
    }
}
