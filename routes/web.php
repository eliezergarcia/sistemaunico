<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

DB::listen(function($query){
  // echo "<pre>{$query->sql}</pre>";
});

Route::get('/', function () {
    return view('auth.login2');
});

Route::get('/facturar', function () {
    return view('facturar');
});

Route::get('/pdf', function () {
	$pdf = PDF::loadView('operations.pdf.debitnote');
    return $pdf->stream();
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/calendarios/buscar', 'CalendarController@findEvents')->name('calendarios.findEvents');
Route::get('/calendarios/buscarevento/{id}', 'CalendarController@findEvent')->name('calendarios.findEvent');
Route::post('/calendarios/modificar', 'CalendarController@modificar')->name('calendarios.modificar');
Route::post('/calendarios/eliminar', 'CalendarController@delete')->name('calendarios.delete');
Route::resource('calendarios', 'CalendarController');

Route::delete('/usuarios/desactivar/{id}', 'UserController@deactivate')->name('usuarios.deactivate');
Route::post('/usuarios/activar/{id}', 'UserController@activate')->name('usuarios.activate');
Route::post('/usuarios/clientes', 'UserController@assignmentClient')->name('usuarios.assignmentClient');
Route::delete('/usuarios/clientes', 'UserController@disassociateClient')->name('usuarios.disassociateClient');
Route::resource('usuarios', 'UserController');

Route::get('/conceptos', 'ConceptController@index')->name('conceptos.index');
Route::post('/conceptos', 'ConceptController@store')->name('conceptos.store');
Route::get('/conceptos/buscar/{id}', 'ConceptController@findById')->name('conceptos.findById');
Route::post('/conceptos/actualizar', 'ConceptController@update')->name('conceptos.update');
Route::post('/conceptos/activate', 'ConceptController@activate')->name('conceptos.activate');
Route::delete('/conceptos/deactivate', 'ConceptController@deactivate')->name('conceptos.deactivate');

Route::get('/conceptosproveedor', 'ConceptProviderController@index')->name('conceptosproveedor.index');
Route::post('/conceptosproveedor', 'ConceptProviderController@store')->name('conceptosproveedor.store');
Route::get('/conceptosproveedor/buscar/{id}', 'ConceptProviderController@findById')->name('conceptosproveedor.findById');
Route::post('/conceptosproveedor/actualizar', 'ConceptProviderController@update')->name('conceptosproveedor.update');
Route::post('/conceptosproveedor/activate', 'ConceptProviderController@activate')->name('conceptosproveedor.activate');
Route::delete('/conceptosproveedor/deactivate', 'ConceptProviderController@deactivate')->name('conceptosproveedor.deactivate');

Route::post('/import-clients', 'ClientController@importClients')->name('import.clients');
Route::get('/clientes/buscar/{id}', 'ClientController@findById')->name('clientes.findById');
Route::post('/clientes/modificar', 'ClientController@modificar')->name('clientes.modificar');
Route::post('/clientes/activate', 'ClientController@activate')->name('clientes.activate');
Route::delete('/clientes/deactivate', 'ClientController@deactivate')->name('clientes.deactivate');
Route::resource('clientes', 'ClientController');

Route::post('/import-providers', 'ProviderController@importProvider')->name('import.providers');
Route::get('/proveedores/buscar/{id}', 'ProviderController@findById')->name('proveedores.findById');
Route::post('/proveedores/modificar', 'ProviderController@modificar')->name('proveedores.modificar');
Route::post('/proveedores/activate', 'ProviderController@activate')->name('proveedores.activate');
Route::delete('/proveedores/deactivate', 'ProviderController@deactivate')->name('proveedores.deactivate');
Route::get('/proveedores/buscarcuentas', 'ProviderController@searchAccounts')->name('proveedores.searchAccounts');
Route::resource('proveedores', 'ProviderController');

Route::get('/cuentasproveedor', 'AccountProviderController@index')->name('cuentasproveedor.index');
Route::post('/cuentasproveedor', 'AccountProviderController@store')->name('cuentasproveedor.store');
Route::get('/cuentasproveedor/{id}', 'AccountProviderController@findById')->name('cuentasproveedor.findById');
Route::post('/cuentasproveedor/actualizar', 'AccountProviderController@update')->name('cuentasproveedor.update');
Route::post('/cuentasproveedor/activate', 'AccountProviderController@activate')->name('cuentasproveedor.activate');
Route::delete('/cuentasproveedor/deactivate', 'AccountProviderController@deactivate')->name('cuentasproveedor.deactivate');

Route::get('/operaciones/chart_user', 'OperationController@chart_user')->name('operaciones.chart_user');
Route::get('/operaciones/chart_admin', 'OperationController@chart_admin')->name('operaciones.chart_admin');
Route::get('/operaciones/debitnote/{id}', 'OperationController@debitnote')->name('operations.debitnote');
Route::get('/operaciones/prefactura/{id}', 'OperationController@prefactura')->name('operations.prefacture');
Route::get('/operaciones/facturaproveedor/{id}', 'OperationController@invoiceProvider')->name('operations.invoiceProvider');
Route::get('/operaciones/solicitudgarantia/{id}', 'OperationController@guaranteeRequest')->name('operations.guaranteeRequest');
Route::get('/operaciones/solicitudanticipo/{id}', 'OperationController@advanceRequest')->name('operations.advanceRequest');
Route::put('operaciones/update_status/{id}', 'OperationController@update_status')->name('operaciones.updatestatus');
Route::resource('operaciones', 'OperationController');

Route::get('/contenedores/{id}', 'ContainerController@show')->name('contenedores.show');
Route::post('/contenedores/modificar', 'ContainerController@modificar')->name('contenedores.modificar');
Route::resource('contenedores', 'ContainerController');

Route::get('/debitnotes/buscar/{id}', 'DebitNoteController@findById')->name('debitnote.findById');
Route::delete('/debitnotes/cancelar', 'DebitNoteController@cancel')->name('debitnote.cancel');
Route::resource('debitnotes', 'DebitNoteController');

Route::get('/prefacturas/buscar/{id}', 'PrefactureController@findById')->name('prefacture.findById');
Route::delete('/prefacturas/cancelar', 'PrefactureController@cancel')->name('prefacture.cancel');
Route::resource('prefacturas', 'PrefactureController');

Route::delete('/housebls/cancelar', 'HouseblController@cancel')->name('housebl.cancel');
Route::resource('housebls', 'HouseblController');

Route::get('/facturas/buscar/{id}', 'InvoiceController@findById')->name('facturas.findById');
Route::post('/facturas/modificar', 'InvoiceController@modificar')->name('facturas.modificar');
Route::delete('/facturas/cancelar', 'InvoiceController@cancel')->name('facturas.cancel');
Route::resource('facturas', 'InvoiceController');

Route::post('/pagos/modificar', 'PaymentController@modificar')->name('pagos.modificar');
Route::delete('/pagos/cancelar', 'PaymentController@cancel')->name('pagos.cancel');
Route::resource('pagos', 'PaymentController');



Route::post('/pagosproveedores/modificar', 'PaymentProvidersController@modificar')->name('pagosproveedores.modificar');
Route::post('/pagosproveedores/facturas', 'PaymentProvidersController@facturas')->name('pagosproveedores.facturas');
Route::get('/pagosproveedores/facturas/total', 'PaymentProvidersController@facturasTotal')->name('pagosproveedores.facturasTotal');
Route::delete('/pagosproveedores/deactivate', 'PaymentProvidersController@deactivate')->name('pagosproveedores.deactivate');
Route::resource('pagosproveedores', 'PaymentProvidersController');

Route::post('/notascredito/modificar', 'CreditNoteController@modificar')->name('notascredito.modificar');
Route::delete('/notascredito/deactivate', 'CreditNoteController@deactivate')->name('notascredito.deactivate');
Route::resource('notascredito', 'CreditNoteController');

Route::get('/estadoscuenta/facturacion', 'AccountStatementsController@facturacion')->name('accountstatements.facturacion');
Route::get('/estadoscuenta/debitnotes', 'AccountStatementsController@debitnotes')->name('accountstatements.debitnotes');
Route::post('/estadoscuenta/facturacion/generar', 'AccountStatementsController@facturacion_generar')->name('accountstatements.facturacion_generar');
Route::post('/estadoscuenta/debitnotes/generar', 'AccountStatementsController@debitnotes_generar')->name('accountstatements.debitnotes_generar');

Route::get('/manenjocuentas', 'AccountManagementController@index')->name('manejocuentas.index');
Route::post('/manenjocuentas', 'AccountManagementController@show')->name('manejocuentas.show');

Route::resource('notificaciones', 'NotificationController');

Route::get('/facturasproveedor/solicitudesgarantia', 'InvoiceProviderController@guaranteerequests')->name('facturasproveedor.guaranteerequests');
Route::get('/facturasproveedor/solicitudesanticipo', 'InvoiceProviderController@advancerequests')->name('facturasproveedor.advancerequests');
Route::get('/facturasproveedor/buscar/{id}', 'InvoiceProviderController@buscar')->name('facturasproveedor.buscar');
Route::post('/facturasproveedor/modificar', 'InvoiceProviderController@modificar')->name('facturasproveedor.modificar');
Route::delete('/facturasproveedor/deactivate', 'InvoiceProviderController@deactivate')->name('facturasproveedor.deactivate');
Route::post('/facturasproveedor/autorizar', 'InvoiceProviderController@authorizeInvoice')->name('facturasproveedor.authorizeInvoice');

Route::post('/facturasproveedor/notas/{id}', 'InvoiceProviderController@notes')->name('facturasproveedor.notes');
Route::post('/facturasproveedor/revision', 'InvoiceProviderController@revisionInvoice')->name('facturasproveedor.revisionInvoice');
Route::delete('/facturasproveedor/cancelarRevision', 'InvoiceProviderController@cancelRevision')->name('facturasproveedor.cancelRevision');
Route::resource('facturasproveedor', 'InvoiceProviderController');

Route::get('/balances', 'BalanceController@index')->name('balances.index');
Route::get('/balances/buscar/{id}', 'BalanceController@findById')->name('balances.findById');
Route::post('/balances', 'BalanceController@update')->name('balances.update');

Route::get('/estadogastos/pdf/{id}', 'ExpenseStatementController@pdf')->name('estadogastos.pdf');
Route::get('estadogastos/buscar/{id}', 'ExpenseStatementController@findById')->name('estadogastos.findById');
Route::post('estadogastos/modificar', 'ExpenseStatementController@modificar')->name('estadogastos.modificar');
Route::get('estadogastos/plantilla/{id}', 'ExpenseStatementController@findTemplate')->name('estadogastos.findTemplate');
Route::post('estadogastos/plantilla', 'ExpenseStatementController@templateStore')->name('estadogastos.templateStore');
Route::post('estadogastos/plantilla/modificar', 'ExpenseStatementController@templateUpdate')->name('estadogastos.templateUpdate');
Route::delete('estadogastos/plantilla/eliminar', 'ExpenseStatementController@templateDelete')->name('estadogastos.templateDelete');
Route::get('estadogastos/expensestatement', 'ExpenseStatementController@expenseStatement')->name('estadogastos.expenseStatement');
Route::post('/estadogastos/notas/{id}', 'ExpenseStatementController@notes')->name('estadogastos.notes');
Route::resource('estadogastos', 'ExpenseStatementController');

Route::post('/import-services', 'ExpenseServiceController@importServices')->name('serviciosgastos.importServices');
Route::get('serviciosgastos', 'ExpenseServiceController@index')->name('serviciosgastos.index');
Route::post('serviciosgastos', 'ExpenseServiceController@store')->name('serviciosgastos.store');
Route::get('serviciosgastos/buscar/{id}', 'ExpenseServiceController@findById')->name('serviciosgastos.findById');
Route::post('serviciosgastos/modificar', 'ExpenseServiceController@modificar')->name('serviciosgastos.modificar');
Route::post('/serviciosgastos/activate', 'ExpenseServiceController@activate')->name('serviciosgastos.activate');
Route::delete('/serviciosgastos/deactivate', 'ExpenseServiceController@deactivate')->name('serviciosgastos.deactivate');

Route::get('/api/users', function(){
	return datatables()->eloquent(App\User::query())->toJson();
});
