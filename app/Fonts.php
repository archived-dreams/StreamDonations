<?php

namespace App;

class Fonts
{

    public static function get()
    {
        $fonts = [
            'Open Sans', 'Josefin Slab', 'Arvo', 'Lato', 'Vollkorn', 
            'Abril Fatface', 'Ubuntu', 'PT Sans', 'Old Standard TT', 
            'Droid Sans', 'Anivers', 'Junction', 'Fertigo', 'Aller', 
            'Audimat', 'Delicious', 'Prociono', 'Fontin', 'Fontin-Sans', 
            'Chunkfive'
            ];
        return array_combine($fonts, $fonts);
    }

    public static function keys()
    {
        return array_keys(Fonts::get());
    }

}