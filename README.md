# Extend the Spryker Sales Module
[![Build Status](https://travis-ci.org/fond-of/spryker-sales.svg?branch=master)](https://travis-ci.org/fond-of/spryker-sales)
[![PHP from Travis config](https://img.shields.io/travis/php-v/fond-of/spryker-sales.svg)](https://php.net/)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/fond-of-spryker/sales)


   * customize OrderReferenceGenerator
   * add TaxRate in the Order Totals

## Installation

```
composer require fond-of-spryker/sales
```

## Configuration

```
$config[SalesConstants::ORDER_REFERENCE_PREFIX] = 'xxx';
$config[SalesConstants::ORDER_REFERENCE_OFFSET] = 1000;
```

Remove last separator from prefix e.g. xxx-yyy-1000 => xxx-yyy1000, xxx-1000 => xxx1000
```
$config[SalesConstants::ORDER_REFERENCE_USE_SEPARATOR_TO_CONNECT_PREFIX_TO_ORDER_NUMBER] = false;
```

## Changelog
2020-05-11 1.0.5 => added config param SalesConstants::ORDER_REFERENCE_USE_SEPARATOR_TO_CONNECT_PREFIX_TO_ORDER_NUMBER for removing last separator from prefix of order number. Default is false and it would not be removed
