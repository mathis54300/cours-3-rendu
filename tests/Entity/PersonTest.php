<?php

namespace Tests\Entity;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testConstruct(): void
    {
        $person = new Person('John Doe', 'USD');
        $this->assertEquals('John Doe', $person->name);
        $this->assertNotNull($person->wallet);
        $this->assertEquals('USD', $person->wallet->getCurrency());
    }

    public function testGetName(): void
    {
        $person = new Person('John Doe', 'USD');
        $this->assertEquals('John Doe', $person->getName());
    }

    public function testSetName(): void
    {
        $person = new Person('John Doe', 'USD');
        $person->setName('Jane Doe');
        $this->assertEquals('Jane Doe', $person->getName());
    }

    public function testGetWallet(): void
    {
        $person = new Person('John Doe', 'USD');
        $this->assertNotNull($person->getWallet());
        $this->assertEquals('USD', $person->getWallet()->getCurrency());
    }

    public function testSetWallet(): void
    {
        $person = new Person('John Doe', 'USD');
        $person->setWallet(new Wallet('EUR'));
        $this->assertNotNull($person->getWallet());
        $this->assertEquals('EUR', $person->getWallet()->getCurrency());
    }

    public function testHasFund(): void
    {
        $person = new Person('John Doe', 'USD');
        $this->assertFalse($person->hasFund());
        $person->getWallet()->setBalance(10);
        $this->assertTrue($person->hasFund());
    }

    public function testTransfertFund(): void
    {
        $person = new Person('John Doe', 'USD');
        $person2 = new Person('Jane Doe', 'USD');
        $person->getWallet()->setBalance(10);
        $this->assertEquals(10, $person->getWallet()->getBalance());
        $this->assertEquals(0, $person2->getWallet()->getBalance());
        $person->transfertFund(5, $person2);
        $this->assertEquals(5, $person->getWallet()->getBalance());
        $this->assertEquals(5, $person2->getWallet()->getBalance());
    }

    public function testTransfertFundDifferentCurrency(): void
    {
        $person = new Person('John Doe', 'USD');
        $person2 = new Person('Jane Doe', 'EUR');
        $person->getWallet()->setBalance(10);
        $this->assertEquals(10, $person->getWallet()->getBalance());
        $this->assertEquals(0, $person2->getWallet()->getBalance());
        $this->expectException(\Exception::class);
        $person->transfertFund(5, $person2);
    }

    public function testDivideWallet(): void
    {
        $person = new Person('John Doe', 'USD');
        $person->getWallet()->setBalance(10);
        $person2 = new Person('Jane Doe', 'USD');
        $person3 = new Person('Jack Doe', 'USD');
        $person4 = new Person('Jill Doe', 'USD');
        $this->assertEquals(10, $person->getWallet()->getBalance());
        $this->assertEquals(0, $person2->getWallet()->getBalance());
        $this->assertEquals(0, $person3->getWallet()->getBalance());
        $this->assertEquals(0, $person4->getWallet()->getBalance());

        $person->divideWallet([$person2, $person3, $person4]);
        $this->assertEquals(0, $person->getWallet()->getBalance());
        $this->assertEquals(3.34, $person2->getWallet()->getBalance());
        $this->assertEquals(3.33, $person3->getWallet()->getBalance());
        $this->assertEquals(3.33, $person4->getWallet()->getBalance());
    }

    public function testBuyProduct(): void
    {
        $person = new Person('John Doe', 'USD');
        $person->getWallet()->setBalance(10);
        $this->assertEquals(10, $person->getWallet()->getBalance());
        $product = new Product('Product 1', ['USD' => 3], 'food');
        $person->buyProduct($product);
        $this->assertEquals(7, $person->getWallet()->getBalance());
        $person->buyProduct($product);
        $this->assertEquals(4, $person->getWallet()->getBalance());
    }

    public function testBuyProductWrongCurrency(): void
    {
        $person = new Person('John Doe', 'USD');
        $person->getWallet()->setBalance(10);
        $this->assertEquals(10, $person->getWallet()->getBalance());
        $product = new Product('Product 1', ['EUR' => 3], 'food');
        $this->expectException(\Exception::class);
        $person->buyProduct($product);
    }
}
