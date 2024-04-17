<?php
declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
* TestCase class
*/
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    /**
    * setUp
    */
    public function setup(): void
    {
        parent::setup();
        $this->prepareForTests();
    }
}