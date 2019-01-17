<?php

class HomeController extends TwigLoader {

    public function home () {

        $showList = new ShowModel();
        $shows = $showList->findAll();
    
        $args = ['shows' => $shows];
        $this->getTwigTemplate('home', $args);

    }

    public function page404() {
        echo 'erreur';
    }
}
