<?php
    $digits = 4;
    $year = date('Y');
    $randomNumber = mt_rand(pow(10, $digits-1), pow(10, $digits)-1);
    echo $randomNumber;
?>