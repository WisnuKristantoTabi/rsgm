<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');

$routes->get('/t/(:any)', 'Tracer::find/$1');
$routes->post('/recordmedical/searchdata', 'RecordMedical::searchData');
$routes->post('/returndoc/searchdata', 'ReturnDocument::searchData');
$routes->post('/returndoc/showdata', 'ReturnDocument::showData');


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
    $routes->get('/print/recordmedical/(:any)', 'PrintPDF::printrm/$1');
    $routes->get('/print/test', 'PrintPDF::test');

    $routes->get('/test', 'RecordMedical::test');

    $routes->get('/officer', 'Officer::index');
    $routes->get('/officer/edit/(:any)', 'Officer::edit/$1');
    $routes->post('/officer/update', 'Officer::update');
    $routes->get('/officer/delete/(:any)', 'Officer::delete/$1');


    $routes->get('/serviceunit', 'ServiceUnit::index');
    $routes->get('/serviceunit/add', 'ServiceUnit::add');
    $routes->post('/serviceunit/store', 'ServiceUnit::store');
    $routes->get('/serviceunit/edit/(:any)', 'ServiceUnit::edit/$1');
    $routes->post('/serviceunit/update', 'ServiceUnit::update');
    $routes->get('/serviceunit/delete/(:any)', 'ServiceUnit::delete/$1');

    $routes->get('/f', 'Tracer::findloan');
    $routes->get('/print/tracer/(:any)', 'PrintPDF::printTracer/$1');

    $routes->get('/coass', 'Coass::index');
    $routes->get('/coass/add', 'Coass::add');
    $routes->post('/coass/store', 'Coass::store');
    $routes->get('/coass/edit/(:any)', 'Coass::edit/$1');
    $routes->post('/coass/update', 'Coass::update');
    $routes->get('/coass/show/(:any)', 'Coass::show/$1');
    $routes->get('/coass/delete/(:any)', 'Coass::delete/$1');

    $routes->get('/loancoass', 'LoanCoass::index');
    $routes->get('/loancoass/add', 'LoanCoass::add');
    $routes->post('/loancoass/store', 'LoanCoass::store');
    $routes->get('/loancoass/edit/(:any)', 'LoanCoass::edit/$1');
    $routes->post('/loancoass/update', 'LoanCoass::update');
    $routes->get('/loancoass/delete/(:any)', 'LoanCoass::delete/$1');
    $routes->post('/loancoass/searchcoass/', 'LoanCoass::searchCoass');
    $routes->post('/loancoass/showcoass/', 'LoanCoass::showCoass');

    $routes->get('/loanpublic', 'LoanPublic::index');
    $routes->get('/loanpublic/add', 'LoanPublic::add');
    $routes->post('/loanpublic/store', 'LoanPublic::store');
    $routes->get('/loanpublic/edit/(:any)', 'LoanPublic::edit/$1');
    $routes->post('/loanpublic/update', 'LoanPublic::update');
    $routes->get('/loanpublic/delete/(:any)', 'LoanPublic::delete/$1');

    $routes->get('/returndoc', 'ReturnDocument::index');
    $routes->get('/returndoc/add', 'ReturnDocument::add');
    $routes->get('/returndoc/edit/(:any)', 'ReturnDocument::edit/$1');
    $routes->get('/returndoc/show/(:any)', 'ReturnDocument::show/$1');
    $routes->post('/returndoc/update', 'ReturnDocument::update');
    $routes->get('/returndoc/delete/(:any)', 'ReturnDocument::delete/$1');
    $routes->post('/returndoc/find/', 'ReturnDocument::find');
    $routes->get('/returndoc/sendmessage', 'ReturnDocument::sendmessage');

    $routes->get('/returndocoass', 'ReturnDocumentCoass::index');
    $routes->post('/returndocoass/find/', 'ReturnDocumentCoass::find');


    $routes->get('report', 'Report::index');
    $routes->post('reportexcel', 'Report::saveExcel');
});
