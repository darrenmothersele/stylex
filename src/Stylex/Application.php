<?php

namespace Stylex;

class Application extends \Silex\Application {
  use \Silex\Application\TwigTrait;
  use \Silex\Application\UrlGeneratorTrait;

  public function __construct(array $values = []) {
    parent::__construct($values);

    // $this['debug'] = TRUE;

    // Default values
    $values += [
      'templates' => 'templates',
      'data' => 'data',
      'content' => 'content',
      'twig.options' => ['strict_variables' => FALSE],
    ];
    if ($values['debug']) {
      $this['debug'] = TRUE;
      $values['twig.options']['debug'] = TRUE;
    }

    $this->register(new \Silex\Provider\TwigServiceProvider(), array(
      'twig.path' => $values['templates'],
      'twig.options' => $values['twig.options'],
    ));    
    if ($this['debug']) {
      $this['twig']->addExtension(new \Twig_Extension_Debug());
    }
    $yaml = new \Symfony\Component\Yaml\Parser();

    // Load all data files
    if (file_exists($values['data'])) {
      $finder = new \Symfony\Component\Finder\Finder();
      $finder->files()->in($values['data'])->name('*.yml');
      foreach ($finder as $file) {
        $data = $yaml->parse($file->getContents());
        $this['twig']->addGlobal($file->getBasename('.yml'), $data);
      }
    }

    // Load all sample content
    $content = [];
    if (file_exists($values['content'])) {
      $finder = new \Symfony\Component\Finder\Finder();
      $finder->files()->in($values['content'] . '/*')->name('*.md');
      foreach ($finder as $file) {
        list(, $data, $body) = explode("---\n", $file->getContents());
        $data = $yaml->parse($data);
        $data['content'] = \Michelf\Markdown::defaultTransform($body);
        $content[basename(dirname($file->getPathname()))][] = $data; 
        $content[basename(dirname($file->getPathname()))][$file->getBasename('.md')] = $data; 
      }
    }
    $this['twig']->addGlobal('content', $content);

    // Setup the front controller
    $this->get('/{page}', function ($page) {
      $this['twig']->addGlobal('current_page', '/' . (($page == 'index') ? '' : $page));
      return $this->render($page . '.html');
    })->value('page', 'index');
  }
}
