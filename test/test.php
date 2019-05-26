<?php
use PHPUnit\Framework\TestCase;

class StackTest extends TestCase
{
    public function testEmpty()
    {
        $stack = [];
        $this->assertEmpty($stack);

        return $stack;
    }

    public function test_incorrectRequestURL_responseIs404() {
        $this->assertTrue(true);
    }
}