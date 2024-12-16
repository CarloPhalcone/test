<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class ValidateErrorExcelRowDataService
{
    public function getValidateMessage(array $row): array
    {
        $errors = [];

        $data = [
            'id' => $row[0] ?? null,
            'name' => $row[1] ?? null,
            'date' => $row[2] ?? null,
        ];

        $validator = Validator::make($data, [
            'id'   => 'required|integer|min:1|max:9223372036854775807',
            'name' => 'required|regex:/^[a-zA-Z ]+$/',
            'date' => 'required|date_format:d.m.Y',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            dump($errors);
        }

        return $errors;
    }
}
