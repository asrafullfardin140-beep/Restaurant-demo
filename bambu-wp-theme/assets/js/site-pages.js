(() => {
 const script = document.currentScript;
 const reduced = matchMedia('(prefers-reduced-motion: reduce)').matches;
 let seen = true;
 try { seen = sessionStorage.getItem('bambu-intro') === '1'; sessionStorage.setItem('bambu-intro','1'); } catch (_) {}
 if (!seen && !reduced) {
   const overlay = document.createElement('div'); overlay.className = 'brand-intro';
   const logo = document.createElement('img'); logo.src = new URL('../logo.webp', script.src).href; logo.alt = 'Bambu';
   const skip = document.createElement('button'); skip.type='button'; skip.textContent='Skip intro';
   overlay.append(logo,skip); document.body.append(overlay);
   const remove = () => overlay.remove();
   skip.addEventListener('click',remove); logo.addEventListener('error',remove);
   document.addEventListener('keydown',remove,{once:true});
   setTimeout(remove,1200);
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
