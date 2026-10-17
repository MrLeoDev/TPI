const root = document.getElementById('glvRoot');
const loginView = document.getElementById('loginView');
const appView = document.getElementById('appView');
const pageContent = document.getElementById('pageContent');
const navLinks = document.getElementById('navLinks');
const mobileNav = document.getElementById('mobileNav');
const roleSelect = document.getElementById('roleSelect');
const userName = document.getElementById('userName');
const toast = document.getElementById('toast');
const modal = document.getElementById('demoModal');
const modalContent = document.getElementById('modalContent');

const initialData = {
  users: [
    {id:1, first:'Alex', last:'Martin', email:'alex.martin@demo.local', role:'Gestionnaire', spent:0},
    {id:2, first:'Sophie', last:'Bernard', email:'sophie.bernard@demo.local', role:'Administrateur', spent:0},
    {id:3, first:'Lucas', last:'Morel', email:'lucas.morel@demo.local', role:'Client', spent:780},
    {id:4, first:'Emma', last:'Rossi', email:'emma.rossi@demo.local', role:'Client', spent:1240},
    {id:5, first:'Nicolas', last:'Meyer', email:'nicolas.meyer@demo.local', role:'Client', spent:460}
  ],
  cars: [
    {id:'GE-101', brand:'Audi', model:'A3', type:'Berline', transmission:'Automatique', price:95, status:'Disponible', hue:'#9ca3af'},
    {id:'VD-204', brand:'Volkswagen', model:'Golf', type:'Compacte', transmission:'Manuel', price:72, status:'Disponible', hue:'#60a5fa'},
    {id:'GE-318', brand:'BMW', model:'X1', type:'SUV', transmission:'Automatique', price:128, status:'Loué', hue:'#111827'},
    {id:'VD-425', brand:'Peugeot', model:'208', type:'Citadine', transmission:'Manuel', price:64, status:'Révision', hue:'#ef4444'}
  ],
  rentals: [
    {id:1, carId:'GE-318', userId:4, start:'2023-05-15', end:'2023-05-22', amount:896}
  ],
  simulatedDate:'2023-05-18'
};

let state = JSON.parse(localStorage.getItem('glv-demo-state') || 'null') || structuredClone(initialData);
let role = localStorage.getItem('glv-demo-role') || 'Gestionnaire';
let currentPage = 'dashboard';
let toastTimer;

function save(){ localStorage.setItem('glv-demo-state', JSON.stringify(state)); localStorage.setItem('glv-demo-role', role); }
function esc(value){ return String(value).replace(/[&<>'"]/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;',"'":'&#39;','"':'&quot;'}[c])); }
function notify(message){ clearTimeout(toastTimer); toast.textContent = message; toast.classList.add('show'); toastTimer=setTimeout(()=>toast.classList.remove('show'),2300); }
function currentUser(){ return state.users.find(u=>u.role===role) || state.users[0]; }
function formatDate(value){ return new Intl.DateTimeFormat('fr-CH').format(new Date(value+'T12:00:00')); }
function todayRental(carId){ return state.rentals.find(r=>r.carId===carId); }
function amountFor(days, price){ if(days>=30)return days*price*.8; if(days>=7)return days*price*.9; return days*price; }

function carSvg(color='#6b7280'){
  return `<svg viewBox="0 0 520 210" role="img" aria-label="Illustration véhicule"><defs><linearGradient id="g" x1="0" x2="1"><stop stop-color="${color}"/><stop offset="1" stop-color="#111827"/></linearGradient></defs><path d="M78 140c10-37 24-67 49-76 58-21 191-24 256-2 19 7 39 28 56 58l32 8c15 4 27 18 27 33v9H26v-9c0-18 14-33 32-35l20-2z" fill="url(#g)"/><path d="M158 66h194c20 0 36 9 49 28l19 29H107l20-35c7-13 18-22 31-22z" fill="#dbeafe" opacity=".9"/><path d="M250 68v53" stroke="#6b7280" stroke-width="5"/><circle cx="126" cy="167" r="33" fill="#111827"/><circle cx="126" cy="167" r="15" fill="#9ca3af"/><circle cx="405" cy="167" r="33" fill="#111827"/><circle cx="405" cy="167" r="15" fill="#9ca3af"/><rect x="67" y="135" width="35" height="9" rx="4" fill="#fee2e2"/><rect x="442" y="135" width="35" height="9" rx="4" fill="#fef3c7"/></svg>`;
}

