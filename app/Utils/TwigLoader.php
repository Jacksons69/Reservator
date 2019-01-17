<?php

require_once __DIR__.'/../vendor/autoload.php';

class TwigLoader {

    private $loader = '';
    private $twig = '';

    public function __construct() {
        $this->loader = new Twig_Loader_Filesystem(__DIR__.'/../Views');
        $this->twig = new Twig_Environment($this->loader);
    }

   public function getTwigTemplate ($name, $args = []) {
       
        $template = $this->twig->load($name.'.html.twig');
        echo $template->render($args);
   }
   
    public function getLoader()
    {
        return $this->loader;
    }


    public function setLoader($loader)
    {
        $this->loader = $loader;

        return $this;
    }

  
    public function getTwig()
    {
        return $this->twig;
    }

   
    public function setTwig($twig)
    {
        $this->twig = $twig;

        return $this;
    }
}