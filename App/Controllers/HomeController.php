<?php
namespace App\Controllers;

class HomeController extends Controller {
    public function index() {
        
        return $this->publicView('home', [
            'title' => 'NAPS | Welcome'
        ]);
    }
    public function about() {
        return $this->publicView('about', [
            'title' => 'About NAPS'
        ]);
    }
    public function services() {
        return $this->publicView('services', [
            'title' => 'Our Services'
        ]);
    }
    public function contact() {
        return $this->publicView('contact', [
            'title' => 'Contact Us'
        ]);
    }
    public function helpCenter() {
        return $this->publicView('help',[
    'title'=> 'help center'
        ]);
    }
}