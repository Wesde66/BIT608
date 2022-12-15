$( function() {
    var st = document.getElementById('Checkindate');
    $( st ).datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        minDate: 'today',

    });
} );

$( function() {
    var en = document.getElementById('Checkoutdate');
    $( en).datepicker({
        numberOfMonths: 2,
        showButtonPanel: true,
        dateFormat: 'yy-mm-dd',
        minDate: 'startdate + 1',
    });
} );