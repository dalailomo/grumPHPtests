<?php

namespace Kapusta\Tests;

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

    public function providerKrander()
    {
        return array(
            array('Hello World!', 'Hello World!'),
            array('', ''),
            array(null, 'Hello Default!'),
        );
    }

    /**
     * @test
     * @covers Jandemor::krander
     * @dataProvider providerKrander
     */
    public function testKrander($insert, $expected)
    {
        $this->sut->krander($insert);
        $this->assertSame($expected, $this->sut->krander());
    }
}
