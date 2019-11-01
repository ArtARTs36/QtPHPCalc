<?php

trait SignTrait
{
    /**
     * @slot buttonPow::clicked
     * @param object $sender
     */
    public function onButtonPowClicked($sender)
    {
        $this->expressionAddSign('^');
    }

    /**
     * @slot buttonAdd::clicked
     * @param object $sender
     */
    public function onButtonAddClicked($sender)
    {
        $this->expressionAddSign('+');
    }

    /**
     * @slot buttonSub::clicked
     * @param object $sender
     */
    public function onButtonSubClicked($sender)
    {
        $this->expressionAddSign('-');
    }

    /**
     * @slot buttonMulti::clicked
     * @param object $sender
     */
    public function onButtonMultiClicked($sender)
    {
        $this->expressionAddSign('*');
    }

    /**
     * @slot buttonDevision::clicked
     * @param object $sender
     */
    public function onButtonDevisionClicked($sender)
    {
        $this->expressionAddSign('/');
    }
}
