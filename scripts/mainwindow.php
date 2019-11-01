<?php

require_once 'qrc://scripts/math.php';
require_once 'qrc://scripts/signtrait.php';

class MainWindow extends QMainWindow 
{
    /** Подключаем клики для знаков */
    use SignTrait;

    /** @var int Количество цифровых кнопок */
    const COUNT_NUMBERS = 10;

    private $ui;

    public function __construct($parent = null) 
    {
        parent::__construct($parent);
        $this->ui = setupUi($this);
        $this->makeEventNumbers();
    }

    /**
     * Вешаем клик на кнопки цифровые кнопки number*
     */
    private function makeEventNumbers()
    {
        for ($i = 0; $i < self::COUNT_NUMBERS; $i++) {
            $mapButton = 'number'. $i;

            $this->ui->$mapButton->onClicked = function () use ($i) {
                $exp = $this->ui->expression->text();

                $text = $exp . ($this->isNumberLastSymbolExpression() || empty($this->ui->expression->text()) ? '' : ' ') . $i;

                $this->ui->expression->setText($text);
            };
        }
    }

    /**
     * @slot buttonResult::clicked
     * @param object $sender
     * @throws Exception
     */
    public function onButtonResultClicked($sender)
    {
        $result = $this->bringExpression();

        $this->ui->fieldResult->setText($result);
    }

    /**
     * Добавить знак в строку выражения
     *
     * @param $sign
     */
    private function expressionAddSign($sign)
    {
        $exp = $this->ui->expression->text();
        if (
            (!empty($exp) || $exp == 0) &&
            $this->isNumberLastSymbolExpression()
            ) {
            $this->ui->expression->setText($exp . ' ' . $sign . ' ');
        }
    }

    /**
     * Является ли последний символ выражения ЗНАКОМ
     *
     * @return bool
     */
    private function isNumberLastSymbolExpression()
    {
        $expression = trim($this->ui->expression->text());
        $lastSymbol = substr($expression, -1);

        return is_numeric($lastSymbol);
    }

    /**
     * Посчитать выражение
     *
     * @return int|mixed
     * @throws Exception
     */
    private function bringExpression()
    {
        $exp = $this->ui->expression->text();
        if (
            !empty($exp)
        ) {
            $math = new Math();

            try {
                $result = $math->bring($exp);
            } catch (Exception $exception) {
                $this->alert($exception->getMessage());

                $result = '';
            }
        } else {
            return 0;
        }

        return $result;
    }

    /**
     * @slot reset::clicked
     * @param object $sender
     */
    public function onResetClicked($sender)
    {
        $this->resetFieldResult();
        $this->resetExpression();
    }

    /**
     * @slot removeLastSymbol::clicked
     * @param object $sender
     */
    public function onRemoveLastSymbolClicked($sender)
    {
        if (empty($this->ui->expression->text())) {
            return;
        }

        $exp = $this->ui->expression->text();

        $groups = explode(' ', $exp);
        array_pop($groups);

        $text = implode(' ', $groups);

        if ($this->getLastSymbolExpression() == ' ') {
            $text = substr($text, 0, -1);
        }

        $this->ui->expression->setText($text);

        $this->resetFieldResult();
    }

    /**
     * Сбросить результат
     */
    private function resetFieldResult()
    {
        $this->ui->fieldResult->setText('');
    }

    /**
     * Сбросить выражение
     */
    private function resetExpression()
    {
        $this->ui->expression->setText('');
    }

    /**
     * Получить последний символ выражения
     *
     * @return false|string
     */
    private function getLastSymbolExpression()
    {
        return substr($this->ui->expression->text(), -1);
    }

    /**
     * Делаем всплываемое окошко
     *
     * @param $text
     * @return mixed
     */
    private function alert($text)
    {
        $messageBox = new QMessageBox(
            QMessageBox::Information,
            'Ошибка!',
            $text
        );

        $messageBox->addButton("Закрыть", QMessageBox::AcceptRole);

        return $messageBox->exec();
    }
}
