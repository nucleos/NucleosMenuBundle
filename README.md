MenuBundle
==========
[![Latest Stable Version](https://poser.pugx.org/core23/menu-bundle/v/stable)](https://packagist.org/packages/core23/menu-bundle)
[![Latest Unstable Version](https://poser.pugx.org/core23/menu-bundle/v/unstable)](https://packagist.org/packages/core23/menu-bundle)
[![License](https://poser.pugx.org/core23/menu-bundle/license)](LICENSE.md)

[![Total Downloads](https://poser.pugx.org/core23/menu-bundle/downloads)](https://packagist.org/packages/core23/menu-bundle)
[![Monthly Downloads](https://poser.pugx.org/core23/menu-bundle/d/monthly)](https://packagist.org/packages/core23/menu-bundle)
[![Daily Downloads](https://poser.pugx.org/core23/menu-bundle/d/daily)](https://packagist.org/packages/core23/menu-bundle)

[![Continuous Integration](https://github.com/core23/MenuBundle/workflows/Continuous%20Integration/badge.svg)](https://github.com/core23/MenuBundle/actions)
[![Code Coverage](https://codecov.io/gh/core23/MenuBundle/branch/master/graph/badge.svg)](https://codecov.io/gh/core23/MenuBundle)

This bundle provides services for defining static menus for sonata.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```
composer require core23/menu-bundle
```

### Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Core23\MenuBundle\Core23MenuBundle::class => ['all' => true],
];
```

## Usage

Create a configuration file called `core23_menu.yaml`:

```yaml
# config/packages/core23_menu.yaml

core23_menu:
    groups:
        // Header menu
        header:
            name: 'Header'
            attributes:
                id: 'header-nav'

        // Footer menu
        footer:
            name: 'Footer'

        // Main menu
        main:
            name: 'Main'
            attributes:
                class: 'nav navbar-nav'
            items:
                home:
                    label: 'Home'
                    icon: 'fa fa-home'
                    route: 'app_home'
                    routeParams: { path: '/' }
                downloads:
                    label: 'Download'
                    route: 'app_download_index'
                event:
                    label: 'Event'
                    route: 'app_event_index'
                    // Submenu items
                    children:
                        venue:
                            label: 'Venue'
                            route: 'app_venue_index'
```

## License

This bundle is under the [MIT license](LICENSE.md).

