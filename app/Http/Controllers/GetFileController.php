<?php

namespace App\Http\Controllers;

use App\Models\Rows;
use Illuminate\Http\Request;

class GetFileController extends Controller
{
    public function index()
    {
        // Получаем все строки из таблицы и группируем по полю 'date'
        $rows = Rows::orderBy('date')
            ->get()
            ->groupBy('date');

        // Преобразуем коллекцию в двумерный массив
        $groupedRows = $rows->map(function ($group) {
            return $group->map(function ($row) {
                return [
                    'excel_id' => $row->excel_id,
                    'name' => $row->name,
                    'date' => $row->date,
                ];
            });
        });

        // Возвращаем результат в виде JSON
        return response()->json($groupedRows);
    }
}
