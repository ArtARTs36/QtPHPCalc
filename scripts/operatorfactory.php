<?php

/**
 * Класс для разбора операторов
 *
 * Class OperatorFactory
 */
abstract class OperatorFactory
{
    private static $operators = array(
        '+' => 'add',
        '-' => 'sub',
        '*' => 'mul',
        '/' => 'div',
        '^' => 'pow'
    );

    public static function getTokens()
    {
        return array_keys(self::$operators);
    }

    public static function getOperator($token)
    {
        if (!array_key_exists($token, self::$operators)) {
            return $token;
        }

        /** @var string $class маппимся на оператор */
        $class = ucfirst(self::$operators[$token]) . 'Operator';
        if (!class_exists($class)) {
            throw new Exception('Не найден класс оператора');
        }

        $operator = new $class();
        if (!($operator instanceof AbstractOperator)) {
            throw new Exception('Класс оператора найден. Но не найден оператор!');
        }

        return $operator;
    }
}
