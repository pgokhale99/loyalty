<?php
use PHPUnit\Framework\TestCase;
include('../api/index.php');

class StackTest extends TestCase
{
    public function testEmpty()
    {
        $stack = [];
        $this->assertEmpty($stack);

        return $stack;
    }

    public function test_incorrectRequestURL_responseIs404() {
        receive_request("hello");
    }
}