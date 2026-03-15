<?php
namespace App\Controllers;

use App\Models\Model;
use App\Models\UserModel; 

class SettingsController extends Controller {

    public function index() {
        $user = $this->checkAuth();
        if (!$user) return $this->redirect('/login');

        $model = new Model();
        $results = $model->where('users', ['id' => $user['id']]);
    
        $userData = (!empty($results) && isset($results[0])) ? $results[0] : null;

        if (!$userData) {
            
            return $this->redirect('/login');
        }

        return $this->view('dashboard/pages/settings', [
            'title' => 'Account Settings',
            'user_settings' => $userData
        ]);
    }

    public function updateTheme() {
        $user = $this->checkAuth();
        if (!$user) return $this->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
   
        $data = $this->getJsonInput(); 
        $theme = $data['theme'] ?? 'light';

        $model = new Model();
        if ($model->update('users', ['theme_preference' => $theme], $user['id'])) {
            return $this->json(['status' => 'success']);
        }
        return $this->json(['status' => 'error', 'message' => 'Failed to update theme'], 500);
    }

    public function updateLanguage() {
        $user = $this->checkAuth();
        if (!$user) return $this->json(['status' => 'error', 'message' => 'Unauthorized'], 401);

        $data = $this->getJsonInput();
        $lang = $data['lang'] ?? 'sw';

        $model = new Model();
        if ($model->update('users', ['language_preference' => $lang], $user['id'])) {
            return $this->json(['status' => 'success']);
        }
        return $this->json(['status' => 'error', 'message' => 'Failed to update language'], 500);
    }

    public function help() {
        $this->view('dashboard/pages/help', [
            'title' => 'Help and Communication'
        ]);
    }
}