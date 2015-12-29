$(function() {


    $("a.fancyimage").fancybox({
    });

    $.ajax({
        url:"/site/getcities",
        dataType:"json",
        success:function(data){
            $('.autocomplete').autocompleter({
                source: data,
                limit: 11111,
                highlightMatches:true
            });

        }
    });





});