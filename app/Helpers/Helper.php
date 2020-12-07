<?php

use Carbon\Carbon;

function return_date($date)
{
    return Carbon::parse($date)->format('j F, Y. h:i a');
}