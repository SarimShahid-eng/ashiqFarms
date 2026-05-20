<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Inventory\Employees;
use App\Inventory\Employees_type;
use App\Http\Controllers\NotesController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/password/reset/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('change.langPass');

Auth::routes([
    'register'  => false,
]);

// Route::get('/register/{lang?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::get('/login/{lang?}', 'Auth\LoginController@showLoginForm')->name('login');


//upload image per user
Route::post('/dashboardImageStore','DashboardImageController@store')->name('dashboardImage.store')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('/', 'DashboardController@index')->name('dashboard')->middleware(
    [
        'auth',
        'xss'
    ]
);

Route::get('/dashboard', 'DashboardController@index')->name('dashboard')->middleware(
    [
        'auth',
        'xss',
    ]
);
//check some change
Route::get('/some_changes','DashboardController@some_changes')->name('some_changes')->middleware(
    [
        'auth',
        'xss',
    ]
);


Route::get('user/{id}/plan', 'UserController@upgradePlan')->name('plan.upgrade')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::post('user/login-user', 'UserController@loginAdminWithoutAuth')->name('login.loginWithoutAuth')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::post('user/auto-login', 'UserController@autoLogin')->name('user.autologin');


Route::get('user/{id}/plan/{pid}', 'UserController@activePlan')->name('plan.active')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::get('profile', 'UserController@profile')->name('profile')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::put('edit-profile', 'UserController@editprofile')->name('update.account')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::resource('users', 'UserController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::put('change-password', 'UserController@updatePassword')->name('update.password');


Route::resource('roles', 'RoleController')->middleware(
    [
        'auth',
        'xss',
    ]
);
Route::resource('permissions', 'PermissionController')->middleware(
    [
        'auth',
        'xss',
    ]
);

Route::middleware(['auth','xss'])->prefix('expense')->name('expense.')->group(function(){
    //head routes
    Route::get('/head','HeadController@index')->name('heads.show');
    Route::post('/head/store','HeadController@store')->name('heads.store');
    Route::get('head/edit/{id}','HeadController@edit')->name('heads.edit');
    Route::get('head/delete/{id}','HeadController@delete')->name('heads.delete');
    //subhead routes
    Route::get('/subhead','SubHeadController@index')->name('subheads.show');
    Route::get('/subhead/add','SubHeadController@add')->name('subheads.add');
    Route::post('/subhead/store','SubHeadController@store')->name('subheads.store');
    Route::get('/subhead/edit/{id}','SubHeadController@edit')->name('subheads.edit');
    Route::get('/subhead/delete/{id}','SubHeadController@delete')->name('subheads.delete');
    //child subhead routs
    Route::get('child-subhead','ChildSubheadController@index')->name('child.subheads.show');
    Route::get('child-subhead/add','ChildSubheadController@add')->name('child.subheads.add');
    Route::post('child-subhead/store','ChildSubheadController@store')->name('child.subheads.store');
    Route::get('child-subhead/edit/{id}','ChildSubheadController@edit')->name('child.subheads.edit');
    Route::get('child-subhead/delete/{id}','ChildSubheadController@delete')->name('child.subheads.delete');

    //Forth  subhead routs
    Route::get('child-fourthhead','FourthHeadController@index')->name('child.forthheads.show');
    Route::get('child-fourthhead/add','FourthHeadController@add')->name('child.forthheads.add');
    Route::post('child-forhead/store','FourthHeadController@store')->name('child.forheads.store');
    Route::get('child-fourthhead/edit/{id}','FourthHeadController@edit')->name('child.forheads.edit');
    Route::get('child-forhead/delete/{id}','FourthHeadController@delete')->name('child.forheads.delete');


});
//enteries routess

Route::get('/enteries','EnteriesController@index')->name('enteries.show');
// Route::get('/enteries','EnteriesController@add')->name('enteries.add');
Route::get('enteries/add','EnteriesController@add')->name('enteries.add');
Route::post('enteries/store','EnteriesController@store')->name('enteries.store');
Route::get('enteries/edit','EnteriesController@edit')->name('enteries.edit');
Route::get('enteries/delete/{id}','EnteriesController@delete')->name('enteries.delete');
Route::get('enteries/subheads','EnteriesController@subhead');
Route::get('enteries/child-subheads','EnteriesController@childSubhead');
Route::get('enteries/forth-subheads','EnteriesController@forthSubhead');
Route::get('enteries/search/{type}/{from}/{to}','EnteriesController@search');
// Route::get('enteries/search','EnteriesController@search');


//user permisssion route

Route::post('roles/store', 'RoleController@store')->name('roles.store');
Route::get('/roles/edit/{id?}','RoleController@create')->name('roles.edit');

Route::get('/users/destroy/{id}','UserController@destroy')->name('users.destroy');
Route::post('/users/backgrond-image','UserController@backgroundImage')->name('users.background');
Route::post('/users/background-image/remove','UserController@removeBackground')->name('users.background.remove');
Route::post('/dashboard/icons','UserController@iconUpload')->name('icons.upload');

//credit routes
Route::get('credit','CreditController@index')->name('credits.show');
Route::get('credit/add','CreditController@add')->name('credits.add');
Route::post('credit/store','CreditController@store')->name('credits.store');
Route::get('credit/edit','CreditController@edit')->name('credits.edit');
Route::get('credit/delete/{id}','CreditController@delete')->name('credits.delete');
Route::get('credit/subheads/{id}','CreditController@subhead');


//payment routes
Route::get('payment','PaymentController@index')->name('payments.show');
Route::get('payment/add','PaymentController@add')->name('payments.add');
Route::post('payment/store','PaymentController@store')->name('payments.store');
Route::get('payment/edit','PaymentController@edit')->name('payments.edit');
Route::get('payment/delete/{id}','PaymentController@delete')->name('payments.delete');
Route::get('payment/subheads/{id}','PaymentController@subhead');

//report routes
Route::get('report','ReportController@index')->name('reports.show');
Route::get('report/subhead/{id}','ReportController@subhead')->name('reports.subhead');
Route::get('report/childhead/{id}','ReportController@thirdhead')->name('reports.childhead');
Route::get('download_database','ReportController@download')->name('download.database');
Route::get('import_database','ReportController@import_db_view')->name('import.database');
Route::post('import_db','ReportController@import_db')->name('import.db');
Route::get('note','NoteController@index')->name('note.show');
Route::post('note','NoteController@store')->name('note.store');
Route::get('note/edit/{id}','NoteController@edit')->name('note.edit');
Route::get('note/delete/{id}','NoteController@delete')->name('note.delete');
// Route::get('report/search','ReportController@search')->name('reports.search');
Route::get('report/search/{head_id?}/{subhead_id?}/{child_head_id?}/{fourth_head_id?}','ReportController@search')->name('reports.search');
Route::get('/report/csv','ReportController@reportExportExcel')->name('reports.export.csv');
Route::get('report/column_color/{id}','ReportController@column_color')->name('reports.column');
Route::get('/report/update','ReportController@update')->name('reports.update');
Route::get('report/headsubhead','ReportController@headSubhead')->name('reprots.headsubhead');
Route::get('report/row','ReportController@row')->name('reports.row');
Route::get('report/delete','ReportController@delete')->name('reports.delete');
//late and dues routes
Route::get('/report/late','ReportController@late')->name('reports.late');
Route::get('/report/due','ReportController@due')->name('reports.due');
Route::get('/report/late/paid','ReportController@latePay')->name('report.late.pay');
//check all and uncheck all routes
Route::get('report/checkall','ReportController@check')->name('reports.check');
Route::get('report/move','ReportController@move')->name('reports.move');
Route::get('report/moveEntryToAnotherUser','ReportController@moveEntryToAnotherUser')->name('reports.moveEntryToAnotherUser');

//banana agreement
Route::get('/banana','BananaAgreementController@index')->name('banana.show');
Route::get('/banana/contract','BananaAgreementController@contract')->name('bananas.contract');
Route::post('/banana/store','BananaAgreementController@store')->name('bananas.store');
Route::get('/banana/edit/{id}','BananaAgreementController@edit')->name('bananas.edit');
Route::post('/banana/update','BananaAgreementController@update')->name('bananas.update');
Route::get('/banana/paid','BananaAgreementController@paid')->name('bananas.paid');
Route::get('/banana/delete/{id}','BananaAgreementController@delete')->name('bananas.delete');
Route::get('/banana/late/dues','BananaAgreementController@lateDues')->name('bananas.late');
Route::get('/banana/schedule/delete/{id}','BananaAgreementController@scheduleDelete')->name('bananas.schedules.delete');
Route::get('/print-agreement/{id}','BananaAgreementController@printAgreement')->name('bananas.agreement.print');


Route::get('/notes', [NotesController::class, 'index'])->name('admin.notes.index');
Route::post('/notes/save', [NotesController::class, 'save'])->name('admin.notes.save');
Route::get('/notes/delete', [NotesController::class, 'delete'])->name('admin.notes.delete');


Route::get('/settings', [DashboardController::class, 'settings'])->name('admin.settings');

//accounts
Route::prefix('accounts')->name('accounts.')->group(function(){
    //bank routes
    Route::get('bank','AccountController@bank')->name('banks.show');
    Route::post('/bank/store','AccountController@store')->name('banks.store');
    Route::get('bank/delete/{id}','AccountController@delete')->name('banks.delete');
    //bank bracnhes routes
    Route::get('bank_branches','AccountController@bankBranchList')->name('branches.show');
    Route::get('bank_branch/add','AccountController@bankBranchAdd')->name('branches.add');
    Route::post('bank_branch/store','AccountController@bankBranchStore')->name('branches.store');
    Route::get('bank_branch/edit/{id}','AccountController@bankBranchEdit')->name('branches.edit');
    Route::get('bank_branch/delete/{id}','AccountController@bankBranchDelete')->name('branches.delete');
    //customer
    Route::get('user','CustomerController@customerIndex')->name('customer.show');
    Route::get('user/add','CustomerController@customerStore')->name('customer.store');
    Route::get('user/delete/{id}','CustomerController@customerDelete')->name('customer.delete');
    //customers banks and branches
    Route::get('users/bank_branches','CustomerController@index')->name('customers.show');
    Route::get('users/bank_branches/add','CustomerController@add')->name('customers.add');
    Route::get('users/branches','CustomerController@branches')->name('customers.branches');
    Route::post('users/store','CustomerController@store')->name('customers.store');
    Route::get('/users/edit/{id}','CustomerController@edit')->name('customers.edit');
    Route::get('/users/delete/{id}','CustomerController@delete')->name('customers.delete');
    //Route::get('/users/user_bank_branch','CustomerController@addUserBankAndBranch')->name('customers.bank_and_branch');
    Route::post('/users/store_user_bank_branch','CustomerController@storeCustomerBankAndBranch')->name('customers.stores.user_bank_branch');
    Route::get('/users/delete_user_bank_branch/{id}','CustomerController@deleteCustomerBankAndBranch')->name('customers.deletes.user_bank_branch');
    //customers accounts
    Route::get('/users_accounts','CustomerAccountController@index')->name('customer_accounts.show');
    Route::get('/users_accounts/users_payments','CustomerAccountController@add')->name('customer_accounts.add');
    // Route::get('/users_accounts/branches','CustomerAccountController@bankBranch')->name('customer_accounts.branch');
    // Route::get('/users_accounts/users','CustomerAccountController@user')->name('customer_accounts.user');
    Route::get('/users_accounts/users_banks/{id}','CustomerAccountController@customerBank')->name('customer_accounts.customer_bank');
    Route::get('/users_accounts/users_branches/{bank_id}/{customer_id}','CustomerAccountController@customerBranch')->name('customers_accounts.customer_branch');
    Route::get('/users_accounts/add_row','CustomerAccountController@addRow')->name('customer_accounts.row');
    Route::get('/users_accounts/store','CustomerAccountController@store')->name('customer_accounts.store');
    Route::get('/users_accounts/edit/{id}','CustomerAccountController@edit')->name('customer_accounts.edit');
    Route::get('/users_accounts/delete/{id}','CustomerAccountController@delete')->name('customer_accounts.delete');
    //customer accounts report
    Route::get('/users_accounts/report','CustomerAccountController@userAccountReportIndex')->name('customer_accounts.report');
    Route::get('/users_accounts/report/check','CustomerAccountController@check')->name('customer_accounts.check');
    Route::get('/users_accounts/report/search','CustomerAccountController@search')->name('customer_accounts.search');
    Route::get('/users_accounts/report/column_color/{id}','CustomerAccountController@columnColor')->name('customer_accounts.color');
    Route::get('/users_accounts/report/edit/{id}','CustomerAccountController@editReport')->name('customer_accounts.edit_report');
    Route::get('/users_accounts/report/update','CustomerAccountController@updateReport')->name('customer_accounts.update_report');
    Route::get('/users_accounts/report/delete/{id}','CustomerAccountController@deleteReport')->name('customer_accounts.delete_report');
    Route::get('/users_accounts/report/bank_branch_checkbox/{id}','CustomerAccountController@bankBranchCheckBox')->name('customer_accounts.chexkbox');
    Route::get('/users_accounts/user_banks_branches/{id}','CustomerAccountController@UserBankAndBranch')->name('customer_accounts.bank_branches');
    //transaction routes
    Route::get('/user_accounts/transaction/{id?}','TransactionController@index')->name('customer_accounts.transactions.show');
    Route::post('/user_accounts/transaction/store','TransactionController@store')->name('customer_accounts.transaction.store');
    Route::get('/user_accounts/transaction/delete/{id}','TransactionController@delete')->name('customer_accounts.transaction.delete');

    //entries reason
    Route::get('/user_accounts/entry_reason','EntryReasonController@index')->name('customer_accounts.reasons.show');
    Route::post('/user_accounts/entry_reason/add','EntryReasonController@store')->name('customer_accounts.reasons.store');
    Route::get('/user_accounts/entry_reason/edit/{id}','EntryReasonController@edit')->name('customer_accounts.reasons.edit');
    Route::get('/user_accounts/entry_reason/delete/{id}','EntryReasonController@delete')->name('customer_accounts.reasons.delete');

});
// Inventory
Route::prefix('inventory')->name('inventory.')->namespace('Inventory')->group(function (){
Route::get('/','InventoryController@index')->name('index');
// Employees
Route::prefix('employees')->name('employees.')->group(function () {
Route::get('/employees/{id?}','EmployeesController@index')->name('index');
Route::get('/employees/delete/{id}','EmployeesController@delete')->name('delete');
Route::post('/store','EmployeesController@store')->name('store');

//employees type
Route::get('/employees_type/{id?}','EmployeesController@employees_type')->name('employees_type');
Route::get('/employees_type/delete/{id}','EmployeesController@employees_type_delete')->name('employees_type.delete');
Route::post('/type_store','EmployeesController@type_store')->name('type_store');
});
Route::prefix('stock')->name('stock.')->group(function () {
Route::get('/stock/{id?}','StockController@index')->name('index');
Route::post('store','StockController@store')->name('store');
Route::get('/stock/delete/{id}','StockController@delete')->name('delete');
Route::get('/consumer/{id?}','StockController@stock_consume')->name('stock_consume');
Route::post('/stock_consume/store','StockController@stock_consume_store')->name('stock_consumes_store');
Route::get('/stock_consume/delete/{id?}','StockController@stock_consume_delete')->name('stock_consume_delete');
});

  });






