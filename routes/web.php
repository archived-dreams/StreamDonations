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

/* Home & Dashboard */ {
    Route::get('/', ['uses' => 'HomeController@getHome', 'as' => 'home']);
}

/* Auth */ {
    Route::get('/auth', ['uses' => 'Auth\AuthController@getLogin', 'as' => 'login']);
    Route::get('/auth/check', ['uses' => 'Auth\AuthController@getCheck', 'as' => 'auth.check']);
    Route::get('/auth/success', ['uses' => 'Auth\AuthController@getSuccess', 'as' => 'auth.success']);
    Route::get('/auth/logout', ['uses' => 'Auth\AuthController@getLogout', 'as' => 'auth.logout']);
    Route::get('/auth/{slug}', ['uses' => 'Auth\AuthController@getRedirect', 'as' => 'auth.redirect'])->where(['slug' => '[A-Za-z]+']);
    Route::any('/auth/{slug}/callback', ['uses' => 'Auth\AuthController@getCallback', 'as' => 'auth.service.callback'])->where(['slug' => '[A-Za-z]+']);
}

/* Settings */ {
    // Account Settings
    Route::get('/settings/account', ['uses' => 'SettingsController@getAccount', 'as' => 'settings.account']);
    Route::post('/settings/account', ['uses' => 'SettingsController@postAccount', 'as' => 'settings.account.save']);
    // Donation Settings
    Route::get('/settings/donation', ['uses' => 'SettingsController@getDonation', 'as' => 'settings.donation']);
    Route::post('/settings/donation', ['uses' => 'SettingsController@postDonation', 'as' => 'settings.donation.save']);
}

/* Donation list */ {
    Route::get('/donations', ['uses' => 'DonationsController@getHome', 'as' => 'donations']);
    Route::get('/donations/data', ['uses' => 'DonationsController@getData', 'as' => 'donations.data']);
    Route::post('/donations/remove', ['uses' => 'DonationsController@postRemove', 'as' => 'donations.remove']);
    Route::post('/donations/create', ['uses' => 'DonationsController@postCreate', 'as' => 'donations.create']);
}

/* Donation page */ {
    Route::get('/d/{service}/{id}', ['uses' => 'DonationsController@getDonate', 'as' => 'donate'])->where(['service' => '[A-Za-z]+', 'id' => '[A-Za-z0-9]+']);
    Route::post('/d/{service}/{id}', ['uses' => 'DonationsController@postDonate', 'as' => 'donate.post'])->where(['service' => '[A-Za-z]+', 'id' => '[A-Za-z0-9]+']);
}

/* Payments */ {
    /* Global */ {
        Route::get('/payments/status/{id}', ['uses' => 'Payments\PaymentsController@getStatus', 'as' => 'payments.status'])->where(['id' => '[0-9]+']);
        Route::get('/payments/status/{id}/ajax', ['uses' => 'Payments\PaymentsController@getStatusAjax', 'as' => 'payments.status.ajax'])->where(['id' => '[0-9]+']);
    }

    /* PayPal */ {
        Route::get('/payments/paypal/redirect/{id}', ['uses' => 'Payments\PayPalController@getRedirect', 'as' => 'payments.paypal.redirect'])->where(['id' => '[0-9]+']);
        Route::any('/payments/paypal/notify', ['uses' => 'Payments\PayPalController@anyNotify', 'as' => 'payments.paypal.notify']);
    }
}

/* Widets */ {
    /* Event List */ {
        Route::get('/widgets/eventlist', ['uses' => 'Widgets\EventlistController@getHome', 'as' => 'widgets.eventlist']);
        Route::post('/widgets/eventlist', ['uses' => 'Widgets\EventlistController@postHome', 'as' => 'widgets.eventlist.save']);
        Route::get('/widgets/eventlist/{token}', ['uses' => 'Widgets\EventlistController@getWidget', 'as' => 'widgets.eventlist.widget'])->where(['token' => '[A-Za-z0-9]+']);
        Route::get('/widgets/eventlist/{token}/get', ['uses' => 'Widgets\EventlistController@getWidgetData', 'as' => 'widgets.eventlist.widget.get'])->where(['token' => '[A-Za-z0-9]+']);
    }
    /* Alert Box */ {
        Route::get('/widgets/alertbox', ['uses' => 'Widgets\AlertboxController@getHome', 'as' => 'widgets.alertbox']);
        Route::post('/widgets/alertbox', ['uses' => 'Widgets\AlertboxController@postHome', 'as' => 'widgets.alertbox.save']);
        Route::get('/widgets/alertbox/{token}', ['uses' => 'Widgets\AlertboxController@getWidget', 'as' => 'widgets.alertbox.widget'])->where(['token' => '[A-Za-z0-9]+']);
        Route::get('/widgets/alertbox/{token}/settings', ['uses' => 'Widgets\AlertboxController@getWidgetSettings', 'as' => 'widgets.alertbox.widget.settings'])->where(['token' => '[A-Za-z0-9]+']);
        Route::post('/widgets/alertbox/{token}/read', ['uses' => 'Widgets\AlertboxController@postWidgetRead', 'as' => 'widgets.alertbox.widget.read'])->where(['token' => '[A-Za-z0-9]+']);
        Route::get('/widgets/alertbox/{token}/get', ['uses' => 'Widgets\AlertboxController@getWidgetData', 'as' => 'widgets.alertbox.widget.get'])->where(['token' => '[A-Za-z0-9]+']);
    }
    /* Donation Goal */ {
        Route::get('/widgets/donationgoal', ['uses' => 'Widgets\DonationgoalController@getHome', 'as' => 'widgets.donationgoal']);
        Route::post('/widgets/donationgoal', ['uses' => 'Widgets\DonationgoalController@postHome', 'as' => 'widgets.donationgoal.save']);
        Route::get('/widgets/donationgoal/{token}', ['uses' => 'Widgets\DonationgoalController@getWidget', 'as' => 'widgets.donationgoal.widget'])->where(['token' => '[A-Za-z0-9]+']);
        Route::get('/widgets/donationgoal/{token}/get', ['uses' => 'Widgets\DonationgoalController@getWidgetData', 'as' => 'widgets.donationgoal.widget.get'])->where(['token' => '[A-Za-z0-9]+']);
    }
}