const pageNames = {
  accounts:'Création / Modification de comptes',
  reservations:'Gestion des réservations',
  fleet:'Gestion de la flotte',
  dashboard:'Tableau de bord'
};

function pagesForRole(){
  if(role==='Client') return ['accounts','reservations'];
  if(role==='Administrateur') return ['accounts','fleet','dashboard'];
  return ['accounts','reservations','fleet','dashboard'];
}

function renderNavigation(){
  const user=currentUser(); userName.textContent=`${user.first} ${user.last}`;
  const pages=pagesForRole();
  if(!pages.includes(currentPage)) currentPage=pages[0];
  const markup=pages.map(p=>`<button class="nav-link ${currentPage===p?'active':''}" type="button" data-page="${p}">${pageNames[p]}</button>`).join('');
  navLinks.innerHTML=markup; mobileNav.innerHTML=markup;
  document.querySelectorAll('[data-page]').forEach(btn=>btn.onclick=()=>{currentPage=btn.dataset.page; renderNavigation(); renderPage(); mobileNav.hidden=true;});
}

function sectionTitle(title, subtitle=''){ return `<div class="title-card"><h1>${title}</h1>${subtitle?`<p>${subtitle}</p>`:''}</div>`; }

function renderAccounts(){
  const me=currentUser();
  const userCards = state.users.map(u=>`<article class="user-card"><small>${esc(u.role)}</small><strong>${esc(u.first)} ${esc(u.last)}</strong>${u.role==='Client'?`<small>Montant des locations</small><div style="color:#ab0800;font-weight:800;font-size:18px">${u.spent.toFixed(2)} CHF</div>`:''}${role==='Administrateur'?`<div class="form-actions"><button class="glv-secondary edit-user" data-id="${u.id}">MODIFIER</button>${u.id!==me.id?`<button class="danger-button delete-user" data-id="${u.id}">SUPPRIMER</button>`:''}</div>`:''}</article>`).join('');
  pageContent.innerHTML=`
    <section class="block"><div class="stats-row" style="grid-template-columns:${role==='Client'?'1fr 1fr':'1fr'}"><div class="stat"><div class="stat-label">Catégorie</div><div class="stat-value">${role}</div></div>${role==='Client'?`<div class="stat"><div class="stat-label">Montant des locations</div><div class="stat-value">${me.spent.toFixed(2)} CHF</div></div>`:''}</div></section>
    ${role!=='Client'?`<section class="block">${role==='Administrateur'?`<div style="display:flex;justify-content:center;margin:14px"><button id="addUserButton" class="glv-primary">AJOUTER UN COMPTE</button></div>`:''}<div class="accounts-scroll">${userCards}</div></section>`:''}
    <section class="block"><div class="profile-card"><section><h2>Informations personnelles</h2>${role==='Administrateur'?`<div class="form-grid"><div class="form-group"><label>Prénom*</label><input id="profileFirst" value="${esc(me.first)}"></div><div class="form-group"><label>Nom*</label><input id="profileLast" value="${esc(me.last)}"></div><div class="form-group" style="grid-column:1/-1"><label>Email*</label><input id="profileEmail" type="email" value="${esc(me.email)}"></div></div><div class="form-actions"><button id="updateProfile" class="glv-primary">METTRE À JOUR</button></div>`:`<p>Prénom</p><div class="stat-value">${esc(me.first)}</div><p>Nom</p><div class="stat-value">${esc(me.last)}</div><p>Email</p><div class="stat-value" style="font-size:22px">${esc(me.email)}</div>`}</section><div class="vertical-divider"></div><section><h2>Mise à jour du mot de passe</h2><p style="color:#b91c1c">Utilisez un mot de passe suffisamment robuste.</p><div class="form-group"><label>Nouveau mot de passe*</label><input type="password" value="demo-password"></div><div class="form-group" style="margin-top:12px"><label>Confirmation*</label><input type="password" value="demo-password"></div><div class="form-actions"><button class="glv-primary" data-toast="Mot de passe mis à jour — simulation">METTRE À JOUR</button></div></section></div></section>`;

  document.getElementById('addUserButton')?.addEventListener('click', openAddUser);
  document.querySelectorAll('.delete-user').forEach(b=>b.onclick=()=>{state.users=state.users.filter(u=>u.id!==Number(b.dataset.id));save();renderAccounts();notify('Utilisateur supprimé — simulation');});
  document.querySelectorAll('.edit-user').forEach(b=>b.onclick=()=>openEditUser(Number(b.dataset.id)));
  document.getElementById('updateProfile')?.addEventListener('click',()=>{me.first=document.getElementById('profileFirst').value;me.last=document.getElementById('profileLast').value;me.email=document.getElementById('profileEmail').value;save();renderNavigation();notify('Informations mises à jour');});
  bindToastButtons();
}

