<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Workerman\Worker;

class WorkermanCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wk {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        global $argv;
        $arg = $this->argument('action');
        $argv[1] = $argv[2];
        $argv[2] = isset($argv[3]) ? "-{$argv[3]}" : '';

        switch($arg) {
            case 'start':
                $this->start();
                break;

            case 'stop':
                break;

            case 'restart':
                break;

            case 'reload':
                break;

            case 'status':
                break;

            case 'connections':
                break;
        }
    }

    private function start(){
        // 创建一个Worker监听2345端口，使用http协议通讯
        $http_worker = new Worker("http://0.0.0.0:2345");

        // 启动4个进程对外提供服务
        $http_worker->count = 4;

        // 接收到浏览器发送的数据时回复hello world给浏览器
        $http_worker->onMessage = function($connection, $data)
        {
            // 向浏览器发送hello world
            $connection->send('hello world');
        };

        Worker::runAll();
    }
}
