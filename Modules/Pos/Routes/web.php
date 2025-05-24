<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {
    foreach (["pos.php"] as $value) {
        require(module_path('Pos', 'Routes/Dashboard/' . $value));
    }
});
