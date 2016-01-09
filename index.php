<?php
require __DIR__ . '/vendor/autoload.php';
define('START_TIME', microtime(true));
define('START_MEM', memory_get_usage());
(new Dreamer\Kernel)->run();
