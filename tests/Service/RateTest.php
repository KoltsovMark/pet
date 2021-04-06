<?php

declare(strict_types=1);

namespace CommissionTask\Tests\Service;

use CommissionTask\Exception\RateDoNotExist as RateDoNotExistException;
use CommissionTask\Factory\Rate as RateFactory;
use CommissionTask\Repository\Rate as RateRepository;
use CommissionTask\Service\Math as MathService;
use CommissionTask\Service\Rate as RateService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class RateTest extends TestCase
{
    protected RateService $rateService;
    protected MathService $mathServiceMock;
    protected RateRepository $rateRepositoryMock;
    protected RateFactory $rateFactory;
    protected RateFactory $rateFactoryMock;

    /**
     * @covers \CommissionTask\Service\Rate::getDefaultRatesArray
     */
    public function testGetDefaultRatesArray()
    {
        $class = new ReflectionClass(RateService::class);

        $method = $class->getMethod('getDefaultRatesArray');
        $method->setAccessible(true);

        $defaultRatesConstant = $class->getConstant('DEFAULT_RATES');

        $defaultRates = $method->invokeArgs($this->rateService, []);

        $this->assertEquals($defaultRatesConstant, $defaultRates);
    }

    /**
     * @covers \CommissionTask\Service\Rate::isRateSupported
     */
    public function testIsRateSupportedTrue()
    {
        $baseCurrency = 'EUR';
        $quoteCurrency = 'USD';
        $expectedRate = $this->rateFactory->create($baseCurrency, $quoteCurrency, '1.23');

        $this->rateRepositoryMock
            ->expects($this->once())
            ->method('getRateByCodesOrNull')
            ->with(...[$baseCurrency, $quoteCurrency])
            ->willReturn($expectedRate)
        ;

        $this->assertTrue($this->rateService->isRateSupported($baseCurrency, $quoteCurrency));
    }

    /**
     * @covers \CommissionTask\Service\Rate::isRateSupported
     */
    public function testIsRateSupportedFalse()
    {
        $baseCurrency = 'EUR';
        $quoteCurrency = 'USD';

        $this->rateRepositoryMock
            ->expects($this->once())
            ->method('getRateByCodesOrNull')
            ->with(...[$baseCurrency, $quoteCurrency])
            ->willReturn(null)
        ;

        $this->assertFalse($this->rateService->isRateSupported($baseCurrency, $quoteCurrency));
    }

    /**
     * @covers \CommissionTask\Service\Rate::getRateByCodesOrTrow
     */
    public function testGetRateByCodesOrTrow()
    {
        $rateServicePartialMock = $this->createPartialMock(RateService::class, ['isRateSupported']);
        $class = new ReflectionClass(RateService::class);
        $property = $class->getProperty('rateRepository');
        $property->setAccessible(true);
        $property->setValue($rateServicePartialMock, $this->rateRepositoryMock);

        $baseCurrency = 'EUR';
        $quoteCurrency = 'USD';
        $expectedRate = $this->rateFactory->create($baseCurrency, $quoteCurrency, '1.23');

        $rateServicePartialMock
            ->expects($this->once())
            ->method('isRateSupported')
            ->with(...[$baseCurrency, $quoteCurrency])
            ->willReturn(true)
        ;

        $this->rateRepositoryMock
            ->expects($this->once())
            ->method('getRateByCodesOrNull')
            ->with(...[$baseCurrency, $quoteCurrency])
            ->willReturn($expectedRate)
        ;

        $rate = $rateServicePartialMock->getRateByCodesOrTrow($baseCurrency, $quoteCurrency);

        $this->assertEquals($expectedRate, $rate);
    }

    /**
     * @covers \CommissionTask\Service\Rate::getRateByCodesOrTrow
     */
    public function testGetRateByCodesOrTrowRateNotFound()
    {
        $rateServicePartialMock = $this->createPartialMock(RateService::class, ['isRateSupported']);

        $baseCurrency = 'EUR';
        $quoteCurrency = 'USD';

        $rateServicePartialMock
            ->expects($this->once())
            ->method('isRateSupported')
            ->with(...[$baseCurrency, $quoteCurrency])
            ->willReturn(false)
        ;

        $this->expectException(RateDoNotExistException::class);

        $rateServicePartialMock->getRateByCodesOrTrow($baseCurrency, $quoteCurrency);
    }

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->mathServiceMock = $this->createMock(MathService::class);
        $this->rateRepositoryMock = $this->createMock(RateRepository::class);
        $this->rateFactoryMock = $this->createMock(RateFactory::class);
        $this->rateService = new RateService(
            $this->mathServiceMock,
            $this->rateRepositoryMock,
            $this->rateFactoryMock
        );

        $this->rateFactory = new RateFactory();
    }
}