/*global jQuery */
'use strict';

(() => {
  const $ = jQuery;
  if (/^1\.(0|1)\./.test($.fn.jquery) || /^1\.2\.(0|1|2|3|4|5)/.test($.fn.jquery)) {
    throw new Error(`Modal requieres jQuery v1.2.6 or later. You are using v${$.fn.jquery}`);
  }

  $.modal = function (data, params) {
    this.params = $.extend(this.params, params);
    return this.build(data);
  };
  $.modal.version = '1.0';

  $.modal.prototype = {
    params: {
      width: null,
      height: null,
      speed: 300,
      opacity: 0.9,
      loader_img: 'loader.gif',
      loader_txt: 'loading...',
      close_img: 'close.png',
      close_txt: 'close',
      on_close() {},
    },
    ctrl: {
      box: $(),
      loader: $(),
      overlay: $('<div id="jq-modal-overlay"></div>'),
      hidden: $(),
    },

    build(data) {
      this.ctrl.loader = $(
        `<div class="jq-modal-load"><img src="${this.params.loader_img}" alt="${this.params.loader_txt}"></div>`,
      );
      this.addOverlay();
      const size = this.getBoxSize(this.ctrl.loading);

      this.ctrl.box = this.getBox(this.ctrl.loading, {
        top: Math.round($(window).height() / 2 + $(window).scrollTop() - size.h / 2),
        left: Math.round($(window).width() / 2 + $(window).scrollLeft() - size.w / 2),
        visibility: 'hidden',
      });
      this.ctrl.overlay.after(this.ctrl.box);
      if (data !== undefined) {
        this.updateBox(data);
        this.data = data;
      }
      return this;
    },
    updateBox(data, fn) {
      this.hideCloser();
      fn = typeof fn === 'function' ? fn : () => {};
      const content = $('div.jq-modal-content', this.ctrl.box);
      content.empty().append(this.ctrl.loader);
      const size = this.getBoxSize(data, this.params.width, this.params.height);

      const top = Math.round($(window).height() / 2 + $(window).scrollTop() - size.h / 2);
      const left = Math.round($(window).width() / 2 + $(window).scrollLeft() - size.w / 2);

      this.ctrl.box.css('visibility', 'visible').animate(
        {
          top: top < 0 ? 0 : top,
          left: left < 0 ? 0 : left,
          width: size.w,
          height: size.h,
        },
        this.params.speed,
        () => {
          this.setContentSize(content, this.params.width, this.params.height);
          content
            .empty()
            .append(data)
            .css('opacity', 0)
            .fadeTo(this.params.speed, 1, () => {
              fn.call(this, content);
            });
          this.showCloser();
        },
      );
    },
    getBox(data, css, content_w, content_h) {
      const box = $(
        '<div class="jq-modal">' + '<div class="jq-modal-container"><div class="jq-modal-content">' + '</div></div></div>',
      ).css(
        $.extend(
          {
            position: 'absolute',
            top: 0,
            left: 0,
            zIndex: 100,
          },
          css,
        ),
      );

      if (data !== undefined) {
        $('div.jq-modal-content', box).append(data);
      }

      this.setContentSize($('div.jq-modal-content', box), content_w, content_h);
      return box;
    },
    getBoxSize(data, content_w, content_h) {
      let box = this.getBox(
        data,
        {
          visibility: 'hidden',
        },
        content_w,
        content_h,
      );
      this.ctrl.overlay.after(box);
      const size = {
        w: box.width(),
        h: box.height(),
      };
      box.remove();
      box = null;
      return size;
    },
    setContentSize(content, w, h) {
      content.css({
        width: w > 0 ? w : 'auto',
        height: h > 0 ? h : 'auto',
      });
    },
    showCloser() {
      if ($('div.jq-modal-closer', this.ctrl.box).length > 0) {
        $('div.jq-modal-closer', this.ctrl.box).show();
        return;
      }

      $('div.jq-modal-container', this.ctrl.box).append(
        `<div class="jq-modal-closer"><a href="#">${this.params.close_txt}</a></div>`,
      );
      const close = $('div.jq-modal-closer a', this.ctrl.box);
      close
        .css({
          background: `transparent url(${this.params.close_img}) no-repeat`,
        })
        .click(() => {
          this.removeOverlay();
          return false;
        });

      if (document.all) {
        close[0].runtimeStyle.filter = `progid:DXImageTransform.Microsoft.AlphaImageLoader(src="${this.params.close_img}", sizingMethod="crop")`;
        close[0].runtimeStyle.backgroundImage = 'none';
      }
    },
    hideCloser() {
      $('div.jq-modal-closer', this.ctrl.box).hide();
    },

    addOverlay() {
      if (document.all) {
        this.ctrl.hidden = $('select:visible, object:visible, embed:visible').css('visibility', 'hidden');
      }
      this.ctrl.overlay
        .css({
          backgroundColor: '#000',
          position: 'absolute',
          top: 0,
          left: 0,
          zIndex: 90,
          opacity: this.params.opacity,
        })
        .appendTo('body')
        .dblclick(() => {
          this.removeOverlay();
        });

      this.resizeOverlay({
        data: this.ctrl,
      });

      $(window).on('resize.modal', this.ctrl, this.resizeOverlay);
      $(document).on('keypress.modal', this, this.keyRemove);
    },
    resizeOverlay(e) {
      e.data.overlay.css({
        width: $(window).width(),
        height: $(document).height(),
      });
      if (e.data.box.parents('body').length > 0) {
        const top = Math.round($(window).height() / 2 + $(window).scrollTop() - e.data.box.height() / 2);
        const left = Math.round($(window).width() / 2 + $(window).scrollLeft() - e.data.box.width() / 2);
        e.data.box.css({
          top: top < 0 ? 0 : top,
          left: left < 0 ? 0 : left,
        });
      }
    },
    keyRemove(e) {
      if (e.keyCode === 27) {
        e.data.removeOverlay();
      }
      return true;
    },
    removeOverlay() {
      $(window).off('resize.modal');
      $(document).off('keypress');
      this.params.on_close.apply(this);
      this.ctrl.overlay.remove();
      this.ctrl.hidden.css('visibility', 'visible');
      this.ctrl.box.remove();
      this.ctrl.box = $();
    },
  };
})();

