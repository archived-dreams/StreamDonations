function auto_notify(data) {
    
    $.each([ 'warning', 'info', 'success', 'danger' ], function( index, type ) {

        if (typeof data[type] == 'undefined')
            return;

        if (typeof data[type] == 'string')
            data[type] = [ data[type] ];

        $.each(data[type], function( index, message) {
           $.notify({ message: message },{ type: type });
        });

    });

}

function error_notify(data) {
    console.log(data);
    $.each(data, function( name, errors ) {
        $.each(errors, function( key, value ) {
           $.notify({ message: value }, { type: 'danger' });
        });
    });
}