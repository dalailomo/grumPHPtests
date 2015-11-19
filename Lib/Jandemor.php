<?php

namespace Kapusta;

class Jandemor
{
    /**
     * @var string
     */
    protected $krander = 'Hello Default!';

    /**
     * Krander method to do krander things.
     *
     * @param null|string $krander
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
