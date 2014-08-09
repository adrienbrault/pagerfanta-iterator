<?php

use AdrienBrault\PagerfantaIterator\PagerfantaIterator;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

require_once __DIR__.'/vendor/autoload.php';

$pager = new Pagerfanta(new ArrayAdapter(array_fill(0, 100, 'SUP')));
$pager->setMaxPerPage(10);

foreach (PagerfantaIterator::iterateOverElements($pager) as $key => $value) {
    var_dump($key, $value);
}
