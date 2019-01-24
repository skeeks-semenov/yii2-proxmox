ProxmoxVE API Client for yii2
================

[![Latest Stable Version](https://img.shields.io/packagist/v/skeeks/yii2-proxmox.svg)](https://packagist.org/packages/skeeks/yii2-proxmox)
[![Total Downloads](https://img.shields.io/packagist/dt/skeeks/yii2-proxmox.svg)](https://packagist.org/packages/skeeks/yii2-proxmox)

Installation
------------

```sh
$ composer require skeeks/yii2-proxmox "*"
```

Or add this to your `composer.json` file:

```json
{
    "require": {
        "skeeks/yii2-proxmox": "*"
    }
}
```

Usage
-----

Config:

```php

    'proxmox' => [
        'class'     => 'skeeks\proxmox\ProxmoxComponent',
        'hostname'  => 'server1.proxmox.com',
        'username'  => 'root',
        'password'  => 'password',
        //'realm'     => 'pam', //pve
        //'port'      => '8006',
    ],

    'proxmox2' => [
        'class'     => 'skeeks\proxmox\ProxmoxComponent',
        'hostname'  => 'server2.proxmox.com',
        'username'  => 'root',
        'password'  => 'password',
        //'realm'     => 'pam', //pve
        //'port'      => '8006',
    ],

````

Usage:

```php

if (\Yii::$app->proxmox->api)
{
    $allNodes = \Yii::$app->proxmox->api->get('/nodes');
    print_r($allNodes);
} else
{
    //\Yii::$app->proxmox->error — \Exception
    \Yii::$app->proxmox->error->getMessage();
}


if (\Yii::$app->proxmox2->api)
{
    \Yii::$app->proxmox2->api->get('/nodes');
}

....

````


Sample output:

```php
Array
(
    [data] => Array
        (
            [0] => Array
                (
                    [disk] => 2539465464
                    [cpu] => 0.031314446882002
                    [maxdisk] => 30805066770
                    [maxmem] => 175168446464
                    [node] => mynode1
                    [maxcpu] => 24
                    [level] =>
                    [uptime] => 139376
                    [id] => node/mynode1
                    [type] => node
                    [mem] => 20601992182
                )

        )

)
```

```php
// It is common to fetch images and then use base64 to display the image easily in a webpage
\Yii::$app->proxmox->api->setResponseType('pngb64'); // Sample format: data:image/png;base64,iVBORw0KGgoAAAA...
$base64 = \Yii::$app->proxmox->api->get('/nodes/hosting4-skeeks/rrd', ['ds' => 'cpu', 'timeframe' => 'day']);
// So we can do something like this
echo "<img src='{$base64}' \>";
```

```php
// Ask for nodes, gives back a PHP string with HTML response
\Yii::$app->proxmox->api->get('/nodes');

// Change response type to JSON
\Yii::$app->proxmox->api->setResponseType('json');

// Now asking for nodes gives back JSON raw string
\Yii::$app->proxmox->api->get('/nodes');

// If you want again return PHP arrays you can use the 'array' format.
\Yii::$app->proxmox->api->setResponseType('array');

// Also you can call getResponseType for whatever reason you have
$responseType = \Yii::$app->proxmox->api->getResponseType();  // array
```


Docs
----

On your proxmox client object you can use `get()`, `create()`, `set()` and `delete()` functions for all resources specified at [PVE2 API Documentation], params are passed as the second parameter in an associative array.

**What resources or paths can I interact with and how?**

In your proxmox server you can use the [pvesh CLI Tool](http://pve.proxmox.com/wiki/Proxmox_VE_API#Using_.27pvesh.27_to_access_the_API) to manage all the pve resources, you can use this library in the exact same way you would use the pvesh tool. For instance you could run `pvesh` then, as the screen message should say, you can type `help [path] [--verbose]` to see how you could use a path and what params you should pass to it. Be sure to [read about the pvesh CLI Tool](http://pve.proxmox.com/wiki/Proxmox_VE_API#Using_.27pvesh.27_to_access_the_API) at the [Proxmox wiki].


___

> [![skeeks!](https://skeeks.com/img/logo/logo-no-title-80px.png)](https://skeeks.com)  
<i>SkeekS CMS (Yii2) — fast, simple, effective!</i>  
[skeeks.com](https://skeeks.com) | [cms.skeeks.com](https://cms.skeeks.com)

