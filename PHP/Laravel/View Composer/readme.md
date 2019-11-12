# View Composer
#### Usage 
pass veriables to multiple specified views without the need to declare them multiple times.

#### Example
You need a `$logo` variable on multiple views, you would have to specify it in all the different controllers.
This can be achieved with a `View Composer` (a static function of View) inside of a `Service Provider`.

The composer function accepts 2 parameters, the first one is an `array of views` you want to pass the variables to, the second parameter is a `callback function` that will that will be called before the view is loaded.

In this callback function we can accept the `$view` parameter representing the view currently being loaded. Now we can call the `$view->with()` to pass the variable to the view. The first parameter of this function is the `variable name` that you want to use in the view and the second parameter is `the actual data` you want to pass.
```php
// AppServiceProvider.php

...
use App\Logo;
use Illuminate\Support\Facades\View;
...

public function boot()
{
    View::composer(["view1", "view2", "view3"], function($view){
        $view->with("logo", Logo::getLogo());
    });
}
```

#### Test
```php
// TestController.php
public function test(){
    return view("test");
}
```

```php
// test.blade.php

{{ dd($logo) }}
```

This should output the data of your test variable