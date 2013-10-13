<?php

namespace tests\units\fullPhp\lib;

class PhpFullPower extends \atoum
{
    public function testAddFunctionality()
    {
        $full = new \fullPhp\lib\PhpFullPower();



        $full = new \fullPhp\lib\PhpFullPower();

        $functionalityMock = new \mock\fullPhp\interfaces\FunctionalityInterface;

        $isBeforeExecuted = false;

        $functionalityMock->getMockController()->before = function(\AopJoinPoint $joinPoint) use($isBeforeExecuted)
        {
            $isBeforeExecuted = true;
        };

        $full->addFunctionality($functionalityMock);

        $full->setMatch("*->*()");

        $full->enable();

        $this->getVariable();

        $full->disable();

        $this
            ->boolean($isBeforeExecuted)
                ->isTrue()
        ;
    }

    private function getVariable()
    {
        return "var";
    }

    public function testEnable()
    {

    }

    public function testDisable()
    {

    }
}

?>