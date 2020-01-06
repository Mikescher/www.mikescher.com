function changeAOCPanel(year, shownav, linkheader, ajax, frameid)
{
    let xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/html::panel_aoc_calendar?year='+year+'&nav='+shownav+'&linkheader='+linkheader+'&ajax='+ajax+'&frameid='+frameid);
    xhr.onload = function()
    {
        if (xhr.status === 200) document.getElementById(frameid).innerHTML = xhr.responseText;
    };
    xhr.send();

    return true;
}