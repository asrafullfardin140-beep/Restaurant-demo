(() => {
 const script = document.currentScript;
 const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
 let seen = true;
 try { seen = sessionStorage.getItem('bambu-intro-v2') === '1'; sessionStorage.setItem('bambu-intro-v2','1'); } catch (_) {}
 if (!seen && !reduced) {
   const overlay = document.createElement('div'); overlay.className = 'brand-intro';
   const group = document.createElement('div'); group.className = 'brand-intro-group';
   const logo = document.createElement('img'); logo.alt = ''; logo.width = 120; logo.height = 120;
   const name = document.createElement('p'); name.className = 'brand-intro-name'; name.textContent = 'BAMBU';
   const tagline = document.createElement('p'); tagline.className = 'brand-intro-tagline'; tagline.textContent = 'INDIAN & THAI · LIMERICK';
   const skip = document.createElement('button'); skip.type = 'button'; skip.textContent = 'Skip intro';
   group.append(logo, name, tagline); overlay.append(group, skip); document.body.append(overlay);
   let timer;
   const remove = () => { clearTimeout(timer); document.removeEventListener('keydown', remove); overlay.remove(); };
   const start = () => { if (!overlay.isConnected) return; overlay.classList.add('is-ready'); clearTimeout(timer); timer = setTimeout(remove, 1900); };
   skip.addEventListener('click', remove);
   logo.addEventListener('error', remove, {once:true});
   logo.addEventListener('load', start, {once:true});
   document.addEventListener('keydown', remove, {once:true});
   timer = setTimeout(remove, 3000);
   logo.src = new URL('../logo.webp', script.src).href;
 }
 document.addEventListener('DOMContentLoaded', () => {
   const video = document.querySelector('.hero-video');
   const control = document.querySelector('.hero-video-toggle');
   if (video && control) {
     const viewport = matchMedia('(max-width: 768px)');
     const motion = matchMedia('(prefers-reduced-motion: reduce)');
     let wanted = !motion.matches && !navigator.connection?.saveData;
     let visible = true;
     let selected = '';
     const label = () => { control.textContent = video.paused ? 'Play background video' : 'Pause background video'; };
     const source = () => {
       const next = viewport.matches ? video.dataset.mobile : video.dataset.desktop;
       if (selected === next) return;
       selected = next;
       video.classList.remove('is-playing');
       video.src = next;
       video.load();
     };
     const sync = () => {
       if (wanted && visible && !document.hidden) {
         source();
         video.muted = true;
         video.play().catch(label);
       } else video.pause();
       label();
     };
     video.addEventListener('playing', () => { video.classList.add('is-playing'); label(); });
     video.addEventListener('pause', label);
     video.addEventListener('error', () => { video.classList.remove('is-playing'); control.hidden = true; });
     control.hidden = false;
     control.addEventListener('click', () => { wanted = video.paused; sync(); });
     viewport.addEventListener('change', () => {
       if (selected) { video.pause(); video.removeAttribute('src'); video.load(); selected = ''; video.classList.remove('is-playing'); }
       sync();
     });
     motion.addEventListener('change', () => { wanted = !motion.matches && !navigator.connection?.saveData; sync(); });
     document.addEventListener('visibilitychange', sync);
     if ('IntersectionObserver' in window) {
       new IntersectionObserver(entries => { visible = entries[0].isIntersecting; sync(); }, {threshold:0})
         .observe(video.closest('.hero'));
     } else sync();
   }

   const toggle = document.querySelector('.menu-toggle'), menu = document.querySelector('.mobile-nav-menu');
   if(toggle && menu) {
     toggle.setAttribute('aria-controls','mobile-nav-menu');
     const sync=()=>toggle.setAttribute('aria-expanded',String(menu.classList.contains('open')));
     new MutationObserver(sync).observe(menu,{attributes:true,attributeFilter:['class']}); sync();
   }
 });
})();
