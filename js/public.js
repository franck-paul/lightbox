/*global $, dotclear */
'use strict';

dotclear.ready(() => {
  const lb = dotclear.getData('lightbox');
  const lb_settings = {
    loader_img: `${lb.url}/img/loader.gif`,
    prev_img: `${lb.url}/img/prev.png`,
    next_img: `${lb.url}/img/next.png`,
    close_img: `${lb.url}/img/close.png`,
    blank_img: `${lb.url}/img/blank.gif`,
  };
  const sel = lb.extensions.map((x) => `a[href$=".${x}"], a[href$=".${x.toUpperCase()}"]`).join(', ');
  $('div.post, article.post').each(function () {
    $(this).find(sel).modalImages(lb_settings);
  });
});
