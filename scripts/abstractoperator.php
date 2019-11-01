<?php

/**
 * Интерфейс для оператор
 *
 * Class AbstractOperator
 */
abstract class AbstractOperator
{
    const ASSOCIATIVE_LEFT = 0;
    const ASSOCIATIVE_RIGHT = 1;

    private $associativeMap = array(
        self::ASSOCIATIVE_LEFT,
        self::ASSOCIATIVE_RIGHT
    );

    /** @var int Приоритет выполнения операции*/
    protected $priority = null;

    /** @var string Знак */
    protected $token = null;

    /** @var int Количество операндов */
    protected $operandsCount = null;

    /** @var int Ассоциативность */
    protected $associative = null;

    final public function __construct()
    {

    }

    abstract protected function doExecute(array $operands);

    /**
     * @param array $operands
     * @return mixed
     * @throws Exception
     */
    public function execute(array $operands)
    {
        if (count($operands) != $this->getOperandsCount()) {
            throw new Exception('Какой-то не порядок ' . $this->getOperandsCount());
        }

        $operands = array_values($operands);

        return $this->doExecute($operands);
    }

    public function getAssociative()
    {
        if (is_null($this->associative)) {
            throw new Exception('Associative пуст');
        }

        if (!in_array($this->associative, $this->associativeMap)) {
            throw new Exception('Associative не замапился');
        }

        return $this->associative;
    }

    public function getOperandsCount()
    {
        if (is_null($this->operandsCount)) {
            throw new Exception('Операнды не прочитались!');
        }

        return $this->operandsCount;
    }

    public function comparePriority(AbstractOperator $operator)
    {
        if (is_null($this->priority)) {
            throw new Exception('Не указан приоритет!');
        }

        $num = $this->priority - $operator->priority;

        return ($num > 0) ? 1 : (($num < 0) ? -1 : 0);
    }

    public function __toString()
    {
        if (is_null($this->token)) {
            throw new Exception('Токены пусты!');
        }

        return $this->token;
    }
}
