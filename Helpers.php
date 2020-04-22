<?php

use Symfony\Component\VarDumper\VarDumper;

if (! function_exists('dump')) {
    function dump()
    {
        array_map(function ($x) {
            $varDumper = new VarDumper();
            $varDumper->dump($x);
        }, func_get_args());
    }
}

if (! function_exists('dd')) {
    function dd()
    {
        array_map(function ($x) {
            $varDumper = new VarDumper();
            $varDumper->dump($x);
        }, func_get_args());
        die(1);
    }
}