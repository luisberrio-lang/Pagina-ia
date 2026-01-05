import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// Parallax suave (optimizado)
(() => {
  const root = document.documentElement;

  let tx = 0, ty = 0;
  let cx = 0, cy = 0;

  window.addEventListener('pointermove', (e) => {
    tx = (e.clientX / window.innerWidth) * 2 - 1;   // -1..1
    ty = (e.clientY / window.innerHeight) * 2 - 1;  // -1..1
  }, { passive: true });

  const loop = () => {
    cx += (tx - cx) * 0.08;
    cy += (ty - cy) * 0.08;

    root.style.setProperty('--px', cx.toFixed(3));
    root.style.setProperty('--py', cy.toFixed(3));

    requestAnimationFrame(loop);
  };

  requestAnimationFrame(loop);
})();