function openAddUser(){
  modalContent.innerHTML=`<div class="modal-inner"><h2>Ajouter un compte</h2><div class="form-grid"><div class="form-group"><label>Prénom*</label><input id="newFirst"></div><div class="form-group"><label>Nom*</label><input id="newLast"></div><div class="form-group" style="grid-column:1/-1"><label>Email*</label><input id="newEmail" type="email"></div><div class="form-group" style="grid-column:1/-1"><label>Catégorie*</label><select id="newRole" class="field"><option>Client</option><option>Gestionnaire</option><option>Administrateur</option></select></div></div><div class="form-actions"><button id="confirmAddUser" class="glv-primary">AJOUTER</button></div></div>`;
  modal.showModal(); document.getElementById('confirmAddUser').onclick=()=>{const first=document.getElementById('newFirst').value||'Nouveau';const last=document.getElementById('newLast').value||'Utilisateur';state.users.push({id:Date.now(),first,last,email:document.getElementById('newEmail').value||`${first.toLowerCase()}@demo.local`,role:document.getElementById('newRole').value,spent:0});save();modal.close();renderAccounts();notify('Le compte a bien été ajouté.');};
}
function openEditUser(id){const u=state.users.find(x=>x.id===id);modalContent.innerHTML=`<div class="modal-inner"><h2>Modifier un compte</h2><div class="form-grid"><div class="form-group"><label>Prénom</label><input id="editFirst" value="${esc(u.first)}"></div><div class="form-group"><label>Nom</label><input id="editLast" value="${esc(u.last)}"></div><div class="form-group" style="grid-column:1/-1"><label>Email</label><input id="editEmail" value="${esc(u.email)}"></div></div><div class="form-actions"><button id="confirmEditUser" class="glv-primary">METTRE À JOUR</button></div></div>`;modal.showModal();document.getElementById('confirmEditUser').onclick=()=>{u.first=document.getElementById('editFirst').value;u.last=document.getElementById('editLast').value;u.email=document.getElementById('editEmail').value;save();modal.close();renderAccounts();notify('Compte mis à jour');};}

function carCard(car, editable=true){
  const rental=todayRental(car.id); const rentedUser=rental?state.users.find(u=>u.id===rental.userId):null;
  return `<article class="car-card"><div class="car-visual">${carSvg(car.hue)}<span class="car-id">${esc(car.id)}</span></div><div class="car-body"><div class="car-meta"><span>${esc(car.brand)}</span><span>${esc(car.model)}</span></div><div class="car-meta"><span>${esc(car.type)}</span><span>${car.price} CHF/j</span></div><div class="divider"></div><div class="form-group"><label>Statut*</label><select class="status-select car-status" data-id="${esc(car.id)}" ${(!editable||car.status==='Loué'||car.status==='Hors d’usage')?'disabled':''}><option ${car.status==='Disponible'?'selected':''}>Disponible</option><option ${car.status==='Révision'?'selected':''}>Révision</option>${car.status==='Loué'?'<option selected>Loué</option>':''}<option ${car.status==='Hors d’usage'?'selected':''}>Hors d’usage</option></select></div>${rentedUser?`<div class="divider"></div><div style="text-align:center"><strong style="color:#ab0800">${esc(rentedUser.first)} ${esc(rentedUser.last)}</strong><br><small>Début de location ${formatDate(rental.start)} · Fin ${formatDate(rental.end)}</small></div>`:''}${car.status==='Hors d’usage'&&editable?`<div class="form-actions"><button class="danger-button delete-car" data-id="${esc(car.id)}">SUPPRIMER</button></div>`:''}</div></article>`;
}

