<?php

namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase
{

    public function setUp()
    {
        // Initialise the receipt object
        $this->Receipt = new Receipt();
    }

    public function tearDown()
    {
        // Delete the receipt object
        unset($this->Receipt);
    }

    public function testTotal()
    {
        //Create a variable of an array and the coupon value
        $input = [0, 2, 5, 8];
        $coupon = null;
        // Give the $input variable to the total() method and save the output to a new variable
        $output = $this->Receipt->total($input, $coupon);
        $this->assertEquals(
            15, // Expected value
            $output, // Value returned by total()
            'When summing the total should equal 15' // Message to return
        );
    }

    public function testTotalAndCoupon()
    {
        // Create a variable of an array and the coupon value
        $input = [0, 2, 5, 8];
        $coupon = 0.20;
        // Execute total() with the array and the additional value of coupon and save to variable
        $output = $this->Receipt->total($input, $coupon);
        $this->assertEquals(
            12, // Expected value
            $output, // Value returned by total()
            'When summing the total should equal 12' // Message to return
        );
    }

    public function testPostTaxTotal()
    {
        // Create a variable of an array and the tax value
        $items = [1,2,5,8];
        $tax = 0.20;
        $coupon = null;

        // Create a mock receipt class
        $Receipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['tax', 'total'])
            ->getMock();

        // Make sure that the total method in mock Receipt will return 10.00
        $Receipt->expects($this->once())
            ->method('total')
            ->with($items, $coupon)
            ->will($this->returnValue(10.00));

        $Receipt->expects($this->once())
            ->method('tax')
            ->with(10.00, $tax)
            ->will($this->returnValue(1.00));
        $result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);
        $this->assertEquals(
            11.00, // Expected value
            $result // Value returned by postTaxTotal()
        );
    }

    public function testTax()
    {
        // Set variables that will be given to tax()
        $inputAmount = 10.00;
        $taxInput = 0.10;
        // Run tax() with the variables and save to $output
        $output = $this->Receipt->tax($inputAmount, $taxInput);
        $this->assertEquals(
            1.00, // Expected value
            $output, // Value returned by tax()
            'The tax calculation should equal 1.00'
        );
    }

}