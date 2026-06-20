/* AlphaGearXBD — shared multi-page logic
   Injects header/footer/background, renders product grids, category tiles,
   goal cards, handles filter/sort/cart/favorites across all pages. */
(function(){
  "use strict";

  /* ---------- DATA ---------- */
  var CATS = [
    {key:'strength',   label:'Strength Training',  icon:'i-dumbbell', page:'strength-training.html', img:'weightlifting,gym?lock=1',     count:4, tag:'Build raw power',
      sub:['Weight Lifting Belt','Weightlifting Wrist Straps','Weightlifting Wraps','Barbell Pad','ABS Roller','Knee Support','Elbow Brace']},
    {key:'yoga',       label:'Yoga & Flexibility', icon:'i-lotus',    page:'yoga-flexibility.html', img:'yoga?lock=2',                   count:4, tag:'Move better, feel better',
      sub:['Yoga Mats','Yoga Roller','Exercise Ball','Resistance Ball','Resistance Band','Sweat-Resistant Head Band']},
    {key:'recovery',   label:'Recovery & Support', icon:'i-heart',    page:'recovery-support.html', img:'physiotherapy,massage?lock=3',  count:3, tag:'Heal and protect',
      sub:['Ankle Straps','Knee Support','Elbow Brace','ABS Roller','Sweat-Resistant Head Band']},
    {key:'home',       label:'Home Workout',       icon:'i-house',    page:'home-workout.html',     img:'home,workout?lock=4',           count:3, tag:'Train anywhere',
      sub:['Doorway Pull-up Bar','Double Twister','Hand Grip']},
    {key:'accessories',label:'Gym Accessories',    icon:'i-bag',      page:'gym-accessories.html',  img:'gym,bag?lock=5',                count:3, tag:'Everyday essentials',
      sub:['Gym Bag','Gym Towel','Water Bottle','Gym Sneaker']},
    {key:'kits',       label:'Complete Kits',      icon:'i-box',      page:'complete-kits.html',    img:'gym,equipment?lock=6',          count:4, tag:'Best value bundles', kit:true,
      sub:['Home Beginner Kit','Strength Starter Kit','Recovery Kit','Full Home Gym Kit']}
  ];

  var GOALS = [
    {label:'Build Muscle',        icon:'i-dumbbell', img:'muscle,gym?lock=71',           page:'strength-training.html'},
    {label:'Lose Weight at Home', icon:'i-flame',    img:'home,workout,cardio?lock=72',  page:'home-workout.html'},
    {label:'Increase Flexibility',icon:'i-spark',    img:'stretching,fitness?lock=73',   page:'yoga-flexibility.html'},
    {label:'Recover from Pain',   icon:'i-heart',    img:'physiotherapy,recovery?lock=74',page:'recovery-support.html'},
    {label:'Start Yoga',          icon:'i-lotus',    img:'yoga,meditation?lock=75',      page:'yoga-flexibility.html'}
  ];

  var PRODUCTS = [
    {id:'belt',       name:'Weight Lifting Belt',        cat:'strength',    price:1450, old:1800, badge:'sale', rating:4.8, count:96,  img:'weightlifting,belt?lock=11', feat:true},
    {id:'wrist',      name:'Weightlifting Wrist Straps', cat:'strength',    price:650,            rating:4.7, count:64,  img:'gym,wrist,strap?lock=12'},
    {id:'barbellpad', name:'Barbell Pad',                cat:'strength',    price:550,            rating:4.6, count:41,  img:'barbell?lock=13'},
    {id:'absroller',  name:'ABS Roller',                 cat:'strength',    price:890,  badge:'new', rating:4.8, count:73, img:'ab,wheel,fitness?lock=14', feat:true},

    {id:'yogamat',    name:'Premium Yoga Mat',           cat:'yoga',        price:1200, old:1500, badge:'sale', rating:4.9, count:152, img:'yoga,mat?lock=21', feat:true},
    {id:'foamroller', name:'Yoga Foam Roller',           cat:'yoga',        price:750,            rating:4.7, count:88,  img:'foam,roller?lock=22'},
    {id:'resband',    name:'Resistance Band',            cat:'yoga',        price:450,  badge:'new', rating:4.6, count:60, img:'resistance,band?lock=23', feat:true},
    {id:'exball',     name:'Exercise Ball',              cat:'yoga',        price:1100,           rating:4.7, count:49,  img:'exercise,ball,gym?lock=24'},

    {id:'knee',       name:'Knee Support',               cat:'recovery',    price:520,            rating:4.7, count:70,  img:'knee,brace?lock=31'},
    {id:'ankle',      name:'Ankle Straps',               cat:'recovery',    price:480,            rating:4.6, count:38,  img:'ankle,support?lock=32'},
    {id:'elbow',      name:'Elbow Brace',                cat:'recovery',    price:460,  badge:'new', rating:4.5, count:33, img:'elbow,brace?lock=33'},

    {id:'pullup',     name:'Doorway Pull-up Bar',        cat:'home',        price:1650, old:1990, badge:'sale', rating:4.8, count:91,  img:'pull,up,bar?lock=41', feat:true},
    {id:'handgrip',   name:'Hand Grip Strengthener',     cat:'home',        price:350,            rating:4.7, count:120, img:'hand,grip?lock=42'},
    {id:'twister',    name:'Double Twister',             cat:'home',        price:600,            rating:4.5, count:28,  img:'fitness,home,exercise?lock=43'},

    {id:'gymbag',     name:'Gym Bag',                    cat:'accessories', price:1350,           rating:4.8, count:77,  img:'gym,bag?lock=51'},
    {id:'towel',      name:'Gym Towel',                  cat:'accessories', price:320,            rating:4.6, count:44,  img:'towel,gym?lock=52'},
    {id:'bottle',     name:'Water Bottle',               cat:'accessories', price:420,  badge:'new', rating:4.7, count:102, img:'water,bottle,sport?lock=53', feat:true},

    {id:'kitbeginner',name:'Home Beginner Kit',          cat:'kits', kit:true, price:1990, old:2400, badge:'kit', kitlabel:'Kit · Save 17%', rating:4.9, count:58, img:'home,workout,equipment?lock=61', desc:'Yoga Mat + Resistance Band + Hand Grip', feat:true},
    {id:'kitstrength',name:'Strength Starter Kit',       cat:'kits', kit:true, price:2490,           badge:'kit', kitlabel:'Kit',            rating:4.8, count:47, img:'gym,equipment?lock=62',          desc:'Weight Lifting Belt + Wrist Straps + Barbell Pad'},
    {id:'kitrecovery',name:'Recovery Kit',               cat:'kits', kit:true, price:1790,           badge:'kit', kitlabel:'Kit',            rating:4.8, count:39, img:'recovery,fitness?lock=63',       desc:'Foam Roller + Knee Support + Ankle Straps'},
    {id:'kitfull',    name:'Full Home Gym Kit',          cat:'kits', kit:true, price:4990, old:5800, badge:'kit', kitlabel:'Kit · Save 14%', rating:4.9, count:66, img:'home,gym?lock=64',               desc:'Pull-up Bar + Yoga Mat + Dumbbells + Towel', feat:true}
  ];

  var IMG = 'https://loremflickr.com/600/600/';
  function catLabel(k){ for(var i=0;i<CATS.length;i++){ if(CATS[i].key===k) return CATS[i].label; } return k; }
  function catBy(k){ for(var i=0;i<CATS.length;i++){ if(CATS[i].key===k) return CATS[i]; } return null; }
  function fmt(n){ return '৳' + n.toLocaleString('en-US'); }

  /* ---------- STATE (cart + favourites in localStorage) ---------- */
  function load(key,def){ try{ return JSON.parse(localStorage.getItem(key)) || def; }catch(e){ return def; } }
  function save(key,val){ try{ localStorage.setItem(key, JSON.stringify(val)); }catch(e){} }
  var cart = load('agx_cart', 0);
  var favs = load('agx_favs', []);
  function isFav(id){ return favs.indexOf(id) > -1; }

  /* ---------- CHROME (background, sprite, header, footer) ---------- */
  var SPRITE = '<svg width="0" height="0" style="position:absolute" aria-hidden="true"><defs>'+
    '<symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>'+
    '<symbol id="i-caret" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></symbol>'+
    '<symbol id="i-lotus" viewBox="0 0 24 24"><path d="M12 21c-5 0-9-2.5-9-2.5s1.5-4.5 5.5-4.5M12 21c5 0 9-2.5 9-2.5s-1.5-4.5-5.5-4.5M12 21c0-4 .5-8 3-11M12 21c0-4-.5-8-3-11M12 21V9"/></symbol>'+
    '<symbol id="i-dumbbell" viewBox="0 0 24 24"><path d="M2 12h2M20 12h2M5 8.5v7M19 8.5v7M8 10v4M16 10v4M8 12h8"/></symbol>'+
    '<symbol id="i-moon" viewBox="0 0 24 24"><path d="M20 14.5A8 8 0 0 1 9.5 4 7 7 0 1 0 20 14.5z"/></symbol>'+
    '<symbol id="i-heart" viewBox="0 0 24 24"><path d="M12 20s-7-4.6-9.3-9C1 7.5 3 4.5 6.2 4.5c2 0 3.2 1.2 3.8 2.3C10.6 5.7 11.8 4.5 13.8 4.5 17 4.5 19 7.5 17.3 11 15 15.4 12 20 12 20z"/></symbol>'+
    '<symbol id="i-spark" viewBox="0 0 24 24"><path d="M12 3v18M3 12h18M6 6l12 12M18 6L6 18" stroke-width="1.2"/></symbol>'+
    '<symbol id="i-drop" viewBox="0 0 24 24"><path d="M12 3c4 5 6 8 6 11a6 6 0 0 1-12 0c0-3 2-6 6-11z"/></symbol>'+
    '<symbol id="i-bag" viewBox="0 0 24 24"><path d="M6 7h12l1 13H5zM9 7a3 3 0 0 1 6 0"/></symbol>'+
    '<symbol id="i-house" viewBox="0 0 24 24"><path d="M3 11l9-7 9 7M5 10v10h14V10"/></symbol>'+
    '<symbol id="i-box" viewBox="0 0 24 24"><path d="M3 8l9-5 9 5v8l-9 5-9-5zM3 8l9 5 9-5M12 13v9"/></symbol>'+
    '<symbol id="i-flame" viewBox="0 0 24 24"><path d="M12 3c1 4 5 5 5 9a5 5 0 0 1-10 0c0-2 1-3 2-4 .4 1.8 2 1.8 2 0 0-2-1-3-1-5z"/></symbol>'+
    '</defs></svg>';

  var BG = '<div class="bg-anim"><div class="neon n1"></div><div class="neon n2"></div><div class="neon n3"></div><div class="neon n4"></div></div><div class="grain"></div>';

  function megaHTML(){
    var cols = CATS.map(function(c){
      var subs = c.sub.map(function(s){ return '<a href="'+c.page+'">'+s+'</a>'; }).join('');
      return '<div class="mega-col'+(c.kit?' kit':'')+'">'+
        '<h5><a href="'+c.page+'"><svg class="icn"><use href="#'+c.icon+'"/></svg>'+c.label+'</a></h5>'+subs+'</div>';
    }).join('');
    return '<div class="mega" id="mega"><div class="mega-grid">'+cols+'</div></div>';
  }

  function headerHTML(){
    return '<header id="hdr"><div class="wrap"><nav class="nav">'+
      '<a class="brand" href="index.html"><span class="logo">AG</span>AlphaGearXBD</a>'+
      '<ul class="navlinks" id="navlinks">'+
        '<li class="has-mega"><a class="navlink" data-nav="shop" href="shop.html">Shop <svg class="icn"><use href="#i-caret"/></svg></a>'+megaHTML()+'</li>'+
        '<li><a class="navlink" data-nav="learn" href="learn.html">Learn</a></li>'+
        '<li><a class="navlink" data-nav="about" href="about.html">About Us</a></li>'+
        '<li><a class="navlink kit" data-nav="kits" href="complete-kits.html">Complete Kits</a></li>'+
      '</ul>'+
      '<div class="navcta">'+
        '<button class="cartbtn" id="cartBtn" aria-label="Cart"><svg class="icn"><use href="#i-bag"/></svg><span class="cart-count empty" id="cartCount">0</span></button>'+
        '<a class="btn btn-primary" href="shop.html">Shop Now</a>'+
        '<div class="hamb" id="hamb"><span></span><span></span><span></span></div>'+
      '</div>'+
    '</nav></div></header>';
  }

  function footerHTML(){
    return '<footer><div class="wrap">'+
      '<div class="fcta reveal"><span class="eyebrow">Get Started</span>'+
        '<h2>Start Your Fitness Journey</h2>'+
        '<p>AlphaGearXBD is your trusted source for premium gym, yoga and recovery gear in Bangladesh. Quality equipment, fair prices, and Cash on Delivery nationwide.</p>'+
        '<a class="btn btn-primary" href="shop.html">Shop Now</a></div>'+
      '<div class="fbar"><div class="fbrand"><span class="logo">AG</span>AlphaGearXBD</div>'+
        '<div class="flinks">'+
          '<a href="shop.html">Shop</a>'+
          '<a href="complete-kits.html">Complete Kits</a>'+
          '<a href="learn.html">Learn</a>'+
          '<a href="about.html">About Us</a>'+
        '</div></div>'+
      '<div class="fcopy">© 2026 AlphaGearXBD. All rights reserved. · Cash on Delivery across Bangladesh.</div>'+
    '</div></footer>';
  }

  /* ---------- RENDER HELPERS ---------- */
  function tileHTML(c){
    return '<a class="cat-tile'+(c.kit?' kit':'')+'" href="'+c.page+'">'+
      '<img src="'+IMG+c.img+'" alt="'+c.label+'" loading="lazy">'+
      (c.kit?'<span class="kit-tag">Best Value</span>':'')+
      '<div class="cic"><svg class="icn"><use href="#'+c.icon+'"/></svg></div>'+
      '<h4>'+c.label+'</h4><span>'+(c.kit?c.count+' bundles':c.count+' items')+'</span></a>';
  }
  function goalHTML(g){
    return '<a class="goal" href="'+g.page+'">'+
      '<img src="'+IMG+g.img+'" alt="'+g.label+'" loading="lazy">'+
      '<div class="gic"><svg class="icn"><use href="#'+g.icon+'"/></svg></div>'+
      '<h4>'+g.label+'</h4>'+
      '<span class="glink">Shop Gear <svg class="icn"><use href="#i-arrow"/></svg></span></a>';
  }
  function cardHTML(p){
    var badge = p.badge==='kit' ? '<span class="pbadge kit">'+p.kitlabel+'</span>'
              : p.badge==='sale' ? '<span class="pbadge sale">Sale</span>'
              : p.badge==='new'  ? '<span class="pbadge new">New</span>' : '';
    var old  = p.old ? '<span class="price-old">'+fmt(p.old)+'</span>' : '';
    var desc = p.desc ? '<p class="pdesc">'+p.desc+'</p>' : '';
    var pcat = p.cat==='kits' ? 'Complete Kit' : catLabel(p.cat);
    return '<div class="pcard'+(p.kit?' kit':'')+' reveal" data-id="'+p.id+'" data-price="'+p.price+'" data-new="'+(p.badge==='new'?1:0)+'">'+
      '<div class="pthumb">'+badge+
        '<div class="pfav'+(isFav(p.id)?' on':'')+'" data-fav="'+p.id+'" title="Add to favorites"><svg class="icn"><use href="#i-heart"/></svg></div>'+
        '<img src="'+IMG+p.img+'" alt="'+p.name+'" loading="lazy"></div>'+
      '<span class="pcat">'+pcat+'</span>'+
      '<h3>'+p.name+'</h3>'+desc+
      '<div class="prating"><span class="stars">★★★★★</span> '+p.rating+' ('+p.count+')</div>'+
      '<div class="price-row"><span class="price">'+fmt(p.price)+'</span>'+old+'</div>'+
      '<button class="shop-btn add-btn" data-add="'+p.id+'">Add to Bag</button></div>';
  }

  function listFor(key){
    if(!key || key==='all') return PRODUCTS.slice();
    if(key==='feat') return PRODUCTS.filter(function(p){ return p.feat; });
    return PRODUCTS.filter(function(p){ return p.cat===key; });
  }
  function sortList(arr,mode){
    var a = arr.slice();
    if(mode==='low')  a.sort(function(x,y){ return x.price-y.price; });
    else if(mode==='high') a.sort(function(x,y){ return y.price-x.price; });
    else if(mode==='new')  a.sort(function(x,y){ return (y.badge==='new'?1:0)-(x.badge==='new'?1:0); });
    return a;
  }
  function renderGrid(grid){
    var list = sortList(listFor(grid.getAttribute('data-cat')), grid.getAttribute('data-sort') || 'featured');
    grid.innerHTML = list.length ? list.map(cardHTML).join('') : '<p class="empty">No products found in this category yet.</p>';
    observeReveal(grid);
  }

  /* ---------- REVEAL ON SCROLL ---------- */
  var io = ('IntersectionObserver' in window) ? new IntersectionObserver(function(es){
    es.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('in'); io.unobserve(e.target); } });
  }, {threshold:.12}) : null;
  function observeReveal(scope){
    var els = (scope||document).querySelectorAll('.reveal');
    if(!io){ for(var i=0;i<els.length;i++) els[i].classList.add('in'); return; }
    els.forEach(function(el){ if(!el.classList.contains('in')) io.observe(el); });
  }

  /* ---------- TOAST ---------- */
  var toastEl, toastT;
  function toast(msg){
    if(!toastEl){ toastEl = document.getElementById('toast'); }
    if(!toastEl) return;
    toastEl.textContent = msg;
    toastEl.style.transform = 'translateX(-50%) translateY(0)';
    clearTimeout(toastT);
    toastT = setTimeout(function(){ toastEl.style.transform = 'translateX(-50%) translateY(120px)'; }, 2200);
  }

  /* ---------- CART + FAV ---------- */
  function updateCart(){
    var el = document.getElementById('cartCount');
    if(!el) return;
    el.textContent = cart;
    el.classList.toggle('empty', cart<=0);
  }
  function addToBag(id){
    var p = PRODUCTS.filter(function(x){ return x.id===id; })[0];
    cart++; save('agx_cart', cart); updateCart();
    toast((p?p.name:'Item') + ' added to bag');
  }
  function toggleFav(id, el){
    var i = favs.indexOf(id);
    if(i>-1){ favs.splice(i,1); el && el.classList.remove('on'); toast('Removed from favorites'); }
    else    { favs.push(id);   el && el.classList.add('on');   toast('Added to favorites ♥'); }
    save('agx_favs', favs);
  }

  /* ---------- INIT ---------- */
  function init(){
    var body = document.body;
    var main = body.querySelector('main');

    // inject chrome
    body.insertAdjacentHTML('afterbegin', BG + SPRITE + headerHTML());
    body.insertAdjacentHTML('beforeend', footerHTML() + '<div id="toast"></div>');

    // active nav state
    var page = body.getAttribute('data-page');
    var cat  = body.getAttribute('data-cat');
    var nav = (page==='learn') ? 'learn'
            : (page==='about') ? 'about'
            : (cat==='kits')   ? 'kits'
            : (page==='shop' || page==='cat') ? 'shop' : '';
    if(nav){
      var link = body.querySelector('.navlink[data-nav="'+nav+'"]');
      if(link) link.classList.add('active');
    }

    // header scroll state + hamburger
    var hdr = document.getElementById('hdr');
    window.addEventListener('scroll', function(){ hdr.classList.toggle('scrolled', window.scrollY>30); });
    var navlinks = document.getElementById('navlinks');
    document.getElementById('hamb').onclick = function(){ navlinks.classList.toggle('open'); };
    // close mobile menu on link tap
    navlinks.addEventListener('click', function(e){ if(e.target.closest('a')) navlinks.classList.remove('open'); });

    // cart button
    document.getElementById('cartBtn').addEventListener('click', function(){
      toast(cart>0 ? ('Cart: '+cart+' item'+(cart>1?'s':'')+' · checkout coming soon') : 'Your bag is empty');
    });
    updateCart();

    // render category tiles
    body.querySelectorAll('[data-tiles]').forEach(function(c){ c.innerHTML = CATS.map(tileHTML).join(''); });
    // render goal cards
    body.querySelectorAll('[data-goals]').forEach(function(c){ c.innerHTML = GOALS.map(goalHTML).join(''); });
    // render sub-category chips (uses body data-cat)
    body.querySelectorAll('[data-subcats]').forEach(function(c){
      var meta = catBy(cat);
      if(meta) c.innerHTML = meta.sub.map(function(s){ return '<span class="chip">'+s+'</span>'; }).join('');
    });

    // render filter tabs (shop page)
    body.querySelectorAll('[data-tabs]').forEach(function(c){
      var tabs = '<button class="ftab active" data-cat="all">All</button>' +
        CATS.map(function(k){ return '<button class="ftab'+(k.kit?' kit':'')+'" data-cat="'+k.key+'">'+k.label+'</button>'; }).join('');
      c.innerHTML = tabs;
    });

    // render sort controls
    body.querySelectorAll('[data-sort]').forEach(function(c){
      c.innerHTML = 'Sort by <select class="sortSel"><option value="featured">Featured</option><option value="new">Newest</option><option value="low">Price: Low to High</option><option value="high">Price: High to Low</option></select>';
    });

    // render product grids
    var grids = body.querySelectorAll('.js-grid');
    grids.forEach(renderGrid);

    // filter tab clicks -> set first grid category
    body.querySelectorAll('.ftab').forEach(function(tab){
      tab.addEventListener('click', function(){
        body.querySelectorAll('.ftab').forEach(function(t){ t.classList.remove('active'); });
        tab.classList.add('active');
        grids.forEach(function(g){ g.setAttribute('data-cat', tab.getAttribute('data-cat')); renderGrid(g); });
      });
    });
    // sort change -> re-render grids
    body.querySelectorAll('.sortSel').forEach(function(sel){
      sel.addEventListener('change', function(){
        grids.forEach(function(g){ g.setAttribute('data-sort', sel.value); renderGrid(g); });
      });
    });

    // delegated clicks for fav + add-to-bag
    document.addEventListener('click', function(e){
      var fav = e.target.closest('[data-fav]');
      if(fav){ toggleFav(fav.getAttribute('data-fav'), fav); return; }
      var add = e.target.closest('[data-add]');
      if(add){ addToBag(add.getAttribute('data-add')); return; }
    });

    observeReveal(document);
  }

  if(document.readyState==='loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
