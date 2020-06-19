<?php

namespace MemoChou1993\Lexicon\Listeners;

use MemoChou1993\Lexicon\Facades\Lexicon;

class Sync
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        Lexicon::clear()->export();
    }
}
