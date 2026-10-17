(() => {
  const vehicleImages = {
    '#9ca3af': { src: 'assets/car-vintage.webp', alt: 'Véhicule classique blanc' },
    '#60a5fa': { src: 'assets/car-lada.webp', alt: 'Véhicule tout-terrain blanc' },
    '#111827': { src: 'assets/car-bmw.webp', alt: 'BMW de collection' },
    '#ef4444': { src: 'assets/car-hotrod.webp', alt: 'Hot rod rouge' }
  };

  const fallbackCarSvg = typeof carSvg === 'function' ? carSvg : null;

  if (fallbackCarSvg) {
    carSvg = function (color = '#6b7280') {
      const asset = vehicleImages[String(color).toLowerCase()];
      if (!asset) return fallbackCarSvg(color);
      return `<img class="car-photo" src="${asset.src}" alt="${asset.alt}" loading="lazy">`;
    };
  }

  function installLogo() {
    document.querySelectorAll('.glv-logo').forEach((logo) => {
      if (logo.querySelector('.glv-brand-image')) return;
      logo.innerHTML = '<img class="glv-brand-image" src="assets/logo-glv.webp" alt="GLV — Gestion Location Voitures">';
    });
  }

  installLogo();

  // Some parts of the demo are rendered dynamically. Keep the real logo in place
  // if the navigation is recreated later by JavaScript.
  const observer = new MutationObserver(() => installLogo());
  observer.observe(document.body, { childList: true, subtree: true });
})();
