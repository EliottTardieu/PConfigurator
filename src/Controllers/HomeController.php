<?php

namespace PConfigurator\Controllers;

class HomeController extends Controller {


    public function home(): void {
        $this->render("home.main");
    }
}