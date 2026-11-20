/**
 * hpo-courses-form.js — M4 Module JS
 * Combines:
 *   1. courses-demo-vehicle-config.js (defer-safe via window.hpoCoursesFormConfig)
 *   2. courses-demo-stage-renderer.js (3D road + spinning rims + VehicleArtwork guard)
 *   3. courses-demo-interactions.js (hover expand, mobile accordion, IntersectionObserver pause)
 *   4. dang-ky-uu-dai-form.js (client validation, ?location= JSON lookup, WP REST submit, XSS-safe status)
 */
(function (global) {
  'use strict';

  var cfg = global.hpoCoursesFormConfig || {};

  /* ========================================================================
     1. VEHICLE CONFIG (defer-safe URL resolution)
     ======================================================================== */
  var currentScriptSrc = (typeof document !== 'undefined' && document.currentScript && document.currentScript.src)
    ? document.currentScript.src
    : '';

  function resolveVehicleImage(name) {
    if (cfg.coursesVehiclesUrl) {
      var base = String(cfg.coursesVehiclesUrl);
      return (base.endsWith('/') ? base : base + '/') + name;
    }
    if (cfg.assetsBaseUrl) {
      var assetsBase = String(cfg.assetsBaseUrl);
      return (assetsBase.endsWith('/') ? assetsBase : assetsBase + '/') + 'vehicles/' + name;
    }
    if (currentScriptSrc) {
      try {
        return new URL('../images/courses-demo/vehicles/' + name, currentScriptSrc).href;
      } catch (e) {
        // fallback below
      }
    }
    return 'assets/images/courses-demo/vehicles/' + name;
  }

  global.VehiclePhotos = {
    'hang-b-vios': {
      body: resolveVehicleImage('hang-b-vios-than-xe.webp'),
      alt: 'Xe tập lái hạng B – Toyota Vios',
      w: 2959,
      h: 1564,
      wheels: [
        { src: resolveVehicleImage('hang-b-vios-mam-sau.webp'), x: 6.887, y: 59.405, d: 10.958, m: [0.0391, 0.9992, -0.4249, 0.0166] },
        { src: resolveVehicleImage('hang-b-vios-mam-truoc.webp'), x: 44.454, y: 79.425, d: 14.9, m: [0.1239, 0.9923, -0.5352, 0.0668] },
      ],
      tyres: [{ x: 6.887, y: 73.849 }, { x: 44.454, y: 99.233 }],
      yaw: 19.65,
      roadYaw: 24,
      spin: 2.4,
      scale: 1,
    },
    'hang-c1-kia-k200': {
      body: resolveVehicleImage('hang-c1-kia-k200-than-xe.webp'),
      alt: 'Xe tập lái hạng C1 – Kia K200 thùng mui bạt',
      w: 3088,
      h: 2369,
      wheels: [
        { src: resolveVehicleImage('hang-c1-kia-k200-mam-sau.webp'), x: 10.826, y: 76.45, d: 7.834, m: [0.0264, 0.9997, -0.3313, 0.0087] },
        { src: resolveVehicleImage('hang-c1-kia-k200-mam-truoc.webp'), x: 38.578, y: 85.749, d: 13.499, m: [0.0976, 0.9952, -0.4454, 0.0437] },
      ],
      tyres: [{ x: 10.826, y: 84.339 }, { x: 38.578, y: 99.451 }],
      yaw: 22.67,
      roadYaw: 27,
      spin: 2.2,
      scale: 0.74,
    },
  };

  /* ========================================================================
     2. STAGE RENDERER (window.CourseScene)
     ======================================================================== */
  var SKY = '<div class="stage__sky"><div class="stage__skyline"></div></div>';
  var ROAD_STRAIGHT = '<div class="road"><div class="road__plane"><div class="road__strip"></div></div></div>';
  var ROAD_ANGLED = '<div class="road road--angled"><div class="road__plane"><div class="road__yaw">' +
    '<div class="road__surface"></div><div class="road__strip"></div></div></div></div>';

  var counter = 0;

  function escapeAttr(value) {
    return String(value).replace(/[&"'<>]/g, function (ch) {
      return '&#' + ch.charCodeAt(0) + ';';
    });
  }

  function num(value) {
    return Number(value) || 0;
  }

  function vectorVehicle(stage) {
    var art = global.VehicleArtwork;
    if (!art || !art.MODELS) {
      return '';
    }
    var model = Object.prototype.hasOwnProperty.call(art.MODELS, stage.dataset.vehicle || '')
      ? stage.dataset.vehicle
      : 'sedan';
    var m = art.MODELS[model];
    var id = 'veh' + (++counter);
    var tyreShadows = m.wheels
      .map(function (w) {
        return '<span class="vehicle__tyre-shadow" style="left:' + ((w.x / m.w) * 100).toFixed(2) + '%"></span>';
      })
      .join('');
    return ROAD_STRAIGHT +
      '<div class="course-demo-vehicle vehicle--' + model + '" style="--vehicle-ratio:' + m.w + ' / ' + m.h + '">' +
      '<span class="vehicle__shadow"></span>' + tyreShadows +
      art.body(model, stage.dataset.paint, id) +
      art.wheels(model, id) +
      '</div>';
  }

  function photoVehicle(stage, photoCfg) {
    stage.style.setProperty('--road-yaw', num(photoCfg.roadYaw) + 'deg');
    var rear = photoCfg.tyres[0];
    var front = photoCfg.tyres[1];
    var span = Math.hypot((front.x - rear.x) * photoCfg.w, (front.y - rear.y) * photoCfg.h) / photoCfg.w;
    var bodyShadow = 'left:' + ((rear.x + front.x) / 2) + '%;top:' + ((rear.y + front.y) / 2) + '%;width:' + (span * 1.5) + '%;--shadow-rot:' + num(photoCfg.yaw) + 'deg';
    var tyres = photoCfg.tyres
      .map(function (t) {
        return '<span class="vehicle__tyre-shadow" style="left:' + num(t.x) + '%;top:' + num(t.y) + '%"></span>';
      })
      .join('');
    var rims = photoCfg.wheels
      .map(function (w) {
        var m = w.m.map(num);
        return '<span class="vehicle__rim" style="left:' + num(w.x) + '%;top:' + num(w.y) + '%;width:' + num(w.d) + '%;--rim-matrix:matrix(' + m[0] + ',' + m[1] + ',' + m[2] + ',' + m[3] + ',0,0)">' +
          '<img class="vehicle__rim-spin" src="' + escapeAttr(w.src) + '" alt="" decoding="async"></span>';
      })
      .join('');
    var src = escapeAttr(photoCfg.body);
    return ROAD_ANGLED +
      '<div class="course-demo-vehicle vehicle--photo" style="--vehicle-ratio:' + num(photoCfg.w) + ' / ' + num(photoCfg.h) + ';--photo-spin:' + (num(photoCfg.spin) || 2.2) + ';--photo-scale:' + (num(photoCfg.scale) || 1) + '">' +
      '<span class="vehicle__shadow" style="' + bodyShadow + '"></span>' + tyres +
      '<div class="vehicle__body">' +
      '<img class="vehicle__img" src="' + src + '" alt="' + escapeAttr(photoCfg.alt || '') + '" decoding="async">' +
      '<img class="vehicle__img vehicle__img--shine" src="' + src + '" alt="" aria-hidden="true">' +
      rims +
      '</div>' +
      '</div>';
  }

  function imageVehicle(stage) {
    var src = escapeAttr(stage.dataset.image);
    var alt = escapeAttr(stage.dataset.imageAlt || '');
    return ROAD_STRAIGHT +
      '<div class="course-demo-vehicle vehicle--image">' +
      '<span class="vehicle__shadow"></span>' +
      '<div class="vehicle__body">' +
      '<img class="vehicle__img" src="' + src + '" alt="' + alt + '" decoding="async">' +
      '<img class="vehicle__img vehicle__img--shine" src="' + src + '" alt="" aria-hidden="true">' +
      '</div>' +
      '</div>';
  }

  function renderStage(stage) {
    if (!stage || stage.dataset.rendered === 'true') return;
    try {
      var photos = global.VehiclePhotos || {};
      var photoKey = stage.dataset.photo || '';
      var vehicle;
      if (Object.prototype.hasOwnProperty.call(photos, photoKey)) {
        stage.classList.add('stage--photo');
        vehicle = photoVehicle(stage, photos[photoKey]);
      } else if (stage.dataset.image) {
        vehicle = imageVehicle(stage);
      } else {
        vehicle = vectorVehicle(stage);
      }
      stage.insertAdjacentHTML('beforeend', SKY + vehicle + '<div class="stage__glare"></div>');
      stage.dataset.rendered = 'true';
    } catch (err) {
      if (global.console && typeof global.console.error === 'function') {
        global.console.error('[CourseScene] Không dựng được sân khấu xe:', err);
      }
    }
  }

  global.CourseScene = { render: renderStage };

  /* ========================================================================
     3. COURSES INTERACTIONS (Hover desktop / Accordion mobile / IO pause)
     ======================================================================== */
  function initCoursesSection(section) {
    if (!section || section.dataset.hpoCoursesInit === 'true') return;
    var list = section.querySelector('[data-courses]');
    if (!list) return;
    section.dataset.hpoCoursesInit = 'true';

    var cards = Array.prototype.slice.call(list.querySelectorAll('[data-course]'));
    var accordionMode = global.matchMedia('(max-width: 767px)');
    var KEYBOARD_HOVER_GUARD_MS = 600;
    var lastPointerType = 'mouse';
    var ignoreHoverUntil = 0;

    list.querySelectorAll('[data-stage]').forEach(function (stage) {
      if (global.CourseScene && typeof global.CourseScene.render === 'function') {
        global.CourseScene.render(stage);
      }
    });

    function getActive() {
      for (var i = 0; i < cards.length; i++) {
        if (cards[i].classList.contains('course-demo-active')) return cards[i];
      }
      return null;
    }

    function syncAria() {
      cards.forEach(function (card) {
        var toggle = card.querySelector('[data-toggle]');
        if (!toggle) return;
        if (accordionMode.matches) {
          toggle.setAttribute('aria-expanded', String(card.classList.contains('course-demo-active')));
          var priceList = card.querySelector('.price-list');
          if (priceList && priceList.id) {
            toggle.setAttribute('aria-controls', priceList.id);
          }
        } else {
          toggle.removeAttribute('aria-expanded');
          toggle.removeAttribute('aria-controls');
        }
      });
    }

    function setActive(target) {
      if (target === getActive()) return;
      cards.forEach(function (card) {
        card.classList.toggle('course-demo-active', card === target);
      });
      syncAria();
    }

    list.addEventListener('pointerover', function (event) {
      if (event.pointerType !== 'mouse' || accordionMode.matches) return;
      if (global.performance && global.performance.now() < ignoreHoverUntil) return;
      var card = event.target.closest('[data-course]');
      if (card) setActive(card);
    });

    list.addEventListener('pointerleave', function (event) {
      if (event.pointerType !== 'mouse' || accordionMode.matches) return;
      setActive(null);
    });

    list.addEventListener('focusin', function (event) {
      if (accordionMode.matches) return;
      try {
        if (!event.target.matches(':focus-visible')) return;
      } catch (e) {
        return;
      }
      setActive(event.target.closest('[data-course]'));
    });

    list.addEventListener('focusout', function (event) {
      if (accordionMode.matches || list.contains(event.relatedTarget)) return;
      try {
        if (list.matches(':hover')) return;
      } catch (e) {
        // ignore
      }
      setActive(null);
    });

    document.addEventListener('pointerdown', function (event) {
      lastPointerType = event.pointerType || 'mouse';
    });

    list.addEventListener('keydown', function (event) {
      if (event.key === 'Enter' || event.key === ' ') {
        var card = event.target.closest('[data-course]');
        if (card) {
          if (event.key === ' ') event.preventDefault();
          if (global.performance) {
            ignoreHoverUntil = global.performance.now() + KEYBOARD_HOVER_GUARD_MS;
          }
          setActive(card === getActive() ? null : card);
        }
      }
    });

    list.addEventListener('click', function (event) {
      var card = event.target.closest('[data-course]');
      if (!card) return;
      if (event.target.closest('a')) return;
      var viaKeyboard = event.detail === 0;
      if (viaKeyboard && global.performance) {
        ignoreHoverUntil = global.performance.now() + KEYBOARD_HOVER_GUARD_MS;
      }
      if (!accordionMode.matches && lastPointerType === 'mouse' && !viaKeyboard) {
        setActive(card);
        return;
      }
      setActive(card === getActive() ? null : card);
    });

    document.addEventListener('click', function (event) {
      if (lastPointerType === 'mouse' || accordionMode.matches) return;
      if (!list.contains(event.target)) setActive(null);
    });

    if (typeof accordionMode.addEventListener === 'function') {
      accordionMode.addEventListener('change', function () {
        cards.forEach(function (card) {
          card.classList.remove('course-demo-active');
        });
        syncAria();
      });
    } else if (typeof accordionMode.addListener === 'function') {
      accordionMode.addListener(function () {
        cards.forEach(function (card) {
          card.classList.remove('course-demo-active');
        });
        syncAria();
      });
    }
    syncAria();

    if ('IntersectionObserver' in global) {
      new global.IntersectionObserver(function (entries) {
        if (entries && entries[0]) {
          section.classList.toggle('is-paused', !entries[0].isIntersecting);
        }
      }).observe(section);
    }
  }

  /* ========================================================================
     4. CONSULTATION FORM (#uu-reg-form)
     ======================================================================== */
  function initConsultationForm() {
    var form = document.getElementById('uu-reg-form');
    if (!form || form.dataset.hpoFormInit === 'true') return;
    form.dataset.hpoFormInit = 'true';

    var HOTLINE = cfg.hotline || form.getAttribute('data-hotline') || '028.36.362.362';
    var HOTLINE_TEL = cfg.hotlineTel || ('tel:' + HOTLINE.replace(/[^0-9+]/g, ''));

    var nameInput = form.querySelector('#uu-reg-name');
    var phoneInput = form.querySelector('#uu-reg-phone');
    var classSet = form.querySelector('.uu-reg__classes');
    var trap = form.querySelector('#uu-reg-web');
    var submitBtn = form.querySelector('.uu-reg__submit');
    var submitText = form.querySelector('[data-submit-text]');
    var statusBox = form.querySelector('.uu-reg__status');

    if (!nameInput || !phoneInput || !classSet || !submitBtn || !submitText || !statusBox) return;

    function normalizePhone(value) {
      var digits = String(value || '').replace(/[\s.\-()]/g, '');
      if (digits.indexOf('+84') === 0) {
        digits = '0' + digits.slice(3);
      } else if (digits.indexOf('84') === 0 && (digits.length === 11 || digits.length === 12)) {
        digits = '0' + digits.slice(2);
      }
      return /^0[1-9]\d{8,9}$/.test(digits) ? digits : '';
    }

    function setError(el, errId, show) {
      var err = document.getElementById(errId);
      if (err) err.hidden = !show;
      if (show) el.setAttribute('aria-invalid', 'true');
      else el.removeAttribute('aria-invalid');
    }

    function checkedClass() {
      var r = form.querySelector('input[name="hangDaoTao"]:checked');
      return r ? r.value : '';
    }

    function validate() {
      var okName = nameInput.value.trim().length >= 2;
      var okPhone = !!normalizePhone(phoneInput.value);
      var okClass = !!checkedClass();
      setError(nameInput, 'uu-reg-name-err', !okName);
      setError(phoneInput, 'uu-reg-phone-err', !okPhone);
      setError(classSet, 'uu-reg-class-err', !okClass);
      var first = !okName ? nameInput : !okPhone ? phoneInput : !okClass ? classSet.querySelector('input') : null;
      if (first) first.focus();
      return !first;
    }

    nameInput.addEventListener('input', function () {
      if (nameInput.value.trim().length >= 2) setError(nameInput, 'uu-reg-name-err', false);
    });
    phoneInput.addEventListener('input', function () {
      if (normalizePhone(phoneInput.value)) setError(phoneInput, 'uu-reg-phone-err', false);
    });
    classSet.addEventListener('change', function () {
      setError(classSet, 'uu-reg-class-err', false);
    });

    function showStatus(kind, text, withHotline) {
      statusBox.textContent = text;
      if (withHotline) {
        var a = document.createElement('a');
        a.href = HOTLINE_TEL;
        a.textContent = HOTLINE;
        statusBox.append(' ', a, '.');
      }
      statusBox.className = 'uu-reg__status ' + (kind === 'ok' ? 'is-ok' : 'is-error');
      statusBox.hidden = false;
    }

    function setBusy(busy) {
      submitBtn.disabled = busy;
      submitText.textContent = busy ? 'Đang gửi…' : (submitText.dataset.defaultText || 'Nhận tư vấn miễn phí');
    }

    submitText.dataset.defaultText = submitText.textContent;

    var areaName = '';
    (function loadArea() {
      var raw = (new URLSearchParams(global.location.search).get('location') || '').trim();
      var code = raw.toLowerCase().replace(/[-_\s]/g, '');
      if (!/^[a-z0-9]{2,40}$/.test(code)) return;
      var fileCode = code.replace(/\d+$/, '');
      if (!fileCode) return;
      areaName = raw.replace(/[-_\s]/g, '').replace(/\d+$/, '').slice(0, 80);
      var base = cfg.locationsBaseUrl || form.getAttribute('data-xa-base') || 'data/';
      if (!base.endsWith('/')) base += '/';
      fetch(base + fileCode + '.json', { cache: 'no-cache' })
        .then(function (res) {
          return res.ok ? res.json() : null;
        })
        .then(function (data) {
          if (!data || !data.tenXa || String(data.maXa || '').toLowerCase().replace(/[-_\s]/g, '') !== code) return;
          areaName = String(data.tenXa).replace(/^\s*(xã|phường|thị trấn)\s+/i, '').trim();
          var box = form.closest('.uu-reg');
          if (box) {
            box.querySelectorAll('[data-ten-xa]').forEach(function (el) {
              if (!el.textContent.trim()) el.textContent = data.tenXa;
            });
          }
        })
        .catch(function () {
          // keep temporary code
        });
    })();

    function highlightServerField(field) {
      if (field === 'hoTen') {
        setError(nameInput, 'uu-reg-name-err', true);
        nameInput.focus();
      } else if (field === 'soDienThoai') {
        setError(phoneInput, 'uu-reg-phone-err', true);
        phoneInput.focus();
      } else if (field === 'hangDaoTao') {
        setError(classSet, 'uu-reg-class-err', true);
        var radio = classSet.querySelector('input');
        if (radio) radio.focus();
      }
    }

    form.addEventListener('submit', function (e) {
      e.preventDefault();
      statusBox.hidden = true;
      if (!validate()) return;

      if (trap && trap.value) {
        showStatus('ok', 'Đã nhận đăng ký. Cảm ơn bạn!', false);
        form.reset();
        return;
      }

      var endpoint = String(cfg.restUrl || form.getAttribute('data-endpoint') || '').trim();
      if (!/^https?:\/\//i.test(endpoint) && endpoint.indexOf('/') !== 0) {
        showStatus('error', 'Hệ thống nhận đăng ký đang được cập nhật. Vui lòng gọi tổng đài', true);
        return;
      }

      var name = nameInput.value.trim();
      var payload = {
        hoTen: name.slice(0, 80),
        soDienThoai: normalizePhone(phoneInput.value),
        hangDaoTao: checkedClass(),
        xa: areaName,
        trang: global.location.href.slice(0, 300),
        website: trap ? trap.value : '',
        nonce: cfg.nonce || '',
      };

      var headers = { 'Content-Type': 'application/json' };

      setBusy(true);
      fetch(endpoint, {
        method: 'POST',
        headers: headers,
        credentials: 'same-origin',
        body: JSON.stringify(payload),
      })
        .then(function (res) {
          return res
            .json()
            .catch(function () {
              return null;
            })
            .then(function (json) {
              return { res: res, json: json };
            });
        })
        .then(function (result) {
          var res = result.res;
          var json = result.json;
          if (res.ok && json && json.ok) {
            form.reset();
            var okText = json.message
              ? json.message + ' Cần gấp, gọi tổng đài'
              : 'Đã nhận đăng ký của ' + name + '. Nhân viên tuyển sinh Hiệp Phát sẽ gọi lại cho bạn sớm. Cần gấp, gọi tổng đài';
            showStatus('ok', okText, true);
            return;
          }
          if (json && json.field) {
            highlightServerField(json.field);
          }
          var errMsg = (json && json.message)
            ? json.message
            : 'Thông tin chưa hợp lệ. Vui lòng kiểm tra lại hoặc gọi tổng đài';
          showStatus('error', errMsg, !(json && json.field));
        })
        .catch(function () {
          showStatus('error', 'Chưa gửi được (mạng không ổn định). Vui lòng thử lại hoặc gọi tổng đài', true);
        })
        .then(function () {
          setBusy(false);
        });
    });
  }

  /* ========================================================================
     5. BOOTSTRAP ON READY
     ======================================================================== */
  function bootstrap() {
    document.querySelectorAll('[data-courses-section]').forEach(initCoursesSection);
    initConsultationForm();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootstrap);
  } else {
    bootstrap();
  }
})(window);
