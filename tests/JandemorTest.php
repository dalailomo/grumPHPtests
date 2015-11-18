<?php

namespace Kapusta\tests;

use Kapusta\Jandemor;

class JandemorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Jandemor
     */
    private $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = new Jandemor();
    }

    /**
     * @test
     * @covers Jandemor::setKrander
     */
    public function testGetSetKrander()
    {
        $this->sut->setKrander('Hello world!');
        $this->assertSame('Hello world!', $this->sut->getKrander());

        $this->sut->setKrander();
        $this->assertSame('defaultKrander', $this->sut->getKrander());
    }
}
