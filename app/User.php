<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'level', 'avatar', 'balance', 'token', 'timezone', 'smiles', 'links', 'black_list_words'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
    
    public function settings()
    {
        return $this->hasMany('App\Settings', 'user_id', 'id');
    }
    
    public function eventlist_settings()
    {
        return $this->hasMany('App\EventlistSettings', 'user_id', 'id');
    }
    
    public function format_balance() {
        return number_format($this->balance, 2, '.', '') . ' ' . config('app.currency_icon');
    }
    
    public function donation_link() {
        $data = explode('::', $this->token);
        return route('donate', [ 'service' => $data[0], 'id' => $data[1] ]);
    }
    
    public function service() {
        $data = explode('::', $this->token);
        return $data[0];
    }
    
    public function service_id() {
        $data = explode('::', $this->token);
        return $data[1];
    }
    
    public function timezone_list() {
        static $regions = [
            \DateTimeZone::AFRICA,
            \DateTimeZone::AMERICA,
            \DateTimeZone::ANTARCTICA,
            \DateTimeZone::ASIA,
            \DateTimeZone::ATLANTIC,
            \DateTimeZone::AUSTRALIA,
            \DateTimeZone::EUROPE,
            \DateTimeZone::INDIAN,
            \DateTimeZone::PACIFIC,
        ];
    
        $timezones = [];
        foreach( $regions as $region )
        {
            $timezones = array_merge( $timezones, \DateTimeZone::listIdentifiers( $region ) );
        }
    
        $timezone_offsets = [];
        foreach( $timezones as $timezone )
        {
            $tz = new \DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new \DateTime);
        }
    
        asort($timezone_offsets);
    
        $timezone_list = [];
        foreach( $timezone_offsets as $timezone => $offset )
        {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate( 'H:i', abs($offset) );
    
            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";
    
            $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
        }
    
        return $timezone_list;
    }
    
    public function timezone_get() {
        $timezones = $this->timezone_list();
        foreach ($timezones as $timezone => $title) {
            if ($timezone == $this->timezone)
                return $timezone;
        }
        return config('app.timezone');
    }

    /**
     * Convert words black list to string
     *
     * @param  string  $value
     * @return string
     */
    public function getBlackListWordsAttribute($value)
    {
        return $value ? (string) $value : '';
    }
}