/* Pages */ {
    /* Contact */ {
        Route::get('/pages/contact', ['uses' => 'PagesController@getContact', 'as' => 'pages.contact']);
        Route::post('/pages/contact/submit', ['uses' => 'PagesController@postContact', 'as' => 'pages.contact.post']);
    }
    /* Static */ {
        Route::get('/pages/{slug}', ['uses' => 'PagesController@getStatic', 'as' => 'pages.static'])->where(['slug' => '[A-Za-z0-9-_]+']);
        Route::post('/pages/{slug}', ['uses' => 'PagesController@postStatic', 'as' => 'pages.static.save'])->where(['slug' => '[A-Za-z0-9-_]+']);
    }
}

/* Apanel */ {
    /* Configurations */ {
        Route::get('/apanel/configurations', ['uses' => 'ApanelController@getConfigurations', 'as' => 'apanel.configurations']);
        Route::post('/apanel/configurations/save', ['uses' => 'ApanelController@postConfigurations', 'as' => 'apanel.configurations.save']);
    }
    /* Statistics */ {
        Route::get('/apanel/statistics', ['uses' => 'ApanelController@getStatistics', 'as' => 'apanel.statistics']);
    }
    /* Donation list */ {
        Route::get('/apanel/donations', ['uses' => 'ApanelController@getDonations', 'as' => 'apanel.donations']);
        Route::get('/apanel/donations/data', ['uses' => 'ApanelController@getDonationsData', 'as' => 'apanel.donations.data']);
    }
    /* Users */ {
        Route::get('/apanel/users', ['uses' => 'ApanelController@getUsers', 'as' => 'apanel.users']);
        Route::get('/apanel/users/data', ['uses' => 'ApanelController@getUsersData', 'as' => 'apanel.users.data']);
        Route::get('/apanel/users/edit/{id}', ['uses' => 'ApanelController@getUsersEdit', 'as' => 'apanel.users.edit'])->where(['id' => '[0-9]+']);
        Route::post('/apanel/users/edit/{id}', ['uses' => 'ApanelController@postUsersEdit', 'as' => 'apanel.users.save'])->where(['id' => '[0-9]+']);
    }
    /* Payouts */ {
        Route::get('/apanel/payouts', ['uses' => 'ApanelController@getPayouts', 'as' => 'apanel.payouts']);
        Route::get('/apanel/payouts/data', ['uses' => 'ApanelController@getPayoutsData', 'as' => 'apanel.payouts.data']);
        Route::post('/apanel/payouts/save', ['uses' => 'ApanelController@postPayouts', 'as' => 'apanel.payouts.save']);
        Route::get('/apanel/payouts/settings', ['uses' => 'ApanelController@getPayoutsSettings', 'as' => 'apanel.payouts.settings']);
        Route::post('/apanel/payouts/settings/save', ['uses' => 'ApanelController@postPayoutsSettings', 'as' => 'apanel.payouts.settings.save']);
        Route::post('/apanel/payouts/settings/remove', ['uses' => 'ApanelController@postPayoutsSettingsRemove', 'as' => 'apanel.payouts.settings.remove']);
    }
    /* Terms & Conditions */ {
        Route::get('/apanel/conditions', ['uses' => 'ApanelController@getConditions', 'as' => 'apanel.conditions']);
        Route::post('/apanel/conditions', ['uses' => 'ApanelController@postConditions', 'as' => 'apanel.conditions.save']);
    }
}
