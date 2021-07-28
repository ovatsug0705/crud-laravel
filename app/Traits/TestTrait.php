<?php

namespace App\Traits;

/**
 * Test Trait
 */
trait TestTrait
{
    public function getTest(): string {
        return 'Trait de Test';
    }

    public function getFakeData(): string {
        return 'Alguma informação qualquer';
    }
}
