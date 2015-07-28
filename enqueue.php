<?php
require __DIR__ . '/vendor/autoload.php';

Resque::setBackend(
    sprintf(
        '%s:%d',
        getenv('REDIS_PORT_6379_TCP_ADDR'),
        getenv('REDIS_PORT_6379_TCP_PORT')
    )
);

$job_count = isset($argv[1]) ? $argv[1] : 10;
echo $job_count, PHP_EOL;

for($x = 0; $x < $job_count; $x++) {
    Resque::enqueue(
        'default',
        'MyJob',
        array(
            'num'   => $x,
            'id'    => uniqid(),
        )
    );
}
