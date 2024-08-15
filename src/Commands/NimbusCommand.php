<?php

namespace Hjbdev\Nimbus\Commands;

use Illuminate\Console\Command;

class NimbusCommand extends Command
{
    public $signature = 'nimbus';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
