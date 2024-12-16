<?php

namespace App\Http\Controllers;

use App\Jobs\ParserExcelFileJob;
use Illuminate\Http\Request;

class FileUploaderController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        // Сохранение файла
        $path = $request->file('file')->store('xlsx');

        ParserExcelFileJob::dispatch(storage_path('app/private/' . $path));

        return redirect()->route('file.get');
    }
}
