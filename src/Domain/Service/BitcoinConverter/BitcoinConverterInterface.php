<?php

namespace Domain\Service\BitcoinConverter;

interface BitcoinConverterInterface
{
    function ars2btc(float $arsAmount): float;
}
