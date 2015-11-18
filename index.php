<?php

require 'vendor/autoload.php';

use \Kapusta\Jandemor;

$jandemor = new Jandemor();

echo (isset($jandemor)) ? 'jandemor!' : 'nou :(';

var_dump('nouuu');
