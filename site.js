const screens = {
  login: {
    image: 'Documentation/Documents/Images/DocUser/Login/Login.png',
    title: { en: 'Authentication', fr: 'Authentification' },
    description: {
      en: 'A dedicated login screen starts the authenticated experience and routes each user toward the features available to their role.',
      fr: "Un écran de connexion dédié démarre l'expérience authentifiée et dirige chaque utilisateur vers les fonctionnalités disponibles selon son rôle."
    },
    tags: { en: ['Authentication', 'Responsive UI'], fr: ['Authentification', 'Interface responsive'] }
  },
  dashboard: {
    image: 'Documentation/Documents/Images/DocUser/Gestionnaire/TDB.png',
    title: { en: 'Operational dashboard', fr: 'Tableau de bord opérationnel' },
    description: {
      en: 'Managers can follow rental activity and vehicle status from a central operational view.',
      fr: "Les gestionnaires peuvent suivre l'activité de location et les statuts des véhicules depuis une vue opérationnelle centrale."
    },
    tags: { en: ['Monitoring', 'Vehicle status'], fr: ['Suivi', 'Statuts véhicules'] }
  },
  fleet: {
    image: 'Documentation/Documents/Images/DocUser/Gestionnaire/GDF_Vue.png',
    title: { en: 'Fleet management', fr: 'Gestion de la flotte' },
    description: {
      en: 'The fleet interface centralizes vehicle information, availability and management actions for operational users.',
      fr: "L'interface de flotte centralise les informations véhicules, leur disponibilité et les actions de gestion destinées aux utilisateurs opérationnels."
    },
    tags: { en: ['CRUD', 'Fleet', 'Roles'], fr: ['CRUD', 'Flotte', 'Rôles'] }
  },
  reservation: {
    image: 'Documentation/Documents/Images/DocUser/Gestionnaire/GDR.png',
    title: { en: 'Reservation management', fr: 'Gestion des réservations' },
    description: {
      en: 'Reservation workflows connect clients, managers, vehicle availability, rental periods and dynamic price calculation.',
      fr: "Les parcours de réservation relient clients, gestionnaires, disponibilité des véhicules, périodes de location et calcul dynamique du prix."
    },
    tags: { en: ['Reservations', 'Dynamic pricing'], fr: ['Réservations', 'Prix dynamique'] }
  },
  accounts: {
    image: 'Documentation/Documents/Images/DocUser/Administrateur/CMC.png',
    title: { en: 'Account management', fr: 'Gestion des comptes' },
    description: {
      en: 'Administrators manage users and personal information through dedicated account-management screens.',
      fr: "Les administrateurs gèrent les utilisateurs et les informations personnelles depuis des écrans dédiés à l'administration des comptes."
    },
    tags: { en: ['Administration', 'Authorization'], fr: ['Administration', 'Autorisations'] }
  }
};

const state = {
  lang: localStorage.getItem('tpi-lang') || 'en',
  screen: 'login'
};

const langToggle = document.getElementById('langToggle');
const stageImage = document.getElementById('stageImage');
const stageTitle = document.getElementById('stageTitle');
const stageDescription = document.getElementById('stageDescription');
const stageTags = document.getElementById('stageTags');
const stageCount = document.getElementById('stageCount');
const tabs = [...document.querySelectorAll('.showcase-tab')];
const modal = document.getElementById('previewModal');
const modalImage = document.getElementById('modalImage');
const modalTitle = document.getElementById('modalTitle');
const modalClose = document.getElementById('modalClose');

function applyLanguage() {
  document.documentElement.dataset.lang = state.lang;
  document.documentElement.lang = state.lang;
  langToggle.textContent = state.lang === 'en' ? 'FR' : 'EN';

  document.querySelectorAll('[data-en][data-fr]').forEach((element) => {
    element.textContent = element.dataset[state.lang];
  });

  renderScreen(state.screen);
}

