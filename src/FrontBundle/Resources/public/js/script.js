$(document).ready(function() {
    $('select').material_select();

    var d = new Date();

    var month = d.getMonth()+1;
    var day= d.getDate();
    var year = d.getFullYear();
    var output = (day<10 ? '0' : '' ) + day + '/' +
        (month<10 ? '0' : '') + month + '/' +
        (year< 10 ? '0' : '') + year;

    $('#date-default').html(output);

    $('.div-encours').show();
    $('#li-encours').addClass("text-blue-gsb");
    $('.div-validees').hide();
    $('.div-cloturees').hide();

    $('#li-encours').click(function(){
        $('#li-encours').addClass("text-blue-gsb");
        $('.div-encours').slideDown(400);


        $('#li-validees').removeClass("text-blue-gsb");
        $('.div-validees').slideUp(400);
        $('#li-cloturees').removeClass("text-blue-gsb");
        $('.div-cloturees').slideUp(400);
    });

    $('#li-validees').click(function(){
        $('#li-encours').removeClass("text-blue-gsb");
        $('.div-encours').slideUp(400);
        $('#li-cloturees').removeClass("text-blue-gsb");
        $('.div-cloturees').slideUp(400);

        $('#li-validees').addClass("text-blue-gsb");
        $('.div-validees').slideDown(400);
    });

    $('#li-cloturees').click(function(){
        $('#li-encours').removeClass("text-blue-gsb");
        $('.div-encours').slideUp(400);
        $('#li-validees').removeClass("text-blue-gsb");
        $('.div-validees').slideUp(400);

        $('#li-cloturees').addClass("text-blue-gsb");
        $('.div-cloturees').slideDown(400);
    });

});