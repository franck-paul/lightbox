/*global jQuery, dotclear */
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
  const posts = document.querySelectorAll('div.post, article.post');
  for (const post of posts) {
    jQuery(post).find(sel).modalImages(lb_settings);
  }
});
