<?php
namespace App\Blog\PHPUnit\Commands;

use App\Blog\Exceptions\ArgumentsException;
use PHPUnit\Framework\TestCase;
use App\Blog\Commands\Arguments;

class ArgumentsTest extends TestCase
{

    /**
     * Тест на соответсвие найденого значения с введенным
     *
     * @return void
     */
    public function testItReturnsArgumentsValueByName(): void
    {
        // Подготовка
        $arguments = new Arguments(['some_key' => 'some_value']);

        // Действие
        $value = $arguments->get('some_key');
        
        // Проверка
        $this->assertEquals('some_value', $value);
    }

    /**
     * Проверка на возврат строки
     *
     * @return void
     */
    public function testItReturnsValuesAsString(): void 
    {
        $arguments = new Arguments(['some_key' => 123]);

        $value = $arguments->get('some_key');

        $this->assertSame('123', $value);
    }

    /**
     * Проверка на выбрасывание исключения
     *
     * @return void
     */
    public function testItThrowsAnExceptionWhenArgumentIsEmpty(): void 
    {
        $arguments = new Arguments([]);

        $this->expectException(ArgumentsException::class);

        $this->expectExceptionMessage("Нет такого аргумента: some_key");

        $arguments->get('some_key');
    }

    /**
     * Тест с ипользованием провайдера данных
     *
     * @dataProvider argumentsProvider
     */
    public function testItConvertsArgumentsToStrings($inputValue, $expectedValue): void {

        $arguments = new Arguments(['some_key' => $inputValue]);

        $value = $arguments->get('some_key');

        $this->assertEquals($expectedValue, $value);
    }


    /**
     * Провайдер данных для тестов
     *
     * @return iterable
     */
    public static function argumentsProvider(): iterable
    {
        return [
            ['some_string', 'some_string'], // Тестовый набор
            [' some_string', 'some_string'], // Тестовый набор №2
            [' some_string ', 'some_string'],
            [123, '123'],
            [12.3, '12.3'],
        ];
    }
}