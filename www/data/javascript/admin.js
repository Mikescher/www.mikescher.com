function queryStatus(appendix, secret)
{
    jQuery.ajax({
        url:    '/admin/egh/status?secret='+secret,
        success: function(result)
        {
            let ajaxOutput = $('#egh_ajaxOutput');
            ajaxOutput.val(result + '\r\n' + appendix);
            ajaxOutput.scrollTop(ajaxOutput[0].scrollHeight);
        },
        async:   true
    });
}

function startAjaxRefresh(secret)
{
    $('#egh_ajaxOutput').val("Started.");
    val = setInterval(function(){ queryStatus('', secret); }, 500);

    jQuery.ajax({
        url:    '/admin/egh/reload?secret='+secret,
        success: function(result)
        {
            clearInterval(val);
            queryStatus('Finished.', secret);
        },
        error: function( jqXHR, textStatus, errorThrown)
        {
            clearInterval(val);
            queryStatus('AN ERROR OCCURED:' + '\r\n' + textStatus, secret);
        },
        async:   true
    });
}

function startAjaxRedraw(secret)
{
    $('#egh_ajaxOutput').val("Started.");
    val = setInterval(function(){ queryStatus('', secret); }, 500);

    jQuery.ajax({
        url:    '/admin/egh/redraw?secret='+secret,
        success: function(result)
        {
            clearInterval(val);
            queryStatus('Finished.', secret);
        },
        error: function( jqXHR, textStatus, errorThrown)
        {
            clearInterval(val);
            queryStatus('AN ERROR OCCURED:' + '\r\n' + textStatus, secret);
        },
        async:   true
    });
}