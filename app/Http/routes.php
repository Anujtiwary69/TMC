<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::resource('automation', 'AutomationController');
Route::group(['middleware' => ['installed']], function () {
    // Installation
    Route::get('install', 'InstallController@starting');
    Route::get('install/site-info', 'InstallController@siteInfo');
    Route::post('install/site-info', 'InstallController@siteInfo');
    Route::get('install/system-compatibility', 'InstallController@systemCompatibility');
    Route::get('install/database', 'InstallController@database');
    Route::post('install/database', 'InstallController@database');
    Route::get('install/database_import', 'InstallController@databaseImport');
    Route::get('install/import', 'InstallController@import');
    Route::get('install/cron-jobs', 'InstallController@cronJobs');
    Route::post('install/cron-jobs', 'InstallController@cronJobs');
    Route::get('install/finishing', 'InstallController@finishing');
    Route::get('install/finish', 'InstallController@finish');
});

Route::group(['namespace' => 'Api', 'prefix' => 'api/v1', 'middleware' => 'auth:api'], function () {
    // Route::group(['namespace' => 'Api', 'prefix' => 'api/v1'], function () {
    Route::get('', 'HomeController@index');

    // List
    Route::resource('lists', 'MailListController');

    // Campaign
    Route::resource('campaigns', 'CampaignController');

    // Subscriber
    Route::patch('lists/{list_uid}/subscribers/{uid}/update', 'SubscriberController@update');
    Route::get('subscribers/email/{email}', 'SubscriberController@showByEmail');
    Route::patch('lists/{list_uid}/subscribers/{uid}/update', 'SubscriberController@update');
    Route::get('lists/{list_uid}/subscribers', 'SubscriberController@index');
    Route::get('lists/{list_uid}/subscribers/{uid}', 'SubscriberController@show');
    Route::patch('lists/{list_uid}/subscribers/{uid}/subscribe', 'SubscriberController@subscribe');
    Route::patch('lists/{list_uid}/subscribers/{uid}/unsubscribe', 'SubscriberController@unsubscribe');
    Route::delete('lists/{list_uid}/subscribers/{uid}/delete', 'SubscriberController@delete');
    Route::post('lists/{list_uid}/subscribers/store', 'SubscriberController@store');

    // Automation
    Route::post('automations/{uid}/api/call', 'AutomationController@apiCall');

    // Sending server
    Route::resource('sending_servers', 'SendingServerController');

    // Plan
    Route::resource('plans', 'PlanController');

    // Customer
    Route::patch('customers/{uid}/disable', 'CustomerController@disable');
    Route::patch('customers/{uid}/enable', 'CustomerController@enable');
    Route::resource('customers', 'CustomerController');

    // Subscription
    Route::resource('subscriptions', 'SubscriptionController');

    // File
    Route::post('file/upload', 'FileController@upload');
});

Route::group(['middleware' => ['not_logged_in']], function () {
    Route::auth();
    Route::get('user/activate/{token}', 'UserController@activate');

    Route::get('/offline', 'Controller@offline');
    Route::get('/not-authorized', 'Controller@notAuthorized');
    Route::get('/demo', 'Controller@demo');
    Route::get('/demo/go/{view}', 'Controller@demoGo');
    Route::get('/autologin/{api_token}', 'Controller@autoLogin');
    Route::get('/reload/cache', 'Controller@reloadCache');
    Route::get('/migrate/run', 'Controller@runMigration');
    Route::post('/remote-job/{remote_job_token}', 'Controller@remoteJob');

    // Customer avatar
    Route::get('assets/images/avatar/customer-{uid?}.jpg', 'CustomerController@avatar');

    // Admin avatar
    Route::get('assets/images/avatar/admin-{uid?}.jpg', 'AdminController@avatar');

    // Customer subscription
    Route::get('subscriptions/preview', 'SubscriptionController@preview');
    Route::post('subscriptions/register/{plan_uid?}', 'SubscriptionController@register');
    Route::get('subscriptions/register/{plan_uid?}', 'SubscriptionController@register');
    Route::get('subscriptions/select-plan', 'SubscriptionController@selectPlan');

    // User resend activation email
    Route::get('users/resend-activation-email', 'UserController@resendActivationEmail');

    // Plan
    Route::get('plans/select2', 'PlanController@select2');

    // Payments
    Route::get('paypal-payment-cancel/{subscription_uid}', 'PaymentController@paypalCancel');
    Route::get('paypal-payment-status/{subscription_uid}', 'PaymentController@paypalStatus');
    Route::get('paypal-payment-cancel', function () {
        return 'Payment has been canceled';
    });

    // Translation data
    Route::get('/datatable_locale', 'Controller@datatable_locale');
    Route::get('/jquery_validate_locale', 'Controller@jquery_validate_locale');
});

