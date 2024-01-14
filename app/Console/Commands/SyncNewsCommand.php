<?php

namespace App\Console\Commands;

use App\Services\ScrapNews;
use Illuminate\Console\Command;

class SyncNewsCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync news categories, authors, sources, and articles';

    /**
     * Execute the console command.
     */
    public function handle() {
        $scrapNews = new ScrapNews();
        $scrapNews->run();
        $this->info('News sync completed successfully.');
    }
}
