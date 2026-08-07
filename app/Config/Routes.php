<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route - redirect to login
$routes->get('/', 'Auth::login');

// Authentication Routes
$routes->group('auth', function($routes) {
    $routes->get('login', 'Auth::login');
    $routes->post('process-login', 'Auth::processLogin');
    $routes->get('logout', 'Auth::logout');
    $routes->post('verify-and-register', 'Auth::verifyAndRegister'); // Add this
    $routes->get('register', 'Auth::register'); // Add this
    $routes->post('process-register', 'Auth::processRegister'); // Add this
});

// Dashboard Routes
$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/statistics', 'Dashboard::getStatistics');

// PWD Profiles Routes
$routes->group('pwd-profiles', function($routes) {
    $routes->get('/', 'PwdProfiles::index');
    $routes->get('add', 'PwdProfiles::add');
    $routes->post('create', 'PwdProfiles::create');
    $routes->get('edit/(:num)', 'PwdProfiles::edit/$1');
    $routes->post('update/(:num)', 'PwdProfiles::update/$1');
    $routes->get('view/(:num)', 'PwdProfiles::view/$1');
    $routes->get('archive/(:num)', 'PwdProfiles::archive/$1');
    $routes->get('activate/(:num)', 'PwdProfiles::activate/$1');
    $routes->get('delete/(:num)', 'PwdProfiles::delete/$1');
    $routes->get('search', 'PwdProfiles::search');
});

// Assistance Routes
$routes->group('assistance', function($routes) {
    $routes->get('/', 'Assistance::index');
    $routes->get('record', 'Assistance::record');
    $routes->post('create-assistance', 'Assistance::createAssistance');
    $routes->get('reservations', 'Assistance::reservations');
    $routes->post('create-reservation', 'Assistance::createReservation');
    $routes->post('update-reservation-status/(:num)', 'Assistance::updateReservationStatus/$1');
    $routes->get('history/(:num)', 'Assistance::history/$1');
    $routes->get('edit/(:num)', 'Assistance::edit/$1');
$routes->post('update-assistance/(:num)', 'Assistance::updateAssistance/$1');
});

// Reports Routes
$routes->group('reports', function($routes) {
    $routes->get('/', 'Reports::index');
    $routes->get('generate', 'Reports::generate');
    $routes->get('disability-report', 'Reports::disabilityReport');
    $routes->get('assistance-report', 'Reports::assistanceReport');
    $routes->get('demographic-report', 'Reports::demographicReport');
    $routes->get('export', 'Reports::exportReport');
    $routes->get('data', 'Reports::getReportData');
    $routes->get('print', 'Reports::printReport');
});

// Admin Routes
$routes->group('admin', function($routes) {
    $routes->get('audit-log', 'Admin::auditLog');
    $routes->get('clear-audit-log', 'Admin::clearAuditLog');
    $routes->get('profile', 'Admin::profile');
    $routes->post('update-profile', 'Admin::updateProfile');
    $routes->post('update-password', 'Admin::updatePassword'); // Add this
    $routes->get('settings', 'Admin::systemSettings');
    $routes->post('update-settings', 'Admin::updateSystemSettings');
});

// API Routes for AJAX calls
$routes->group('api', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('pwd-search', 'PwdProfiles::search');
    $routes->get('dashboard-stats', 'Dashboard::getStatistics');
    $routes->get('report-data', 'Reports::getReportData');
});

// Catch all - 404 page
// Catch all - 404 page
$routes->set404Override(function($message = null) {
    // Pass the message to the view
    return view('errors/html/error_404', ['message' => $message]);
});

// Maintenance mode (optional)
// $routes->setAutoRoute(false);