
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
    $('div.team-switcher input').change(function () {
        var id = $(this).attr('name');
        var value = $(this).attr('value');
        if (value === 'find') {
            $('#' + id + '_find').show();
            $('#' + id + '_create').hide();
        } else {
            $('#' + id + '_find').hide();
            $('#' + id + '_create').show();
        }
    });

});
