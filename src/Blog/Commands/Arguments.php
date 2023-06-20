<?php 
namespace App\Blog\Commands;

use App\Blog\Exceptions\ArgumentsException;

final class Arguments 
{
    private array $arguments = [];

    public function __construct(iterable $arguments){
        
        foreach ($arguments as $key => $value) {
            $stringValue = trim((string)$value);

            if (empty($stringValue)) {
                continue;
            }

            $this->arguments[(string)$key] = $stringValue;
        }
    }

    public static function fromArgv(array $argv): self 
    {
        $arguments = [];

        foreach ($argv as $argument) {
            $parts = explode('=', $argument);
            
            if (count($parts) !== 2) {
                continue;
            }
            
            $arguments[$parts[0]] = $parts[1];
        }

        return new self($arguments);
    }

    public function get(string $argument): string
    {
        if (!array_key_exists($argument, $this->arguments)) {
            throw new ArgumentsException(
                "Нет такого аргумента: $argument"
            );
        }
        
        return $this->arguments[$argument];
    }
}