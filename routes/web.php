<?php

use AvoRed\Framework\Catalog\Controllers\AttributeController;
use AvoRed\Framework\Catalog\Controllers\CategoryController;
use AvoRed\Framework\Catalog\Controllers\ProductController;
use AvoRed\Framework\Catalog\Controllers\ProductReviewController;
use AvoRed\Framework\Catalog\Controllers\PropertyController;
use AvoRed\Framework\Cms\Controllers\PageController;
use AvoRed\Framework\Equipment\Controllers\EquipmentController;
use AvoRed\Framework\HowToVideo\Controllers\HowToVideoController;
use AvoRed\Framework\Order\Controllers\OrderController;
use AvoRed\Framework\Order\Controllers\OrderStatusController;
use AvoRed\Framework\System\Controllers\RoleController;
use AvoRed\Framework\User\Controllers\LoginController;
use AvoRed\Framework\User\Controllers\StaffController;
use AvoRed\Framework\User\Controllers\SubscriberController;
use AvoRed\Framework\Recipe\Controllers\RecipeController;
use AvoRed\Framework\Post\Controllers\PostController;
use AvoRed\Framework\GroupChat\Controllers\GroupChatController;
use AvoRed\Framework\MapData\Controllers\MapDataController;
use AvoRed\Framework\User\Controllers\UsersController;
use AvoRed\Framework\_Category\Controllers\NewCategoryController;
use AvoRed\Framework\_Product\Controllers\NewProductController;
use Illuminate\Support\Facades\Route;
use AvoRed\Framework\Equipment\Controllers\EquipmentVideoController;
use AvoRed\Framework\AdminChatMessage\Controllers\AdminChatMessageController;

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


$baseAdminUrl = config('avored.admin_url');

Route::middleware(['web'])
    ->prefix($baseAdminUrl)
    ->namespace('AvoRed\\Framework')
    ->name('admin.')
    ->group(function () {

        /***************** LOGIN ROUTE *****************/
        Route::get('login', [LoginController::class, 'loginForm'])
            ->name('login');
        Route::post('login', [LoginController::class, 'login'])
            ->name('login.post');
        Route::get('logout', [LoginController::class, 'logout'])
            ->name('logout');

        /***************** PASSWORD RESET *****************/
        Route::get(
            'password/reset',
            [\AvoRed\Framework\User\Controllers\ForgotPasswordController::class, 'linkRequestForm']
        )->name('password.request');
        Route::post(
            'password/email',
            [\AvoRed\Framework\User\Controllers\ForgotPasswordController::class, 'sendResetLinkEmail']
        )->name('password.email');

        Route::get(
            'password/reset/{token}',
            [\AvoRed\Framework\User\Controllers\ResetPasswordController::class, 'showResetForm']
        )->name('password.reset');
        Route::post('password/reset', [\AvoRed\Framework\User\Controllers\ResetPasswordController::class, 'reset'])
            ->name('password.update');
    });

