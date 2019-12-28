"use strict";
var ExtendedGitGraph2;
(function (ExtendedGitGraph2) {
    function initHover() {
        const allsvgtips = Array.from(document.getElementsByClassName("svg-tip"));
        if (allsvgtips.length == 0)
            return;
        const masterTip = allsvgtips[0];
        masterTip.style.opacity = '1';
        masterTip.style.display = 'none';
        const masterTipHeader = masterTip.getElementsByTagName('strong')[0];
        const masterTipContent = masterTip.getElementsByTagName('span')[0];
        const rects = Array.from(document.getElementsByClassName("egg_rect"));
        for (let rect of rects) {
            rect.addEventListener("mouseenter", event => {
                const target = event.target;
                let count = target.getAttribute('data-count');
                let date = target.getAttribute('data-date');
                masterTip.style.display = 'block';
                masterTipHeader.innerHTML = count + ' commits';
                masterTipContent.innerHTML = ' on ' + date;
                masterTip.style.left = (window.pageXOffset + target.getBoundingClientRect().left - masterTip.getBoundingClientRect().width / 2 - 3.5 + 9) + 'px';
                masterTip.style.top = (window.pageYOffset + target.getBoundingClientRect().top - masterTip.getBoundingClientRect().height - 10) + 'px';
            });
            rect.addEventListener("mouseleave", _ => masterTip.style.display = 'none');
        }
    }
    ExtendedGitGraph2.initHover = initHover;
})(ExtendedGitGraph2 || (ExtendedGitGraph2 = {}));
window.onload = () => { ExtendedGitGraph2.initHover(); };