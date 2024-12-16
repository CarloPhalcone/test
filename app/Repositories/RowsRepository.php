<?php

namespace App\Repositories;

class RowsRepository
{
    public function __construct() {}

    public function insert(array $rows): void
    {
        try {
            $formattedRows = array_map(function($row) {
                return [
                    'excel_id' => $row['id'],
                    'name' => $row['name'],
                    'date' => $row['date'],
                ];
            }, $rows);

            \DB::table('rows')->upsert($formattedRows, ['excel_id'], ['name', 'date']);
        } catch (\Throwable $e) {
            dd($e->getMessage());
        }
    }
}
