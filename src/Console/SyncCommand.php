<?php

namespace MemoChou1993\Localize\Console;

use Illuminate\Console\Command;
use MemoChou1993\Localize\Facades\Localize;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'localize:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync language files';

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
     * @return int
     */
    public function handle()
    {
        try {
            Localize::export();
        } catch (HttpException $e) {
            $this->error($e->getMessage());

            return 0;
        }

        return 1;
    }
}
