<?php

function d(...$args)
{
    array_map(function ($arg) {
        if (is_array($arg) || is_object($arg)) {
            echo sprintf('<pre style="display: block; font: monospace; white-space: pre;">%s</pre>', print_r($arg, true));
        } else {
            var_dump($arg);
        }
    }, $args);
}

function dd(...$args)
{
    d(...$args);
    die;
}
