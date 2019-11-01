<?php

require_once 'qrc://scripts/infix2postfix.php';
require_once 'qrc://scripts/abstractoperator.php';
require_once 'qrc://scripts/operators.php';
require_once 'qrc://scripts/operatorfactory.php';

class Math
{
    /**
     * @param $str
     * @return mixed
     * @throws Exception
     */
    public function bring($str)
    {
        $parser = new Infix2Postfix();
        $postfix = $parser->process($str);
        $stack = array();
        foreach ($postfix as $token) {
            if (is_numeric($token)) {
                array_unshift($stack, $token);
            } elseif ($token instanceof AbstractOperator) {
                $params = array();
                for ($i = 1; $i <= $token->getOperandsCount(); $i++) {
                    if (count($stack) == 0) {
                        $params[] = 0;
                    } else {
                        $params[] = array_shift($stack);
                    }
                }
                $result = $token->execute(array_reverse($params));
                array_unshift($stack, $result);
            }
        }

        $result = array_shift($stack);

        return $result;
    }
}
