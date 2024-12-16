<?php

namespace App\Services;

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

readonly class ExcelFileParserService
{
    private ValidateErrorExcelRowDataService $_validateErrorExcelRowDataService;

    private SaveErrorsInFileService $_saveErrorsInFileService;

    public function __construct(
        ValidateErrorExcelRowDataService $validateErrorExcelRowDataService,
        SaveErrorsInFileService          $saveErrorsInFileService
    )
    {
        $this->_validateErrorExcelRowDataService = $validateErrorExcelRowDataService;
        $this->_saveErrorsInFileService = $saveErrorsInFileService;
    }

    public function parse(string $path, int $chunkSize = 1000, int $startRow = 1): array
    {
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($path);

        $currentRow = 0; // Счётчик строк
        $chunk = []; // Для хранения строк в текущем чанке
        $errorValidateList = [];

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {

                $currentRow++;

                // Пропускаем строки до нужного старта
                if ($currentRow <= $startRow) {
                    continue;
                }

                // Добавляем строку в текущий чанк
                $errorValidate = $this->_validateErrorExcelRowDataService->getValidateMessage($row->toArray());

                if (count($errorValidate) <= 0) {
                    [$id , $name, $date] = $row->toArray();
                    $chunk[] = [
                        'id' => $id,
                        'name' => $name,
                        'date' => (\DateTime::createFromFormat('d.m.Y', $date))->format('Y-m-d'),
                    ];
                } else {
                    $errorValidateList[] = [
                        'row' => $currentRow,
                        'errors' => $errorValidate,
                    ];
                }

                // Если достигли размера чанка, обрабатываем данные
                if (count($chunk) === $chunkSize) {
                    break;
                }
            }
        }

        $reader->close();

        if (count($errorValidateList)> 0) {
            $this->_saveErrorsInFileService->save($errorValidateList);
        }

        return $chunk;
    }
}