function renderFleet(){
  const editable=role==='Gestionnaire';
  pageContent.innerHTML=`${editable?`<section class="block">${sectionTitle('Ajouter un véhicule')}<div class="panel fleet-add"><div class="upload-pane"><h2 style="text-align:center">Image du véhicule*</h2><div class="upload-preview" id="uploadPreview">Aperçu de l’image</div><input id="fakeUpload" type="file" accept="image/*"></div><div class="info-pane"><h2 style="text-align:center">Information du véhicule</h2><div class="form-grid"><div class="form-group"><label>Identifiant du véhicule*</label><input id="carId"></div><div class="form-group"><label>Tarif journalier*</label><input id="carPrice" type="number" min="1"></div><div class="form-group"><label>Marque*</label><input id="carBrand"></div><div class="form-group"><label>Modèle*</label><input id="carModel"></div><div class="form-group"><label>Type*</label><select id="carType" class="field"><option>Citadine</option><option>Compacte</option><option>Berline</option><option>SUV</option></select></div><div class="form-group"><label>Statut*</label><select id="carStatus" class="field"><option>Disponible</option><option>Révision</option><option>Hors d’usage</option></select></div></div><div style="display:flex;gap:18px;margin-top:14px"><label><input name="trans" type="radio" value="Manuel" checked> Manuel</label><label><input name="trans" type="radio" value="Automatique"> Automatique</label></div><div class="form-actions"><button id="addCar" class="glv-primary">AJOUTER</button></div></div></div></section>`:''}
  <section class="block">${sectionTitle("Vue d'ensemble")}<div class="cards-grid">${state.cars.map(c=>carCard(c,editable)).join('')}</div></section>`;
  document.getElementById('addCar')?.addEventListener('click',()=>{const id=document.getElementById('carId').value.trim()||`DEMO-${Math.floor(Math.random()*900+100)}`;if(state.cars.some(c=>c.id===id)){notify('Identifiant déjà utilisé');return;}state.cars.push({id,brand:document.getElementById('carBrand').value||'Demo',model:document.getElementById('carModel').value||'Car',type:document.getElementById('carType').value,transmission:document.querySelector('input[name=trans]:checked').value,price:Number(document.getElementById('carPrice').value)||80,status:document.getElementById('carStatus').value,hue:'#7c3aed'});save();renderFleet();notify('Le véhicule a bien été ajouté.');});
  document.getElementById('fakeUpload')?.addEventListener('change',e=>{const f=e.target.files[0];if(!f)return;const r=new FileReader();r.onload=()=>{document.getElementById('uploadPreview').innerHTML=`<img src="${r.result}" alt="Aperçu" style="width:100%;height:100%;object-fit:cover;border-radius:10px">`;};r.readAsDataURL(f);});
  document.querySelectorAll('.car-status').forEach(s=>s.onchange=()=>{const c=state.cars.find(x=>x.id===s.dataset.id);c.status=s.value;save();renderFleet();notify('Statut mis à jour!');});
  document.querySelectorAll('.delete-car').forEach(b=>b.onclick=()=>{state.cars=state.cars.filter(c=>c.id!==b.dataset.id);save();renderFleet();notify(`Le véhicule ${b.dataset.id} a été supprimé.`);});
}

