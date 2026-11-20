/* ==========================================================================
   HPO Press Coverage Module (F8 Ticker Strip + Dialog & F9 News Rotator)
   Data sources (3-tier): window.HPO_PRESS_DATA -> #hpoPressData -> REST API.
   ========================================================================== */
(function () {
  'use strict';

  var NEW_COUNT = 3;
  var CLOSE_MS = 180;

  var DEFAULT_KENH = {
    'bao-dien-tu': 'Báo điện tử',
    'truyen-hinh': 'Truyền hình',
    'phat-thanh': 'Phát thanh',
    'mang-xa-hoi': 'Mạng xã hội'
  };

  var VERB = {
    'bao-dien-tu': 'Đọc bài',
    'truyen-hinh': 'Xem video',
    'phat-thanh': 'Nghe bài',
    'mang-xa-hoi': 'Xem bài đăng'
  };

  var ICONS = {
    'bao-dien-tu': '<path d="M4 5h13v14H6a2 2 0 0 1-2-2zM17 9h3v8a2 2 0 0 1-2 2"/><path d="M7.5 9h6M7.5 12.5h6M7.5 16h4"/>',
    'truyen-hinh': '<rect x="3" y="5" width="18" height="14" rx="3"/><path d="M10 9.5v5l4.2-2.5z"/>',
    'phat-thanh': '<rect x="9" y="3" width="6" height="11" rx="3"/><path d="M5.5 11a6.5 6.5 0 0 0 13 0M12 17.5V21M8.5 21h7"/>',
    'mang-xa-hoi': '<circle cx="18" cy="5.5" r="2.5"/><circle cx="6" cy="12" r="2.5"/><circle cx="18" cy="18.5" r="2.5"/><path d="m8.2 10.8 7.6-4M8.2 13.2l7.6 4"/>'
  };
  var GO = '<path d="M7 17 17 7M9 7h8v8"/>';
  var CLOCK = '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>';
  var SEARCH = '<circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>';
  var X_ICON = '<path d="M6 6l12 12M18 6 6 18"/>';

  function el(tag, cls, text) {
    var node = document.createElement(tag);
    if (cls) node.className = cls;
    if (text != null) node.textContent = text;
    return node;
  }

  function svgEl(paths, cls) {
    var s = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    s.setAttribute('viewBox', '0 0 24 24');
    s.setAttribute('aria-hidden', 'true');
    if (cls) s.setAttribute('class', cls);
    s.innerHTML = paths;
    return s;
  }

  function safeUrl(raw) {
    if (!raw) return '#';
    try {
      var u = new URL(String(raw), window.location.origin);
      if (u.protocol === 'http:' || u.protocol === 'https:') return u.href;
    } catch (e) { /* invalid URL */ }
    return '#';
  }

  function safeImgUrl(raw) {
    if (!raw) return '';
    try {
      var u = new URL(String(raw), window.location.origin);
      if (u.protocol === 'http:' || u.protocol === 'https:') return u.href;
    } catch (e) { /* invalid URL */ }
    return '';
  }

  function pad(n) {
    return (n < 10 ? '0' : '') + n;
  }

  function parseDate(s) {
    if (!s) return null;
    var norm = String(s).trim().replace(' ', 'T');
    if (norm.length === 10) norm += 'T00:00';
    var d = new Date(norm);
    return isNaN(d) ? null : d;
  }

  function dayKey(d) {
    return d ? d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) : 'none';
  }

  function dayLabel(d) {
    if (!d) return 'Chưa rõ ngày đăng';
    var w = d.toLocaleDateString('vi-VN', { weekday: 'long' });
    return w.charAt(0).toUpperCase() + w.slice(1) + ', ' + pad(d.getDate()) + '/' + pad(d.getMonth() + 1) + '/' + d.getFullYear();
  }

  function timeLabel(d) {
    return pad(d.getHours()) + ':' + pad(d.getMinutes()) + ' · ' + pad(d.getDate()) + '/' + pad(d.getMonth() + 1) + '/' + d.getFullYear();
  }

  function dateText(d) {
    return d ? pad(d.getDate()) + '/' + pad(d.getMonth() + 1) + '/' + d.getFullYear() : '';
  }

  function fold(s) {
    return String(s).normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D').toLowerCase();
  }

  function byName(a, b) {
    return a.bao.localeCompare(b.bao, 'vi');
  }

  var dataPromise = null;
  function loadPressData(fallbackRestUrl) {
    if (dataPromise) return dataPromise;

    if (window.HPO_PRESS_DATA && Array.isArray(window.HPO_PRESS_DATA.bai)) {
      dataPromise = Promise.resolve(window.HPO_PRESS_DATA);
      return dataPromise;
    }

    var inlineEl = document.getElementById('hpoPressData');
    if (inlineEl && inlineEl.textContent) {
      try {
        var parsed = JSON.parse(inlineEl.textContent);
        if (parsed && Array.isArray(parsed.bai)) {
          dataPromise = Promise.resolve(parsed);
          return dataPromise;
        }
      } catch (e) { /* fall through to REST */ }
    }

    var restUrl = (window.HPO_PRESS_CONFIG && window.HPO_PRESS_CONFIG.restUrl)
      || fallbackRestUrl
      || '/wp-json/hpo/v1/press';

    dataPromise = fetch(restUrl, { cache: 'no-cache' })
      .then(function (r) {
        if (!r.ok) throw new Error('HTTP ' + r.status);
        return r.json();
      });

    return dataPromise;
  }

  /* ========================================================================
     F8: Press Strip & Dialog (#pressListDialog)
     ======================================================================== */
  function initPressStripAndDialog(data) {
    var strips = document.querySelectorAll('.strip--press');
    var dialog = document.getElementById('pressListDialog');
    if (!strips.length && !dialog) return;

    var KENH = Object.assign({}, DEFAULT_KENH, (data && data.kenh) || {});
    var items = ((data && data.bai) || [])
      .filter(function (b) { return b && b.bao && b.link; })
      .map(function (b, i) {
        return {
          order: i,
          bao: String(b.bao),
          kenh: KENH[b.kenh] ? b.kenh : 'bao-dien-tu',
          tieuDe: String(b.tieuDe || ''),
          link: safeUrl(b.link),
          date: parseDate(b.ngay)
        };
      });

    if (!items.length) {
      Array.prototype.forEach.call(strips, function (strip) {
        if (strip.dataset.hideOnEmpty !== '0') strip.hidden = true;
      });
      document.querySelectorAll('[data-press-count]').forEach(function (n) { n.textContent = '0'; });
      return;
    }

    items.filter(function (it) { return it.date; })
      .sort(function (a, b) { return b.date - a.date; })
      .slice(0, NEW_COUNT)
      .forEach(function (it) { it.isNew = true; });

    items.forEach(function (it) {
      it.nguon = it.bao.split(' - ')[0].trim();
      it.search = fold(it.bao + ' ' + it.tieuDe + ' ' + (KENH[it.kenh] || ''));
    });

    function stripChip(it, hidden) {
      var a = el('a', 'strip-chip strip-chip--press');
      a.href = it.link;
      a.target = '_blank';
      a.rel = 'noopener';
      a.title = it.bao + ': ' + it.tieuDe;
      if (hidden) {
        a.tabIndex = -1;
      } else {
        a.setAttribute('aria-label', it.bao + ': ' + it.tieuDe + ' (' + (KENH[it.kenh] || '').toLowerCase() + ', mở trong tab mới)');
      }
      var iconWrap = el('span', 'strip-chip__icon');
      iconWrap.setAttribute('aria-hidden', 'true');
      iconWrap.appendChild(svgEl(ICONS[it.kenh] || ICONS['bao-dien-tu']));
      a.appendChild(iconWrap);
      a.appendChild(el('b', null, it.bao));
      a.appendChild(el('span', 'strip-chip__desc', it.tieuDe));
      a.appendChild(svgEl(GO, 'strip-chip__go'));
      return a;
    }

    Array.prototype.forEach.call(strips, function (strip) {
      var maxItems = parseInt(strip.dataset.maxItems || '0', 10) || 0;
      var stripItems = maxItems > 0 ? items.slice(0, maxItems) : items;
      var groups = strip.querySelectorAll('[data-press-strip-group]');
      Array.prototype.forEach.call(groups, function (g, gi) {
        g.textContent = '';
        stripItems.forEach(function (it) {
          g.appendChild(stripChip(it, gi > 0));
        });
      });
    });

    document.querySelectorAll('[data-press-count]').forEach(function (n) {
      n.textContent = String(items.length);
    });
    document.querySelectorAll('[data-press-open]').forEach(function (btn) {
      btn.setAttribute('aria-label', 'Báo chí đưa tin: xem tất cả ' + items.length + ' bài');
    });

    if (!dialog || typeof dialog.showModal !== 'function') return;

    var list = dialog.querySelector('[data-press-list]');
    var closeBtn = dialog.querySelector('[data-press-close]');
    if (!list) return;

    var state = { kenh: 'all', bao: '', q: '', sort: 'new' };
    var ui = {};
    var closeTimer = 0;

    function buildCard(it) {
      var a = el('a', 'press-item');
      a.href = it.link;
      a.target = '_blank';
      a.rel = 'noopener';
      var kenhName = KENH[it.kenh] || '';
      a.setAttribute(
        'aria-label',
        it.bao + ': ' + it.tieuDe + ' (' + kenhName.toLowerCase() +
        (it.date ? ', đăng ' + timeLabel(it.date).replace(' · ', ' ngày ') : '') +
        (it.isNew ? ', mới' : '') + ', mở trong tab mới)'
      );

      var iconWrap = el('span', 'press-item__icon');
      iconWrap.setAttribute('aria-hidden', 'true');
      iconWrap.appendChild(svgEl(ICONS[it.kenh] || ICONS['bao-dien-tu']));
      a.appendChild(iconWrap);

      var body = el('span', 'press-item__body');
      var meta = el('span', 'press-item__meta');
      meta.appendChild(el('b', 'press-item__outlet', it.bao));
      meta.appendChild(el('span', 'press-item__type press-item__type--' + it.kenh, kenhName));
      if (it.isNew) meta.appendChild(el('span', 'press-item__new', 'Mới'));
      body.appendChild(meta);
      body.appendChild(el('span', 'press-item__title', it.tieuDe));

      if (it.date) {
        var when = el('span', 'press-item__date');
        when.appendChild(svgEl(CLOCK));
        when.appendChild(document.createTextNode(timeLabel(it.date)));
        body.appendChild(when);
      }

      a.appendChild(body);
      a.appendChild(svgEl(GO, 'press-item__go'));
      return a;
    }

    function option(value, text) {
      var o = el('option', null, text);
      o.value = value;
      return o;
    }

    function clearFilter(which) {
      if (which === 'kenh' || which === 'all') state.kenh = 'all';
      if ((which === 'bao' || which === 'all') && ui.bao) { state.bao = ''; ui.bao.value = ''; }
      if ((which === 'q' || which === 'all') && ui.q) { state.q = ''; ui.q.value = ''; }
      render();
    }

    function render() {
      if (!ui.kenh) return;
      ui.kenh.querySelectorAll('button').forEach(function (b) {
        b.setAttribute('aria-pressed', String(b.dataset.kenh === state.kenh));
      });

      var q = fold(state.q.trim());
      var shown = items.filter(function (it) {
        return (state.kenh === 'all' || it.kenh === state.kenh)
          && (!state.bao || it.nguon === state.bao)
          && (!q || it.search.indexOf(q) > -1);
      });

      var byDate = state.sort === 'new' || state.sort === 'old';
      shown.sort(function (a, b) {
        if (state.sort === 'az') return byName(a, b);
        if (state.sort === 'za') return byName(b, a);
        if (!a.date || !b.date) return a.date ? -1 : b.date ? 1 : a.order - b.order;
        return state.sort === 'new' ? b.date - a.date : a.date - b.date;
      });

      ui.active.textContent = '';
      ui.active.appendChild(el('span', 'press-active__count', shown.length + ' / ' + items.length + ' bài'));
      var tags = [];
      if (state.kenh !== 'all') tags.push(['kenh', KENH[state.kenh] || state.kenh]);
      if (state.bao) tags.push(['bao', state.bao]);
      if (state.q.trim()) tags.push(['q', '“' + state.q.trim() + '”']);

      tags.forEach(function (t) {
        var b = el('button', 'press-active__tag', t[1]);
        b.type = 'button';
        b.dataset.clear = t[0];
        b.setAttribute('aria-label', 'Bỏ lọc ' + t[1]);
        b.appendChild(svgEl(X_ICON));
        ui.active.appendChild(b);
      });

      if (tags.length) {
        var allBtn = el('button', 'press-active__clear', 'Xóa lọc');
        allBtn.type = 'button';
        allBtn.dataset.clear = 'all';
        ui.active.appendChild(allBtn);
      }

      list.textContent = '';
      if (!shown.length) {
        var empty = el('li', 'press-dialog__empty');
        empty.appendChild(el('p', 'press-dialog__empty-title', 'Không có bài nào khớp'));
        empty.appendChild(el('p', 'press-dialog__empty-text', 'Thử gõ từ khác hoặc bỏ bớt bộ lọc.'));
        var resetBtn = el('button', 'press-active__clear press-active__clear--big', 'Xóa lọc, xem tất cả');
        resetBtn.type = 'button';
        resetBtn.setAttribute('data-clear-all', '');
        empty.appendChild(resetBtn);
        list.appendChild(empty);
        return;
      }

      var last = null;
      shown.forEach(function (it, i) {
        var key = byDate ? dayKey(it.date) : it.bao.charAt(0).toLocaleUpperCase('vi');
        if (key !== last) {
          last = key;
          var head = el('li', 'press-dialog__day');
          head.appendChild(el('h3', 'press-dialog__day-title', byDate ? dayLabel(it.date) : key));
          list.appendChild(head);
        }
        var li = el('li', 'press-dialog__item');
        li.style.setProperty('--i', Math.min(i, 12));
        li.appendChild(it.card);
        list.appendChild(li);
      });
      list.scrollTop = 0;
    }

    function buildDialog() {
      if (dialog.querySelector('.press-dialog__tools')) return;

      items.forEach(function (it) { it.card = buildCard(it); });

      var tools = el('div', 'press-dialog__tools');
      var row = el('div', 'press-tools__row');

      var search = el('label', 'press-search');
      search.appendChild(svgEl(SEARCH, 'press-search__icon'));
      search.appendChild(el('span', 'press-sr', 'Tìm bài theo tên báo hoặc tiêu đề'));
      ui.q = el('input', 'press-search__input');
      ui.q.type = 'search';
      ui.q.placeholder = 'Tìm tên báo hoặc tiêu đề';
      ui.q.autocomplete = 'off';
      search.appendChild(ui.q);

      var srcWrap = el('label', 'press-select');
      srcWrap.appendChild(el('span', 'press-select__label', 'Tên báo'));
      ui.bao = el('select', 'press-select__input');
      ui.bao.appendChild(option('', 'Tất cả (' + items.length + ')'));
      var counts = {};
      items.forEach(function (it) { counts[it.nguon] = (counts[it.nguon] || 0) + 1; });
      Object.keys(counts)
        .sort(function (a, b) { return a.localeCompare(b, 'vi'); })
        .forEach(function (name) {
          ui.bao.appendChild(option(name, name + (counts[name] > 1 ? ' (' + counts[name] + ')' : '')));
        });
      srcWrap.appendChild(ui.bao);

      var sortWrap = el('label', 'press-select');
      sortWrap.appendChild(el('span', 'press-select__label', 'Sắp xếp'));
      ui.sort = el('select', 'press-select__input');
      [['new', 'Mới nhất'], ['old', 'Cũ nhất'], ['az', 'Tên báo A → Z'], ['za', 'Tên báo Z → A']]
        .forEach(function (s) { ui.sort.appendChild(option(s[0], s[1])); });
      sortWrap.appendChild(ui.sort);

      row.appendChild(search);
      row.appendChild(srcWrap);
      row.appendChild(sortWrap);

      ui.kenh = el('div', 'press-filter');
      ui.kenh.setAttribute('role', 'group');
      ui.kenh.setAttribute('aria-label', 'Lọc theo kênh');
      [['all', 'Tất cả']].concat(Object.keys(KENH).map(function (k) { return [k, KENH[k]]; })).forEach(function (k) {
        var n = k[0] === 'all' ? items.length : items.filter(function (it) { return it.kenh === k[0]; }).length;
        if (!n) return;
        var b = el('button', 'press-filter__btn');
        b.type = 'button';
        b.dataset.kenh = k[0];
        b.appendChild(document.createTextNode(k[1] + ' '));
        b.appendChild(el('span', 'press-filter__count', String(n)));
        ui.kenh.appendChild(b);
      });

      ui.active = el('div', 'press-active');
      ui.active.setAttribute('aria-live', 'polite');

      tools.appendChild(row);
      tools.appendChild(ui.kenh);
      tools.appendChild(ui.active);
      list.parentNode.insertBefore(tools, list);

      ui.q.addEventListener('input', function () { state.q = ui.q.value; render(); });
      ui.bao.addEventListener('change', function () { state.bao = ui.bao.value; render(); });
      ui.sort.addEventListener('change', function () { state.sort = ui.sort.value; render(); });
      ui.kenh.addEventListener('click', function (e) {
        var b = e.target.closest('button');
        if (!b || b.dataset.kenh === state.kenh) return;
        state.kenh = b.dataset.kenh;
        render();
      });
      ui.active.addEventListener('click', function (e) {
        var b = e.target.closest('button[data-clear]');
        if (b) clearFilter(b.dataset.clear);
      });
      list.addEventListener('click', function (e) {
        if (e.target.closest('[data-clear-all]')) clearFilter('all');
      });

      render();
    }

    function openDialog(trigger) {
      clearTimeout(closeTimer);
      dialog.classList.remove('is-closing');
      if (!dialog.open) dialog.showModal();
      document.documentElement.classList.add('press-dialog-open');
      document.querySelectorAll('.strip--press').forEach(function (s) { s.classList.add('is-paused'); });
      document.querySelectorAll('[data-press-open]').forEach(function (op) {
        op.setAttribute('aria-expanded', op === trigger ? 'true' : 'false');
      });
      dialog.scrollTop = 0;
      list.scrollTop = 0;
    }

    function closeDialog() {
      if (!dialog.open || dialog.classList.contains('is-closing')) return;
      var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
      dialog.classList.add('is-closing');
      closeTimer = setTimeout(function () {
        dialog.classList.remove('is-closing');
        if (dialog.open) dialog.close();
      }, reduce ? 0 : CLOSE_MS);
    }

    buildDialog();

    document.addEventListener('click', function (e) {
      var trigger = e.target.closest('[data-press-open], [data-news-all]');
      if (!trigger) return;
      openDialog(trigger);
    });

    if (closeBtn) closeBtn.addEventListener('click', closeDialog);

    dialog.addEventListener('close', function () {
      document.documentElement.classList.remove('press-dialog-open');
      document.querySelectorAll('.strip--press').forEach(function (s) { s.classList.remove('is-paused'); });
      document.querySelectorAll('[data-press-open]').forEach(function (op) { op.setAttribute('aria-expanded', 'false'); });
    });

    dialog.addEventListener('cancel', function (e) {
      e.preventDefault();
      if (ui.q && document.activeElement === ui.q && ui.q.value) {
        clearFilter('q');
        return;
      }
      closeDialog();
    });

    dialog.addEventListener('click', function (e) {
      if (e.target !== dialog) return;
      var r = dialog.getBoundingClientRect();
      var inside = e.clientX >= r.left && e.clientX <= r.right && e.clientY >= r.top && e.clientY <= r.bottom;
      if (!inside) closeDialog();
    });
  }

  /* ========================================================================
     F9: Press News Rotator ([data-news-rotator])
     ======================================================================== */
  function initNewsRotator(root, instIdx, data) {
    var SMALL = Math.max(1, parseInt(root.dataset.smallCount || '3', 10) || 3);
    var intervalMs = Math.max(1500, parseInt(root.dataset.intervalMs || '6500', 10) || 6500);
    root.style.setProperty('--news-interval', intervalMs + 'ms');

    var catRaw = (root.dataset.categoryFilter || '').trim();
    var catList = catRaw ? catRaw.split(',').map(function (s) { return s.trim(); }).filter(Boolean) : [];

    var feature = root.querySelector('[data-news-feature]');
    var list = root.querySelector('[data-news-list]');
    var btnPrev = root.querySelector('[data-news-prev]');
    var btnNext = root.querySelector('[data-news-next]');
    var btnPause = root.querySelector('[data-news-pause]');
    var btnAll = root.querySelector('[data-news-all]');
    var allCount = root.querySelector('[data-news-all-count]');
    var track = root.querySelector('[data-news-track]');
    var bar = root.querySelector('[data-news-progress]');
    var live = root.querySelector('[data-news-live]');

    if (!feature || !list) {
      root.hidden = true;
      return;
    }

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    var hasVT = typeof document.startViewTransition === 'function';
    var KENH = Object.assign({}, DEFAULT_KENH, (data && data.kenh) || {});

    var all = ((data && data.bai) || []).filter(function (b) { return b && b.bao && b.link; });
    var newest = all
      .map(function (b) { return parseDate(b.ngay); })
      .filter(Boolean)
      .sort(function (a, b) { return b - a; })
      .slice(0, NEW_COUNT)
      .map(Number);

    var items = all
      .filter(function (b) {
        if (!b.anh) return false;
        if (catList.length && catList.indexOf(b.kenh) < 0) return false;
        return true;
      })
      .map(function (b) {
        var d = parseDate(b.ngay);
        return {
          bao: String(b.bao),
          kenh: KENH[b.kenh] ? b.kenh : 'bao-dien-tu',
          tieuDe: String(b.tieuDe || ''),
          moTa: String(b.moTa || ''),
          link: safeUrl(b.link),
          anh: safeImgUrl(b.anh),
          date: d,
          isNew: !!d && newest.indexOf(+d) > -1
        };
      })
      .filter(function (it) { return Boolean(it.anh); })
      .sort(function (a, b) { return (b.date || 0) - (a.date || 0); });

    if (items.length < SMALL + 1) {
      root.hidden = true;
      return;
    }

    if (allCount) allCount.textContent = String(all.length);
    if (btnAll && !document.getElementById('pressListDialog')) {
      btnAll.hidden = true;
    }

    var cards = [];
    var index = 0;
    var inView = false;
    var hovering = false;
    var focused = false;
    var userPaused = reduceMotion.matches;

    function outLink(href, cls) {
      var a = el('a', cls);
      a.href = href;
      a.target = '_blank';
      a.rel = 'noopener';
      return a;
    }

    function whenNear(fn) {
      if (!('IntersectionObserver' in window)) {
        fn();
        return;
      }
      var io = new IntersectionObserver(function (es) {
        if (es.some(function (e) { return e.isIntersecting; })) {
          io.disconnect();
          fn();
        }
      }, { rootMargin: '600px 0px' });
      io.observe(root);
    }

    function buildCard(it, i) {
      var card = el('article', 'hpo-news-card');
      card.style.viewTransitionName = 'hpo-news-card-' + instIdx + '-' + i;
      var verb = VERB[it.kenh] || 'Xem bài';
      var kenh = KENH[it.kenh] || 'Báo chí';

      var media = outLink(it.link, 'hpo-news-card__media');
      media.setAttribute('aria-hidden', 'true');
      var img = el('img');
      img.src = it.anh;
      img.alt = '';
      img.decoding = 'async';
      img.loading = i < SMALL + 2 ? 'eager' : 'lazy';
      img.width = 960;
      img.height = 540;
      media.appendChild(img);

      var chip = el('span', 'hpo-news-card__chip');
      chip.appendChild(svgEl(ICONS[it.kenh] || ICONS['bao-dien-tu']));
      chip.appendChild(document.createTextNode(kenh));
      media.appendChild(chip);
      media.appendChild(el('span', 'hpo-news-card__flag' + (it.isNew ? ' is-on' : ''), 'Mới'));

      var body = el('div', 'hpo-news-card__body');
      var h = el('h3', 'hpo-news-card__title');
      var titleLink = outLink(it.link);
      titleLink.textContent = it.tieuDe;
      h.appendChild(titleLink);
      body.appendChild(h);

      var line = [it.bao, kenh, dateText(it.date)].filter(Boolean).join(' · ');
      body.appendChild(el('p', 'hpo-news-card__desc', it.moTa || line));
      body.appendChild(el('span', 'hpo-news-card__src', [it.bao, dateText(it.date)].filter(Boolean).join(' · ')));

      var foot = el('div', 'hpo-news-card__foot');
      if (it.moTa) foot.appendChild(el('span', 'hpo-news-card__meta', line));
      var go = outLink(it.link, 'hpo-news-card__go');
      go.appendChild(document.createTextNode(verb));
      go.appendChild(svgEl(GO));
      go.setAttribute('aria-label', verb + ': ' + it.tieuDe + ' (' + it.bao + ', mở tab mới)');
      foot.appendChild(go);
      body.appendChild(foot);

      var pick = el('button', 'hpo-news-card__pick');
      pick.type = 'button';
      pick.setAttribute('aria-label', 'Xem lớn: ' + it.bao + ', ' + it.tieuDe);
      pick.addEventListener('click', function () { show(i, true); });

      card.appendChild(media);
      card.appendChild(body);
      card.appendChild(pick);
      return card;
    }

    function at(n) {
      return ((n % items.length) + items.length) % items.length;
    }

    function shown() {
      var out = [];
      for (var k = 0; k <= SMALL; k++) out.push(at(index + k));
      return out;
    }

    function render(entering) {
      var ids = shown();
      ids.forEach(function (id, k) {
        var c = cards[id];
        var big = k === 0;
        c.setAttribute('data-slot', big ? 'big' : 's');
        c.classList.toggle('is-enter', !!entering && entering.indexOf(id) > -1);
        Array.prototype.forEach.call(c.querySelectorAll('a'), function (a) {
          if (big && !a.classList.contains('hpo-news-card__media')) a.removeAttribute('tabindex');
          else a.setAttribute('tabindex', '-1');
        });
        c.querySelector('.hpo-news-card__pick').hidden = big;
      });
      feature.replaceChildren(cards[ids[0]]);
      list.replaceChildren.apply(list, ids.slice(1).map(function (id) { return cards[id]; }));
      if (track) cards[ids[0]].querySelector('.hpo-news-card__media').appendChild(track);
      var pre = cards[at(index + SMALL + 1)];
      if (pre) pre.querySelector('img').loading = 'eager';

      var it = items[at(index)];
      if (live) live.textContent = 'Bài ' + (at(index) + 1) + ' trên ' + items.length + ': ' + it.bao + ', ' + it.tieuDe;
    }

    function restartBar() {
      if (!bar) return;
      bar.classList.remove('is-running');
      void bar.offsetWidth;
      if (!userPaused) bar.classList.add('is-running');
    }

    function syncPaused() {
      root.classList.toggle('is-paused', userPaused || hovering || focused || !inView || document.hidden);
      root.classList.toggle('is-user-paused', userPaused);
      if (btnPause) {
        btnPause.setAttribute('aria-label', userPaused ? 'Tự chuyển bài' : 'Tạm dừng tự chuyển bài');
        btnPause.setAttribute('aria-pressed', userPaused ? 'true' : 'false');
      }
    }

    function show(target, byUser) {
      target = at(target);
      if (target === index) return;
      var before = shown();
      var update = function () {
        index = target;
        render(shown().filter(function (n) { return before.indexOf(n) < 0; }));
      };
      if (hasVT && !reduceMotion.matches && inView && !document.hidden && !window.navigator.webdriver) {
        var html = document.documentElement;
        html.classList.add('news-vt');
        document.startViewTransition(update).finished.finally(function () {
          html.classList.remove('news-vt');
        });
      } else {
        update();
      }
      if (live) live.setAttribute('aria-live', byUser ? 'polite' : 'off');
      restartBar();
    }

    function build() {
      cards = items.map(buildCard);
      if (!hasVT) root.classList.add('no-vt');
      render(null);
      root.classList.add('is-ready');

      if (btnPrev) btnPrev.addEventListener('click', function () { show(index - 1, true); });
      if (btnNext) btnNext.addEventListener('click', function () { show(index + 1, true); });
      if (btnPause) {
        btnPause.addEventListener('click', function () {
          userPaused = !userPaused;
          syncPaused();
          if (userPaused) {
            if (bar) bar.classList.remove('is-running');
          } else {
            restartBar();
          }
        });
      }
      if (bar) bar.addEventListener('animationend', function () { show(index + 1, false); });

      var area = root.querySelector('.news-rot__inner');
      if (area) {
        area.addEventListener('mouseenter', function () { hovering = true; syncPaused(); });
        area.addEventListener('mouseleave', function () { hovering = false; syncPaused(); });
      }
      root.addEventListener('focusin', function () { focused = true; syncPaused(); });
      root.addEventListener('focusout', function (e) {
        if (!root.contains(e.relatedTarget)) {
          focused = false;
          syncPaused();
        }
      });
      document.addEventListener('visibilitychange', syncPaused);
      if (reduceMotion.addEventListener) {
        reduceMotion.addEventListener('change', function () {
          userPaused = reduceMotion.matches;
          syncPaused();
          if (userPaused) {
            if (bar) bar.classList.remove('is-running');
          } else {
            restartBar();
          }
        });
      }

      var x0 = null;
      feature.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
      feature.addEventListener('touchend', function (e) {
        if (x0 == null) return;
        var dx = e.changedTouches[0].clientX - x0;
        x0 = null;
        if (Math.abs(dx) > 50) show(index + (dx < 0 ? 1 : -1), true);
      });

      if ('IntersectionObserver' in window) {
        new IntersectionObserver(function (es) {
          inView = es[es.length - 1].isIntersecting;
          syncPaused();
        }, { threshold: 0.35 }).observe(feature);
      } else {
        inView = true;
      }

      syncPaused();
      restartBar();
    }

    whenNear(build);
  }

  /* ========================================================================
     Bootstrap
     ======================================================================== */
  function init() {
    var rotators = document.querySelectorAll('[data-news-rotator]');
    var strips = document.querySelectorAll('.strip--press');
    var dialog = document.getElementById('pressListDialog');
    if (!rotators.length && !strips.length && !dialog) return;

    var fallbackRest = rotators.length ? rotators[0].dataset.restUrl : '';
    loadPressData(fallbackRest)
      .then(function (data) {
        initPressStripAndDialog(data);
        Array.prototype.forEach.call(rotators, function (root, idx) {
          initNewsRotator(root, idx, data);
        });
      })
      .catch(function (err) {
        if (window.console) console.warn('[hpo-press] Không tải được dữ liệu báo chí:', err);
        Array.prototype.forEach.call(strips, function (strip) {
          if (strip.dataset.hideOnEmpty !== '0') strip.hidden = true;
        });
        Array.prototype.forEach.call(rotators, function (root) {
          root.hidden = true;
        });
      });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
