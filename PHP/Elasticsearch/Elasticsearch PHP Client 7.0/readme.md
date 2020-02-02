# Elasticsearch PHP Client 7.0

> [Documentation](https://www.elastic.co/guide/en/elasticsearch/reference/current/index.html)

## Install

``` 
composer require elasticsearch/elasticsearch 7.0
```

## Build

### Server

``` php
use Elasticsearch\ClientBuilder;

$hosts = [
    // This is effectively equal to: "https://username:password!#$?*abc@foo.com:9200/elastic"
    [
        'host' => 'foo.com',
        'port' => '9200',
        'scheme' => 'https',
        'path' => '/elastic',
        'user' => 'username',
        'pass' => 'password!#$?*abc'
    ],
    // This is equal to "http://localhost:9200/"
    [
        'host' => 'localhost',    // Only host is required
    ]
]

$client = ClientBuilder::create()->setHosts($hosts)->build();
```

### Elastic Cloud

#### Basic auth

``` php
$client = ClientBuilder::create()
            ->setElasticCloudId('<elastic-cloud-id>')  
            ->setBasicAuthentication('<username>', '<secure-password>') 
            ->build();
```

#### Api key

``` php
$client = ClientBuilder::create()
            ->setElasticCloudId('<elastic-cloud-id>') 
            ->setApiKey('<id>', '<api_key>') 
            ->build();
```

## Documents

### Create (Index)
``` php
$response = $client->index([
    'index' => 'sample-index',
    'id' => 'sample-id',
    'body' => [
        'title' => 'Sample title',
        'text' => 'Sample text',
        'other-field' => 'this is a sample value',
    ]
]);
```


### Read (Search)

#### Simple search
``` php
$response = $client->search([
    'index' => 'sample-index',
    'body' => [
        'query' => [
            'match' => [
                'title' => $search_term
            ]
        ]
    ]
]);
```

#### Add options to query field

``` php
$response = $client->search([
    'index' => 'sample-index',
    'body' => [
        'query' => [
            'match' => [ [
                'title' => [
                    'query' => $search_term,
                    'zero_terms_query' => 'all',
                    'fuzziness' => 'auto'
                ]
            ]
        ]
    ]
]);
```

With fuzziness you can change how many characters a result term can differ from the term, you can also change the default transposition (ab -> ba) behavior.

> Read more about fuzziness [here](https://www.elastic.co/guide/en/elasticsearch/reference/current/common-options.html#fuzziness)
and [here](https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html#query-dsl-match-query-fuzziness)




### Update

TODO

### Delete

#### Delete an index
``` php
$response = $client->delete([
    'index' => 'sample-index'
]);
```

#### Delete a document

``` php
$response = $client->delete([
    'index' => 'test-index',
    'id' => 'test-id'
]);
```

## Logging
```
composer require monolog/monolog
```


``` php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('name');
$logger->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

$client = ClientBuilder::create()       // Instantiate a new ClientBuilder
            ->setLogger($logger)        // Set your custom logger
            ->build();                  // Build the client object
```

## Change the serializer
``` php
$serializer = '\Elasticsearch\Serializers\SmartSerializer';
$client = ClientBuilder::create()
            ->setSerializer($serializer)
            ->build();
```