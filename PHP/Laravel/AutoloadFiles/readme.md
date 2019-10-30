# Autoloading Files
Usage example: you want to declare a global function to use anywhere (Ex. in a blade file). You will be able to use the function without using "require".

### How to use
First you need to create a file anywhere in your directory. For this example we will create a file called "example.php" in the "app" directory.

```php
<?php

function example(){
    return "Hello World!";
}
```
Now how would you go about using this function in a blade file?There is no way (that I know of) to achieve this without autoloading.

So let's setup autoloading for this file.

First you need to alter the composer.json file, find the autoload section and (if it's not already there) add a new attribute: "files", as the value of the attribute you have to specify the path to the file you want to autoload.

```json
{
    ...
    "autoload": {
            "psr-4": {
                "App\\": "app/"
            },
            ...
            "files": [
                "app/example.php"
            ]
    }
    ...
}
```

We're not finished yet, we still need to update composer's autoload_classmap.php (vendor/composer/autoload_classmap.php) which houses an array of aliasses and files based on the autoload section in composer.json. To update the file with the changes you've made you can use the following command.

```
composer dump-autoload
```

Now you will be able to use your file everywhere in your project.

### Test
Let's test if our example function works in a blade file.

```html
{{ example() }}
```

output

```
Hello World!
```

#### Enjoy!