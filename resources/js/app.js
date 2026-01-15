import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Parallax suave: SOLO si existe un contenedor con data-parallax
(() => {
  const parallaxRoot = document.querySelector('[data-parallax]');
  if (!parallaxRoot) return;

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReduced) return;

  let tx = 0, ty = 0;
  let cx = 0, cy = 0;

  window.addEventListener('pointermove', (e) => {
    const w = window.innerWidth || 1;
    const h = window.innerHeight || 1;
    tx = (e.clientX / w) * 2 - 1;
    ty = (e.clientY / h) * 2 - 1;
  }, { passive: true });

  const loop = () => {
    cx += (tx - cx) * 0.08;
    cy += (ty - cy) * 0.08;

    // Variables SOLO en el contenedor (no en :root)
    parallaxRoot.style.setProperty('--px', cx.toFixed(3));
    parallaxRoot.style.setProperty('--py', cy.toFixed(3));

    requestAnimationFrame(loop);
  };

  requestAnimationFrame(loop);
})();
