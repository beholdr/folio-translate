<?php

namespace Beholdr\FolioTranslate\Commands;

use Illuminate\Console\Command;

class FolioTranslateCommand extends Command
{
    public $signature = 'folio-translate';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
