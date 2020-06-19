<?php

namespace MemoChou1993\Lexicon\Console;

use Illuminate\Console\Command;
use MemoChou1993\Lexicon\Facades\Lexicon;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lexicon:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear language files';

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
            Lexicon::clear();
        } catch (HttpException $e) {
            $this->error($e->getMessage());

            return 0;
        }

        return 1;
    }
}
