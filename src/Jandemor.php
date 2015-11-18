<?php

namespace Kapusta;

class Jandemor
{
    protected $krander;

    public function setKrander($krander = 'defaultKrander')
    {
        $this->krander = $krander;
    }

    public function getKrander()
    {
        return $this->krander;
    }
}
