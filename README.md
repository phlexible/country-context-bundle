PhlexibleCountryContextBundle
=============================

The PhlexibleCountryContextBundle adds support for country-based content support in phlexible.

Installation
------------

Installation is a 5 step process:

1. Download PhlexibleCountryContextBundle using composer
2. Enable the Bundle
3. Configure the PhlexibleCountryContextBundle
4. Update your database schema
5. Clear the symfony cache

### Step 1: Download PhlexibleCountryContextBundle using composer

Add PhlexibleCountryContextBundle by running the command:

``` bash
$ php composer.phar require phlexible/country-context-bundle "~1.0.0"
```

Composer will install the bundle to your project's `vendor/phlexible` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Phlexible\Bundle\CountryContextBundle\PhlexibleCountryContextBundle(),
    );
}
```

### Step 3: Configure the PhlexibleCountryContextBundle

Now that the bundle is enabled, you need to configure the PhlexibleCountryContextBundle.
Add the following configuration to your config.yaml file.

``` yaml
# app/config/config.yaml
phlexible_country_context:
    countries:
        gb:
            continent: eu
            country: gb
            languages:
                en: {locale: en, expose: true}
                
phlexible_tree:
    router:
        url_generator_service: "phlexible_country_context.router.country_aware_url_generator"
        request_matcher_service: "phlexible_country_context.router.country_aware_request_matcher"
```

### Step 4: Update your database schema

Now that the bundle is set up, the last thing you need to do is update your database schema because the country context bundle includes entities that need to be installed in your database.

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

### Step 5: Clear the symfony cache

If you access your phlexible application with environment prod, clear the cache:

``` bash
$ php app/console cache:clear --env=prod
```
