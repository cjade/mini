<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Apidoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apidoc:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新API文档';

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
        exec("apidoc -i app/Http/Controllers/Api -o public/doc");
        $this->info('完成');
    }
}
