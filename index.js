$(function() {
    
    if ($("#hunter-select").val() === '') {
        $("#confirm-button").prop("disabled", true);
    } else {
        $("#confirm-button").prop("disabled", false);
    }
    
    $("#hunter-select").change(function() {
        console.log("changed");
        if ($("#hunter-select").val() === '') {
            $("#confirm-button").prop("disabled", true);
        } else {
            $("#confirm-button").prop("disabled", false);
        }
    });
    
});