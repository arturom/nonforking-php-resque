<?php
require  __DIR__ . '/vendor/autoload.php';

putenv('QUEUE=default');

putenv(
    sprintf(
        'REDIS_BACKEND=%s:%d',
        getenv('REDIS_PORT_6379_TCP_ADDR'),
        getenv('REDIS_PORT_6379_TCP_PORT')
    )
);

class MyJob {
    public $args = null;

    public function perform() {
        echo $this->args['id'], PHP_EOL;
        echo 'hello world', PHP_EOL, PHP_EOL;
        $x = range(0, 1000000000000);
        echo 'done', PHP_EOL;
    }
}

Resque::setBackend(
    sprintf(
        '%s:%d',
        getenv('REDIS_PORT_6379_TCP_ADDR'),
        getenv('REDIS_PORT_6379_TCP_PORT')
    )
);

$process_key = sprintf(
    'rt_job:%s:%s',
    getmypid(),
    uniqid()
);


$logger = new Resque_Log(true);

$queues = explode(',', getenv('QUEUE'));
$worker = new \RealTime\NonForkingWorker($queues);
$worker->setLogger($logger);
$logger->log(Psr\Log\LogLevel::NOTICE, 'Starting worker {worker}', array('worker' => $worker));
$worker->work(5, true);


/*
$child_pid = Resque::fork();

if ($child_pid === 0 || $child_pid === false) {
    // Forked and we're the child 
    $queues = explode(',', getenv('QUEUE'));
    $worker = new \RealTime\NonForkingWorker($queues);
    $worker->setLogger($logger);

    $logger->log(Psr\Log\LogLevel::NOTICE, 'Starting worker {worker}', array('worker' => $worker));
    $worker->work(5, true);
}

if($child_pid > 0) {
    // Parent process, sit and wait
    $status = 'Forked ' . $child_pid . ' at ' . strftime('%F %T');
    $logger->log(Psr\Log\LogLevel::INFO, $status);

    // Wait until the child process finishes before continuing
    pcntl_wait($status);
    $exitStatus = pcntl_wexitstatus($status);
    if($exitStatus !== 0) {
        $status = 'We must find the job and fail it!';
        $logger->log(Psr\Log\LogLevel::INFO, $status);
    }
}
 */
