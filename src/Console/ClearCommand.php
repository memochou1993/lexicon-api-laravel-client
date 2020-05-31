<?php

namespace MemoChou1993\Localize\Console;

use Illuminate\Console\Command;
use MemoChou1993\Localize\Facades\Localize;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'localize:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear language resources';

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
     * @return void
     */
    public function handle()
    {
        Localize::clear();
    }
}
