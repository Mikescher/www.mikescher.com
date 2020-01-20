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

function showSelfTestOutput(id1, id2)
{
    if (!$(id1).hasClass('consistency_result_fin')) return;

    if ($(id2).hasClass('generic_nodisplay'))
    {
        $('.selftest_outputchild').addClass('generic_nodisplay');
        $(id2).removeClass('generic_nodisplay');
    }
    else
    {
        $('.selftest_outputchild').addClass('generic_nodisplay');
    }

}

function refreshConsistencyDisplaySequential(skip)
{
    let i = 0;
    for (let apibutton of $('.selftest_sequential .consistence_ajax_handler').toArray())
    {
        if (i++ !== skip) continue;

        const filter = $(apibutton).data('filter');
        const outdiv = $($(apibutton).data('stid'));

        $(apibutton).removeClass('consistency_result_intermed');
        $(apibutton).addClass('consistency_result_running');

        $.ajax('/api/site::selftest?filter=' + filter)
            .done((data, status, xhr) =>
            {
                let json = JSON.parse(data);
                $(apibutton).removeClass('consistency_result_intermed');
                $(apibutton).removeClass('consistency_result_running');
                $(apibutton).addClass('consistency_result_fin');

                if (json.result === 0) $(apibutton).addClass('consistency_result_ok');
                if (json.result === 1) $(apibutton).addClass('consistency_result_warn');
                if (json.result === 2) $(apibutton).addClass('consistency_result_err');

                $(apibutton).text(json.message);
                //$(apibutton).attr('title', json.long);
                outdiv.text(json.long);

                setTimeout(() => refreshConsistencyDisplaySequential(skip+1), 10);
            })
            .fail((xhr, status, err) =>
            {
                $(apibutton).removeClass('consistency_result_intermed');
                $(apibutton).removeClass('consistency_result_running');

                $(apibutton).addClass('consistency_result_err');
                $(apibutton).addClass('consistency_result_fin');
                $(apibutton).text(("" + err).substr(0, 48));

                //$(apibutton).attr('title', json.long);
                outdiv.text(err);

                setTimeout(() => refreshConsistencyDisplaySequential(skip+1), 10);
            });

    }
}

function refreshConsistencyDisplayParallel()
{
    for (let apibutton of $('.selftest_parallel .consistence_ajax_handler').toArray())
    {
        const filter = $(apibutton).data('filter');

        $(apibutton).removeClass('consistency_result_intermed');
        $(apibutton).addClass('consistency_result_running');

        $.ajax('/api/site::selftest?filter=' + filter)
            .done((data, status, xhr) =>
            {
                let json = JSON.parse(data);

                if (json.result === 0) $(apibutton).addClass('consistency_result_ok');
                if (json.result === 1) $(apibutton).addClass('consistency_result_warn');
                if (json.result === 2) $(apibutton).addClass('consistency_result_err');

                $(apibutton).removeClass('consistency_result_running');
                $(apibutton).addClass('consistency_result_fin');

                $(apibutton).text(json.message);
                //$(apibutton).attr('title', json.long);
                outdiv.text(json.long);
            })
            .fail((xhr, status, err) =>
            {
                $(apibutton).removeClass('consistency_result_intermed');
                $(apibutton).removeClass('consistency_result_running');

                $(apibutton).addClass('consistency_result_err');
                $(apibutton).addClass('consistency_result_fin');

                //$(apibutton).attr('title', json.long);
                outdiv.text(err);
            });
    }
}

$(function()
{
    for (let apibutton of $('.selftest_sequential').toArray()) setTimeout(() => refreshConsistencyDisplaySequential(0), 200);
    for (let apibutton of $('.selftest_parallel').toArray())   setTimeout(() => refreshConsistencyDisplayParallel(), 200);
});