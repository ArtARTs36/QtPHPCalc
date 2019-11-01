<?php

/**
 * Класс для оператора: Возведение в степень
 *
 * Class PowOperator
 */
class PowOperator extends AbstractOperator
{
    protected $priority = 2;
    protected $token = '^';
    protected $operandsCount = 2;
    protected $associative = parent::ASSOCIATIVE_RIGHT;

    protected function doExecute(array $operands)
    {
        return pow($operands[0], $operands[1]);
    }
}

/**
 * Класс для оператора: Сложение
 *
 * Class AddOperator
 */
class AddOperator extends AbstractOperator
{
    protected $priority = 0;
    protected $token = '+';
    protected $operandsCount = 2;
    protected $associative = parent::ASSOCIATIVE_LEFT;

    protected function doExecute(array $operands)
    {
        return $operands[0] + $operands[1];
    }
}

/**
 * Класс для оператора: Вычитание
 *
 * Class SubOperator
 */
class SubOperator extends AbstractOperator
{
    protected $priority = 0;
    protected $token = '-';
    protected $operandsCount = 2;
    protected $associative = parent::ASSOCIATIVE_LEFT;

    protected function doExecute(array $operands)
    {
        return $operands[0] - $operands[1];
    }
}

/**
 * Класс для оператора: Умножение
 *
 * Class MulOperator
 */
class MulOperator extends AbstractOperator
{
    protected $priority = 1;
    protected $token = '*';
    protected $operandsCount = 2;
    protected $associative = parent::ASSOCIATIVE_LEFT;

    protected function doExecute(array $operands)
    {
        return $operands[0] * $operands[1];
    }
}

/**
 * Класс для оператора: Деление
 *
 * Class DivOperator
 */
class DivOperator extends AbstractOperator
{
    protected $priority = 1;
    protected $token = '/';
    protected $operandsCount = 2;
    protected $associative = parent::ASSOCIATIVE_LEFT;

    protected function doExecute(array $operands)
    {
        if ($operands[1] == 0) {
            throw new Exception('На ноль делить нельзя!');
        }

        return $operands[0] / $operands[1];
    }
}
