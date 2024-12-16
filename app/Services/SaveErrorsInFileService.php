<?php

namespace App\Services;

class SaveErrorsInFileService
{
    public function save(array $errorValidateList): void
    {
        $path = base_path('result.txt');

        if (!file_exists($path)) {
            // Если файл не существует, создаем его
            file_put_contents($path, " ");
        }

        $newContent = '';

        foreach ($errorValidateList as $error) {

            $messages = '';
            foreach ($error['errors'] as $message) {
                $messages .= "<" . $message . ">";
            }

            $newContent .= '<' . $error['row'] . '> - ' . $messages . "\n";
        }

        // Открываем файл для добавления (или создаем его, если он не существует)
        $file = fopen($path, 'a');  // 'a' - режим добавления

        if ($file) {

            // Записываем новую строку в файл
            fwrite($file, $newContent);

            // Закрываем файл
            fclose($file);
        }
    }
}