function renderScreen(key) {
  const screen = screens[key];
  state.screen = key;

  tabs.forEach((tab, index) => {
    const isActive = tab.dataset.screen === key;
    tab.classList.toggle('active', isActive);
    tab.setAttribute('aria-selected', String(isActive));
    if (isActive) stageCount.textContent = `${String(index + 1).padStart(2, '0')} / ${String(tabs.length).padStart(2, '0')}`;
  });

  stageImage.classList.add('switching');
  window.setTimeout(() => {
    stageImage.src = screen.image;
    stageImage.alt = screen.title[state.lang];
    stageTitle.textContent = screen.title[state.lang];
    stageDescription.textContent = screen.description[state.lang];
    stageTags.innerHTML = screen.tags[state.lang].map(tag => `<span>${tag}</span>`).join('');
    stageImage.classList.remove('switching');
  }, 120);
}

function openPreview(image, title) {
  modalImage.src = image;
  modalImage.alt = title;
  modalTitle.textContent = title;
  if (typeof modal.showModal === 'function') modal.showModal();
}

langToggle.addEventListener('click', () => {
  state.lang = state.lang === 'en' ? 'fr' : 'en';
  localStorage.setItem('tpi-lang', state.lang);
  applyLanguage();
});

tabs.forEach(tab => {
  tab.addEventListener('click', () => renderScreen(tab.dataset.screen));
});

document.querySelector('.preview-current').addEventListener('click', () => {
  const screen = screens[state.screen];
  openPreview(screen.image, screen.title[state.lang]);
});

document.querySelectorAll('.preview-trigger').forEach(button => {
  button.addEventListener('click', () => {
    const title = state.lang === 'en' ? button.dataset.titleEn : button.dataset.titleFr;
    openPreview(button.dataset.image, title);
  });
});

modalClose.addEventListener('click', () => modal.close());
modal.addEventListener('click', event => {
  if (event.target === modal) modal.close();
});
document.addEventListener('keydown', event => {
  if (event.key === 'Escape' && modal.open) modal.close();
});

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
      observer.unobserve(entry.target);
    }
  });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal').forEach(element => observer.observe(element));

applyLanguage();

// Interactive reconstruction CTA — kept separate from the original 2023 source.
const demoStyle = document.createElement('style');
demoStyle.textContent = `
  .live-demo-section{padding-top:24px;padding-bottom:104px}
  .live-demo-card{position:relative;overflow:hidden;display:grid;grid-template-columns:1.05fr .95fr;gap:36px;align-items:center;padding:44px;border:1px solid rgba(255,255,255,.16);border-radius:28px;background:linear-gradient(135deg,rgba(171,8,0,.18),rgba(155,108,255,.12) 50%,rgba(255,255,255,.035));box-shadow:0 24px 80px rgba(0,0,0,.28)}
  .live-demo-card:before{content:'';position:absolute;width:300px;height:300px;border-radius:50%;right:-120px;top:-140px;background:rgba(171,8,0,.16);filter:blur(10px);pointer-events:none}
  .live-demo-copy{position:relative;z-index:1}
  .live-demo-copy h2{margin:0;font-size:clamp(38px,5vw,64px);line-height:1;letter-spacing:-.05em}
  .live-demo-copy p{max-width:650px;color:var(--muted);font-size:16px}
  .live-demo-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:24px}
  .live-demo-window{position:relative;z-index:1;border:1px solid rgba(255,255,255,.18);border-radius:18px;background:#363A43;box-shadow:0 22px 55px rgba(0,0,0,.35);overflow:hidden;transform:rotate(1deg)}
  .live-demo-window-bar{height:40px;display:flex;align-items:center;gap:6px;padding:0 12px;background:#f5f5f5}
  .live-demo-window-bar i{display:block;width:8px;height:8px;border-radius:50%;background:#ab0800}.live-demo-window-bar i:nth-child(2){opacity:.65}.live-demo-window-bar i:nth-child(3){opacity:.35}
  .live-demo-mini{padding:24px;min-height:280px;display:grid;place-items:center}.live-demo-mini-card{width:min(100%,330px);padding:20px;background:#c6c6c6;border:4px solid #ab0800;border-radius:12px;color:#111}.live-demo-mini-logo{width:84px;height:84px;margin:0 auto 15px;display:grid;place-items:center;border-radius:50%;background:#fff;border:4px solid #111;color:#ab0800;font-weight:900;font-size:22px}.live-demo-mini-field{height:34px;border:1px solid #9ca3af;background:#fff;border-radius:6px;margin:8px 0}.live-demo-mini-button{width:92px;height:30px;margin:12px 0 0 auto;background:#ab0800;border-radius:6px}
  .live-demo-badge{display:inline-flex;align-items:center;gap:8px;margin-bottom:14px;padding:7px 10px;border-radius:999px;border:1px solid rgba(120,247,182,.2);background:rgba(120,247,182,.07);color:#9ffac8;font-size:11px;font-weight:800}.live-demo-badge span{width:7px;height:7px;border-radius:50%;background:#78f7b6;box-shadow:0 0 14px rgba(120,247,182,.45)}
  @media(max-width:850px){.live-demo-card{grid-template-columns:1fr;padding:28px}.live-demo-window{transform:none}}
`;
document.head.appendChild(demoStyle);

