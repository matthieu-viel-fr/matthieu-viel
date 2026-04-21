'use strict';

/* ---- Nav scroll shadow ---- */
const nav = document.getElementById('nav');
const onScroll = () => nav.classList.toggle('is-scrolled', window.scrollY > 10);
window.addEventListener('scroll', onScroll, { passive: true });
onScroll();

/* ---- Menu burger (mobile) ---- */
const burger = document.getElementById('nav-burger');
const navLinks = document.getElementById('nav-links');

burger.addEventListener('click', () => {
  const expanded = burger.getAttribute('aria-expanded') === 'true';
  burger.setAttribute('aria-expanded', String(!expanded));
  navLinks.classList.toggle('is-open', !expanded);
});

/* Ferme le menu si on clique sur un lien */
navLinks.querySelectorAll('a').forEach(link => {
  link.addEventListener('click', () => {
    burger.setAttribute('aria-expanded', 'false');
    navLinks.classList.remove('is-open');
  });
});

/* Ferme le menu si on clique en dehors */
document.addEventListener('click', (e) => {
  if (!nav.contains(e.target)) {
    burger.setAttribute('aria-expanded', 'false');
    navLinks.classList.remove('is-open');
  }
});

/* ---- Active nav link on scroll ---- */
const sections = document.querySelectorAll('section[id]');
const navAnchors = document.querySelectorAll('.nav__links a[href^="#"]');

const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        navAnchors.forEach(a => a.classList.remove('is-active'));
        const active = document.querySelector(`.nav__links a[href="#${entry.target.id}"]`);
        if (active) active.classList.add('is-active');
      }
    });
  },
  { rootMargin: '-40% 0px -55% 0px' }
);

sections.forEach(s => observer.observe(s));

/* ---- Animate elements on scroll (fade-up) ---- */
const animateElements = document.querySelectorAll('.fade-up');
if (animateElements.length) {
  const fadeObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          fadeObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.12 }
  );
  animateElements.forEach(el => fadeObserver.observe(el));
}

// ── Scroll to top ──
const scrollTopBtn = document.createElement('button');
scrollTopBtn.id = 'scroll-top';
scrollTopBtn.setAttribute('aria-label', 'Remonter en haut de page');
scrollTopBtn.textContent = '↑';
document.body.appendChild(scrollTopBtn);

window.addEventListener('scroll', () => {
  scrollTopBtn.classList.toggle('visible', window.scrollY > 300);
}, { passive: true });

scrollTopBtn.addEventListener('click', () => {
  window.scrollTo({ top: 0, behavior: 'smooth' });
});
