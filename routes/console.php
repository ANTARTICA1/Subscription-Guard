<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('subscriptions:check-reminders')->hourly();
Schedule::command('shares:reset')->daily();
