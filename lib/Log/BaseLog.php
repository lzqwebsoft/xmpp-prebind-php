<?php

class BaseLog {
    
    // loger level
    const INFO = 'INFO';
    const WARN = 'WARN';
    const ERROR = 'ERROR';
    const TRACE = 'TRACE';
    
    public function log($msg, $label) {
        echo "[$label]: ".$msg.PHP_EOL;
    }
}