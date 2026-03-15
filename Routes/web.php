<?php
use App\Controllers\HomeController;

return [
'/'         => ['GET' => ['controller' => 'HomeController', 'action' => 'index']],
'/about'    => ['GET' => ['controller' => 'HomeController', 'action' => 'about']],
'/services' => ['GET' => ['controller' => 'HomeController', 'action' => 'services']],
'/contact'  => ['GET' => ['controller' => 'HomeController', 'action' => 'contact']],
'/help'     => ['GET' =>  ['controller'  =>  'HomeController','action'=>'helpCenter']],

'/login'    => [
    'GET'  => ['controller' => 'AuthController', 'action' => 'login'],
    'POST' => ['controller' => 'AuthController', 'action' => 'handleLogin']
],
'/register' => [
    'GET'  => ['controller' => 'AuthController', 'action' => 'registerForm'],
    'POST' => ['controller' => 'AuthController', 'action' => 'processRegister']
],
    
   '/dashboard' => [
    'GET' => ['controller' => 'DashboardController', 'action' => 'index']
],
'/dashboard/{page}' => [
    'GET' => ['controller' => 'DashboardController', 'action' => 'index']
],
    
    '/logout' => [
        'GET' => ['controller' => 'AuthController', 'action' => 'logout']
    ],
  '/admin/users' => [
    'GET' => ['controller' => 'AdminController', 'action' => 'users']
],
    '/admin/users/create' => [
        'POST' => ['controller' => 'AdminController', 'action' => 'createUser']
    ],
    '/admin/users/toggle-status' => [
        'POST' => ['controller' => 'AdminController', 'action' => 'toggleUserStatus']
    ],
    '/admin/users/delete' => [
        'POST' => ['controller' => 'AdminController', 'action' => 'deleteUser']
    ],
    

'/profile' => [
    'GET'  => ['controller' => 'CitizenController', 'action' => 'profile'],
],

'/citizen/update-profile' => [
    'POST' => ['controller' => 'CitizenController', 'action' => 'updateProfile']
],

'/citizen/activity' => [
    'GET' => ['controller' => 'ActivityController', 'action' => 'index']
],

'/citizen/apply' => [
    'GET'  => ['controller' => 'CitizenController', 'action' => 'applications'],
    'POST' => ['controller' => 'CitizenController', 'action' => 'submitPermit']
],
'/citizen/applications' => ['GET' => ['controller' => 'CitizenController', 'action' => 'allApplications']],
'/citizen/payments' => [
    'GET'  => ['controller' => 'CitizenController', 'action' => 'payments']
],
'/citizen/get-control-no' => [
    'POST' => ['controller' => 'CitizenController', 'action' => 'requestControlNo']
],
'/citizen/payment' => [
    'POST' => ['controller' => 'CitizenController', 'action' => 'processPayment']
],
'/citizen/notifications' => [
    'GET'  => ['controller' => 'NotificationController', 'action' => 'index']
],
'/notifications/read' => [
    'POST' => ['controller' => 'NotificationController', 'action' => 'read']
],
'/settings' => ['GET' => ['controller' => 'SettingsController', 'action' => 'index']],
'/settings/update-theme' => ['POST' => ['controller' => 'SettingsController', 'action' => 'updateTheme']],
'/settings/update-lang' => ['POST' => ['controller' => 'SettingsController', 'action' => 'updateLanguage']],

'/support' => ['GET' => ['controller' => 'SettingsController', 'action' => 'help']],
//staff
'/staff/profile' => [
    'GET'  => ['controller' => 'StaffController', 'action' => 'profile'],
],
'/staff/profile/update' =>['POST'=>['controller'=>'StaffController','action'=> 'updateProfile']],
'/staff/review' => ['GET'=>['controller'=>'PermitController','action'=>'review']],
'/permit/decision' => ['POST'=>['controller'=>'PermitController','action'=> 'handleDecision']],
];