<?php
namespace App\Http;

// Абстрактный класс ответа,
// содержащий общую функциональность
// успешного и неуспешного ответа
abstract class Response 
{
    // Маркировка успешного ответа
    protected const SUCCESS = true;

    // Метод для отправки ответа
    public function send(): void 
    {
        // Данные ответа
        $data = ['success' => static::SUCCESS] + $this->payload();

        // Отправляем заголовок, говорящий, что в ответе будет JSON
        header('Content-Type: application/json');

        echo json_encode($data, JSON_THROW_ON_ERROR);
    }

    // Декларация абстрактного метода,
    // возвращающего полезные данные ответа
    abstract protected function payload(): array;
}