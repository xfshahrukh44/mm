<?php

use Carbon\Carbon;
use App\User;

function return_date($date)
{
    return Carbon::parse($date)->format('j F, Y. h:i a');
}

function return_user_name($id)
{
    $user = User::find($id);
    return optional($user)->name;
}