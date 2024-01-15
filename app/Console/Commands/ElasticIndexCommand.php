<?php

namespace App\Console\Commands;

use App\Services\IndexArticles;
use Illuminate\Console\Command;

class ElasticIndexCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:elastic-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexing articles through elasticsearch';

    /**
     * Execute the console command.
     */
    public function handle() {
        $indexArticles = new IndexArticles();
        $indexArticles->run();
        $this->info('Articles indexed successfully.');
    }
}