Route::group(['middleware' => ['not_installed', 'frontend']], function () {
    Route::get('/', 'HomeController@index');
    Route::get('{view}/docs/api/v1', 'Controller@docsApiV1');

    Route::get('/current_user_uid', 'UserController@showUid');

    // Update current user profile
    Route::get('account/api/renew', 'AccountController@renewToken');
    Route::get('account/api', 'AccountController@api');
    Route::get('account/profile', 'AccountController@profile');
    Route::post('account/profile', 'AccountController@profile');
    Route::get('account/contact', 'AccountController@contact');
    Route::post('account/contact', 'AccountController@contact');
    Route::get('account/logs', 'AccountController@logs');
    Route::get('account/logs/listing', 'AccountController@logsListing');
    Route::get('account/quota_log', 'AccountController@quotaLog');
    Route::get('account/subscription', 'AccountController@subscription');
    Route::get('account/subscription/new', 'AccountController@subscriptionNew');

    // User avatar
    Route::get('assets/images/avatar/user-{uid?}.jpg', 'UserController@avatar');

    // Mail list
    Route::get('lists/{uid}/verification/progress', 'MailListController@verificationProgress');
    Route::get('lists/{uid}/verification', 'MailListController@verification');
    Route::post('lists/{uid}/verification/start', 'MailListController@startVerification');
    Route::post('lists/{uid}/verification/stop', 'MailListController@stopVerification');
    Route::post('lists/{uid}/verification/reset', 'MailListController@resetVerification');
    Route::post('lists/copy', 'MailListController@copy');
    Route::get('lists/quick-view', 'MailListController@quickView');
    Route::get('lists/{uid}/list-growth', 'MailListController@listGrowthChart');
    Route::get('lists/{uid}/list-statistics-chart', 'MailListController@statisticsChart');
    Route::get('lists/sort', 'MailListController@sort');
    Route::get('lists/listing/{page?}', 'MailListController@listing');
    Route::get('lists/delete', 'MailListController@delete');
    Route::get('lists/delete/confirm', 'MailListController@deleteConfirm');
    Route::get('lists/{uid}/overview', 'MailListController@overview');
    Route::resource('lists', 'MailListController');
    Route::get('lists/{uid}/edit', 'MailListController@edit');
    Route::patch('lists/{uid}/update', 'MailListController@update');
    Route::get('lists/{uid}/embedded-form', 'MailListController@embeddedForm');
    Route::post('lists/{uid}/embedded-form-subscribe', 'MailListController@embeddedFormSubscribe');
    Route::post('lists/{uid}/embedded-form-subscribe-captcha', 'MailListController@embeddedFormCaptcha');
    Route::get('lists/{uid}/embedded-form-frame', 'MailListController@embeddedFormFrame');

    // PR list
    Route::get('prlists/{uid}/verification/progress', 'PRListController@verificationProgress');
    Route::get('prlists/{uid}/verification', 'PRListController@verification');
    Route::post('prlists/{uid}/verification/start', 'PRListController@startVerification');
    Route::post('prlists/{uid}/verification/stop', 'PRListController@stopVerification');
    Route::post('prlists/{uid}/verification/reset', 'PRListController@resetVerification');
    Route::post('prlists/copy', 'PRListController@copy');
    Route::get('prlists/quick-view', 'PRListController@quickView');
    Route::get('prlists/{uid}/list-growth', 'PRListController@listGrowthChart');
    Route::get('prlists/{uid}/list-statistics-chart', 'PRListController@statisticsChart');
    Route::get('prlists/sort', 'PRListController@sort');
    Route::get('prlists/listing/{page?}', 'PRListController@listing');
    Route::get('prlists/delete', 'PRListController@delete');
    Route::get('prlists/delete/confirm', 'PRListController@deleteConfirm');
    Route::get('prlists/{uid}/overview', 'PRListController@overview');
    Route::resource('prlists', 'PRListController');
    Route::get('prlists/{uid}/edit', 'PRListController@edit');
    Route::patch('prlists/{uid}/update', 'PRListController@update');
    Route::get('prlists/{uid}/embedded-form', 'PRListController@embeddedForm');
    Route::post('prlists/{uid}/embedded-form-subscribe', 'PRListController@embeddedFormSubscribe');
    Route::post('prlists/{uid}/embedded-form-subscribe-captcha', 'PRListController@embeddedFormCaptcha');
    Route::get('prlists/{uid}/embedded-form-frame', 'PRListController@embeddedFormFrame');

    // Field
    Route::get('lists/{list_uid}/fields', 'FieldController@index');
    Route::get('lists/{list_uid}/fields/sort', 'FieldController@sort');
    Route::post('lists/{list_uid}/fields/store', 'FieldController@store');
    Route::get('lists/{list_uid}/fields/sample/{type}', 'FieldController@sample');
    Route::get('lists/{list_uid}/fields/{uid}/delete', 'FieldController@delete');

    // PR Field
    Route::get('prlists/{list_uid}/fields', 'PRFieldController@index');
    Route::get('prlists/{list_uid}/fields/sort', 'PRFieldController@sort');
    Route::post('prlists/{list_uid}/fields/store', 'PRFieldController@store');
    Route::get('prlists/{list_uid}/fields/sample/{type}', 'PRFieldController@sample');
    Route::get('prlists/{list_uid}/fields/{uid}/delete', 'PRFieldController@delete');

    // Subscriber
    Route::post('subscriber/{uid}/verification/start', 'SubscriberController@startVerification');
    Route::post('subscriber/{uid}/verification/reset', 'SubscriberController@resetVerification');
    Route::get('subscribers/copy-move-from/{list_uid}/{action}', 'SubscriberController@copyMoveForm');
    Route::post('subscribers/move', 'SubscriberController@move');
    Route::post('subscribers/copy', 'SubscriberController@copy');
    Route::get('lists/{list_uid}/subscribers', 'SubscriberController@index');
    Route::get('lists/{list_uid}/subscribers/create', 'SubscriberController@create');
    Route::get('lists/{list_uid}/subscribers/listing', 'SubscriberController@listing');
    Route::post('lists/{list_uid}/subscribers/store', 'SubscriberController@store');
    Route::get('lists/{list_uid}/subscribers/{uid}/edit', 'SubscriberController@edit');
    Route::patch('lists/{list_uid}/subscribers/{uid}/update', 'SubscriberController@update');
    Route::get('lists/{list_uid}/subscribers/delete', 'SubscriberController@delete');
    Route::get('lists/{list_uid}/subscribers/subscribe', 'SubscriberController@subscribe');
    Route::get('lists/{list_uid}/subscribers/unsubscribe', 'SubscriberController@unsubscribe');
    Route::get('lists/{list_uid}/subscribers/import', 'SubscriberController@import');
    Route::post('lists/{list_uid}/subscribers/import', 'SubscriberController@import');
    Route::get('lists/{list_uid}/subscribers/import/list', 'SubscriberController@importList');
    Route::get('lists/{list_uid}/subscribers/import/log', 'SubscriberController@downloadImportLog');
    Route::get('lists/{list_uid}/subscribers/import/proccess', 'SubscriberController@importProccess');
    Route::get('lists/{list_uid}/subscribers/export', 'SubscriberController@export');
    Route::post('lists/{list_uid}/subscribers/export', 'SubscriberController@export');
    Route::get('lists/{list_uid}/subscribers/export/proccess', 'SubscriberController@exportProccess');
    Route::get('lists/{list_uid}/subscribers/export/download', 'SubscriberController@downloadExportedCsv');
    Route::get('lists/{list_uid}/subscribers/export/list', 'SubscriberController@exportList');

    //PR Subscriber
    Route::post('prsubscriber/{uid}/verification/start', 'PRSubscriberController@startVerification');
    Route::post('prsubscriber/{uid}/verification/reset', 'PRSubscriberController@resetVerification');
    Route::get('prsubscribers/copy-move-from/{list_uid}/{action}', 'PRSubscriberController@copyMoveForm');
    Route::post('prsubscribers/move', 'PRSubscriberController@move');
    Route::post('prsubscribers/copy', 'PRSubscriberController@copy');
    Route::get('prlists/{list_uid}/subscribers', 'PRSubscriberController@index');
    Route::get('prlists/{list_uid}/subscribers/create', 'PRSubscriberController@create');
    Route::get('prlists/{list_uid}/subscribers/listing', 'PRSubscriberController@listing');
    Route::post('prlists/{list_uid}/subscribers/store', 'PRSubscriberController@store');
    Route::get('prlists/{list_uid}/subscribers/{uid}/edit', 'PRSubscriberController@edit');
    Route::patch('prlists/{list_uid}/subscribers/{uid}/update', 'PRSubscriberController@update');
    Route::get('prlists/{list_uid}/subscribers/delete', 'PRSubscriberController@delete');
    Route::get('prlists/{list_uid}/subscribers/subscribe', 'PRSubscriberController@subscribe');
    Route::get('prlists/{list_uid}/subscribers/unsubscribe', 'PRSubscriberController@unsubscribe');
    Route::get('prlists/{list_uid}/subscribers/import', 'PRSubscriberController@import');
    Route::post('prlists/{list_uid}/subscribers/import', 'PRSubscriberController@import');
    Route::get('prlists/{list_uid}/subscribers/import/list', 'PRSubscriberController@importList');
    Route::get('prlists/{list_uid}/subscribers/import/log', 'PRSubscriberController@downloadImportLog');
    Route::get('prlists/{list_uid}/subscribers/import/proccess', 'PRSubscriberController@importProccess');
    Route::get('prlists/{list_uid}/subscribers/export', 'PRSubscriberController@export');
    Route::post('prlists/{list_uid}/subscribers/export', 'PRSubscriberController@export');
    Route::get('prlists/{list_uid}/subscribers/export/proccess', 'PRSubscriberController@exportProccess');
    Route::get('prlists/{list_uid}/subscribers/export/download', 'PRSubscriberController@downloadExportedCsv');
    Route::get('prlists/{list_uid}/subscribers/export/list', 'PRSubscriberController@exportList');

    // Notification handler
    Route::post('delivery/notify/{stype}', 'DeliveryController@notify');
    Route::get('delivery/notify/{stype}', 'DeliveryController@notify');

    // Segment
    Route::get('segments/condition-value-control', 'SegmentController@conditionValueControl');
    Route::get('segments/select_box', 'SegmentController@selectBox');
    Route::get('lists/{list_uid}/segments', 'SegmentController@index');
    Route::get('lists/{list_uid}/segments/{uid}/subscribers', 'SegmentController@subscribers');
    Route::get('lists/{list_uid}/segments/{uid}/listing_subscribers', 'SegmentController@listing_subscribers');
    Route::get('lists/{list_uid}/segments/create', 'SegmentController@create');
    Route::get('lists/{list_uid}/segments/listing', 'SegmentController@listing');
    Route::post('lists/{list_uid}/segments/store', 'SegmentController@store');
    Route::get('lists/{list_uid}/segments/{uid}/edit', 'SegmentController@edit');
    Route::patch('lists/{list_uid}/segments/{uid}/update', 'SegmentController@update');
    Route::get('lists/{list_uid}/segments/delete', 'SegmentController@delete');
    Route::get('lists/{list_uid}/segments/sample_condition', 'SegmentController@sample_condition');

    // Segment
    Route::get('prsegments/condition-value-control', 'PRSegmentController@conditionValueControl');
    Route::get('prsegments/select_box', 'PRSegmentController@selectBox');
    Route::get('prlists/{list_uid}/segments', 'PRSegmentController@index');
    Route::get('prlists/{list_uid}/segments/{uid}/subscribers', 'PRSegmentController@subscribers');
    Route::get('prlists/{list_uid}/segments/{uid}/listing_subscribers', 'PRSegmentController@listing_subscribers');
    Route::get('prlists/{list_uid}/segments/create', 'PRSegmentController@create');
    Route::get('prlists/{list_uid}/segments/listing', 'PRSegmentController@listing');
    Route::post('prlists/{list_uid}/segments/store', 'PRSegmentController@store');
    Route::get('prlists/{list_uid}/segments/{uid}/edit', 'PRSegmentController@edit');
    Route::patch('prlists/{list_uid}/segments/{uid}/update', 'PRSegmentController@update');
    Route::get('prlists/{list_uid}/segments/delete', 'PRSegmentController@delete');
    Route::get('prlists/{list_uid}/segments/sample_condition', 'PRSegmentController@sample_condition');

    // Page
    Route::get('lists/{list_uid}/pages/{alias}/update', 'PageController@update');
    Route::post('lists/{list_uid}/pages/{alias}/update', 'PageController@update');
    Route::post('lists/{list_uid}/pages/{alias}/preview', 'PageController@preview');
    Route::get('lists/{list_uid}/sign-up', 'PageController@signUpForm');
    Route::post('lists/{list_uid}/sign-up', 'PageController@signUpForm');
    Route::get('lists/{list_uid}/sign-up/thank-you', 'PageController@signUpThankyouPage');
    Route::get('lists/{list_uid}/subscribe-confirm/{uid}/{code}', 'PageController@signUpConfirmationThankyou');
    Route::get('lists/{list_uid}/unsubscribe/{uid}/{code}', 'PageController@unsubscribeForm');
    Route::post('lists/{list_uid}/unsubscribe/{uid}/{code}', 'PageController@unsubscribeForm');
    Route::get('lists/{list_uid}/update-profile/{uid}/{code}', 'PageController@profileUpdateForm');
    Route::post('lists/{list_uid}/update-profile/{uid}/{code}', 'PageController@profileUpdateForm');
    Route::get('lists/{list_uid}/update-profile-success/{uid}', 'PageController@profileUpdateSuccessPage');
    Route::get('lists/{list_uid}/profile-update-email-sent/{uid}', 'PageController@profileUpdateEmailSent');
    Route::get('lists/{list_uid}/unsubscribe-success/{uid}', 'PageController@unsubscribeSuccessPage');

    // PR Page
    Route::get('prlists/{list_uid}/pages/{alias}/update', 'PRPageController@update');
    Route::post('prlists/{list_uid}/pages/{alias}/update', 'PRPageController@update');
    Route::post('prlists/{list_uid}/pages/{alias}/preview', 'PRPageController@preview');
    Route::get('prlists/{list_uid}/sign-up', 'PRPageController@signUpForm');
    Route::post('prlists/{list_uid}/sign-up', 'PRPageController@signUpForm');
    Route::get('prlists/{list_uid}/sign-up/thank-you', 'PRPageController@signUpThankyouPage');
    Route::get('prlists/{list_uid}/subscribe-confirm/{uid}/{code}', 'PRPageController@signUpConfirmationThankyou');
    Route::get('prlists/{list_uid}/unsubscribe/{uid}/{code}', 'PRPageController@unsubscribeForm');
    Route::post('prlists/{list_uid}/unsubscribe/{uid}/{code}', 'PRPageController@unsubscribeForm');
    Route::get('prlists/{list_uid}/update-profile/{uid}/{code}', 'PRPageController@profileUpdateForm');
    Route::post('prlists/{list_uid}/update-profile/{uid}/{code}', 'PRPageController@profileUpdateForm');
    Route::get('prlists/{list_uid}/update-profile-success/{uid}', 'PRPageController@profileUpdateSuccessPage');
    Route::get('prlists/{list_uid}/profile-update-email-sent/{uid}', 'PRPageController@profileUpdateEmailSent');
    Route::get('prlists/{list_uid}/unsubscribe-success/{uid}', 'PRPageController@unsubscribeSuccessPage');

    // Template
    Route::get('templates/{uid}/content', 'TemplateController@content');
    Route::get('templates/sort', 'TemplateController@sort');
    Route::get('templates/listing/{page?}', 'TemplateController@listing');
    Route::get('templates/choosing/{campaign_uid}/{page?}', 'TemplateController@choosing');
    Route::get('templates/upload', 'TemplateController@upload');
    Route::post('templates/upload', 'TemplateController@upload');
    Route::get('templates/{uid}/image', 'TemplateController@image');
    Route::post('templates/{uid}/saveImage', 'TemplateController@saveImage');
    Route::get('templates/{uid}/preview', 'TemplateController@preview');
    Route::get('templates/delete', 'TemplateController@delete');
    Route::get('templates/build/select', 'TemplateController@buildSelect');
    Route::get('templates/build/{style?}', 'TemplateController@build');
    Route::get('templates/{uid}/rebuild', 'TemplateController@rebuild');
    Route::resource('templates', 'TemplateController');
    Route::get('templates/{uid}/edit', 'TemplateController@edit');
    Route::patch('templates/{uid}/update', 'TemplateController@update');

    // PR Template
    Route::get('prtemplates/{uid}/content', 'PRTemplateController@content');
    Route::get('prtemplates/sort', 'PRTemplateController@sort');
    Route::get('prtemplates/listing/{page?}', 'PRTemplateController@listing');
    Route::get('prtemplates/choosing/{campaign_uid}/{page?}', 'PRTemplateController@choosing');
    Route::get('prtemplates/upload', 'PRTemplateController@upload');
    Route::post('prtemplates/upload', 'PRTemplateController@upload');
    Route::get('prtemplates/{uid}/image', 'PRTemplateController@image');
    Route::post('prtemplates/{uid}/saveImage', 'PRTemplateController@saveImage');
    Route::get('prtemplates/{uid}/preview', 'PRTemplateController@preview');
    Route::get('prtemplates/delete', 'PRTemplateController@delete');
    Route::get('prtemplates/build/select', 'PRTemplateController@buildSelect');
    Route::get('prtemplates/build/{style?}', 'PRTemplateController@build');
    Route::get('prtemplates/{uid}/rebuild', 'PRTemplateController@rebuild');
    Route::resource('prtemplates', 'PRTemplateController');
    Route::get('prtemplates/{uid}/edit', 'PRTemplateController@edit');
    Route::patch('prtemplates/{uid}/update', 'PRTemplateController@update');


    // Campaign
    Route::get('campaigns/{message_id}/web-view', 'CampaignController@webView');
    Route::get('campaigns/select-type', 'CampaignController@selectType');
    Route::get('campaigns/{uid}/list-segment-form', 'CampaignController@listSegmentForm');
    Route::get('campaigns/{uid}/template/review', 'CampaignController@templateReview');
    Route::post('campaigns/{uid}/image/save', 'CampaignController@saveImage');
    Route::get('campaigns/{uid}/image', 'CampaignController@image');
    Route::get('campaigns/{uid}/preview', 'CampaignController@preview');
    Route::get('campaigns/templates/list', 'CampaignController@templateList');
    Route::patch('campaigns/{uid}/templates/choose/from/{from_uid}', 'CampaignController@campaignTemplateChoose');
    Route::post('campaigns/send-test-email', 'CampaignController@sendTestEmail');
    Route::get('campaigns/delete/confirm', 'CampaignController@deleteConfirm');
    Route::get('campaigns/{message_id}/open', 'CampaignController@open');
    Route::get('campaigns/{message_id}/click/{url}', 'CampaignController@click');
    Route::get('campaigns/{message_id}/unsubscribe', 'CampaignController@unsubscribe');

    Route::post('campaigns/copy', 'CampaignController@copy');
    Route::get('campaigns/{uid}/subscribers', 'CampaignController@subscribers');
    Route::get('campaigns/{uid}/subscribers/listing', 'CampaignController@subscribersListing');
    Route::get('campaigns/{uid}/open-map', 'CampaignController@openMap');
    Route::get('campaigns/{uid}/tracking-log', 'CampaignController@trackingLog');
    Route::get('campaigns/{uid}/tracking-log/listing', 'CampaignController@trackingLogListing');
    Route::get('campaigns/{uid}/bounce-log', 'CampaignController@bounceLog');
    Route::get('campaigns/{uid}/bounce-log/listing', 'CampaignController@bounceLogListing');
    Route::get('campaigns/{uid}/feedback-log', 'CampaignController@feedbackLog');
    Route::get('campaigns/{uid}/feedback-log/listing', 'CampaignController@feedbackLogListing');
    Route::get('campaigns/{uid}/open-log', 'CampaignController@openLog');
    Route::get('campaigns/{uid}/open-log/listing', 'CampaignController@openLogListing');
    Route::get('campaigns/{uid}/click-log', 'CampaignController@clickLog');
    Route::get('campaigns/{uid}/click-log/listing', 'CampaignController@clickLogListing');
    Route::get('campaigns/{uid}/unsubscribe-log', 'CampaignController@unsubscribeLog');
    Route::get('campaigns/{uid}/unsubscribe-log/listing', 'CampaignController@unsubscribeLogListing');

    Route::get('campaigns/quick-view', 'CampaignController@quickView');
    Route::get('campaigns/{uid}/chart24h', 'CampaignController@chart24h');
    Route::get('campaigns/{uid}/chart', 'CampaignController@chart');
    Route::get('campaigns/{uid}/chart/countries/open', 'CampaignController@chartCountry');
    Route::get('campaigns/{uid}/chart/countries/click', 'CampaignController@chartClickCountry');
    Route::get('campaigns/{uid}/overview', 'CampaignController@overview');
    Route::get('campaigns/{uid}/links', 'CampaignController@links');
    Route::get('campaigns/sort', 'CampaignController@sort');
    Route::get('campaigns/listing/{page?}', 'CampaignController@listing');
    Route::get('campaigns/{uid}/recipients', 'CampaignController@recipients');
    Route::post('campaigns/{uid}/recipients', 'CampaignController@recipients');
    Route::get('campaigns/{uid}/setup', 'CampaignController@setup');
    Route::post('campaigns/{uid}/setup', 'CampaignController@setup');
    Route::get('campaigns/{uid}/template', 'CampaignController@template');
    Route::post('campaigns/{uid}/template', 'CampaignController@template');
    Route::get('campaigns/{uid}/template/select', 'CampaignController@templateSelect');
    Route::get('campaigns/{uid}/template/choose/{template_uid}', 'CampaignController@templateChoose');
    Route::get('campaigns/{uid}/template/preview', 'CampaignController@templatePreview');
    Route::get('campaigns/{uid}/template/iframe', 'CampaignController@templateIframe');
    Route::get('campaigns/{uid}/template/build/{style}', 'CampaignController@templateBuild');
    Route::get('campaigns/{uid}/template/rebuild', 'CampaignController@templateRebuild');
    Route::get('campaigns/{uid}/schedule', 'CampaignController@schedule');
    Route::post('campaigns/{uid}/schedule', 'CampaignController@schedule');
    Route::get('campaigns/{uid}/confirm', 'CampaignController@confirm');
    Route::post('campaigns/{uid}/confirm', 'CampaignController@confirm');
    Route::get('campaigns/delete', 'CampaignController@delete');
    Route::get('campaigns/select2', 'CampaignController@select2');
    Route::get('campaigns/pause', 'CampaignController@pause');
    Route::get('campaigns/restart', 'CampaignController@restart');
    Route::resource('campaigns', 'CampaignController');
    Route::get('campaigns/{uid}/edit', 'CampaignController@edit');
    Route::patch('campaigns/{uid}/update', 'CampaignController@update');

    Route::get('customers/login-back', 'CustomerController@loginBack');

    Route::get('users/login-back', 'UserController@loginBack');

    // PR Campaign
    Route::get('prcampaigns/{message_id}/web-view', 'PRCampaignController@webView');
    Route::get('prcampaigns/select-type', 'PRCampaignController@selectType');
    Route::get('prcampaigns/{uid}/list-segment-form', 'PRCampaignController@listSegmentForm');
    Route::get('prcampaigns/{uid}/template/review', 'PRCampaignController@templateReview');
    Route::post('campaigns/{uid}/image/save', 'PRCampaignController@saveImage');
    Route::get('prcampaigns/{uid}/image', 'PRCampaignController@image');
    Route::get('prcampaigns/{uid}/preview', 'PRCampaignController@preview');
    Route::get('prcampaigns/templates/list', 'PRCampaignController@templateList');
    Route::patch('prcampaigns/{uid}/templates/choose/from/{from_uid}', 'PRCampaignController@campaignTemplateChoose');
    Route::post('prcampaigns/send-test-email', 'PRCampaignController@sendTestEmail');
    Route::get('prcampaigns/delete/confirm', 'PRCampaignController@deleteConfirm');
    Route::get('prcampaigns/{message_id}/open', 'PRCampaignController@open');
    Route::get('prcampaigns/{message_id}/click/{url}', 'PRCampaignController@click');
    Route::get('prcampaigns/{message_id}/unsubscribe', 'PRCampaignController@unsubscribe');

    Route::post('prcampaigns/copy', 'PRCampaignController@copy');
    Route::get('prcampaigns/{uid}/subscribers', 'PRCampaignController@subscribers');
    Route::get('prcampaigns/{uid}/subscribers/listing', 'PRCampaignController@subscribersListing');
    Route::get('prcampaigns/{uid}/open-map', 'PRCampaignController@openMap');
    Route::get('prcampaigns/{uid}/tracking-log', 'PRCampaignController@trackingLog');
    Route::get('prcampaigns/{uid}/tracking-log/listing', 'PRCampaignController@trackingLogListing');
    Route::get('prcampaigns/{uid}/bounce-log', 'PRCampaignController@bounceLog');
    Route::get('prcampaigns/{uid}/bounce-log/listing', 'PRCampaignController@bounceLogListing');
    Route::get('prcampaigns/{uid}/feedback-log', 'PRCampaignController@feedbackLog');
    Route::get('prcampaigns/{uid}/feedback-log/listing', 'PRCampaignController@feedbackLogListing');
    Route::get('prcampaigns/{uid}/open-log', 'PRCampaignController@openLog');
    Route::get('prcampaigns/{uid}/open-log/listing', 'PRCampaignController@openLogListing');
    Route::get('prcampaigns/{uid}/click-log', 'PRCampaignController@clickLog');
    Route::get('prcampaigns/{uid}/click-log/listing', 'PRCampaignController@clickLogListing');
    Route::get('prcampaigns/{uid}/unsubscribe-log', 'PRCampaignController@unsubscribeLog');
    Route::get('prcampaigns/{uid}/unsubscribe-log/listing', 'PRCampaignController@unsubscribeLogListing');

    Route::get('prcampaigns/quick-view', 'PRCampaignController@quickView');
    Route::get('prcampaigns/{uid}/chart24h', 'PRCampaignController@chart24h');
    Route::get('prcampaigns/{uid}/chart', 'PRCampaignController@chart');
    Route::get('prcampaigns/{uid}/chart/countries/open', 'PRCampaignController@chartCountry');
    Route::get('prcampaigns/{uid}/chart/countries/click', 'PRCampaignController@chartClickCountry');
    Route::get('prcampaigns/{uid}/overview', 'PRCampaignController@overview');
    Route::get('prcampaigns/{uid}/links', 'PRCampaignController@links');
    Route::get('prcampaigns/sort', 'PRCampaignController@sort');
    Route::get('prcampaigns/listing/{page?}', 'PRCampaignController@listing');
    Route::get('prcampaigns/{uid}/recipients', 'PRCampaignController@recipients');
    Route::post('prcampaigns/{uid}/recipients', 'PRCampaignController@recipients');
    Route::get('prcampaigns/{uid}/setup', 'PRCampaignController@setup');
    Route::post('prcampaigns/{uid}/setup', 'PRCampaignController@setup');
    Route::get('prcampaigns/{uid}/template', 'PRCampaignController@template');
    Route::post('prcampaigns/{uid}/template', 'PRCampaignController@template');
    Route::get('prcampaigns/{uid}/template/select', 'PRCampaignController@templateSelect');
    Route::get('prcampaigns/{uid}/template/choose/{template_uid}', 'PRCampaignController@templateChoose');
    Route::get('prcampaigns/{uid}/template/preview', 'PRCampaignController@templatePreview');
    Route::get('prcampaigns/{uid}/template/iframe', 'PRCampaignController@templateIframe');
    Route::get('prcampaigns/{uid}/template/build/{style}', 'PRCampaignController@templateBuild');
    Route::get('prcampaigns/{uid}/template/rebuild', 'PRCampaignController@templateRebuild');
    Route::get('prcampaigns/{uid}/schedule', 'PRCampaignController@schedule');
    Route::post('prcampaigns/{uid}/schedule', 'PRCampaignController@schedule');
    Route::get('prcampaigns/{uid}/confirm', 'PRCampaignController@confirm');
    Route::post('prcampaigns/{uid}/confirm', 'PRCampaignController@confirm');
    Route::get('prcampaigns/delete', 'PRCampaignController@delete');
    Route::get('prcampaigns/select2', 'PRCampaignController@select2');
    Route::get('prcampaigns/pause', 'PRCampaignController@pause');
    Route::get('prcampaigns/restart', 'PRCampaignController@restart');
    Route::resource('prcampaigns', 'PRCampaignController');
    Route::get('prcampaigns/{uid}/edit', 'PRCampaignController@edit');
    Route::patch('prcampaigns/{uid}/update', 'PRCampaignController@update');
    Route::get('prcampaigns', 'PRCampaignController@index');

    // System job
    Route::post('systems/jobs/cancel', 'SystemJobController@cancel');
    Route::get('systems/jobs/{type}/listing', 'SystemJobController@listing');
    Route::get('systems/jobs/delete', 'SystemJobController@delete');
    Route::get('systems/jobs/{id}/download/log', 'SystemJobController@downloadLog');
    Route::get('systems/jobs/{id}/download/csv', 'SystemJobController@downloadCsv');

    // Automation
    Route::get('automations/{uid}/list-segment-form', 'AutomationController@listSegmentForm');
    Route::patch('automations/disable', 'AutomationController@disable');
    Route::patch('automations/enable', 'AutomationController@enable');
    Route::get('automations/{uid}/overview/emails/list', 'AutomationController@overviewCampaignsList');
    Route::get('automations/{uid}/overview/emails', 'AutomationController@overviewCampaigns');
    Route::get('automations/{uid}/overview/workflow', 'AutomationController@overviewWorkflow');
    Route::post('automations/{uid}/confirm', 'AutomationController@confirm');
    Route::get('automations/{uid}/confirm', 'AutomationController@confirm');
    Route::delete('automations/delete', 'AutomationController@delete');
    Route::get('automations/{uid}/auto-event/form', 'AutomationController@nextEventForm');
    Route::post('automations/{uid}/workflow', 'AutomationController@workflow');
    Route::get('automations/{uid}/workflow', 'AutomationController@workflow');
    Route::get('automations/{uid}/custom-criteria/form', 'AutomationController@criteriaForm');
    Route::post('automations/{uid}/trigger', 'AutomationController@trigger');
    Route::get('automations/{uid}/trigger', 'AutomationController@trigger');
    Route::get('automations/sort', 'AutomationController@sort');
    Route::get('automations/listing/{page?}', 'AutomationController@listing');
    Route::resource('automations', 'AutomationController');

    //PR Automation
    Route::get('prautomations/{uid}/list-segment-form', 'PRAutomationController@listSegmentForm');
    Route::patch('prautomations/disable', 'PRAutomationController@disable');
    Route::patch('prautomations/enable', 'PRAutomationController@enable');
    Route::get('prautomations/{uid}/overview/emails/list', 'PRAutomationController@overviewCampaignsList');
    Route::get('prautomations/{uid}/overview/emails', 'PRAutomationController@overviewCampaigns');
    Route::get('prautomations/{uid}/overview/workflow', 'PRAutomationController@overviewWorkflow');
    Route::post('prautomations/{uid}/confirm', 'PRAutomationController@confirm');
    Route::get('prautomations/{uid}/confirm', 'PRAutomationController@confirm');
    Route::delete('prautomations/delete', 'PRAutomationController@delete');
    Route::get('prautomations/{uid}/auto-event/form', 'PRAutomationController@nextEventForm');
    Route::post('prautomations/{uid}/workflow', 'PRAutomationController@workflow');
    Route::get('prautomations/{uid}/workflow', 'PRAutomationController@workflow');
    Route::get('prautomations/{uid}/custom-criteria/form', 'PRAutomationController@criteriaForm');
    Route::post('prautomations/{uid}/trigger', 'PRAutomationController@trigger');
    Route::get('prautomations/{uid}/trigger', 'PRAutomationController@trigger');
    Route::get('prautomations/sort', 'PRAutomationController@sort');
    Route::get('prautomations/listing/{page?}', 'PRAutomationController@listing');
    Route::resource('prautomations', 'PRAutomationController');

    // Auto event
    Route::get('auto-events/{uid}/emails/{campaign_uid}/template', 'AutoEventController@template'); //
    Route::post('auto-events/{uid}/emails/{campaign_uid}/template', 'AutoEventController@template'); //
    Route::get('auto-events/{uid}/emails/{campaign_uid}/template/select', 'AutoEventController@templateSelect'); //
    Route::get('auto-events/{uid}/emails/{campaign_uid}/template/choose/{template_uid}', 'AutoEventController@templateChoose');
    Route::get('auto-events/{uid}/emails/{campaign_uid}/template/preview', 'AutoEventController@templatePreview'); //
    Route::get('auto-events/{uid}/emails/{campaign_uid}/template/iframe', 'AutoEventController@templateIframe'); //
    Route::get('auto-events/{uid}/emails/{campaign_uid}/template/build/{style}', 'AutoEventController@templateBuild'); //
    Route::get('auto-events/{uid}/emails/{campaign_uid}/template/rebuild', 'AutoEventController@templateRebuild'); //

    Route::patch('auto-events/{uid}/move/up', 'AutoEventController@moveUp');
    Route::patch('auto-events/{uid}/move/down', 'AutoEventController@moveDown');
    Route::patch('auto-events/{uid}/disable', 'AutoEventController@disable');
    Route::patch('auto-events/{uid}/enable', 'AutoEventController@enable');
    Route::patch('auto-events/{uid}/emails/{campaign_uid}/setup', 'AutoEventController@campaignSetup');
    Route::get('auto-events/{uid}/emails/{campaign_uid}/setup', 'AutoEventController@campaignSetup');
    Route::delete('auto-events/{uid}/delete', 'AutoEventController@delete');
    Route::delete('auto-events/campaigns/{uid}/delete', 'AutoEventController@deleteCampaign');
    Route::post('auto-events/{uid}/campaigns/add', 'AutoEventController@addCampaign');
    Route::get('auto-events/{uid}/campaigns', 'AutoEventController@campaigns');
    Route::resource('auto-events', 'AutoEventController');

    // Subscription
    Route::get('subscriptions/{uid}/pay/method/{payment_method_uid}', 'SubscriptionController@selectPaymentMethod');
    Route::get('subscriptions/checkout/paypal/{subscription_uid}', 'PaymentController@paypal');
    Route::get('subscriptions/checkout/{uid}', 'SubscriptionController@checkout');
    Route::get('subscriptions/finish', 'SubscriptionController@finish');
    Route::post('subscriptions/subscription/{plan_uid?}', 'SubscriptionController@subscription');
    Route::get('subscriptions/subscription/{plan_uid?}', 'SubscriptionController@subscription');
    Route::get('subscriptions/preview', 'SubscriptionController@preview');
    Route::get('subscriptions/listing/{page?}', 'SubscriptionController@listing');
    Route::get('subscriptions/sort', 'SubscriptionController@sort');
    Route::delete('subscriptions/delete', 'SubscriptionController@delete');
    Route::resource('subscriptions', 'SubscriptionController');

    // Subscription
    Route::get('prsubscriptions/{uid}/pay/method/{payment_method_uid}', 'PRSubscriptionController@selectPaymentMethod');
    Route::get('prsubscriptions/checkout/paypal/{subscription_uid}', 'PaymentController@paypal');
    Route::get('prsubscriptions/checkout/{uid}', 'PRSubscriptionController@checkout');
    Route::get('prsubscriptions/finish', 'PRSubscriptionController@finish');
    Route::post('prsubscriptions/subscription/{plan_uid?}', 'PRSubscriptionController@subscription');
    Route::get('prsubscriptions/subscription/{plan_uid?}', 'PRSubscriptionController@subscription');
    Route::get('prsubscriptions/preview', 'PRSubscriptionController@preview');
    Route::get('prsubscriptions/listing/{page?}', 'PRSubscriptionController@listing');
    Route::get('prsubscriptions/sort', 'PRSubscriptionController@sort');
    Route::delete('prsubscriptions/delete', 'PRSubscriptionController@delete');
    Route::resource('prsubscriptions', 'PRSubscriptionController');

    // Sending servers
    Route::get('sending_servers/select', 'SendingServerController@select');
    Route::get('sending_servers/listing/{page?}', 'SendingServerController@listing');
    Route::get('sending_servers/sort', 'SendingServerController@sort');
    Route::get('sending_servers/delete', 'SendingServerController@delete');
    Route::get('sending_servers/disable', 'SendingServerController@disable');
    Route::get('sending_servers/enable', 'SendingServerController@enable');
    Route::resource('sending_servers', 'SendingServerController');
    Route::get('sending_servers/create/{type}', 'SendingServerController@create');
    Route::post('sending_servers/create/{type}', 'SendingServerController@store');
    Route::get('sending_servers/{id}/edit/{type}', 'SendingServerController@edit');
    Route::patch('sending_servers/{id}/update/{type}', 'SendingServerController@update');

    // Sending domain
    Route::get('sending_domains/listing/{page?}', 'SendingDomainController@listing');
    Route::get('sending_domains/sort', 'SendingDomainController@sort');
    Route::get('sending_domains/delete', 'SendingDomainController@delete');
    Route::resource('sending_domains', 'SendingDomainController');

    // Payment
    Route::post('payments/billing-information/{subscription_uid}', 'PaymentController@billingInformation');
    Route::get('payments/billing-information/{subscription_uid}', 'PaymentController@billingInformation');
    Route::post('payments/stripe/credit-card/{subscription_uid}', 'PaymentController@stripe_credit_card');
    Route::get('payments/stripe/credit-card/{subscription_uid}', 'PaymentController@stripe_credit_card');
    Route::post('payments/braintree/paypal/{subscription_uid}', 'PaymentController@braintree_paypal');
    Route::get('payments/braintree/paypal/{subscription_uid}', 'PaymentController@braintree_paypal');
    Route::get('payments/success/{subscription_uid}', 'PaymentController@success');
    Route::post('payments/braintree/credit-card/{subscription_uid}', 'PaymentController@braintree_credit_card');
    Route::get('payments/braintree/credit-card/{subscription_uid}', 'PaymentController@braintree_credit_card');
    Route::get('payments/cash/{subscription_uid}', 'PaymentController@cash');
    Route::post('payments/paypal/{subscription_uid}', 'PaymentController@paypal');
    Route::get('payments/paypal/{subscription_uid}', 'PaymentController@paypal');

    // Email verification servers
    Route::get('email_verification_servers/options', 'EmailVerificationServerController@options');
    Route::get('email_verification_servers/listing/{page?}', 'EmailVerificationServerController@listing');
    Route::get('email_verification_servers/sort', 'EmailVerificationServerController@sort');
    Route::get('email_verification_servers/delete', 'EmailVerificationServerController@delete');
    Route::get('email_verification_servers/disable', 'EmailVerificationServerController@disable');
    Route::get('email_verification_servers/enable', 'EmailVerificationServerController@enable');
    Route::resource('email_verification_servers', 'EmailVerificationServerController');
});

