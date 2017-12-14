What is MenuBundle?
=============================
[![Latest Stable Version](https://poser.pugx.org/core23/menu-bundle/v/stable)](https://packagist.org/packages/core23/menu-bundle)
[![Latest Unstable Version](https://poser.pugx.org/core23/menu-bundle/v/unstable)](https://packagist.org/packages/core23/menu-bundle)
[![License](https://poser.pugx.org/core23/menu-bundle/license)](https://packagist.org/packages/core23/menu-bundle)

[![Build Status](https://travis-ci.org/core23/MenuBundle.svg)](https://travis-ci.org/core23/MenuBundle)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/core23/MenuBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/core23/MenuBundle)
[![Coverage Status](https://coveralls.io/repos/core23/MenuBundle/badge.svg)](https://coveralls.io/r/core23/MenuBundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/93fa4576-c116-4c20-a972-9270e90a4383/mini.png)](https://insight.sensiolabs.com/projects/37449e7c-132b-424c-a9ec-97a5e99a0bf0)

[![Donate to this project using Flattr](https://img.shields.io/badge/flattr-donate-yellow.svg)](https://flattr.com/profile/core23)
[![Donate to this project using PayPal](https://img.shields.io/badge/paypal-donate-yellow.svg)](https://paypal.me/gripp)

This bundle provides services for defining static menus for sonata.

### Installation

```
php composer.phar require core23/menu-bundle
```

### Enabling the bundle

```php
    // app/AppKernel.php

    public function registerBundles()
    {
        return array(
            // ...

            new Core23\MenuBundle\Core23MenuBundle(),

            // ...
        );
    }
```

This bundle is available under the [MIT license](LICENSE.md).

