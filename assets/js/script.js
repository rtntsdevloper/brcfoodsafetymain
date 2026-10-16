"use strict";
// Test code
$('.progress').each((_, progress) => {
    const steps = $('> div.right > div', progress);
    steps.each((i, el) => $(el).mouseenter(e => onHover(el)));
    const onHover = (el) =>
	{
        steps.removeClass(['current', 'prev']);
        el.classList.add('current');
        $(el).prevAll().slice(1).addClass('prev');
    };
});