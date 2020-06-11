<?php

namespace MemoChou1993\Localize\Listeners;

use MemoChou1993\Localize\Facades\Localize;

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
        Localize::clear()->export();
    }
}
