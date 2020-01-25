# Subscribe to Facebook webhook

This is the bare minimum code that your server needs to subscribe to a facebook webhook.

```php
$token = 'YOUR_TOKEN_HERE';

// Check if subscribtion request
if($_GET['hub_mode'] == 'subscribe'){

    // Verify token
    if($_GET['hub_verify_token'] != $token){
        die;
    }

    // Response code has to be 200
    http_response_code(200);

    // Return the hub_challenge value
    echo $_GET['hub_challenge'];
}
```

#### Enjoy!