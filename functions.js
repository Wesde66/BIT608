
//this function is for the date and time picker
$(function(){
    var dateFormat = "yyyy-mm-dd",
        from = $("#startDate").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths:1,

        }).on("change", function (){
            to.datepicker("option", "minDate", getDate(this));
        }),
        to = $("#endDate").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1
        }).on("change", function (){
            from.datepicker("option", "maxDate", getDate(this));
        });
    function getDate(element){
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        }catch (error){
            date = null;
        }
        return date;
    }
});