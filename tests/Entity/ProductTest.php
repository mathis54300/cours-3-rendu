<?php

namespace Entity;

use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testProductConstructor()
    {
        $product = new Product('test', ['EUR' => 10], 'food');
        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('test', $product->getName());
        $this->assertEquals(['EUR' => 10], $product->getPrices());
        $this->assertEquals('food', $product->getType());
    }

    public function testSetType(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $product->setType('tech');
        $this->assertEquals('tech', $product->getType());
    }

    public function testSetTypeInvalid(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $this->expectException(\Exception::class);
        $product->setType('invalid');
    }



    public function testSetPrices(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $product->setPrices(['EUR' => 20]);
        $this->assertEquals(['EUR' => 20], $product->getPrices());
        $product->setPrices(['TTT' => 20, 'EUR' => -10]);
        $this->assertEquals(['EUR' => 20], $product->getPrices());
    }

    public function testSetName(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $product->setName('test2');
        $this->assertEquals('test2', $product->getName());
    }

    public function testGetTVA(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $this->assertEquals(0.1, $product->getTVA());
    }

    public function testlistCurrencies(){
        $product = new Product('test', ['EUR' => 10, 'USD' => 20], 'food');
        $this->assertEquals(['EUR', 'USD'], $product->listCurrencies());
    }

    public function testGetName(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $this->assertEquals('test', $product->getName());
    }

    public function testGetPrices(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $this->assertEquals(['EUR' => 10], $product->getPrices());
    }

    public function testGetType(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $this->assertEquals('food', $product->getType());
    }

    public function testGetPrice(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $this->assertEquals(10, $product->getPrice('EUR'));
    }

    public function testGetPriceInvalidCurrency(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $this->expectException(\Exception::class);
        $product->getPrice('TTT');
    }

    public function testGetPriceUnavailableCurrency(){
        $product = new Product('test', ['EUR' => 10], 'food');
        $this->expectException(\Exception::class);
        $product->getPrice('USD');
    }


}
