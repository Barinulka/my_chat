<?php 
declare(static_types=1);

namespace App\Http;
use App\Http\Response;

// Класс успешного ответа
class SuccessfulResponse extends Response
{
    protected const SUCCESS = true;

    // Успешний ответ содержит массив с данными
    // по умолчанию - пустой
    public function __construct(
        private array $data = []
    ){
    }

    // Реализация абстрактного метода
    // родительского класса
    protected function payload(): array 
    {
        return ['data' => $this->data];
    }
}