// ADMIN AREA
Route::group(['namespace' => 'Admin', 'middleware' => ['not_installed', 'backend']], function () {
    Route::get('admin', 'HomeController@index');

    // User
    Route::get('admin/users/switch/{uid}', 'UserController@switch_user');
    Route::get('admin/users/listing/{page?}', 'UserController@listing');
    Route::get('admin/users/sort', 'UserController@sort');
    Route::get('admin/users/delete', 'UserController@delete');
    Route::resource('admin/users', 'UserController');

    // Template
    Route::get('admin/templates/sort', 'TemplateController@sort');
    Route::get('admin/templates/{uid}/image', 'TemplateController@image');
    Route::post('admin/templates/{uid}/saveImage', 'TemplateController@saveImage');
    Route::get('admin/templates/{uid}/preview', 'TemplateController@preview');
    Route::get('admin/templates/listing/{page?}', 'TemplateController@listing');
    Route::get('admin/templates/upload', 'TemplateController@upload');
    Route::post('admin/templates/upload', 'TemplateController@upload');
    Route::get('admin/templates/delete', 'TemplateController@delete');
    Route::get('admin/templates/build/select', 'TemplateController@buildSelect');
    Route::get('admin/templates/build/{style?}', 'TemplateController@build');
    Route::get('admin/templates/{uid}/rebuild', 'TemplateController@rebuild');
    Route::resource('admin/templates', 'TemplateController');
    Route::get('admin/templates/{uid}/edit', 'TemplateController@edit');
    Route::patch('admin/templates/{uid}/update', 'TemplateController@update');

    // Layout
    Route::get('admin/layouts/listing/{page?}', 'LayoutController@listing');
    Route::get('admin/layouts/sort', 'LayoutController@sort');
    Route::resource('admin/layouts', 'LayoutController');

    // Sending servers
    Route::get('admin/sending_servers/select', 'SendingServerController@select');
    Route::get('admin/sending_servers/listing/{page?}', 'SendingServerController@listing');
    Route::get('admin/sending_servers/sort', 'SendingServerController@sort');
    Route::get('admin/sending_servers/delete', 'SendingServerController@delete');
    Route::get('admin/sending_servers/disable', 'SendingServerController@disable');
    Route::get('admin/sending_servers/enable', 'SendingServerController@enable');
    Route::resource('admin/sending_servers', 'SendingServerController');
    Route::get('admin/sending_servers/create/{type}', 'SendingServerController@create');
    Route::post('admin/sending_servers/create/{type}', 'SendingServerController@store');
    Route::get('admin/sending_servers/{id}/edit/{type}', 'SendingServerController@edit');
    Route::patch('admin/sending_servers/{id}/update/{type}', 'SendingServerController@update');

    // Bounce handlers
    Route::get('admin/bounce_handlers/listing/{page?}', 'BounceHandlerController@listing');
    Route::get('admin/bounce_handlers/sort', 'BounceHandlerController@sort');
    Route::get('admin/bounce_handlers/delete', 'BounceHandlerController@delete');
    Route::resource('admin/bounce_handlers', 'BounceHandlerController');

    // Feedback Loop handlers
    Route::get('admin/feedback_loop_handlers/listing/{page?}', 'FeedbackLoopHandlerController@listing');
    Route::get('admin/feedback_loop_handlers/sort', 'FeedbackLoopHandlerController@sort');
    Route::get('admin/feedback_loop_handlers/delete', 'FeedbackLoopHandlerController@delete');
    Route::resource('admin/feedback_loop_handlers', 'FeedbackLoopHandlerController');

    // Sending domain
    Route::get('admin/sending_domains/listing/{page?}', 'SendingDomainController@listing');
    Route::get('admin/sending_domains/sort', 'SendingDomainController@sort');
    Route::get('admin/sending_domains/delete', 'SendingDomainController@delete');
    Route::resource('admin/sending_domains', 'SendingDomainController');

    // Language
    Route::get('admin/languages/delete/confirm', 'LanguageController@deleteConfirm');
    Route::get('admin/languages/listing/{page?}', 'LanguageController@listing');
    Route::get('admin/languages/delete', 'LanguageController@delete');
    Route::get('admin/languages/{id}/translate/{file}', 'LanguageController@translate');
    Route::post('admin/languages/{id}/translate/{file}', 'LanguageController@translate');
    Route::get('admin/languages/disable', 'LanguageController@disable');
    Route::get('admin/languages/enable', 'LanguageController@enable');
    Route::get('admin/languages/{id}/download', 'LanguageController@download');
    Route::get('admin/languages/{id}/upload', 'LanguageController@upload');
    Route::post('admin/languages/{id}/upload', 'LanguageController@upload');
    Route::resource('admin/languages', 'LanguageController');

    // Settings
    Route::post('admin/settings/upgrade/cancel', 'SettingController@cancelUpgrade');
    Route::post('admin/settings/upgrade', 'SettingController@doUpgrade');
    Route::post('admin/settings/upgrade/upload', 'SettingController@uploadApplicationPatch');
    Route::get('admin/settings/upgrade', 'SettingController@upgrade');
    Route::post('admin/settings/license', 'SettingController@license');
    Route::get('admin/settings/license', 'SettingController@license');
    Route::get('admin/settings/mailer', 'SettingController@mailer');
    Route::post('admin/settings/mailer', 'SettingController@mailer');
    Route::get('admin/settings/cronjob', 'SettingController@cronjob');
    Route::post('admin/settings/cronjob', 'SettingController@cronjob');
    Route::get('admin/settings/urls', 'SettingController@urls');
    Route::get('admin/settings/sending', 'SettingController@sending');
    Route::post('admin/settings/sending', 'SettingController@sending');
    Route::get('admin/settings/general', 'SettingController@general');
    Route::post('admin/settings/general', 'SettingController@general');
    Route::get('admin/settings/logs', 'SettingController@logs');
    Route::get('log', 'SettingController@download_log');
    Route::get('admin/settings/{tab?}', 'SettingController@index');
    Route::post('admin/settings', 'SettingController@index');
    Route::get('admin/update-urls', 'SettingController@updateUrls');


    // Tracking log
    Route::get('admin/tracking_log', 'TrackingLogController@index');
    Route::get('admin/tracking_log/listing', 'TrackingLogController@listing');

    // Feedback log
    Route::get('admin/bounce_log', 'BounceLogController@index');
    Route::get('admin/bounce_log/listing', 'BounceLogController@listing');

    // Open log
    Route::get('admin/open_log', 'OpenLogController@index');
    Route::get('admin/open_log/listing', 'OpenLogController@listing');

    // Click log
    Route::get('admin/click_log', 'ClickLogController@index');
    Route::get('admin/click_log/listing', 'ClickLogController@listing');

    // Feedback log
    Route::get('admin/feedback_log', 'FeedbackLogController@index');
    Route::get('admin/feedback_log/listing', 'FeedbackLogController@listing');

    // Unsubscribe log
    Route::get('admin/unsubscribe_log', 'UnsubscribeLogController@index');
    Route::get('admin/unsubscribe_log/listing', 'UnsubscribeLogController@listing');

    // Sending domain
    Route::get('admin/blacklist', 'BlacklistController@index');
    Route::get('admin/blacklist/listing', 'BlacklistController@listing');
    Route::get('admin/blacklist/delete', 'BlacklistController@delete');

    // Customer Group
    Route::get('admin/customer_groups/listing/{page?}', 'CustomerGroupController@listing');
    Route::get('admin/customer_groups/sort', 'CustomerGroupController@sort');
    Route::get('admin/customer_groups/delete', 'CustomerGroupController@delete');
    Route::resource('admin/customer_groups', 'CustomerGroupController');

    // Customer
    Route::post('admin/customers/{uid}/contact', 'CustomerController@contact');
    Route::get('admin/customers/{id}/contact', 'CustomerController@contact');
    Route::get('admin/customers/growthChart', 'CustomerController@growthChart');
    Route::get('admin/customers/{id}/subscriptions', 'CustomerController@subscriptions');
    Route::get('admin/customers/select2', 'CustomerController@select2');
    Route::get('admin/customers/login-as/{uid}', 'CustomerController@loginAs');
    Route::get('admin/customers/listing/{page?}', 'CustomerController@listing');
    Route::get('admin/customers/sort', 'CustomerController@sort');
    Route::get('admin/customers/delete', 'CustomerController@delete');
    Route::get('admin/customers/disable', 'CustomerController@disable');
    Route::get('admin/customers/enable', 'CustomerController@enable');
    Route::resource('admin/customers', 'CustomerController');

    // Admin Group
    Route::get('admin/admin_groups/listing/{page?}', 'AdminGroupController@listing');
    Route::get('admin/admin_groups/sort', 'AdminGroupController@sort');
    Route::get('admin/admin_groups/delete', 'AdminGroupController@delete');
    Route::resource('admin/admin_groups', 'AdminGroupController');

    // Admin
    Route::get('admin/admins/login-as/{uid}', 'AdminController@loginAs');
    Route::get('admin/admins/listing/{page?}', 'AdminController@listing');
    Route::get('admin/admins/sort', 'AdminController@sort');
    Route::get('admin/admins/delete', 'AdminController@delete');
    Route::get('admin/admins/disable', 'AdminController@disable');
    Route::get('admin/admins/enable', 'AdminController@enable');
    Route::get('admin/admins/login-back', 'AdminController@loginBack');
    Route::resource('admin/admins', 'AdminController');


    // Account
    Route::get('admin/account/api/renew', 'AccountController@renewToken');
    Route::get('admin/account/api', 'AccountController@api');
    Route::get('admin/account/profile', 'AccountController@profile');
    Route::post('admin/account/profile', 'AccountController@profile');
    Route::get('admin/account/contact', 'AccountController@contact');
    Route::post('admin/account/contact', 'AccountController@contact');

    // Plan
    Route::get('admin/plans/pieChart', 'PlanController@pieChart');
    Route::get('admin/plans/delete/confirm', 'PlanController@deleteConfirm');
    Route::get('admin/plans/select2', 'PlanController@select2');
    Route::get('admin/plans/listing/{page?}', 'PlanController@listing');
    Route::get('admin/plans/sort', 'PlanController@sort');
    Route::get('admin/plans/delete', 'PlanController@delete');
    Route::get('admin/plans/disable', 'PlanController@disable');
    Route::get('admin/plans/enable', 'PlanController@enable');
    Route::resource('admin/plans', 'PlanController');

    // Currency
    Route::get('admin/currencies/select2', 'CurrencyController@select2');
    Route::get('admin/currencies/listing/{page?}', 'CurrencyController@listing');
    Route::get('admin/currencies/sort', 'CurrencyController@sort');
    Route::get('admin/currencies/delete', 'CurrencyController@delete');
    Route::get('admin/currencies/disable', 'CurrencyController@disable');
    Route::get('admin/currencies/enable', 'CurrencyController@enable');
    Route::resource('admin/currencies', 'CurrencyController');

    // Subscription
    Route::patch('admin/subscriptions/unpaid', 'SubscriptionController@unpaid');
    Route::patch('admin/subscriptions/paid', 'SubscriptionController@paid');
    Route::get('admin/subscriptions/{uid}/payments', 'SubscriptionController@payments');
    Route::patch('admin/subscriptions/enable', 'SubscriptionController@enable');
    Route::patch('admin/subscriptions/disable', 'SubscriptionController@disable');
    Route::get('admin/subscriptions/preview', 'SubscriptionController@preview');
    Route::get('admin/subscriptions/listing/{page?}', 'SubscriptionController@listing');
    Route::get('admin/subscriptions/sort', 'SubscriptionController@sort');
    Route::delete('admin/subscriptions/delete', 'SubscriptionController@delete');
    Route::resource('admin/subscriptions', 'SubscriptionController');

    // Payment method
    Route::get('admin/payment_methods/braintree/merchant-accounts/select/{uid?}', 'PaymentMethodController@braintreeMerchantAccountSelect');
    Route::get('admin/payment_methods/options/{uid?}', 'PaymentMethodController@options');
    Route::get('admin/payment_methods/select2', 'PaymentMethodController@select2');
    Route::get('admin/payment_methods/listing/{page?}', 'PaymentMethodController@listing');
    Route::get('admin/payment_methods/sort', 'PaymentMethodController@sort');
    Route::get('admin/payment_methods/delete', 'PaymentMethodController@delete');
    Route::get('admin/payment_methods/disable', 'PaymentMethodController@disable');
    Route::get('admin/payment_methods/enable', 'PaymentMethodController@enable');
    Route::resource('admin/payment_methods', 'PaymentMethodController');

    // Email verification servers
    Route::get('admin/email_verification_servers/options', 'EmailVerificationServerController@options');
    Route::get('admin/email_verification_servers/listing/{page?}', 'EmailVerificationServerController@listing');
    Route::get('admin/email_verification_servers/sort', 'EmailVerificationServerController@sort');
    Route::get('admin/email_verification_servers/delete', 'EmailVerificationServerController@delete');
    Route::get('admin/email_verification_servers/disable', 'EmailVerificationServerController@disable');
    Route::get('admin/email_verification_servers/enable', 'EmailVerificationServerController@enable');
    Route::resource('admin/email_verification_servers', 'EmailVerificationServerController');
});
