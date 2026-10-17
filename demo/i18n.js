(() => {
  const languageSelects = [
    document.getElementById('loginLanguage'),
    document.querySelector('.nav-language')
  ].filter(Boolean);

  const locales = { fr: 'fr-CH', en: 'en-GB', de: 'de-CH', it: 'it-CH' };
  let lang = localStorage.getItem('glv-demo-lang') || 'fr';
  let translating = false;

  const translations = {
    en: {
      'Reconstruction interactive': 'Interactive reconstruction',
      'données fictives': 'demo data',
      'aucun backend': 'no backend',
      'Rôle': 'Role',
      'Réinitialiser': 'Reset',
      'Gestionnaire': 'Manager',
      'Administrateur': 'Administrator',
      'Client': 'Client',
      'Connexion': 'Login',
      'Mot de passe': 'Password',
      'Se souvenir de moi': 'Remember me',
      'SE CONNECTER': 'SIGN IN',
      'Manuel utilisateur': 'User manual',
      'Déconnexion': 'Sign out',
      'Création / Modification de comptes': 'Account creation / management',
      'Gestion des réservations': 'Reservation management',
      'Gestion de la flotte': 'Fleet management',
      'Tableau de bord': 'Dashboard',
      'Catégorie': 'Role',
      'Montant des locations': 'Rental total',
      'Informations personnelles': 'Personal information',
      'Prénom': 'First name',
      'Nom': 'Last name',
      'Mise à jour du mot de passe': 'Update password',
      'Utilisez un mot de passe suffisamment robuste.': 'Use a sufficiently strong password.',
      'Nouveau mot de passe*': 'New password*',
      'Confirmation*': 'Confirmation*',
      'METTRE À JOUR': 'UPDATE',
      'AJOUTER UN COMPTE': 'ADD ACCOUNT',
      'Ajouter un compte': 'Add account',
      'Modifier un compte': 'Edit account',
      'AJOUTER': 'ADD',
      'MODIFIER': 'EDIT',
      'SUPPRIMER': 'DELETE',
      'Ajouter un véhicule': 'Add a vehicle',
      'Image du véhicule*': 'Vehicle image*',
      'Aperçu de l’image': 'Image preview',
      'Information du véhicule': 'Vehicle information',
      'Identifiant du véhicule*': 'Vehicle ID*',
      'Tarif journalier*': 'Daily rate*',
      'Marque*': 'Brand*',
      'Modèle*': 'Model*',
      'Type*': 'Type*',
      'Statut*': 'Status*',
      'Manuel': 'Manual',
      'Automatique': 'Automatic',
      "Vue d'ensemble": 'Overview',
      'Disponible': 'Available',
      'Révision': 'Maintenance',
      'Loué': 'Rented',
      'Hors d’usage': 'Out of service',
      'Début de location': 'Rental start',
      'Fin de location': 'Rental end',
      'CLIENTS': 'CLIENTS',
      'FILTRE': 'FILTER',
      'Tous': 'All',
      'Transmission': 'Transmission',
      'Les deux': 'Both',
      'RECHERCHER': 'SEARCH',
      'Véhicules disponibles': 'Available vehicles',
      'Durée de la location': 'Rental duration',
      'Jours*': 'Days*',
      'Montant de la location': 'Rental amount',
      'Tarif journalière': 'Daily rate',
      'RESERVER': 'BOOK',
      "Il n'y a plus de véhicule disponible!": 'No vehicles are currently available!',
      'Gestion de la date actuelle': 'Current date simulation',
      'Statut du véhicule': 'Vehicle status',
      'Aucun véhicule loué': 'No rented vehicle',
      'Résumé': 'Summary',
      'Nombre de véhicules dans la flotte': 'Vehicles in fleet',
      'Nombre de véhicules loués': 'Rented vehicles',
      'Rapport': 'Ratio',
      'Citadine': 'City car',
      'Compacte': 'Compact',
      'Berline': 'Sedan',
      'SUV': 'SUV',
      'Démo statique fidèle au TPI 2023': 'Faithful static demo of the 2023 TPI',
      'Structure, couleurs et parcours reconstruits à partir des vues Blade originales. Les actions restent locales à votre navigateur.': 'Structure, colours and flows reconstructed from the original Blade views. All actions stay local to your browser.'
    },
    de: {
      'Reconstruction interactive': 'Interaktive Rekonstruktion',
      'données fictives': 'Demodaten',
      'aucun backend': 'kein Backend',
      'Rôle': 'Rolle',
      'Réinitialiser': 'Zurücksetzen',
      'Gestionnaire': 'Verwalter',
      'Administrateur': 'Administrator',
      'Client': 'Kunde',
      'Connexion': 'Anmeldung',
      'Mot de passe': 'Passwort',
      'Se souvenir de moi': 'Angemeldet bleiben',
      'SE CONNECTER': 'ANMELDEN',
      'Manuel utilisateur': 'Benutzerhandbuch',
      'Déconnexion': 'Abmelden',
      'Création / Modification de comptes': 'Konten erstellen / bearbeiten',
      'Gestion des réservations': 'Reservierungsverwaltung',
      'Gestion de la flotte': 'Flottenverwaltung',
      'Tableau de bord': 'Übersicht',
      'Catégorie': 'Kategorie',
      'Montant des locations': 'Mietumsatz',
      'Informations personnelles': 'Persönliche Informationen',
      'Prénom': 'Vorname',
      'Nom': 'Nachname',
      'Mise à jour du mot de passe': 'Passwort aktualisieren',
      'Utilisez un mot de passe suffisamment robuste.': 'Verwenden Sie ein ausreichend sicheres Passwort.',
      'Nouveau mot de passe*': 'Neues Passwort*',
      'Confirmation*': 'Bestätigung*',
      'METTRE À JOUR': 'AKTUALISIEREN',
      'AJOUTER UN COMPTE': 'KONTO HINZUFÜGEN',
      'Ajouter un compte': 'Konto hinzufügen',
      'Modifier un compte': 'Konto bearbeiten',
      'AJOUTER': 'HINZUFÜGEN',
      'MODIFIER': 'BEARBEITEN',
      'SUPPRIMER': 'LÖSCHEN',
      'Ajouter un véhicule': 'Fahrzeug hinzufügen',
      'Image du véhicule*': 'Fahrzeugbild*',
      'Aperçu de l’image': 'Bildvorschau',
      'Information du véhicule': 'Fahrzeuginformationen',
      'Identifiant du véhicule*': 'Fahrzeug-ID*',
      'Tarif journalier*': 'Tagestarif*',
      'Marque*': 'Marke*',
      'Modèle*': 'Modell*',
      'Type*': 'Typ*',
      'Statut*': 'Status*',
      'Manuel': 'Manuell',
      'Automatique': 'Automatik',
      "Vue d'ensemble": 'Übersicht',
      'Disponible': 'Verfügbar',
      'Révision': 'Wartung',
      'Loué': 'Vermietet',
      'Hors d’usage': 'Ausser Betrieb',
      'Début de location': 'Mietbeginn',
      'Fin de location': 'Mietende',
      'FILTRE': 'FILTER',
      'Tous': 'Alle',
      'Transmission': 'Getriebe',
      'Les deux': 'Beide',
      'RECHERCHER': 'SUCHEN',
      'Véhicules disponibles': 'Verfügbare Fahrzeuge',
      'Durée de la location': 'Mietdauer',
      'Jours*': 'Tage*',
      'Montant de la location': 'Mietbetrag',
      'Tarif journalière': 'Tagestarif',
      'RESERVER': 'RESERVIEREN',
      "Il n'y a plus de véhicule disponible!": 'Es ist kein Fahrzeug mehr verfügbar!',
      'Gestion de la date actuelle': 'Aktuelles Datum simulieren',
      'Statut du véhicule': 'Fahrzeugstatus',
      'Aucun véhicule loué': 'Kein Fahrzeug vermietet',
      'Résumé': 'Zusammenfassung',
      'Nombre de véhicules dans la flotte': 'Fahrzeuge in der Flotte',
      'Nombre de véhicules loués': 'Vermietete Fahrzeuge',
      'Rapport': 'Verhältnis',
      'Citadine': 'Kleinwagen',
      'Compacte': 'Kompaktwagen',
      'Berline': 'Limousine',
      'Démo statique fidèle au TPI 2023': 'Originalgetreue statische Demo des TPI 2023',
      'Structure, couleurs et parcours reconstruits à partir des vues Blade originales. Les actions restent locales à votre navigateur.': 'Struktur, Farben und Abläufe wurden anhand der originalen Blade-Views rekonstruiert. Alle Aktionen bleiben lokal in Ihrem Browser.'
    },
    it: {
      'Reconstruction interactive': 'Ricostruzione interattiva',
      'données fictives': 'dati demo',
      'aucun backend': 'nessun backend',
      'Rôle': 'Ruolo',
      'Réinitialiser': 'Reimposta',
      'Gestionnaire': 'Gestore',
      'Administrateur': 'Amministratore',
      'Client': 'Cliente',
      'Connexion': 'Accesso',
      'Mot de passe': 'Password',
      'Se souvenir de moi': 'Ricordami',
      'SE CONNECTER': 'ACCEDI',
      'Manuel utilisateur': 'Manuale utente',
      'Déconnexion': 'Disconnetti',
      'Création / Modification de comptes': 'Creazione / modifica account',
      'Gestion des réservations': 'Gestione prenotazioni',
      'Gestion de la flotte': 'Gestione flotta',
      'Tableau de bord': 'Dashboard',
      'Catégorie': 'Categoria',
      'Montant des locations': 'Totale noleggi',
      'Informations personnelles': 'Informazioni personali',
      'Prénom': 'Nome',
      'Nom': 'Cognome',
      'Mise à jour du mot de passe': 'Aggiorna password',
      'Utilisez un mot de passe suffisamment robuste.': 'Utilizza una password sufficientemente sicura.',
      'Nouveau mot de passe*': 'Nuova password*',
      'Confirmation*': 'Conferma*',
      'METTRE À JOUR': 'AGGIORNA',
      'AJOUTER UN COMPTE': 'AGGIUNGI ACCOUNT',
      'Ajouter un compte': 'Aggiungi account',
      'Modifier un compte': 'Modifica account',
      'AJOUTER': 'AGGIUNGI',
      'MODIFIER': 'MODIFICA',
      'SUPPRIMER': 'ELIMINA',
      'Ajouter un véhicule': 'Aggiungi veicolo',
      'Image du véhicule*': 'Immagine veicolo*',
      'Aperçu de l’image': 'Anteprima immagine',
      'Information du véhicule': 'Informazioni veicolo',
      'Identifiant du véhicule*': 'ID veicolo*',
      'Tarif journalier*': 'Tariffa giornaliera*',
      'Marque*': 'Marca*',
      'Modèle*': 'Modello*',
      'Type*': 'Tipo*',
      'Statut*': 'Stato*',
      'Manuel': 'Manuale',
      'Automatique': 'Automatico',
      "Vue d'ensemble": 'Panoramica',
      'Disponible': 'Disponibile',
      'Révision': 'Revisione',
      'Loué': 'Noleggiato',
      'Hors d’usage': 'Fuori servizio',
      'Début de location': 'Inizio noleggio',
      'Fin de location': 'Fine noleggio',
      'FILTRE': 'FILTRO',
      'Tous': 'Tutti',
      'Transmission': 'Trasmissione',
      'Les deux': 'Entrambi',
      'RECHERCHER': 'CERCA',
      'Véhicules disponibles': 'Veicoli disponibili',
      'Durée de la location': 'Durata del noleggio',
      'Jours*': 'Giorni*',
      'Montant de la location': 'Importo del noleggio',
      'Tarif journalière': 'Tariffa giornaliera',
      'RESERVER': 'PRENOTA',
      "Il n'y a plus de véhicule disponible!": 'Non ci sono più veicoli disponibili!',
      'Gestion de la date actuelle': 'Simulazione della data corrente',
      'Statut du véhicule': 'Stato del veicolo',
      'Aucun véhicule loué': 'Nessun veicolo noleggiato',
      'Résumé': 'Riepilogo',
      'Nombre de véhicules dans la flotte': 'Veicoli nella flotta',
      'Nombre de véhicules loués': 'Veicoli noleggiati',
      'Rapport': 'Rapporto',
      'Citadine': 'Utilitaria',
      'Compacte': 'Compatta',
      'Berline': 'Berlina',
      'Démo statique fidèle au TPI 2023': 'Demo statica fedele al TPI 2023',
      'Structure, couleurs et parcours reconstruits à partir des vues Blade originales. Les actions restent locales à votre navigateur.': 'Struttura, colori e percorsi ricostruiti dalle viste Blade originali. Tutte le azioni restano locali nel browser.'
    }
  };

  const languageLabels = {
    fr: { login: 'Français', nav: 'FR' },
    en: { login: 'English', nav: 'EN' },
    de: { login: 'Deutsch', nav: 'DE' },
    it: { login: 'Italiano', nav: 'IT' }
  };

  function dict() { return translations[lang] || {}; }

  function translateString(text) {
    if (lang === 'fr') return text;
    const d = dict();
    if (d[text]) return d[text];

    const replacements = [
      ['Date actuelle : ', lang === 'en' ? 'Current date: ' : lang === 'de' ? 'Aktuelles Datum: ' : 'Data corrente: '],
      ['Début de location ', lang === 'en' ? 'Rental start ' : lang === 'de' ? 'Mietbeginn ' : 'Inizio noleggio '],
      ['Fin ', lang === 'en' ? 'End ' : lang === 'de' ? 'Ende ' : 'Fine '],
      ['Rôle : ', lang === 'en' ? 'Role: ' : lang === 'de' ? 'Rolle: ' : 'Ruolo: '],
      ['Le véhicule ', lang === 'en' ? 'Vehicle ' : lang === 'de' ? 'Fahrzeug ' : 'Il veicolo '],
      [' a été supprimé.', lang === 'en' ? ' was deleted.' : lang === 'de' ? ' wurde gelöscht.' : ' è stato eliminato.']
    ];
    let result = text;
    replacements.forEach(([from, to]) => { result = result.replace(from, to); });
    return result;
  }

  function preserveOptionValue(option) {
    if (!option.hasAttribute('value')) option.setAttribute('value', option.textContent.trim());
  }

  function translateDOM(root = document.body) {
    if (translating || lang === 'fr') return;
    translating = true;
    const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
    const nodes = [];
    while (walker.nextNode()) nodes.push(walker.currentNode);
    nodes.forEach(node => {
      const parent = node.parentElement;
      if (!parent || ['SCRIPT', 'STYLE'].includes(parent.tagName)) return;
      const raw = node.nodeValue;
      const trimmed = raw.trim();
      if (!trimmed) return;
      if (parent.tagName === 'OPTION') preserveOptionValue(parent);
      const translated = translateString(trimmed);
      if (translated !== trimmed) node.nodeValue = raw.replace(trimmed, translated);
    });
    translating = false;
  }

  function resetStaticFrench() {
    const set = (selector, value) => { const el = document.querySelector(selector); if (el) el.textContent = value; };
    set('.demo-back', '← Portfolio TPI');
    const note = document.querySelector('.demo-note');
    if (note) note.innerHTML = '<span class="demo-dot"></span><strong>Reconstruction interactive</strong><span>· données fictives · aucun backend</span>';
    const toolbarLabel = document.querySelector('.demo-controls label');
    if (toolbarLabel && toolbarLabel.firstChild) toolbarLabel.firstChild.nodeValue = 'Rôle ';
    set('#resetDemo', 'Réinitialiser');
    set('.login-card h1', 'Connexion');
    const loginLabels = document.querySelectorAll('.login-card label');
    if (loginLabels[0]?.firstChild) loginLabels[0].firstChild.nodeValue = 'Email';
    if (loginLabels[1]?.firstChild) loginLabels[1].firstChild.nodeValue = 'Mot de passe';
    set('.remember span', 'Se souvenir de moi');
    set('.login-actions .glv-primary', 'SE CONNECTER');
    document.querySelectorAll('.manual-button').forEach(el => el.textContent = 'Manuel utilisateur');
    set('#logoutButton', 'Déconnexion');

    const roleTexts = { Gestionnaire: 'Gestionnaire', Administrateur: 'Administrateur', Client: 'Client' };
    document.querySelectorAll('#roleSelect option').forEach(option => { option.textContent = roleTexts[option.value] || option.value; });
  }

  function syncLanguageSelectors() {
    languageSelects.forEach(select => {
      if (!select) return;
      select.value = lang;
    });
  }

  function rerenderApplication() {
    if (typeof window.renderNavigation === 'function') window.renderNavigation();
    if (typeof window.renderPage === 'function' && !document.getElementById('appView')?.hidden) window.renderPage();
  }

  function applyLanguage() {
    localStorage.setItem('glv-demo-lang', lang);
    document.documentElement.lang = lang;
    resetStaticFrench();
    syncLanguageSelectors();
    rerenderApplication();
    if (lang !== 'fr') translateDOM(document.body);
  }

  languageSelects.forEach(select => {
    select.addEventListener('change', event => {
      lang = event.target.value;
      applyLanguage();
    });
  });

  const originalFormatDate = window.formatDate;
  if (typeof originalFormatDate === 'function') {
    window.formatDate = function(value) {
      try { return new Intl.DateTimeFormat(locales[lang] || 'fr-CH').format(new Date(value + 'T12:00:00')); }
      catch { return originalFormatDate(value); }
    };
  }

  const originalNotify = window.notify;
  if (typeof originalNotify === 'function') {
    window.notify = function(message) { originalNotify(translateString(message)); };
  }

  const observer = new MutationObserver(mutations => {
    if (translating || lang === 'fr') return;
    const hasRelevantChange = mutations.some(m => m.type === 'childList' || m.type === 'characterData');
    if (!hasRelevantChange) return;
    requestAnimationFrame(() => translateDOM(document.body));
  });
  observer.observe(document.body, { childList: true, subtree: true, characterData: true });

  applyLanguage();
})();