function renderReservations(){
  const available=state.cars.filter(c=>c.status==='Disponible'); const clients=state.users.filter(u=>u.role==='Client');
  const clientSelector=role==='Gestionnaire'?`<div class="side-card"><h3>CLIENTS</h3><select id="selectedClient" class="field">${clients.map(c=>`<option value="${c.id}">${esc(c.first)} ${esc(c.last)}</option>`).join('')}</select></div>`:'';
  pageContent.innerHTML=`<div class="sidebar-layout"><aside class="sidebar">${clientSelector}<div class="side-card"><h3>FILTRE</h3><div class="form-group"><label>Type</label><select id="filterType" class="field"><option>Tous</option><option>Citadine</option><option>Compacte</option><option>Berline</option><option>SUV</option></select></div><div class="form-group" style="margin-top:10px"><label>Transmission</label><select id="filterTransmission" class="field"><option>Les deux</option><option>Manuel</option><option>Automatique</option></select></div><div class="form-actions" style="justify-content:center"><button id="applyFilter" class="glv-primary">RECHERCHER</button></div></div></aside><section><div id="availableTitle">${sectionTitle('Véhicules disponibles')}</div><div id="reservationList" style="display:flex;flex-direction:column;gap:18px"></div></section></div>`;
  const list=document.getElementById('reservationList');
  function draw(){const type=document.getElementById('filterType').value,trans=document.getElementById('filterTransmission').value;const cars=available.filter(c=>(type==='Tous'||c.type===type)&&(trans==='Les deux'||c.transmission===trans));list.innerHTML=cars.length?cars.map((car,i)=>`<article class="reservation-card"><div class="reservation-info"><div class="car-visual" style="height:155px;border-radius:12px">${carSvg(car.hue)}</div><h3>${esc(car.brand)} ${esc(car.model)}</h3><p>${esc(car.type)} · ${esc(car.transmission)}</p></div><div class="vertical-divider"></div><div><div class="form-group"><label>Durée de la location</label><div style="display:flex;align-items:center;gap:8px"><input class="duration-input" data-id="${esc(car.id)}" type="number" min="1" value="1" style="width:90px"> <span>Jours*</span></div></div><p style="text-align:center">Montant de la location</p><h3 class="amount-output" data-id="${esc(car.id)}" style="text-align:center">${car.price.toFixed(2)} CHF</h3><p style="text-align:center">Tarif journalière</p><h3 style="text-align:center">${car.price.toFixed(2)} CHF</h3><div class="form-actions" style="justify-content:center"><button class="glv-primary reserve-car" data-id="${esc(car.id)}">RESERVER</button></div></div></article>`).join(''):`<div class="panel empty-state">Il n'y a plus de véhicule disponible!</div>`;
    document.querySelectorAll('.duration-input').forEach(inp=>inp.oninput=()=>{const c=state.cars.find(x=>x.id===inp.dataset.id);const days=Math.max(1,Number(inp.value)||1);document.querySelector(`.amount-output[data-id="${CSS.escape(inp.dataset.id)}"]`).textContent=`${amountFor(days,c.price).toFixed(2)} CHF`;});
    document.querySelectorAll('.reserve-car').forEach(btn=>btn.onclick=()=>bookCar(btn.dataset.id));
  }
  document.getElementById('applyFilter').onclick=draw; draw();
}

function bookCar(carId){const car=state.cars.find(c=>c.id===carId);const duration=Number(document.querySelector(`.duration-input[data-id="${CSS.escape(carId)}"]`)?.value)||1;let client;if(role==='Gestionnaire')client=state.users.find(u=>u.id===Number(document.getElementById('selectedClient').value));else client=currentUser();const start=state.simulatedDate;const endDate=new Date(start+'T12:00:00');endDate.setDate(endDate.getDate()+duration);const end=endDate.toISOString().slice(0,10);const amount=amountFor(duration,car.price);state.rentals.push({id:Date.now(),carId,userId:client.id,start,end,amount});car.status='Loué';client.spent+=amount;save();renderReservations();notify('Réservation faite!');}

