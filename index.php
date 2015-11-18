<?php

require 'vendor/autoload.php';

use Kapusta\Jandemor;

$jandemor = new Jandemor();

$jandemor->krander('akrandemor');

echo $jandemor->krander();
