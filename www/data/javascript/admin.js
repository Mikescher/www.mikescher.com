function queryStatus(appendix, secret)
{
    jQuery.ajax({
        url:    '/api/extendedgitgraph::status?secret='+secret,
        success: function(result)
        {
            let ajaxOutput = $('#egg_ajaxOutput');
            ajaxOutput.val(result + '\r\n' + appendix);
            ajaxOutput.scrollTop(ajaxOutput[0].scrollHeight);
        },
        async:   true
    });
}

function startAjaxRefresh(secret)
{
    $('#egg_ajaxOutput').val("Started.");
    val = setInterval(function(){ queryStatus('', secret); }, 500);

    jQuery.ajax({
        url:    '/api/extendedgitgraph::refresh?secret='+secret,
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
    $('#egg_ajaxOutput').val("Started.");
    val = setInterval(function(){ queryStatus('', secret); }, 500);

    jQuery.ajax({
        url:    '/api/extendedgitgraph::redraw?secret='+secret,
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

function startAjaxReplace(target, url)
{
    $(target).html("Waiting ...");
    jQuery.ajax({
        url:    url,
        success: function(result)
        {
            $(target).html(result);
        },
        error: function( jqXHR, textStatus, errorThrown)
        {
            $(target).html('AN ERROR OCCURED:' + '<br/>' + textStatus);
        },
        async:   true
    });
}

function refreshConsistencyDisplay(skip)
{
    let i = 0;
    for (let apibutton of $('.consistence_ajax_handler').toArray())
    {
        if (i++ !== skip) continue;

        const filter = $(apibutton).data('filter');

        $(apibutton).removeClass('consistency_result_intermed');
        $(apibutton).addClass('consistency_result_running');

        $.ajax('/api/site::selftest?filter=' + filter)
            .done((data, status, xhr) =>
            {
                let json = JSON.parse(data);
                $(apibutton).removeClass('consistency_result_intermed');
                $(apibutton).removeClass('consistency_result_running');

                if (json.result === 0)
                {
                    $(apibutton).addClass('consistency_result_ok');
                    $(apibutton).text(json.message+" ");
                }
                else if (json.result === 1)
                {
                    $(apibutton).addClass('consistency_result_warn');
                    $(apibutton).text(json.message+" ");
                }
                else if (json.result === 2)
                {
                    $(apibutton).addClass('consistency_result_err');
                    $(apibutton).text(json.message+" ");
                }

                setTimeout(() => refreshConsistencyDisplay(skip+1), 300);
            })
            .fail((xhr, status, err) =>
            {
                $(apibutton).removeClass('consistency_result_intermed');
                $(apibutton).removeClass('consistency_result_running');

                $(apibutton).addClass('consistency_result_err');
                $(apibutton).text(err+" ");

                setTimeout(() => refreshConsistencyDisplay(skip+1), 300);
            });

    }
}

$(function()
{
    setTimeout(() => refreshConsistencyDisplay(0), 200);
});