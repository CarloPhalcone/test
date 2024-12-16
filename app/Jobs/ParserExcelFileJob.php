<?php

namespace App\Jobs;

use App\Repositories\RowsRepository;
use App\Services\ExcelFileParserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Redis;

class ParserExcelFileJob implements ShouldQueue
{
    use Queueable;

    private readonly string $_storagePath;

    private readonly ExcelFileParserService $_excelFileParserService;

    private readonly RowsRepository $_rowsRepository;

    /**
     * Create a new job instance.
     */
    public function __construct(string $storagePath)
    {
        $this->_storagePath = $storagePath;
        $this->_excelFileParserService = app(ExcelFileParserService::class);
        $this->_rowsRepository = app(RowsRepository::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $current = Redis::get('current_row_id') ?? 1;
        $chunkSize = 1000;

        $listData = $this->_excelFileParserService->parse($this->_storagePath, $chunkSize, $current);

        if (count($listData) > 0) {
            $this->_rowsRepository->insert($listData);
            Redis::set('current_row_id', $current + count($listData));
            self::dispatch($this->_storagePath)->delay(now()->addSeconds(1));
        } else {
            Redis::del('current_row_id');
        }
    }
}
