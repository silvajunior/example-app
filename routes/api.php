<?php
// routes/api.php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Route;


Route::post('/api/applications', [ApplicationController::class, 'store']);
