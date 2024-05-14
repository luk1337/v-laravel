<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('v:fetch-new-bans')->everyThirtyMinutes()->withoutOverlapping();
