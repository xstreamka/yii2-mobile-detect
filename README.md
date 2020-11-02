Device detect for Yii2
===================
Mobile_Detect class for Yii2 with the ability to add new devices.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist xstreamka/yii2-mobile-detect "*"
```

or add

```
"xstreamka/yii2-mobile-detect": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by:

```php
xstreamka\mobiledetect\Device::$isPhone;
```


Add new device (your list of devices)
-----

Configure the component in your configuration file (`frontend/config/main.php`):

```php
'components' => [
    ...
    'device' => [
        'class' => 'xstreamka\mobiledetect\Device',
        'tablet' => ['SM-T975'], // Array of users' tablets devices.
        'phone' => [] // Array of users' phone devices.
    ],
    ...
]
```

Tools
-----

```php
Device::$isMobile;  // Mobile: Tablet or Phone.
Device::$isTablet;  // Tablet
Device::$isPhone;   // Phone
Device::$isIphone;  // iPhone
Device::$isSamsung; // Samsung
Device::$info;      // About device (HTTP_USER_AGENT)

// Device::$detect === Mobile_Detect()
Device::$detect->isTablet();
Device::$detect->isMobile();
...
Device::$detect->isiOS();
// more here: https://github.com/serbanghita/Mobile-Detect/wiki/Code-examples
```

Example
-----

```php
<?php
use xstreamka\mobiledetect\Device;
...
?>
<h1>Hello World</h1>
...
<?php if (Device::$isPhone) { ?>
<p>text for phone devices</p>
<?php } elseif (Device::$isTablet) { ?>
<p>text for tablet devices</p>
<?php } else { ?>
<p>text for other devices</p>
<?php } ?>
...
```
