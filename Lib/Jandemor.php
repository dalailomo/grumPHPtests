<?php

namespace Kapusta;

class Jandemor
{
    protected $krander = 'Hello Default!';

    /**
     * Krander method to do krander things.
     *
     * @param null $krander
     *
     * @return null|string
     */
    public function krander($krander = null)
    {
        if (isset($krander)) {
            $this->krander = $krander;
        }

        return $this->krander;
    }
}