function renderDashboard(){
  const rented=state.cars.filter(c=>c.status==='Loué');const ratio=state.cars.length?Math.round(rented.length/state.cars.length*100):0;
  pageContent.innerHTML=`<section class="block"><div class="date-card"><h2>Gestion de la date actuelle</h2><input id="currentDate" type="date" value="${state.simulatedDate}"><h2>Date actuelle : ${formatDate(state.simulatedDate)}</h2></div><div class="dashboard-cards">${rented.length?rented.map(c=>{const r=todayRental(c.id);const u=state.users.find(x=>x.id===r.userId);const expired=new Date(state.simulatedDate)>new Date(r.end);return `<article class="rental-card ${expired?'expired':''}"><div class="car-visual">${carSvg(c.hue)}<span class="car-id">${esc(c.id)}</span></div><div class="rental-body"><div class="car-meta"><span>${esc(c.brand)}</span><span>${esc(c.model)}</span></div><div class="divider"></div><div style="display:grid;grid-template-columns:1fr 1px 1fr;gap:14px"><div><label>Statut du véhicule</label><select class="status-select end-rental" data-id="${esc(c.id)}" ${expired?'':'disabled'}><option selected>Loué</option><option>Disponible</option><option>Révision</option><option>Hors d’usage</option></select></div><div style="background:#ab0800"></div><div style="text-align:center"><strong style="color:#ab0800">${esc(u.first)} ${esc(u.last)}</strong><p>Fin de location</p><strong>${formatDate(r.end)}</strong></div></div></div></article>`}).join(''):`<div class="panel empty-state">Aucun véhicule loué</div>`}</div></section><section class="block" style="margin-top:28px">${sectionTitle('Résumé')}<div class="stats-row"><div class="stat"><div class="stat-label">Nombre de véhicules dans la flotte</div><div class="stat-value">${state.cars.length}</div></div><div class="stat"><div class="stat-label">Nombre de véhicules loués</div><div class="stat-value">${rented.length}</div></div><div class="stat"><div class="stat-label">Rapport</div><div class="stat-value">${ratio} %</div></div></div></section>`;
  document.getElementById('currentDate').onchange=e=>{state.simulatedDate=e.target.value;save();renderDashboard();};
  document.querySelectorAll('.end-rental').forEach(sel=>sel.onchange=()=>{const car=state.cars.find(c=>c.id===sel.dataset.id);car.status=sel.value;state.rentals=state.rentals.filter(r=>r.carId!==sel.dataset.id);save();renderDashboard();notify('Statut mis à jour!');});
}

function renderPage(){if(currentPage==='accounts')renderAccounts();else if(currentPage==='fleet')renderFleet();else if(currentPage==='reservations')renderReservations();else renderDashboard();}
function enterApp(){role=roleSelect.value;save();loginView.hidden=true;appView.hidden=false;currentPage=role==='Client'?'reservations':role==='Administrateur'?'accounts':'dashboard';renderNavigation();renderPage();}
function logout(){appView.hidden=true;loginView.hidden=false;document.getElementById('userDropdown').hidden=true;notify('Déconnecté de la démonstration');}
function bindToastButtons(){document.querySelectorAll('[data-toast]').forEach(b=>b.onclick=()=>notify(b.dataset.toast));}

document.getElementById('loginForm').addEventListener('submit',e=>{e.preventDefault();enterApp();});
roleSelect.value=role;roleSelect.addEventListener('change',()=>{role=roleSelect.value;save();if(!appView.hidden){renderNavigation();renderPage();}document.getElementById('loginEmail').value=`${role.toLowerCase()}.demo@tpi.local`;notify(`Rôle : ${role}`);});
document.getElementById('themeToggle').onclick=()=>{root.classList.toggle('dark');root.classList.toggle('light');document.getElementById('themeToggle').textContent=root.classList.contains('dark')?'☀︎':'☾';};
document.getElementById('resetDemo').onclick=()=>{state=structuredClone(initialData);save();currentPage='dashboard';renderNavigation();if(!appView.hidden)renderPage();notify('Données de démonstration réinitialisées');};
document.getElementById('userMenuButton').onclick=()=>{const d=document.getElementById('userDropdown');d.hidden=!d.hidden;};
document.getElementById('logoutButton').onclick=logout;
document.getElementById('mobileMenuButton').onclick=()=>{mobileNav.hidden=!mobileNav.hidden;};
document.querySelectorAll('.manual-button').forEach(b=>b.onclick=()=>notify(b.dataset.toast));
modal.addEventListener('click',e=>{if(e.target===modal)modal.close();});

const fidelity=document.createElement('div');fidelity.className='demo-fidelity';fidelity.innerHTML='<strong>Démo statique fidèle au TPI 2023</strong><br>Structure, couleurs et parcours reconstruits à partir des vues Blade originales. Les actions restent locales à votre navigateur.';document.body.appendChild(fidelity);
