<?php
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(Tests\TestCase::class, LazilyRefreshDatabase::class)->in('Feature');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

function something()
{

}
