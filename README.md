# PHP A/B Tests - ABRouter-php-client

AbrPHPClient :construction_worker_woman: is a PHP library to run ab-tests via ABRouter.

You're welcome to [visit the docs](https://docs.abrouter.com).

# What is the ABRouter service ? 

[ABRouter](https://abrouter.com) is the service to manage experiments(ab-tests). The service provides easy to manage dashboard to get experiments under control.
There you can create experiments, branches and set a percentage for every branch. Then, when you're running an ab-test on PHP you will receive a perfect branch-wise response that following the rules, that you set up.

Can be also used as a feature flag or feature toggle and open-source.
Available for free. 

## :package: Install
Via composer

``` bash
$ composer require abrouter/abrouter-php-client
```

## :rocket: Usage

Client is uses [PHP-DI](https://github.com/PHP-DI/PHP-DI) for DI. If you're uses own DI, you must to configure it in a such way as on example below. 
If you're not uses any DI, let's move php-di from dev-dependency to dependency:
``` bash
$ composer require "php-di/php-di": "^6.0"
```

### Using with PHP-DI

```php
use Abrouter\Client\Config\Config;
use DI\ContainerBuilder;
use Abrouter\Client\Client;

require '/app/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$di = $containerBuilder->build();

$token = '04890788ba2c89c4ff21668c60838a00a87b1cf42c9c6b45d6aa8e11174f0d5762b16b6c09b6b822'; //you can find your token in ABRouter dashboard

$di->set(Config::class, new Config($token, 'https://abrouter.com'));
/**
 * @var Client $client
 */
$client = $di->make(Abrouter\Client\Client::class);
$userSignature = uniqid();
$experimentId = 'B95AC000-0000-0000-00005030';//experiment id is also there


$runExperimentResult = $client->experiments()->run($userSignature, $experimentId);
$experimentId = $runExperimentResult->getExperimentId(); //form-color
$branchId = $runExperimentResult->getBranchId(); //red
echo '<button style="color: '. $branchId .'">Hello</button>';
```

You can create an experiment and get your token and id of experiment on [ABRouter](https://abrouter.com) or just read the [docs](https://abrouter.com/en/docs). 

## :white_check_mark: Testing
Requires docker-compose and docker installed.

``` bash
$ make up
$ make test-run
```

## :wrench: Contributing

Please feel free to fork and sending Pull Requests. This project follows [Semantic Versioning 2](http://semver.org) and [PSR-2](http://www.php-fig.org/psr/psr-2/).

## :page_facing_up: License

GPL3. Please see [License File](LICENSE) for more information.
