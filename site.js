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
