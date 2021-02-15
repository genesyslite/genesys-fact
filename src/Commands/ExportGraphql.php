<?php

namespace GenesysLite\GenesysFact\Commands;

use GenesysLite\GenesysFact\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ExportGraphql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:graphql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command User Create';

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
        Artisan::call('vendor:publish --tag=genesys-business-schema');
        $this->info('Export Graphql to [\graphql\GenesysBusiness]');
        Artisan::call('vendor:publish --tag=genesys-catalog-schema');
        $this->info('Export Graphql to [\graphql\GenesysCatalog]');
        Artisan::call('vendor:publish --tag=genesys-crm-schema');
        $this->info('Export Graphql to [\graphql\GenesysCrm]');
        Artisan::call('vendor:publish --tag=genesys-fact-schema');
        $this->info('Export Graphql to [\graphql\GenesysFact]');
        Artisan::call('vendor:publish --tag=genesys-inventory-schema');
        $this->info('Export Graphql to [\graphql\GenesysInventory]');
        Artisan::call('vendor:publish --tag=genesys-ubigee-schema');
        $this->info('Export Graphql to [\graphql\GenesysUbigee]');
    }
}
