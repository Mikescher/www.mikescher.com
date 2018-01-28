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

function imgcarousel_move(source, delta) {
    let carousel = findParent(source, ".imgcarousel_parent");
    let index    = parseInt(carousel.getAttribute('data-imgcarousel-index'));
    let images   = JSON.parse(carousel.getAttribute('data-imgcarousel-images'));
    let content  = findChild(carousel, '.imgcarousel_content');

    index = (index + delta +  images.length) % images.length;

    carousel.setAttribute('data-imgcarousel-index', index);
    content.setAttribute('style', 'background-image: url(' + images[index] + ');');
}