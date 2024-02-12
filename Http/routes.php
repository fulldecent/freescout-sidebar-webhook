<?php

Route::group(['middleware' => 'web', 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\SidebarWebhook\Http\Controllers'], function () {
  Route::post('/sidebarwebhook/ajax', ['uses' => 'SidebarWebhookController@ajax', 'laroute' => true])->name('sidebarwebhook.ajax');

  Route::get('/mailbox/sidebarwebhook/{id}', ['uses' => 'SidebarWebhookController@mailboxSettings', 'middleware' => ['auth', 'roles'], 'roles' => ['admin']])->name('mailboxes.sidebarwebhook');
  Route::post('/mailbox/sidebarwebhook/{id}', ['uses' => 'SidebarWebhookController@mailboxSettingsSave', 'middleware' => ['auth', 'roles'], 'roles' => ['admin']])->name('mailboxes.sidebarwebhook.save');
});
