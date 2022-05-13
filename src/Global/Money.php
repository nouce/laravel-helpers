<?php

namespace Nouce\LaravelHelpers\Global;

use Money\Money as MoneyMoney;
use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Parser\DecimalMoneyParser;
use Money\Formatter\DecimalMoneyFormatter;

class Money {
    public static function parse($amount, $currency = 'EUR')
    {
        $currencies = new ISOCurrencies();
        $moneyParser = new DecimalMoneyParser($currencies);
        $money = $moneyParser->parse($amount, new Currency($currency));

        return $money->getAmount();
    }

    public static function format($amount, $currency = 'EUR')
    {
        $money = new MoneyMoney($amount, new Currency($currency));
        $currencies = new ISOCurrencies();
        $moneyFormatter = new DecimalMoneyFormatter($currencies);

        return $moneyFormatter->format($money);
    }
}
