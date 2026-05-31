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

// Lazy-load media (video) when visible to keep pages light
(() => {
  const mediaEls = document.querySelectorAll('[data-media-src]');
  if (!mediaEls.length) return;

  const loadMedia = (el) => {
    if (el.dataset.mediaLoaded === '1') return;
    const src = el.getAttribute('data-media-src');
    if (src && el.getAttribute('src') !== src) {
      el.setAttribute('src', src);
    }
    el.dataset.mediaLoaded = '1';
    el.load?.();
    el.play?.().catch(() => {});
  };

  if (!('IntersectionObserver' in window)) {
    mediaEls.forEach(loadMedia);
    return;
  }

  const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach((entry) => {
      if (!entry.isIntersecting) return;
      loadMedia(entry.target);
      obs.unobserve(entry.target);
    });
  }, { rootMargin: '120px 0px' });

  mediaEls.forEach((el) => observer.observe(el));
})();

// Robust video load/retry to avoid blank frames on refresh.
(() => {
  const videos = document.querySelectorAll('video.media-card__media');
  if (!videos.length) return;

  videos.forEach((video) => {
    let retried = false;

    const tryPlay = () => {
      if (!video.hasAttribute('autoplay')) return;
      video.play?.().catch(() => {});
    };

    const retry = () => {
      if (retried) return;
      retried = true;
      const src = video.getAttribute('src');
      if (!src) return;
      const sep = src.includes('?') ? '&' : '?';
      video.setAttribute('src', `${src}${sep}r=${Date.now()}`);
      video.load?.();
      tryPlay();
    };

    video.addEventListener('loadedmetadata', tryPlay, { once: true });
    video.addEventListener('error', retry);
    video.addEventListener('stalled', retry);
    video.addEventListener('suspend', () => {
      if (video.readyState < 2) retry();
    });
  });
})();
