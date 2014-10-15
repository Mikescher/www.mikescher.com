function startAjaxRefresh()
{
    $('#egh_ajaxOutput').val("");

    val = setInterval(
        function()
        {
            jQuery.ajax({
                url:    '/msmain/admin/egh/ajaxStatus',
                success: function(result)
                {
                    $('#egh_ajaxOutput').val(result);
                    $('#egh_ajaxOutput').scrollTop($('#egh_ajaxOutput')[0].scrollHeight);
                },
                async:   false
            });
        }, 500);

    jQuery.ajax({
        url:    '/msmain/admin/egh/ajaxReload',
        success: function(result)
        {
            clearInterval(val);

            jQuery.ajax({
                url:    '/msmain/admin/egh/ajaxStatus',
                success: function(result)
                {
                    $('#egh_ajaxOutput').val(result + '\r\n.');
                    $('#egh_ajaxOutput').scrollTop($('#egh_ajaxOutput')[0].scrollHeight);
                },
                async:   true
            });
        },
        error: function( jqXHR, textStatus, errorThrown)
        {
            clearInterval(val);

            jQuery.ajax({
                url:    '/msmain/admin/egh/ajaxStatus',
                success: function(result)
                {
                    $('#egh_ajaxOutput').val(result + '\r\n' + 'AN ERROR OCCURED:' + '\r\n' + textStatus);
                    $('#egh_ajaxOutput').scrollTop($('#egh_ajaxOutput')[0].scrollHeight);
                },
                async:   true
            });
        },
        async:   true
    });

}