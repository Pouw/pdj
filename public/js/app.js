
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

	$('input[name="hosted_housing"]').change(function () {
		var value = $(this).attr('value');
		if (value === '1') {
		    $('#hosted_housing_date_range').show();
		} else {
			$('#hosted_housing_date_range').hide();
		}
	});

	$('#hosted_housing_date_range input').daterangepicker({
		"minDate": "2017-04-25",
		"maxDate": "2017-05-04",
		locale: {
			format: 'YYYY-MM-DD',
			"firstDay": 1
		}
	});

    $(function () {
        $('[data-toggle="popover"]').popover()
    })
});
