/**
 * AJAX call to the controller to refresh the list of X biggest asteroids
 */
$('#xbiggestbtn').click(function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/get-x-biggest",
        method: 'post',
        data: {
            x: jQuery('#xbiggest').val(),
        },
        success: function(response){
            $('#biggest-x-table').html(($(response).find("#biggest-x-table"))[0].outerHTML);
    }});
});

/**
 * AJAX call to the controller to refresh the list of X smallest asteroids
 */
$('#xsmallestbtn').click(function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/get-x-smallest",
        method: 'post',
        data: {
            x: jQuery('#xsmallest').val(),
        },
        success: function(response){
            $('#smallest-x-table').html(($(response).find("#smallest-x-table"))[0].outerHTML);
    }});
});

/**
 * AJAX call to the controller to refresh the list of X fastest asteroids
 */
$('#xfastestbtn').click(function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/get-x-fastest",
        method: 'post',
        data: {
            x: jQuery('#xfastest').val(),
        },
        success: function(response){
            $('#fastest-x-table').html(($(response).find("#fastest-x-table"))[0].outerHTML);
    }});
});

/**
 * AJAX call to the controller to refresh the list of X slowest asteroids
 */
$('#xslowestbtn').click(function(e){
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "/get-x-slowest",
        method: 'post',
        data: {
            x: jQuery('#xslowest').val(),
        },
        success: function(response){
            $('#slowest-x-table').html(($(response).find("#slowest-x-table"))[0].outerHTML);
    }});
});