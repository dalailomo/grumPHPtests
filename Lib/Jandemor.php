<?php

namespace Kapusta;

class Jandemor
{
    protected $krander = 'Hello Default!';

    public function krander($krander = null)
    {
        if (isset($krander)) {
            $this->krander = $krander;
        }

        return $this->krander;
    }
}
