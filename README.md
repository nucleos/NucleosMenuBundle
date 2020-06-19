NucleosMenuBundle
=================
[![Latest Stable Version](https://poser.pugx.org/nucleos/menu-bundle/v/stable)](https://packagist.org/packages/nucleos/menu-bundle)
[![Latest Unstable Version](https://poser.pugx.org/nucleos/menu-bundle/v/unstable)](https://packagist.org/packages/nucleos/menu-bundle)
[![License](https://poser.pugx.org/nucleos/menu-bundle/license)](LICENSE.md)

[![Total Downloads](https://poser.pugx.org/nucleos/menu-bundle/downloads)](https://packagist.org/packages/nucleos/menu-bundle)
[![Monthly Downloads](https://poser.pugx.org/nucleos/menu-bundle/d/monthly)](https://packagist.org/packages/nucleos/menu-bundle)
[![Daily Downloads](https://poser.pugx.org/nucleos/menu-bundle/d/daily)](https://packagist.org/packages/nucleos/menu-bundle)

[![Continuous Integration](https://github.com/nucleos/MenuBundle/workflows/Continuous%20Integration/badge.svg)](https://github.com/nucleos/MenuBundle/actions)
[![Code Coverage](https://codecov.io/gh/nucleos/NucleosMenuBundle/branch/main/graph/badge.svg)](https://codecov.io/gh/nucleos/NucleosMenuBundle)

This bundle provides services for defining static menus for symfony applications.

## Installation

Open a command console, enter your project directory and execute the following command to download the latest stable version of this bundle:

```
composer require nucleos/menu-bundle
```

### Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles in `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Nucleos\MenuBundle\NucleosMenuBundle::class => ['all' => true],
];
```

## Usage

Create a configuration file called `nucleos_menu.yaml`:

```yaml
# config/packages/nucleos_menu.yaml

nucleos_menu:
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

