<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->string('key');
            $table->primary('key');
            $table->longText('value')->nullable();
        });

        /*
         *  Default data
         */

        /* App */ {
            // Name
            $insert[] = [
                'key' => 'app.name',
                'value' => 'Stream Tip'
            ];
            // Title
            $insert[] = [
                'key' => 'app.title',
                'value' => 'StreamTip'
            ];
            // TimeZone
            $insert[] = [
                'key' => 'app.timezone',
                'value' => 'America/New_York'
            ];
            // Currency
            $insert[] = [
                'key' => 'app.currency',
                'value' => 'usd'
            ];
            // Currency Icon
            $insert[] = [
                'key' => 'app.currency_icon',
                'value' => '<i class="fa fa-usd" aria-hidden="true"></i>'
            ];
            // Email
            $insert[] = [
                'key' => 'app.contact_email',
                'value' => 'you@email.com'
            ];
            // YANDEX_API_KEY
            $insert[] = [
                'key'   => 'app.yandex.api_key',
                'value' => 'b847c958-7f94-492b-8c06-49c4fd0f9cab'
            ];
        }
        
        /* PayPal */ {
            // Mode: live or sandbox
            $insert[] = [
                'key'   => 'paypal.mode',
                'value' => 'sandbox'
            ];
            // Commission
            $insert[] = [
                'key' => 'paypal.commission',
                'value' => '15'
            ];
            // Status
            $insert[] = [
                'key' => 'paypal.status',
                'value' => 'enabled'
            ];
            // Sandbox: email (For commission)
            $insert[] = [
                'key'   => 'paypal.sandbox.email',
                'value' => ''
            ];
            // Sandbox: username
            $insert[] = [
                'key'   => 'paypal.sandbox.username',
                'value' => ''
            ];
            // Sandbox: password
            $insert[] = [
                'key'   => 'paypal.sandbox.password',
                'value' => ''
            ];
            // Sandbox: secret
            $insert[] = [
                'key'   => 'paypal.sandbox.secret',
                'value' => ''
            ];
            // Live: email (For commission)
            $insert[] = [
                'key'   => 'paypal.live.email',
                'value' => ''
            ];
            // Live: username
            $insert[] = [
                'key'   => 'paypal.live.username',
                'value' => ''
            ];
            // Live: password
            $insert[] = [
                'key'   => 'paypal.live.password',
                'value' => ''
            ];
            // Live: app_id
            $insert[] = [
                'key'   => 'paypal.live.app_id',
                'value' => ''
            ];
            // Currency
            $insert[] = [
                'key'   => 'paypal.currency',
                'value' => 'USD'
            ];
            // Notify URL
            $insert[] = [
                'key'   => 'paypal.notify_url',
                'value' => 'https://you.domain/payments/paypal/notify'
            ];
            
        }

        /* Auth */ {
            // Default Avatar
            $insert[] = [
                'key'   => 'auth.default_avatar',
                'value' => 'https://api.adorable.io/avatars/285/abott@adorable.png'
            ];
            // Youtube Status
            $insert[] = [
                'key'   => 'auth.youtube.status',
                'value' => 'enabled'
            ];
            // Twitch Status
            $insert[] = [
                'key'   => 'auth.twitch.status',
                'value' => 'enabled'
            ];
            // Mixer Status
            $insert[] = [
                'key'   => 'auth.mixer.status',
                'value' => 'enabled'
            ];
        }

        DB::table('configurations')->insert($insert);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
