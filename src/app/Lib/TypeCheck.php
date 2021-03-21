<?php

namespace App\Lib;

class TypeCheck
{
    protected function __construct()
    {
    }

    public static function checkArrayType(string $type, array $array): bool
    {
        $supportedTypes = [
            'boolean',
            'integer',
            'double',
            'string',
            'array',
            'object',
            'resource',
        ];

        $badTypeFlag = false;

        if (!\in_array($type, $supportedTypes, true)) {
            throw new InvalidArgumentException('Unsupported type check');
        }

        foreach ($array as $value) {
            if (\gettype($value) !== $type) {
                $badTypeFlag = true;
                break;
            }
        }

        if ($badTypeFlag) {
            return false;
        } else {
            return true;
        }
    }
}
