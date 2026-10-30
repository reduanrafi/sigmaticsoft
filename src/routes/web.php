<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\CaseStudyController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\InsightController;
use App\Http\Controllers\Website\StaticPageController;
use App\Http\Controllers\Website\WorldCupController;
use App\Http\Controllers\Website\TrendOutlookController;
use App\Http\Controllers\AdminPortal\TrendIntelligenceAdminController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('view:clear');
    try {
        Artisan::call('migrate', ['--force' => true]);
    } catch (\Throwable $e) {
        // Ignore migration errors during cache clear if DB is unreachable
    }
    return redirect()->back();
});
Route::get('sitemap.xml', function () {
    return response()->file(public_path('sitemap.xml'))
        ->header('Content-Type', 'text/xml');
});
Route::get('/', [HomeController::class, 'index'])->name('website.index');
Route::get('product-details{slug}', [HomeController::class, 'pd_details'])->name('details');
Route::get('/learning', [StaticPageController::class, 'learning'])->name('learning');
Route::get('/about', [StaticPageController::class, 'about'])->name('website.about');
Route::get('/contact', [StaticPageController::class, 'contact'])->name('website.contact');
Route::post('/contact-submit', [StaticPageController::class, 'contactSubmit'])->name('website.contact.submit');
Route::get('/worldcup', [WorldCupController::class, 'index'])->name('website.worldcup');

Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
Route::get('/insights/{slug}', [InsightController::class, 'show'])->name('insights.show');
Route::redirect('/insites', '/insights', 301);
Route::redirect('/insites/{slug}', '/insights/{slug}', 301);

// Global Software Industry Trend Intelligence Public Pages
Route::get('/software-industry-outlook', [TrendOutlookController::class, 'index'])->name('trend-intelligence.outlook');
Route::get('/software-industry-outlook/{slug}', [TrendOutlookController::class, 'category'])->name('trend-intelligence.category');
Route::redirect('/trend-intelligence', '/software-industry-outlook', 301);
Route::redirect('/industry-outlook', '/software-industry-outlook', 301);

// Services
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/software-audit', [StaticPageController::class, 'softwareAudit'])->name('software-audit');
    Route::get('/legacy-modernization', [StaticPageController::class, 'legacyModernization'])->name('legacy-modernization');
    Route::get('/system-integration', [StaticPageController::class, 'systemIntegration'])->name('system-integration');
    Route::get('/ai-business-automation', [StaticPageController::class, 'aiBusinessAutomation'])->name('ai-business-automation');
    Route::get('/managed-engineering', [StaticPageController::class, 'managedEngineering'])->name('managed-engineering');
});

// Industries
Route::prefix('industries')->name('industries.')->group(function () {
    Route::get('/retail-distribution', [StaticPageController::class, 'retailDistribution'])->name('retail-distribution');
    Route::get('/ecommerce', [StaticPageController::class, 'ecommerce'])->name('ecommerce');
    Route::get('/professional-services', [StaticPageController::class, 'professionalServices'])->name('professional-services');
});

// Case Studies
Route::prefix('case-studies')->name('case-studies.')->group(function () {
    Route::get('/', [StaticPageController::class, 'caseStudiesIndex'])->name('index');
    Route::get('/{slug}', [StaticPageController::class, 'caseStudyShow'])->name('show');
});

// Privacy and Terms
Route::get('/privacy', [StaticPageController::class, 'privacy'])->name('website.privacy');
Route::get('/terms', [StaticPageController::class, 'terms'])->name('website.terms');


Auth::routes();
Route::get('/logout', [LoginController::class, 'logout']);

