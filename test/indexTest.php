<?php

include('../api/index.php');

use PHPUnit\Framework\TestCase;

class indexTest extends TestCase
{

    public function test_geotest_notempty() {
        $response = geodata("Toronto");
        //echo $response;
        $this->assertNotEmpty($response);
    }

    public function test_geotest_empty() {
        $response = geodata("");
        //echo $response;
        $this->assertCount(0, $response);
    }


    public function test_geotemp() {
        $response = geotemperature("43.65","-79.38");
        //echo $response;
        $this->assertEquals(17.22, $response);
    }

    public function test_geotemp_empty() {
        $response = geotemperature("","");
        //echo $response;
        $this->assertEquals("", $response);
    }

}