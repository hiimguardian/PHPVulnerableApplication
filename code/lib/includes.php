<?php
    function logger($log, $severity) {
        if (!file_exists(getcwd() . '/storage/app.log')) {
            file_put_contents(getcwd() . '/storage/app.log', '');
        }
        // IP address
        $ip = $_SERVER['REMOTE_ADDR'];
        // Time of log
        $time = gmdate('m/d/y H:i:s', time());
        // Get eisting logs from file
        $logs = file_get_contents(getcwd() . '/storage/app.log');
        // Appending log to logs
        $logs .= $severity . " $ip - [$time] - $log\r";
        // Update file
        file_put_contents(getcwd() . '/storage/app.log', $logs);
    }
?>