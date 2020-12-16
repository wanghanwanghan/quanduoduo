<?php

use Carbon\Carbon;

include './vendor/autoload.php';




$time = Carbon::parse('1966-12-06')->timestamp;


dd($time);
