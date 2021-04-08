<?php

declare(strict_types=1);

namespace CommissionTask\Repository;

use CommissionTask\Contract\Repository as RepositoryInterface;
use CommissionTask\Model\Rate as RateModel;

class Rate implements RepositoryInterface
{
    /**
     * @var RateModel[]
     */
    private array $rates = [];

    /**
     * @return RateModel[]
     */
    public function getALl(): array
    {
        return $this->rates;
    }

    /**
     * @param string $baseCurrency
     * @param string $quoteCurrency
     *
     * @return RateModel|null
     */
    public function getRateByCodesOrNull(string $baseCurrency, string $quoteCurrency): ?RateModel
    {
        foreach ($this->getALl() as $rate) {
            if ($rate->getBaseCurrency() === $baseCurrency && $rate->getQuoteCurrency() === $quoteCurrency) {
                return $rate;
            }
        }

        return null;
    }

    /**
     * @param RateModel $rate
     *
     * @return $this
     */
    public function add(RateModel $rate): Rate
    {
        if (is_null($this->getRateByCodesOrNull($rate->getBaseCurrency(), $rate->getQuoteCurrency()))) {
            $this->rates[] = $rate;
        }

        return $this;
    }
}