<?php
declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
* ExampleTest class
*/
class ExampleTest extends TestCase
{
    /**
    * @const int 成功時のステータスコード
    */
    const SUCCESS_STATUS_CODE = 200;

    /**
     * topページの検証
     * @test  // 追記
     */
    public function basicTest() // 変更
    {
        $response = $this->get('/');

        $response->assertStatus(self::SUCCESS_STATUS_CODE);
    }
}