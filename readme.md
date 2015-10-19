# Oakwood Wordpress Theme Framework

[![Latest Stable Version](https://poser.pugx.org/owc/wp-theme/version)](https://packagist.org/packages/owc/wp-theme)
[![Total Downloads](https://poser.pugx.org/owc/wp-theme/downloads)](https://packagist.org/packages/owc/wp-theme)
[![License](https://poser.pugx.org/owc/wp-theme/license)](https://packagist.org/packages/owc/wp-theme)


## Installation

Add `owc/wp-theme` as a requirement to `composer.json`:

```javascript
{
    "require": {
        "owc/wp-theme": "dev-master"
    }
}
```

Update your packages with `composer update` or install with `composer install`.

You can also add the package using `composer require owc/wp-theme` and later specifying the version you want (for now, `dev-master` is your best bet).


## Documentation

* [Getting Started](#getting-started)
* [Theme](#theme)
* [Admin](#admin)
* [Cron](#cron)


## Getting Started

Oakwood Wordpress Theme Framework offers 3 main abstract classes to extend:

```php
Oakwood\AbstractTheme; # Handles theme related filters, actions & functions
Oakwood\AbstractAdmin; # Handles Wordpress admin related filters, actions & functions
Oakwood\AbstractCron;  # Handles background jobs for Wordpress
```


## Theme

To implement the Theme class extend Oakwood\AbstractTheme in you theme.
Preferably in /wp-content/themes/[your-theme]/src/[your-namespace]/Theme.php

```php
namespace MyNamespace;

class Theme extends \Oakwood\AbstractTheme {

	public function get_filters( $filters = array() ) {
		// $filters['wordpress_filter'] => 'my_filter';
		
		// return your custom theme filters
		return $filters;
	}

	public function get_actions( $actions = array() ) {
		// $actions['wordpress_action'] => 'my_action';
		
		// return your custom theme actions
		return $actions;
	}

	public function get_widgets( $widgets = array() ) {
		// $widgets['MyWidget'] => true;
		
		// return your custom theme widgets
		return $widgets;
	}

	public function get_styles( $styles = array() ) {
		// $styles['my_css'] => 'path/to/my/css';
		
		// return your custom theme styles
		return $styles;
	}

	public function get_scripts( $scripts = array() ) {
		// $scripts['my_js'] => 'path/to/my/js';
		
		// return your custom theme scripts
		return $scripts;
	}

}
```


## Admin

To implement the Admin class extend Oakwood\AbstractAdmin in you theme.
Preferably in /wp-content/themes/[your-theme]/src/[your-namespace]/Admin.php

```php
namespace MyNamespace;

class Admin extends \Oakwood\AbstractAdmin {

	public function get_filters( $filters = array() ) {
		// $filters['wordpress_filter'] => 'my_filter';
		
		// return your custom theme filters
		return $filters;
	}

	public function get_actions( $actions = array() ) {
		// $actions['wordpress_action'] => 'my_action';
		
		// return your custom theme actions
		return $actions;
	}

}
```


## Cron

To implement the Cron class extend Oakwood\AbstractCron in you theme.
Preferably in /wp-content/themes/[your-theme]/src/[your-namespace]/Cron.php

The class creates four schedules:
* 15min_schedule
* hourly_schedule
* twicedaily_schedule
* daily_schedule

Add your functions and hook them to a schedule in the get_actions method.

```php
namespace MyNamespace;

class Admin extends \Oakwood\AbstractCron {

	public function get_actions( $actions = array() ) {
		$actions['will_run_daily'] => 'daily_schedule';

		return $actions;
	}

	public function will_run_daily() {
		update_option( 'ran_daily', current_time( 'mysql' ) );
	}

}
```