Route::middleware(['web', 'admin.auth:admin', 'permission'])
    ->prefix($baseAdminUrl)
    ->name('admin.')
    ->group(function () {

        // Route::get('', [DashboardController::class, 'index'])
        //     ->name('dashboard');
        Route::get('', [OrderController::class, 'index'])
            ->name('dashboard');


        /***************** CATALOG ROUTES *****************/
        Route::resource('category', CategoryController::class);
//        Route::resource('property', PropertyController::class);
//        Route::resource('attribute', AttributeController::class);
        Route::resource('product', ProductController::class);
//        Route::resource('product-review', ProductReviewController::class);
        Route::get('product-review', [ProductReviewController::class, 'index'])->name('product-review.index');
        Route::get('product-review/{review}/{status}', [ProductReviewController::class, 'update'])->name('product-review.update-status');
        Route::delete('product-review/{review}', [ProductReviewController::class, 'destroy'])->name('product-review.destroy');

        /***************** USER ROUTES *****************/
        Route::resource('staff', StaffController::class);
        Route::resource('users', UsersController::class);
        Route::resource('subscriber', SubscriberController::class);


        /***************** ORDER ROUTES *****************/
        Route::resource('order-status', OrderStatusController::class);
        Route::get('order', [OrderController::class, 'index'])->name('order.index');
        Route::post('order/status', [OrderController::class, 'status'])->name('order.status');
        Route::post('order/filter', [OrderController::class, 'filter'])->name('order.filter');
        Route::get('order/{order}', [OrderController::class, 'show'])->name('order.show');


        /***************** Recipes Routes ****************/
        Route::resource('recipe', RecipeController::class);

        /***************** Categories Routes ****************/
        Route::resource('new_category', NewCategoryController::class);

        /***************** Categories Routes ****************/
        Route::resource('new_product', NewProductController::class);

        /***************** Equipment Routes ****************/
        Route::group(['prefix' => 'equipment/{id}/videos', 'as' => 'equipment.videos.'], function () {
            Route::get('/', [EquipmentVideoController::class, 'index'])->name('index');
            Route::get('create', [EquipmentVideoController::class, 'create'])->name('create');
            Route::post('create', [EquipmentVideoController::class, 'store'])->name('store');
            Route::get('edit/{video_id}', [EquipmentVideoController::class, 'edit'])->name('edit');
            Route::put('edit/{video_id}', [EquipmentVideoController::class, 'update'])->name('update');
            Route::delete('/{video_id}', [EquipmentVideoController::class, 'destroy'])->name('destroy');
        });
        Route::resource('equipment', EquipmentController::class);
        Route::put('equipment-review/{review}', [EquipmentController::class, 'updateStatus'])->name('equipment-review.status-update');
        Route::delete('equipment-review/{id}', [EquipmentController::class, 'deleteReview'])->name('equipment-review.delete');

        /***************** Group Chat Routes ****************/
        Route::resource('group-chat', GroupChatController::class);

        /***************** Map Data Routes {map_datum} ****************/
        Route::resource('map-data', MapDataController::class);
        Route::post('map-data/search', [MapDataController::class, 'search'])->name('map-data.search');

        /***************** How to video uploads Routes ****************/
        Route::resource('how-to-video', HowToVideoController::class);

        /***************** Post Routes ****************/
        Route::get('post', [PostController::class, 'index'])->name('post.index');
        Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');
        Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');
        Route::delete('post/{post}/comment/{comment}', [PostController::class, 'commentDestroy'])->name('post-comment.destroy');

        /***************** CMS ROUTES *****************/
        Route::resource('page', PageController::class);


        /***************** SYSTEM ROUTES *****************/
        Route::resource('role', RoleController::class);
        Route::get('configuration', [\AvoRed\Framework\System\Controllers\ConfigurationController::class, 'index'])
            ->name('configuration.index');
        Route::post('configuration', [\AvoRed\Framework\System\Controllers\ConfigurationController::class, 'store'])
            ->name('configuration.store');

        /*************** REPORTED ROUTES ****************/
        Route::group(['prefix' => 'reported', 'as' => 'reported.'], function () {
            Route::get('/{type}', [\AvoRed\Framework\Reported\Controllers\ReportedController::class, 'index'])
                ->name('index');
            Route::get('/{type}/view/{id}', [\AvoRed\Framework\Reported\Controllers\ReportedController::class, 'itemShow'])
                ->name('item.show');
            Route::delete('/{type}/view/{id}', [\AvoRed\Framework\Reported\Controllers\ReportedController::class, 'itemDestroy'])
                ->name('item.destroy');

            Route::delete('/{reported}', [\AvoRed\Framework\Reported\Controllers\ReportedController::class, 'destroy'])
                ->name('destroy');
        });

        /*************** EMAIL SUBSCRIPTION ROUTES ****************/
        Route::group(['prefix' => 'email-subscription', 'as' => 'email-subscription.'], function () {
            Route::get('/', [\AvoRed\Framework\EmailSubscription\Controllers\EmailSubscriptionController::class, 'index'])
                ->name('index');

            Route::delete('/{email_sub}', [\AvoRed\Framework\EmailSubscription\Controllers\EmailSubscriptionController::class, 'destroy'])
                ->name('destroy');
        });

        /*************** BLOCK USERS ROUTES ****************/
        Route::group(['prefix' => 'block-users', 'as' => 'block-users.'], function () {
            Route::get('/', [\AvoRed\Framework\BlockUsers\Controllers\BlockUsers::class, 'index'])
                ->name('index');
        });


        /***************** SETTINGS ROUTES *****************/
        Route::get('settings/payments', [\AvoRed\Framework\System\Controllers\SettingsController::class, 'payments'])
            ->name('settings.payments');
        Route::post('settings/payments', [\AvoRed\Framework\System\Controllers\SettingsController::class, 'paymentsUpdate'])
            ->name('settings.payments.update');

        Route::get('settings/contact', [\AvoRed\Framework\System\Controllers\SettingsController::class, 'contact'])
            ->name('settings.contact');
        Route::post('settings/contact', [\AvoRed\Framework\System\Controllers\SettingsController::class, 'contactUpdate'])
            ->name('settings.contact.update');

        /***************** Admin Chat Message Routes ****************/
        Route::resource('admin-chat-message', AdminChatMessageController::class);
    });




