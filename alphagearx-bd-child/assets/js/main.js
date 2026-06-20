/* AlphaGearX BD — front-end interactions
   Hero slider, sticky nav, mobile menu, Shop dropdown, favourites, qty steppers, reveal. */
(function () {
  "use strict";
  var doc = document;
  function on(el, ev, fn) { if (el) el.addEventListener(ev, fn); }
  function $(s, c) { return (c || doc).querySelector(s); }
  function $all(s, c) { return Array.prototype.slice.call((c || doc).querySelectorAll(s)); }

  /* ---------- sticky header state ---------- */
  var header = $('.agx-header');
  if (header) {
    window.addEventListener('scroll', function () {
      header.classList.toggle('scrolled', window.scrollY > 24);
    }, { passive: true });
  }

  /* ---------- mobile menu + Shop dropdown ---------- */
  var hamb = $('.agx-hamb'), menu = $('.agx-menu');
  on(hamb, 'click', function () { if (menu) menu.classList.toggle('open'); });
  var shop = $('.agx-shop'), shopLink = $('.agx-shop > .agx-link');
  on(shopLink, 'click', function (e) {
    // on touch/narrow screens let the dropdown toggle instead of navigating immediately
    if (window.innerWidth <= 860) { e.preventDefault(); shop.classList.toggle('open'); }
  });

  /* ---------- promo bar rotating message ---------- */
  var promo = $('.agx-promo[data-rotate]');
  if (promo) {
    var msgs = $all('.agx-promo-msg', promo);
    if (msgs.length > 1) {
      var pi = 0;
      setInterval(function () {
        msgs[pi].style.display = 'none';
        pi = (pi + 1) % msgs.length;
        msgs[pi].style.display = 'inline';
      }, 4000);
    }
  }

  /* ---------- HERO SLIDER ---------- */
  var hero = $('.agx-hero');
  if (hero) {
    var slides = $all('.agx-slide', hero);
    var dotsWrap = $('.agx-dots', hero);
    var idx = 0, timer = null, DELAY = 6000;

    if (slides.length) {
      if (dotsWrap) {
        slides.forEach(function (_, i) {
          var b = doc.createElement('button');
          b.setAttribute('aria-label', 'Go to slide ' + (i + 1));
          if (i === 0) b.className = 'active';
          b.addEventListener('click', function () { go(i); });
          dotsWrap.appendChild(b);
        });
      }
      var dots = dotsWrap ? $all('button', dotsWrap) : [];

      function show(n) {
        slides.forEach(function (s, i) { s.classList.toggle('active', i === n); });
        dots.forEach(function (d, i) { d.classList.toggle('active', i === n); });
        idx = n;
      }
      function go(n) { show((n + slides.length) % slides.length); restart(); }
      function next() { go(idx + 1); }
      function prev() { go(idx - 1); }
      function start() { if (slides.length > 1) timer = setInterval(next, DELAY); }
      function stop() { if (timer) { clearInterval(timer); timer = null; } }
      function restart() { stop(); start(); }

      on($('.agx-arrow.next', hero), 'click', next);
      on($('.agx-arrow.prev', hero), 'click', prev);
      on(hero, 'mouseenter', stop);
      on(hero, 'mouseleave', start);

      // touch swipe
      var sx = 0;
      hero.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; }, { passive: true });
      hero.addEventListener('touchend', function (e) {
        var dx = e.changedTouches[0].clientX - sx;
        if (Math.abs(dx) > 45) { dx < 0 ? next() : prev(); }
      }, { passive: true });

      show(0); start();
    }
  }

  /* ---------- FAVOURITES (localStorage, cosmetic) ---------- */
  var FAVKEY = 'agx_favs';
  function getFavs() { try { return JSON.parse(localStorage.getItem(FAVKEY)) || []; } catch (e) { return []; } }
  function setFavs(a) { try { localStorage.setItem(FAVKEY, JSON.stringify(a)); } catch (e) {} }
  var favs = getFavs();
  $all('.pfav').forEach(function (b) {
    var id = b.getAttribute('data-fav');
    if (id && favs.indexOf(id) > -1) b.classList.add('on');
  });
  doc.addEventListener('click', function (e) {
    var fav = e.target.closest && e.target.closest('.pfav');
    if (!fav) return;
    e.preventDefault();
    var id = fav.getAttribute('data-fav'); if (!id) return;
    favs = getFavs();
    var i = favs.indexOf(id);
    if (i > -1) { favs.splice(i, 1); fav.classList.remove('on'); }
    else { favs.push(id); fav.classList.add('on'); }
    setFavs(favs);
  });

  /* ---------- keyboard activation for role="button" (hamburger, favourite) ---------- */
  doc.addEventListener('keydown', function (e) {
    if (e.key !== 'Enter' && e.key !== ' ' && e.key !== 'Spacebar') return;
    var t = e.target;
    if (t && t.classList && (t.classList.contains('agx-hamb') || t.classList.contains('pfav'))) {
      e.preventDefault();
      t.click();
    }
  });

  /* ---------- QUANTITY STEPPERS on single product ---------- */
  $all('.single-product .quantity').forEach(function (q) {
    if (q.querySelector('.agx-qty-btn')) return;
    var input = q.querySelector('input.qty'); if (!input) return;
    var minus = doc.createElement('button'); minus.type = 'button'; minus.className = 'agx-qty-btn minus'; minus.textContent = '−';
    var plus = doc.createElement('button'); plus.type = 'button'; plus.className = 'agx-qty-btn plus'; plus.textContent = '+';
    q.insertBefore(minus, input); q.appendChild(plus);
    function step(d) {
      var v = parseInt(input.value, 10) || 1, min = parseInt(input.min, 10) || 1;
      var max = parseInt(input.max, 10) || Infinity;
      v = Math.min(max, Math.max(min, v + d));
      input.value = v; input.dispatchEvent(new Event('change', { bubbles: true }));
    }
    minus.addEventListener('click', function () { step(-1); });
    plus.addEventListener('click', function () { step(1); });
  });

  /* ---------- REVEAL ON SCROLL ---------- */
  var io = ('IntersectionObserver' in window) ? new IntersectionObserver(function (es) {
    es.forEach(function (e) { if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); } });
  }, { threshold: 0.12 }) : null;
  function revealScan() {
    var els = $all('.reveal:not(.in)');
    if (!io) { els.forEach(function (el) { el.classList.add('in'); }); return; }
    els.forEach(function (el) { io.observe(el); });
  }
  revealScan();
})();