Route::group(['prefix' => 'private-panel', 'middleware' => ['auth']], function () {
Route::get('/index', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('category', CategoryController::class);
    Route::resource('products', ProductsController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('portfolio', PortfolioController::class);
    Route::resource('case-study', CaseStudyController::class);
    Route::resource('contact', \App\Http\Controllers\Admin\ContactController::class);
    Route::resource('insight', \App\Http\Controllers\Admin\InsightController::class);
    
    // World Cup Fixture Management routes
    Route::get('/worldcup', [\App\Http\Controllers\Admin\WorldCupAdminController::class, 'index'])->name('admin.worldcup.index');
    Route::post('/worldcup/update', [\App\Http\Controllers\Admin\WorldCupAdminController::class, 'update'])->name('admin.worldcup.update');
});

// Admin Portal (Business & Task Management)
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [App\Http\Controllers\AdminPortal\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [App\Http\Controllers\AdminPortal\DashboardController::class, 'index']);
    
    // Clients & users
    Route::resource('clients', App\Http\Controllers\AdminPortal\ClientController::class);
    Route::post('clients/{client}/users', [App\Http\Controllers\AdminPortal\ClientController::class, 'createUser'])->name('clients.users.store');
    
    // Projects
    Route::resource('projects', App\Http\Controllers\AdminPortal\ProjectController::class);
    
    // Tasks
    Route::get('tasks/board', [App\Http\Controllers\AdminPortal\TaskController::class, 'board'])->name('tasks.board');
    Route::post('tasks/update-status', [App\Http\Controllers\AdminPortal\TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::resource('tasks', App\Http\Controllers\AdminPortal\TaskController::class);
    Route::post('tasks/{task}/comments', [App\Http\Controllers\AdminPortal\TaskController::class, 'addComment'])->name('tasks.comments.store');
    
    // Client Requests
    Route::get('requests', [App\Http\Controllers\AdminPortal\ClientRequestController::class, 'index'])->name('requests.index');
    Route::get('requests/{client_request}', [App\Http\Controllers\AdminPortal\ClientRequestController::class, 'show'])->name('requests.show');
    Route::post('requests/{client_request}/convert', [App\Http\Controllers\AdminPortal\ClientRequestController::class, 'convertToTask'])->name('requests.convert');
    Route::post('requests/{client_request}/status', [App\Http\Controllers\AdminPortal\ClientRequestController::class, 'updateStatus'])->name('requests.update-status');
    
    // Finance
    Route::get('finance', [App\Http\Controllers\AdminPortal\FinanceController::class, 'index'])->name('finance.index');
    Route::resource('finance/accounts', App\Http\Controllers\AdminPortal\AccountController::class, ['names' => 'finance.accounts']);
    Route::resource('finance/categories', App\Http\Controllers\AdminPortal\TransactionCategoryController::class, ['names' => 'finance.categories']);
    Route::resource('finance/transactions', App\Http\Controllers\AdminPortal\TransactionController::class, ['names' => 'finance.transactions']);
    Route::post('finance/transfers', [App\Http\Controllers\AdminPortal\FinanceController::class, 'storeTransfer'])->name('finance.transfers.store');
    Route::get('finance/reports', [App\Http\Controllers\AdminPortal\ReportController::class, 'index'])->name('finance.reports');
    
    // Activity Log
    Route::get('activity-log', [App\Http\Controllers\AdminPortal\ActivityLogController::class, 'index'])->name('admin.activity-log');

    // Lead Radar
    Route::get('radar-leads', [\App\Http\Controllers\RadarLeadController::class, 'adminView'])->name('admin.radar-leads');

    // Global Software Industry Trend Intelligence Admin Workflow
    Route::prefix('trend-intelligence')->name('admin.trend-intelligence.')->group(function () {
        Route::get('/', [TrendIntelligenceAdminController::class, 'index'])->name('index');
        Route::post('/sources', [TrendIntelligenceAdminController::class, 'storeSource'])->name('sources.store');
        Route::put('/sources/{source}', [TrendIntelligenceAdminController::class, 'updateSource'])->name('sources.update');
        Route::put('/categories/{category}', [TrendIntelligenceAdminController::class, 'updateCategory'])->name('categories.update');
        Route::post('/collect', [TrendIntelligenceAdminController::class, 'collect'])->name('collect');
        Route::post('/aggregate', [TrendIntelligenceAdminController::class, 'aggregate'])->name('aggregate');
        Route::post('/forecasts/generate', [TrendIntelligenceAdminController::class, 'generateForecast'])->name('forecasts.generate');
        Route::put('/forecasts/{forecast}', [TrendIntelligenceAdminController::class, 'updateForecast'])->name('forecasts.update');
        Route::post('/forecasts/{forecast}/approve', [TrendIntelligenceAdminController::class, 'approveForecast'])->name('forecasts.approve');
        Route::post('/forecasts/{forecast}/publish', [TrendIntelligenceAdminController::class, 'publishForecast'])->name('forecasts.publish');
        Route::post('/forecasts/{forecast}/unpublish', [TrendIntelligenceAdminController::class, 'unpublishForecast'])->name('forecasts.unpublish');
        Route::post('/forecasts/{forecast}/archive', [TrendIntelligenceAdminController::class, 'archiveForecast'])->name('forecasts.archive');
        Route::post('/forecasts/{forecast}/evaluate', [TrendIntelligenceAdminController::class, 'evaluateForecast'])->name('forecasts.evaluate');
    });
});

// Client Portal
Route::group(['prefix' => 'client', 'middleware' => ['auth', 'client']], function () {
    Route::get('/', [App\Http\Controllers\ClientPortal\DashboardController::class, 'index'])->name('client.dashboard');
    Route::get('/dashboard', [App\Http\Controllers\ClientPortal\DashboardController::class, 'index']);
    
    Route::get('projects', [App\Http\Controllers\ClientPortal\ProjectController::class, 'index'])->name('client.projects.index');
    Route::get('projects/{project}', [App\Http\Controllers\ClientPortal\ProjectController::class, 'show'])->name('client.projects.show');
    
    Route::get('tasks/{task}', [App\Http\Controllers\ClientPortal\TaskController::class, 'show'])->name('client.tasks.show');
    Route::post('tasks/{task}/comments', [App\Http\Controllers\ClientPortal\TaskController::class, 'addComment'])->name('client.tasks.comments.store');
    
    Route::resource('requests', App\Http\Controllers\ClientPortal\ClientRequestController::class, [
        'names' => 'client.requests',
        'parameters' => ['requests' => 'client_request']
    ]);
    
    Route::get('profile', [App\Http\Controllers\ClientPortal\ProfileController::class, 'index'])->name('client.profile');
    Route::post('profile', [App\Http\Controllers\ClientPortal\ProfileController::class, 'update'])->name('client.profile.update');
});

// Shared Attachment routes
Route::get('attachments/{attachment}/download', [App\Http\Controllers\AttachmentController::class, 'download'])
    ->middleware(['auth'])
    ->name('attachments.download');
Route::delete('attachments/{attachment}', [App\Http\Controllers\AttachmentController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('attachments.destroy');
