window.addEventListener("load", function()
{

    imgcarousel_init();

},false);

function findParent(el, selector) {
    let retval = null;
    while (el) {
        if (el.matches(selector)) {
            retval = el;
            break
        }
        el = el.parentElement;
    }
    return retval;
}

function findChild(el, selector) {
    for (let i = 0; i < el.children.length; i++) {
        if (el.children[i].matches(selector)) { return el.children[i]; }
        let rec = findChild(el.children[i], selector);
        if (rec !== null) return rec;
    }
    return null;
}

function imgcarousel_init() {
    for (let carousel of document.getElementsByClassName("imgcarousel_parent"))
    {
        let images   = JSON.parse(carousel.getAttribute('data-imgcarousel-images'));

        let btnPrev = findChild(carousel, '.imgcarousel_prev');
        let btnNext = findChild(carousel, '.imgcarousel_next');

        btnPrev.setAttribute('href', "javascript:void(0)");
        btnNext.setAttribute('href', "javascript:void(0)");

        btnPrev.onclick = function () { imgcarousel_move(carousel, -1); };
        btnNext.onclick = function () { imgcarousel_move(carousel, +1); };

        if (images.length <= 1)
        {
            btnPrev.setAttribute('style', 'visibility:hidden');
            btnNext.setAttribute('style', 'visibility:hidden');
        }

        imgcarousel_move(carousel, 0);
        imgcarousel_preload(carousel);
    }
}

function imgcarousel_move(source, delta) {
    let carousel = findParent(source, ".imgcarousel_parent"); // <div>
    let index    = parseInt(carousel.getAttribute('data-imgcarousel-index'));
    let images   = JSON.parse(carousel.getAttribute('data-imgcarousel-images'));
    let content  = findChild(carousel, '.imgcarousel_content'); // <img>

    index = (index + delta +  images.length) % images.length;

    let img = images[index];

    carousel.setAttribute('data-imgcarousel-index', index);

    if (img.toLowerCase().endsWith('.webm'))
    {
        content.setAttribute('style', '');
        content.innerHTML = '<video autoplay loop muted><source src="' + img + '"></video>';
    }
    else
    {
        content.setAttribute('style', 'background-image: url(' + img + ');');
        content.innerHTML = '';
    }
}

function imgcarousel_preload(source) {
    let carousel = findParent(source, ".imgcarousel_parent"); // <div>
    let images = JSON.parse(carousel.getAttribute('data-imgcarousel-images'));

    setTimeout(function () {
        let preload_img = [];

        let i = 0;
        for (let img of images)
        {
            if (img.toLowerCase().endsWith('.webm'))
            {
                // ???
            }
            else
            {
                preload_img[i] = new Image();
                preload_img[i].src = img;
                i++;
            }
        }

    }, 1000);
}