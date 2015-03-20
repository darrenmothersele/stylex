<?php

namespace Stylex;

class Application extends \Silex\Application {
  use \Silex\Application\TwigTrait;
  use \Silex\Application\UrlGeneratorTrait;

  public function __construct(array $values = []) {
    parent::__construct($values);

    $this->get('/{page}', function ($page) {
      return 'Hello ' . $this->escape($page);
    })->value('page', 'index');
  }
}
