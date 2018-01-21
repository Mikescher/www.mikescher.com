function formatDate(date) {
    const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const days       = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    let wday = days[date.getDay()];
    let day = date.getDate();
    let monthIndex = date.getMonth();
    let year = date.getFullYear();

    let suffix = 'th';
    if (day === 1) suffix = 'st';
    if (day === 2) suffix = 'nd';
    if (day === 3) suffix = 'rd';

    return wday + ' ' + day + suffix + ' ' + monthNames[monthIndex] + ', ' + year;
}

window.onload = function ()
{
    let svgtips = document.getElementsByClassName("svg-tip");
    let rects   = document.getElementsByClassName("egg_rect");

    let masterTip = null;

    for (let tip of svgtips)
    {
        tip.style.opacity = '1';
        tip.style.display = 'none';

        masterTip = tip;
    }

    let masterTipHeader  = masterTip.getElementsByTagName('strong')[0];
    let masterTipContent = masterTip.getElementsByTagName('span')[0];

    for (let rect of rects)
    {
        rect.addEventListener("mouseenter", function(event)
        {
            let datesplit = event.target.getAttribute('data-date').split('-');
            let count = event.target.getAttribute('data-count');
            let date  = new Date(Number(datesplit[0]), Number(datesplit[1])-1, Number(datesplit[2]));

            masterTip.style.display = 'block';

            masterTipHeader.innerHTML = count + ' commits';
            masterTipContent.innerHTML = ' on ' + formatDate(date);

            masterTip.style.left = (window.pageXOffset + event.target.getBoundingClientRect().left - masterTip.getBoundingClientRect().width /2 - 3.5 + 9) + 'px';
            masterTip.style.top  = (window.pageYOffset + event.target.getBoundingClientRect().top  - masterTip.getBoundingClientRect().height -10)         + 'px';
        });
        rect.addEventListener("mouseleave", function(event)
        {
            masterTip.style.display = 'none';
        });
    }
};