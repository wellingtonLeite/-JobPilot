<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('jobpilot:search')->dailyAt('08:00');
