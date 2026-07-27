# Changelog

## [3.0.0](https://github.com/compwright/graphql-php-jetpack/compare/v2.3.0...v3.0.0) (2026-07-27)


### ⚠ BREAKING CHANGES

* Drop support for PHP < 8.3

### Bug Fixes

* Fix lint warnings ([acb7220](https://github.com/compwright/graphql-php-jetpack/commit/acb7220b611b769ec35237fda8b46b65578b6019))
* Support millisecond/nanosecond timestamp precision ([47012cc](https://github.com/compwright/graphql-php-jetpack/commit/47012cc8b44571967db5f204d0c01c9c4ae94754))


### Miscellaneous Chores

* Drop support for PHP &lt; 8.3 ([5002680](https://github.com/compwright/graphql-php-jetpack/commit/5002680f3a2364aa04e9f7cb4817914379c772ff))

## [2.3.0](https://github.com/compwright/graphql-php-jetpack/compare/v2.2.1...v2.3.0) (2025-01-30)


### Features

* support PHP 8.4 ([eb69021](https://github.com/compwright/graphql-php-jetpack/commit/eb690210914b961eef90807b0a98a74bacdfa73d))

## [2.2.1](https://github.com/compwright/graphql-php-jetpack/compare/v2.2.0...v2.2.1) (2024-02-22)


### Bug Fixes

* **scalars:** email scalar should accept blank values ([117814e](https://github.com/compwright/graphql-php-jetpack/commit/117814e0eb969f3bc1bd393242c5988cbd155b4b))

## [2.2.0](https://github.com/compwright/graphql-php-jetpack/compare/v2.1.2...v2.2.0) (2024-02-20)


### Features

* **scalars:** add Latitude and Longitude scalars ([360a095](https://github.com/compwright/graphql-php-jetpack/commit/360a095166a456e142f38184a91ad7be8f638e75))

## [2.1.2](https://github.com/compwright/graphql-php-jetpack/compare/v2.1.1...v2.1.2) (2024-02-13)


### Bug Fixes

* **scalars:** US State and Zipcode scalars should accept blank values ([b7b056b](https://github.com/compwright/graphql-php-jetpack/commit/b7b056bf4f146b32df401b51ee8518e3760e6a89))

## [2.1.1](https://github.com/compwright/graphql-php-jetpack/compare/v2.1.0...v2.1.1) (2024-02-06)


### Bug Fixes

* correctly read directive arguments of type Object ([5629942](https://github.com/compwright/graphql-php-jetpack/commit/56299429f33223b8df3e487bd407e846e4500256))

## [2.1.0](https://github.com/compwright/graphql-php-jetpack/compare/v2.0.1...v2.1.0) (2024-02-06)


### Features

* add support for argument definition directives ([#4](https://github.com/compwright/graphql-php-jetpack/issues/4)) ([e3ddbe9](https://github.com/compwright/graphql-php-jetpack/commit/e3ddbe926d8911ac579875157fde48ea21646d64))

## [2.0.1](https://github.com/compwright/graphql-php-jetpack/compare/v2.0.0...v2.0.1) (2024-02-05)


### Bug Fixes

* **directives:** fixed an error when invoking the [@callback](https://github.com/callback) directive ([f90bdab](https://github.com/compwright/graphql-php-jetpack/commit/f90bdab27a8c7fa9f5615b9a610414c1878c2715))

## [2.0.0](https://github.com/compwright/graphql-php-jetpack/compare/v1.0.0...v2.0.0) (2024-02-01)


### ⚠ BREAKING CHANGES

* vastly simplify enabling custom scalars and directives

### Features

* add PSR-7 compatible ServerRequestContext class ([750ffa6](https://github.com/compwright/graphql-php-jetpack/commit/750ffa6fc9270e646b6f1bfe65c5856dcd4e945a))
* vastly simplify enabling custom scalars and directives ([6601fe7](https://github.com/compwright/graphql-php-jetpack/commit/6601fe798d49fb35e71f8ed7ec18c7b9c11e5bdc))

## 1.0.0 (2024-01-31)


### Features

* initial version ([b1f94b1](https://github.com/compwright/graphql-php-jetpack/commit/b1f94b158827bfba4e47e6b5c2ad832a671c079b))
