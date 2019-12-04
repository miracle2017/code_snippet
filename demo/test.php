<?php

function a()
{
    $i = 0;
    while (1) {
        if ($i++ > 5) {
            return $i;
        }
    }
}

echo a();