(() => {
  const $ = jQuery;
  $.fn.modalImages = function (params) {
    params = $.extend(this.params, params);
    const links = [];
    this.each(function () {
      if ($(this).attr('href') === '' || $(this).attr('href') === undefined || $(this).attr('href') === '#') {
        return false;
      }
      const index = links.length;
      links.push($(this));
      $(this).click(() => {
        new $.modalImages(index, links, params);
        return false;
      });
      return true;
    });

    return this;
  };

  $.modalImages = function (index, links, params) {
    this.links = links;
    this.modal = new $.modal(null, params);
    this.showImage(index);
  };

  $.modalImages.prototype = {
    params: {
      prev_txt: 'previous',
      next_txt: 'next',
      prev_img: 'prev.png',
      next_img: 'next.png',
      blank_img: 'blank.gif',
    },
    showImage(index) {
      const This = this;
      $(document).off('keypress.modalImage');
      if (this.links[index] == undefined) {
        this.modal.removeOverlay();
      }
      const link = this.links[index];
      const { modal } = this;

      const res = $('<div></div>');
      res.append(`<img src="${link.attr('href')}" alt="">`);

      const thumb = $('img:first', link);
      if (thumb.length > 0 && thumb.attr('title')) {
        res.append(`<span class="jq-modal-legend">${thumb.attr('title')}</span>`);
      } else if (link.attr('title')) {
        res.append(`<span class="jq-modal-legend">${link.attr('title')}</span>`);
      }

      // Add prev/next buttons
      if (index != 0) {
        $('<a class="jq-modal-prev" href="#">prev</a>').appendTo(res);
      }
      if (index + 1 < this.links.length) {
        $('<a class="jq-modal-next" href="#">next</a>').appendTo(res);
      }

      const img = new Image();

      // Display loader while loading image
      if (this.modal.ctrl.box.css('visibility') == 'visible') {
        $('div.jq-modal-content', this.modal.ctrl.box).empty().append(this.modal.ctrl.loader);
      } else {
        this.modal.updateBox(this.modal.ctrl.loader);
      }

      img.onload = function () {
        modal.updateBox(res, function () {
          const Img = $('div.jq-modal-content img', this.ctrl.box);
          This.navBtnStyle($('a.jq-modal-next', this.ctrl.box), true)
            .css('height', Img.height())
            .on('click', index + 1, navClick);
          This.navBtnStyle($('a.jq-modal-prev', this.ctrl.box), false)
            .css('height', Img.height())
            .on('click', index - 1, navClick);
          Img.click(() => {
            This.modal.removeOverlay();
          });
          $(document).on('keypress.modalImage', navKey);
        });
        this.onload = () => {};
      };
      img.src = link.attr('href');

      var navClick = (e) => {
        This.showImage(e.data);
        return false;
      };
      var navKey = (e) => {
        const key = String.fromCharCode(e.which).toLowerCase();
        if ((key == 'n' || e.keyCode == 39) && index + 1 < This.links.length) {
          // Press "n"
          This.showImage(index + 1);
        }
        if ((key == 'p' || e.keyCode == 37) && index != 0) {
          // Press "p"
          This.showImage(index - 1);
        }
      };
    },
    navBtnStyle(btn, next) {
      const default_bg = `transparent url(${this.modal.params.blank_img}) repeat`;
      const over_bg_i = next ? this.modal.params.next_img : this.modal.params.prev_img;
      const over_bg_p = next ? 'right' : 'left';

      btn
        .css('background', default_bg)
        .on('mouseenter', function () {
          $(this).css('background', `transparent url(${over_bg_i}) no-repeat center ${over_bg_p}`).css('z-index', 110);
        })
        .on('mouseleave', function () {
          $(this).css('background', default_bg);
        });

      return btn;
    },
  };
})();

(() => {
  jQuery.modalWeb = (url, w, h) => {
    const iframe = $(`<iframe src="${url}" frameborder="0">`).css({
      border: 'none',
      width: w,
      height: h,
    });
    return new $.modal(iframe);
  };

  jQuery.fn.modalWeb = function (w, h) {
    this.on('click', function () {
      if (this.href !== undefined) {
        jQuery.modalWeb(this.href, w, h);
      }
      return false;
    });
  };
})();
