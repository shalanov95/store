<?php
function fibo($i) { 
    if ($i == 0 ) return 0; 
    if ($i == 1 || $i == 2) { 
     return 1; 
    } else { 
     return fibo($i - 1) + fibo($i -2); 
    } 
} 

function orderLeftsock($day) {
    $sum = 0;
    $day = ($day < 30) ? $day : 30; // костыль чтобы не зацилкивать сервер.
    for ($i=1; $i <= $day; $i++) { 
        $sum += fibo($i);
    }
    return $sum;
}

function dayAmout($first, $last) {
    return ((strtotime($last) - strtotime($first))/(60*60*24)) + 1;
}