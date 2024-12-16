<?php

namespace App\Providers;

use App\Repositories\RowsRepository;
use App\Services\ExcelFileParserService;
use App\Services\SaveErrorsInFileService;
use App\Services\ValidateErrorExcelRowDataService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(ExcelFileParserService::class);
        $this->app->bind(ValidateErrorExcelRowDataService::class);
        $this->app->bind(SaveErrorsInFileService::class);
        $this->app->bind(RowsRepository::class);
    }
}
