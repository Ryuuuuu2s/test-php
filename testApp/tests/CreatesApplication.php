<?php
declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Artisan; // 追記
use App\Models\Todo; // 追記

/**
* CreateApplication trait
*/
trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    // ここから追記
    /**
    * artisanコマンドを実行しmigrationを行う
    * 実行後テストに必要なデータを投入する
    * @return void
    */
    public function prepareForTests(): void
    {
        Artisan::call('migrate');
        if(!Todo::all()->count()){
            Artisan::call('db:seed');
        }
    }
    // ここまで追記
}