# Filter
Filter component

## Install

`composer require alonity/filter`

### Examples
```php
use alonity\filter\Filters;

require('vendor/autoload.php');

$filterHost = Filters::server('HTTP_HOST', '[^a-z0-9\.\-]')->get();

$filterArray = Filters::getArray([
    'example' => [
        'regexp' => '[^\d]'
    ],
    'test' => [
        'regexp' => '[^\w]',
        'maxLength' => 10
    ]
]);

$results = $filterArray->get();
```

Documentation: https://alonity.gitbook.io/alonity/components/filter