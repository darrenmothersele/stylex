Stylex 
------

Creating prototypes or style guides with Silex and Twig.

See [this blog post](http://www.darrenmothersele.com/blog/2015/03/20/stylex-prototype-style-guide-tool/) for more details.

I've created a [Barbones](https://github.com/darrenmothersele/stylex-barebones) project that
demonstrates how to get started.

## Features

Create a style-guide or prototype front end code using Twig templates. Use YAML format to define sample data and content.

 * Create an atomic design (component-based design) using the power of Twig
 * Separate sample content out from your front-end markup
 * Reuse templates later in your process
 * Fully test front-end code before handing over to dev

## Getting started

Assuming you already
have [Composer installed globally](https://getcomposer.org/doc/00-intro.md#globally) 
all you need to do is create a folder for your
project and run the following command:

```
composer require darrenmothersele/stylex dev-master
```

This will download Stylex from Github and all the dependencies. It creates the 
`composer.json` file for you and downloads all the code for the dependencies into
a `vendor` folder. 

As a bare minimum you will need to create a `index.php` to run the application, and 
a starter template `templates/index.html`. 


Create a file in the project root (same location as the generated `composer.json` file)
called `index.php` with the following code:

```
<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = new Stylex\Application();
$app->run();
```

Then create a `templates` folder and create the first page template, `templates/index.html` in this folder:

```
<html>
  <head>
    <title>Hello!</title>
  </head>
  <body>
    {% block content %}
      <h1>Hello, world!</h1>
    {% endblock %}
  </body>
</html>
```

You can run the application with PHP's build in web server. Simply run the following command:

```
php -S localhost:8000
```

Now, browse to `http://localhost:8000` to see the website.
