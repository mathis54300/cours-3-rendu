<?php

namespace Tests\Entity;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    public function testConstruct(): void
    {
        $wallet = new Wallet('USD');
        $this->assertEquals(0, $wallet->getBalance());
        $this->assertEquals('USD', $wallet->getCurrency());
    }

    public function testGetBalance(): void
    {
        $wallet = new Wallet('USD');
        $this->assertEquals(0, $wallet->getBalance());
    }

    public function testGetCurrency(): void
    {
        $wallet = new Wallet('USD');
        $this->assertEquals('USD', $wallet->getCurrency());
    }

    public function testSetBalance(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $this->assertEquals(100, $wallet->getBalance());
    }

    public function testSetBalanceNegative(): void
    {
        $wallet = new Wallet('USD');
        $this->expectException(\Exception::class);
        $wallet->setBalance(-100);
    }

    public function testSetCurrency(): void
    {
        $wallet = new Wallet('USD');
        $this->assertEquals('USD', $wallet->getCurrency());
        $wallet->setCurrency('EUR');
        $this->assertEquals('EUR', $wallet->getCurrency());
    }

    public function testSetCurrencyInvalid(): void
    {
        $wallet = new Wallet('USD');
        $this->expectException(\Exception::class);
        $wallet->setCurrency('INVALID');
    }

    public function testRemoveFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $wallet->removeFund(60);
        $this->assertEquals(40, $wallet->getBalance());
    }

    public function testRemoveFundNegative(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $this->expectException(\Exception::class);
        $wallet->removeFund(-60);
    }

    public function testRemoveFundInsufficient(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $this->expectException(\Exception::class);
        $wallet->removeFund(160);
    }

    public function testAddFund(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $wallet->addFund(60);
        $this->assertEquals(160, $wallet->getBalance());
    }

    public function testAddFundNegative(): void
    {
        $wallet = new Wallet('USD');
        $wallet->setBalance(100);
        $this->expectException(\Exception::class);
        $wallet->addFund(-60);
    }
}
