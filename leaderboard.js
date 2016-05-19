$(function() {
    
    $(".draw-btn").click(function() {
        var names = [];
        $(".eligible").each(function() {
            names.push($(this).text());
        });
        console.log(names);
        var index = Math.floor(Math.random() * names.length);
        
        $(".winner").text("The winner is... " + names[index] + "!");
        $(".winner").show();
        $(this).hide();
    });

});