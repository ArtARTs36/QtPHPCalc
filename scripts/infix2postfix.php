<?php

/**
 * Класс для перевода выражения из инфиксной формы в постфиксную
 *
 * Class Infix2Postfix
 */
class Infix2Postfix
{
    private $postfix = array();
    private $stack = array();

    public function process($infix)
    {
        $infix = (string)$infix;

        $operators = OperatorFactory::getTokens();
        $operators = array_map('preg_quote', $operators);
        $operators = '(' . implode(')|(', $operators) . ')';
        $pattern = '#(\\d+(\.?\\d+|\\d*))|(\()|(\))|' . $operators . '#';
        $tokens = array();
        preg_match_all($pattern, $infix, $tokens);

        $tokens = array_map(array('OperatorFactory', 'getOperator'), $tokens[0]);

        for ($i = 0; $i < count($tokens); $i++) {
            $token = $tokens[$i];
        //foreach ($tokens as $token) {
            if (is_numeric($token)) {
                $this->postfix[] = $token;
            } elseif ($token == '(') {
                array_unshift($this->stack, $token);
            } elseif ($token == ')') {
                $tmp = '';
                while ($tmp <> '(') {
                    if (count($this->stack) == 0) {
                        throw new Exception('Parse error.');
                    }
                    $tmp = array_shift($this->stack);
                    if ($tmp != '(') {
                        $this->postfix[] = $tmp;
                    }
                }
            } elseif ($token instanceof AbstractOperator) {
                /** Такая заплатка, чтоб ничего к чертям не отвалилось */
                if (
                    isset($this->stack[0]) && !empty($this->stack[0]) &&
                    $this->stack[0] instanceof AbstractOperator
                ) {

                    //
                    if (
                        $token instanceof SubOperator &&
                        //$tokens[$i - 1] instanceof PowOperator &&
                        is_numeric($tokens[$i + 1])
                    ) {
                        $tokens[$i + 1] = $tokens[$i + 1] * -1;

                        continue;
                    }
                    //

                    foreach ($this->stack[0] as $st) {
                        if (
                            $token->comparePriority(@$st) == 1 &&
                            $this->stack[0]->getAssociative() == AbstractOperator::ASSOCIATIVE_LEFT) {
                            break;
                        }

                        if (
                            $token->comparePriority(@$st[0]) >= 0 &&
                            $this->stack[0]->getAssociative() == AbstractOperator::ASSOCIATIVE_RIGHT) {
                            break;
                        }

                        /** Кладем первое значение стэка */
                        $this->postfix[] = array_shift($this->stack);
                    }
                }

                /** Кладем новый токен в начало стэка */
                array_unshift($this->stack, $token);
            }
        }

        foreach ($this->stack as $token) {
            if (!($token instanceof AbstractOperator)) {
                throw new Exception('Ошибка парсинга.');
            }
            $this->postfix[] = $token;
        }

        return $this->postfix;
    }
}
