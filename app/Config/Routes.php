<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');

$routes->get('/t/(:any)', 'Tracer::find/$1');
$routes->get('/recordmedical/searchdata', 'RecordMedical::searchData');


$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // $routes->group('', ['filter' => ''], static function ($routes) {
    $routes->get('/signup', 'Register::index');
    $routes->post('/register', 'Register::store');

    $routes->get('/dashboard', 'Dashboard::index');
    $routes->get('/dashboard/getdataloan', 'Dashboard::getDataLoan');
    $routes->get('/dashboard/getdatareturn', 'Dashboard::getDataReturn');

    $routes->get('/recordmedical', 'RecordMedical::index');
    $routes->get('/recordmedical/show/(:any)', 'RecordMedical::show/$1');
    $routes->get('/recordmedical/add', 'RecordMedical::add');
    $routes->post('/recordmedical/store', 'RecordMedical::store');
    $routes->get('/recordmedical/edit/(:any)', 'RecordMedical::edit/$1');
    $routes->post('/recordmedical/update', 'RecordMedical::update');
    $routes->get('/recordmedical/delete/(:any)', 'RecordMedical::delete/$1');

    $routes->get('/test', 'RecordMedical::test');

    $routes->get('/officer', 'Officer::index');
    $routes->get('/officer/delete/(:any)', 'Officer::delete/$1');


    $routes->get('/serviceunit', 'ServiceUnit::index');
    $routes->get('/serviceunit/add', 'ServiceUnit::add');
    $routes->post('/serviceunit/store', 'ServiceUnit::store');
    $routes->get('/serviceunit/edit/(:any)', 'ServiceUnit::edit/$1');
    $routes->post('/serviceunit/update', 'ServiceUnit::update');
    $routes->get('/serviceunit/delete/(:any)', 'ServiceUnit::delete/$1');

    $routes->get('/f', 'Tracer::findloan');

    $routes->get('/loancoass', 'LoanCoass::index');
    $routes->get('/loancoass/add', 'LoanCoass::add');
    $routes->post('/loancoass/store', 'LoanCoass::store');
    $routes->get('/loancoass/edit/(:any)', 'LoanCoass::edit/$1');
    $routes->post('/loancoass/update', 'LoanCoass::update');
    $routes->get('/loancoass/delete/(:any)', 'LoanCoass::delete/$1');

    $routes->get('/loanpublic', 'LoanPublic::index');
    $routes->get('/loanpublic/add', 'LoanPublic::add');
    $routes->post('/loanpublic/store', 'LoanPublic::store');
    $routes->get('/loanpublic/edit/(:any)', 'LoanPublic::edit/$1');
    $routes->post('/loanpublic/update', 'LoanPublic::update');
    $routes->get('/loanpublic/delete/(:any)', 'LoanPublic::delete/$1');

    $routes->get('/returndoc', 'ReturnDocument::index');
    $routes->get('/returndoc/add', 'ReturnDocument::add');

    $routes->get('reportloan', 'ReportLoan::index');
    $routes->post('reportloanexcel', 'ReportLoan::saveExcel');
});
