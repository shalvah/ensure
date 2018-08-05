<?php
/**
 * Created by shalvah
 * Date: 05-Aug-18
 * Time: 00:50
 */

namespace Shalvah\Ensure\Tests;

use PHPUnit\Framework\TestCase;
use Shalvah\Ensure\RequirementFailedException;
use function Shalvah\Ensure\when;

class RequirementTest extends TestCase
{
    /**
     * @test
     */
    public function it_denies_if_when_expression_is_satisfied_but_ensure_expression_fails()
    {
        $this->expectException(RequirementFailedException::class);
        $this->expectExceptionMessage('Failed');

        when(true)->ensure(false)->orElseDeny('Failed');
    }

    /**
     * @test
     */
    public function it_denies_if_when_callable_is_satisfied_but_ensure_expression_fails()
    {
        $this->expectException(RequirementFailedException::class);
        $this->expectExceptionMessage('Failed');

        when(function () { return true; })->ensure(false)->orElseDeny('Failed');
    }

    /**
     * @test
     */
    public function it_denies_if_when_expression_is_satisfied_but_ensure_callable_fails()
    {
        $this->expectException(RequirementFailedException::class);
        $this->expectExceptionMessage('Failed');

        when(true)->ensure(function () { return false; })->orElseDeny('Failed');
    }

    /**
     * @test
     */
    public function it_denies_if_when_callable_is_satisfied_but_ensure_callable_fails()
    {
        $this->expectException(RequirementFailedException::class);
        $this->expectExceptionMessage('Failed');

        when(function () { return true; })->ensure(function () { return false; })->orElseDeny('Failed');
    }

    /**
     * @test
     */
    public function it_ignores_if_when_expression_fails()
    {
        when(false)->ensure(false)->orElseDeny('Failed');
        when(false)->ensure(function () { return false; })->orElseDeny('Failed');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_ignores_if_when_callable_fails()
    {
        when(function () { return false; })->ensure(false)->orElseDeny('Failed');
        when(function () { return false; })->ensure(function () { return false; })->orElseDeny('Failed');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_passes_if_ensure_expression_passes()
    {
        when(true)->ensure(true)->orElseDeny('Failed');
        when(function () { return true; })->ensure(true)->orElseDeny('Failed');
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function it_passes_if_ensure_callable_passes()
    {
        when(true)->ensure(function () { return true; })->orElseDeny('Failed');
        when(function () { return true; })->ensure(function () { return true; })->orElseDeny('Failed');
        $this->assertTrue(true);
    }

}