const engineeringSection = document.getElementById('engineering');
if (engineeringSection) {
  const liveDemo = document.createElement('section');
  liveDemo.className = 'section-pad live-demo-section reveal';
  liveDemo.id = 'live-demo';
  liveDemo.innerHTML = `
    <div class="live-demo-card">
      <div class="live-demo-copy">
        <div class="live-demo-badge"><span></span><b data-en="Interactive reconstruction" data-fr="Reconstruction interactive">Interactive reconstruction</b></div>
        <h2 data-en="Don't just look at it. Try it." data-fr="Ne regardez pas seulement. Essayez-la.">Don't just look at it. Try it.</h2>
        <p data-en="A static, interactive reconstruction of the original 2023 TPI interface, rebuilt from the original Blade views. Switch roles, manage vehicles, create reservations and explore the dashboard — with demo data only." data-fr="Une reconstruction statique et interactive de l'interface originale du TPI 2023, recréée à partir des vues Blade d'origine. Changez de rôle, gérez des véhicules, créez des réservations et explorez le tableau de bord — uniquement avec des données de démonstration.">A static, interactive reconstruction of the original 2023 TPI interface, rebuilt from the original Blade views. Switch roles, manage vehicles, create reservations and explore the dashboard — with demo data only.</p>
        <div class="live-demo-actions">
          <a class="primary-button" href="demo/"><span data-en="Launch interactive demo" data-fr="Lancer la démo interactive">Launch interactive demo</span><span aria-hidden="true">→</span></a>
          <a class="secondary-button" href="https://github.com/MrLeoDev/TPI/tree/main/Application/Gestion_location_voitures/resources/views" target="_blank" rel="noreferrer"><span data-en="View original Blade views" data-fr="Voir les vues Blade originales">View original Blade views</span><span aria-hidden="true">↗</span></a>
        </div>
      </div>
      <div class="live-demo-window" aria-hidden="true">
        <div class="live-demo-window-bar"><i></i><i></i><i></i></div>
        <div class="live-demo-mini"><div><div class="live-demo-mini-logo">GLV</div><div class="live-demo-mini-card"><strong style="color:#ab0800">Connexion</strong><div class="live-demo-mini-field"></div><div class="live-demo-mini-field"></div><div class="live-demo-mini-button"></div></div></div></div>
      </div>
    </div>`;
  engineeringSection.before(liveDemo);
  observer.observe(liveDemo);
  applyLanguage();

  const nav = document.querySelector('.nav');
  if (nav && !nav.querySelector('[href="#live-demo"]')) {
    const link = document.createElement('a');
    link.href = '#live-demo';
    link.dataset.en = 'Live demo';
    link.dataset.fr = 'Démo live';
    link.textContent = state.lang === 'en' ? 'Live demo' : 'Démo live';
    nav.insertBefore(link, nav.querySelector('[href="#engineering"]'));
  }
}
