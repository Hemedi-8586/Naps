<?php
namespace App\Controllers;

class DashboardController extends Controller {

    public function index($page = 'home') {
        $cleanPage = basename($page, '.php');
        if ($cleanPage === 'index' || empty($cleanPage)) {
            $cleanPage = 'home';
        }
        $token = $_COOKIE['auth_token'] ?? null;
        $username = 'Mtumiaji';

        if ($token) {
            $decoded = $this->jwt->decodeToken($token);
            
            if ($decoded) {
                $decodedArray = (array) $decoded;

                if (isset($decodedArray['username'])) {
                    $username = $decodedArray['username'];
                } else {
                    $username = "Key Missing";
                }
            } else {
                $username = "Decode Failed";
            }
        } else {
            $this->redirect('/login');
            exit;
        }
        return $this->view($cleanPage, [
            'title'    => 'NAPS | ' . ucfirst($cleanPage),
            'username' => $username,
        ]);
    }
}