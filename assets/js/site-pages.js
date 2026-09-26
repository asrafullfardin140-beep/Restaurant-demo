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
   const toggle = document.querySelector('.menu-toggle'), menu = document.querySelector('.mobile-nav-menu');
   if(toggle && menu) {
     toggle.setAttribute('aria-controls','mobile-nav-menu');
     const sync=()=>toggle.setAttribute('aria-expanded',String(menu.classList.contains('open')));
     new MutationObserver(sync).observe(menu,{attributes:true,attributeFilter:['class']}); sync();
   }
 });
})();
