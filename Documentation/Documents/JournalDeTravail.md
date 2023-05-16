# Journal de bord : TPI - Gestion de location de voitures

![image journal de bord](Images/Banner_TPI.png)

## S1 : Lundi 01 Mai 2023

### Étape du projet
Début du projet

### Objectifs
Comprendre l'énoncé du TPI, faire le planning initial, créer le repository sur github, faire l'arborescence du projet, Initier le projet, faire le Kanban sur le repository et faire le maquettage.

### Déroulement de la journée
> 8h00 - 9h30  
>
J'ai pris connaissance de l'énoncé du TPI. J'ai créé la planification initiale via Canva.  
J'ai fait le repository sur github, mais pour l'instant il y a uniquement le README.md du projet. J'ai mis en place une arborescence pour la documentation pour mieux m'y retrouver.  
Je commence le Kanban sur Github.

> 11h35  
>
Je continue sur la réalisation du Kanban sur git. J'ai eu mon premier appel avec Kappel, j'ai eu l'occasion de poser les questions importantes.  
Je comprends mieux de ce qu'il doit être fait.  

> 15h45  
>
J'ai enfin terminé le kanban. Le repos a bien été lié au projet en local. Le projet a été initié, les dépendances sont installées, stack installé, nettoyage des fichiers inutiles, la clé a été générée, lien symbolique fait et des commis qui font référence aux issues du projet.

> 17h50
>
J'ai bien démarré sur la maquette :  
- Login terminer
- Création / Modification de comptes terminer

J'ai pu déjà réfléchir pour la base de données.  
Je mets au propre mon journal de travail.

### Bilan de la journée
Je vois ce que je dois faire, j'ai bien avancé, mais j'aurais bien voulu terminer la maquette aujourd'hui. 

## S1 : Mardi 02 Mai 2023

### Étape du projet
Maquette et Modèle de données

### Objectifs
Terminer la maquette, le modèle de données et commencer la documentation.

### Déroulement de la journée
>  8h50
>
Je me lance sur la finalisation de la maquette.
Je remarque qu'il y a pas mal d'information à montrer comme les vues de chaque rôle,
les sections et la version "sombre" du site.

>  12h00
>
J'effectue encore la maquette :
- Gestion de la flotte : Fait
Cela prend du temps, car je réfléchis à comment faire au plus simple pour le "responsive".

Petit appel avec Kappel, pour une question sur le nom d'une section.

>  16h00
>
J'ai enfin terminé la maquette dans son ensemble avec toutes les vues et le mode sombre du site.  
  
J'ai eu mon premier rendez-vous avec l'expert TPI.  
La discussion a été super, cela m'a permis de déstresser et de mieux comprendre sur les objectifs à réaliser.

Maintenant, j'attaque le début de la documentation technique pour effectuer sa structure et je finalise le modèle de données.

>  19h00
>

J'ai terminé toute la structure du manuel technique ! Maintenant, je peux la maintenir durant ma réalisation. J'ai presque terminé le modèle de données.

### Bilan de la journée
J'ai bien avancé même si l'objectif était de terminer le modèle de données, je l'ai compensé sur le temps que j'aurais passé sur la structure de la documentation du projet.  
Demain, je termine le modèle et je peux commencer la réalisation avec l'écriture des tests.  

## S1 : Mercredi 03 Mai 2023

### Étape du projet
Fin du modèle de données, Début de la réalisation / Tests

### Objectifs
Finir le modèle, faire le "layout" du projet, faire les modèles et les fichiers de migration, s'assurer des tests de connexion et mettre en place la fonctionnalité : multilingue.

### Déroulement de la journée
>  8h50
>  
Je me lance sur la finalité du modèle. J'ai hâte de commencer la réalisation.

>  10h45
> 
J'ai terminé le modèle, j'ai mis à jour mon Kanban et mon repos ainsi que la maquette.  
Je me suis lancé sur la réalisation, je fais les modèles et les tables à créer au moment d'une migration.  
La table "users" et son modèle ont déjà été créés, mais avec le minimum d'information donc j'ai dû rectifier le modèle.  
La table "langues" et le modèle sont terminés.

>  11h11
> 
Tout a été fait concernant les modèles et les tables par contre j'ai une erreur de syntaxe sur "Hors d'usage".  
Au lieu de passer du temps pour contourner l'erreur, j'ai simplement mis des tires bas sur les espaces.  

>  14h20
> 
Je m'assure des "layouts", je vérifie du fonctionnement du "login", car il y a eu pas mal de modifications dans le projet.  
Les tests, concernant le "login", fonctionnent.
Début des modifications et création des layeurs importants.

>  14h40 - 14h55
>  
Bon, il y a eu un test d’incendie pour s'assurer que l'entreprise s'évacue correctement.  
Mon élan a été arrêté, on s'y remet.

>  15h40
>  
J'ai dû modifier la direction d'une connexion de réussite pour qu'il passe sur la page "creation_modification_comptes".  
Pour ce faire, il a fallu aller dans le "RouteServiceProvider" et modifier la valeur de la constante HOME.  
J'ai effectué des changements sur l'emplacement sur certains fichiers pour mieux respecter l'arborescence du dossier "views".  
J'ai effectué une mise à jour de NPM et Composer.
J'ai fait un petit logo gratuitement, mais il a gardé l'arrière-plan blanc. J'ai utilisé le site "remove.bg" pour m'en débarrasser.
Puis le site "favicon.io" pour transformer mon logo en favicon.ico.

>  17h40
>  
La page "Login" est terminée avec son mode sombre!  
Le "layout" Guest est bien adapté.
Maintenant je m'attaque à la navigation-bar

>  18h40
>  
J'ai eu un léger souci sur la navbar, car le nom et le prénom de l'utilisateur ne s'affichaient pas.
Mais j'ai pu la terminer et tous les layeurs sont terminés pour correspondre au mieux à la maquette avec un peu de modernisation sur le design.
Avec aussi le mode sombre et le responsive mobile.
Je me connecte parfaitement donc demain, je peux faire enfin le plus gros, c'est-à-dire les sections.

### Bilan de la journée
Je suis assez content de moi sur l'avancement du projet.

## S1 : Jeudi 04 Mai 2023

### Étape du projet
Démarrage des sections

### Objectifs
Finir le plus de sections possible, avec les fichiers de test, les fichiers de traduction,
les fonctionnalités, etc..

### Déroulement de la journée
>  8h00
>  
Je démarre à faire des blocs de section pour mieux répartir les fonctionnalités de la page.

>  10h30
> 
J'ai énormément eu de problème sur la réalisation du carrousel, que j'ai décidé de le remplacer par un système d'overflow.
Cela me permet d'éviter de surcharger de condition mon bloc de résumer et de le rendre le plus accessible pour un utilisateur.
Les fonctionnalités de l'administrateur, a été compliquées sur le plan de la modification, car j'ai dû passer par de l’AJAX pour afficher les informations sans recharger la page complète dans le modal de modification...

>  13h00
> 
J'ai pu mettre en place les fonctionnalités, j'ai eu une erreur sur la gestion des routes concernant les middlewares, cela m'a fait perdre du temps sur la réalisation de la page 
"Création/Modification de comptes."
Les fichiers tests et langues sont faits avec l'option mode sombre ainsi que la résponsivité.

>  14h30
> 
Je me suis lancé sur la réalisation de la page "Gestion de la flotte", ma première crainte est sur la création de deux tags avec système de sélection. J'ai pataugé un peu, mais j'ai rapidement trouvé la solution qu'est le système de Datalist. Par le contrôleur, je peux vérifier son existence et sinon je la crée puis je renvoie l'information par l'index qui permet a la vue Blade de boucler sur les tags existant dans la balise "datalist".


>  16h40
>  
J'ai eu des problèmes sur l'upload de l'image avec la prévisualisation. La résponvité a décidé de m'embêter. J'ai dû retoucher la structure de la table "Vehicule", car il y a eu plusieurs problèmes. La première est que la clé primaire était auto-incrémenter et exclusivement d'un nombre entier, alors que je souhaitais pouvoir la modifier en chaine de caractère et qu'il soit obligatoire et non auto-incrémental. La seconde est le nom du statut : Hors d'usage, les underscores sont pratique un moment, mais par pour le moment de la réalisation. Mais j'ai résolu le problème par l'utilisation d'une cote spécial.

>  18h00
>  
Les fichiers de langues sont faits, aussi je dois faire les tests, mais pour cela je dois 
faire la gestion des réservations pour tester les résultats des véhicules loués. Le résponsive a été faite, le mode sombre aussi.

### Bilan de la journée
Le projet avance. Je ne m'attendais pas à autant d'erreur ou de souci.
Mentalement, ç’a été compliqué, car je souhaite terminer l'application rapidement pour effectuer la documentation, mais je dois me résigner à attendre la semaine prochaine.  
La gestion des réservations me fait un peu peur concernant le faite que le gestionnaire peut réserver un véhicule pour un client et que je dois faire en sorte que le calcul du montant soit fait en temps réels.

## S2 : Lundi 08 Mai 2023

### Étape du projet
Finir les sections.

### Objectifs
Finir les sections et s'assurer de la résponsivité des pages et de l'accessibilité.

### Déroulement de la journée
>  8h00
>  
Je reprends là où je me suis arrêté, c'est-à-dire la quasi-finalité de la page "Gestion de la flotte", mais je dois réaliser la page "Gestion des réservations" pour la finir.

>  10h30
> 
C'était dur de récupérer la durée de location, le tarif ainsi que le label du montant du véhicule concerner. J'ai fait un jQuery de sélection large avec la variable "this" puis j'ai mis des attributs de type "data-" a l'input de la durée pour récupérer le tarif et le numéro de la carte du véhicule concerner. J'ai pu réfléchir sur la réservation du client par le gestionnaire, en utilisant un input fantôme qui récupère de la sélection pour l'intégrer à la "value" de l'input fantôme. Je dois faire un argument non obligatoire pour la réservation et pour la recherche de la page aussi. j'ai encore pas mal de boulot.  
Je mets à jour le Kanban et le repos aussi.

>  14h15
>
La gestion des réservations (GdR) est presque terminée, je retourne sur la gestion de la flotte (GdF).  
Car une fois terminer la page GdR, je peux vérifier que le prénom et le nom du client s'affichent correctement, les dates de locations et que les statuts réagissent correctement. Je dois encore m'amuser avec AJAX et le retour correct des données sur la BDD.

>  18h00
>
J'ai enfin terminé les deux pages, qui ont été long et technique, mais j'y suis parvenu maintenant j'attaque la dernière page qu'est le tableau de bord.

### Bilan de la journée
La journée a été bonne, mais encore une fois, il y a certaines choses, je pense que j'aurais pu être plus rapide.  
Sinon je suis content de voir le bout du projet, du côté "Application".

## S2 : Mardi 09 Mai 2023

### Étape du projet
Finir la page Tableau de bord, intégrer la modification de date pour la démonstration, finir les tests, finir les fichiers LANG.

### Objectifs
Mon but est de ne plus toucher à l'application pour me mettre à 100% sur la documentation.

### Déroulement de la journée
>  8h00
>  
Je termine la page du tableau de bord et encore certaines corrections sur le lien des pages entre les réservations, le résultat du rapport et la gestion de la flotte.

>  10h30
> 
J'ai des erreurs sur l'intégration des données entre la table Location et Véhicule, donc j'essaye de le corriger au plus vite. Mais sinon dans l'ensemble, cela fonctionne, ça réagit comme je le souhaite.

>  14h15
>
Tout est terminé, mais j'ai dû mal à savoir comment je vais intégrer la modification de date,  
car normalement la réservation se fait aux jours même avec une durée donner par le client.  
Je ne compte pas passer par les fichiers de configuration, car je devrais changer ma manière de récupération de la date actuelle et je n'arrive pas à faire en sorte que la donnée soit prioritaire avec Carbon.

>  18h00
>
J'ai enfin terminé, la manière dont j'allais intégrer, je suis passé par une session du nom "currentDate". Une donnée effectue par une demande Ajax en méthode POST. Je l'ai intégré dans la page Tableau de bord puisque c'est là qu'on peut voir la manière dont on peut modifier les locations. Pas mal de condition ternaire pour choisir la session si elle existe sinon on passe par la fonction "now()" de Carbon pour éviter qu'il n'y ait aucune valeur.  

Grâce à cette réussite, j'ai pu finir mon plus gros test sur le tableau de bord pour s'assurer que la modification de statut du véhicule se fasse après la date de fin et aussi qu'elle ne se fasse pas avant. J'ai pu terminer les fichiers LANG donc la traduction s'effectue correctement sur toutes les pages !

### Bilan de la journée
Super content d'avoir terminé l'application, je peux enfin me concentrer sur la documentation et aussi soulage qu'une partie du document est déjà "réaliser", car ayant fait mes tests fonctionnels par PEST passant par Laravel Artisan. J'ai mes petits userstory avec les résultats et un affichage correct est compréhensible. Donc toute une section du document concernant les tests. Demain, je peux me consacrer à la doc sereinement.

## S2 : Mercredi 10 Mai 2023

### Étape du projet
Mettre à jour le repos, le Kanban, s'assurer que le journal de bord est bon, commencer la documentation technique.

### Objectifs
Avoir fini la section TEST sur la documentation technique et que tout soit en ordre entre Kanban, Repos et fichiers.

### Déroulement de la journée
>  8h00
>  
Je m'assure que l'application est bonne une dernière fois avant de mettre à jour le repos et de commit sur les issues terminées.

>  10h00
>  
JJ'ai ajouté au dernier moment la fonction "Update Info personnel" pour l'administrateur, car je n'avais pas compris qu'il pouvait le faire.
Je relis mon journal de bord, pour être que je n'ai rien oublié et je me lance sur la documentation technique.

>  15h30
>  
J'ai pu discuter avec Kappel pour la réalisation de la section Test de la documentation et je suis en cours d'écriture.

>  18h30
>  
J'utilise une extension de vscode pour réaliser des "screens" de mon code, pour les intégrer à ma documentation, j'ai terminé dans la section Test : Couverture, Cadre, Infrastructure et pratiquement les tests fonctionnels. J'ai fractionné pas mal de code, car beaucoup trop gros pour rentrer dans la doc.

### Bilan de la journée
La documentation n'est pas forcement marrant à faire, mais j'avance bien.  
Évidemment, je souhaitais terminer la section de test, mais il y avait pas mal de choses à dire.

## S2 : Jeudi 11 Mai 2023

### Étape du projet
Faire la documentation

### Objectifs
Finir la section Test, la section Gestion de projet et la planification et entamer l'analyse fonctionnelle / organique.

### Déroulement de la journée
>  9h00
>  
Je finalise la section test concernant les tests fonctionnels, le rapport de tests puis le constat.

>  10h30
>  
Toujours en cours de réalisation de la section Test.

>  15h30
>  
J'ai terminé la section "Tests", la section "Gestion de projet" et la section "Planification". 
La section "Analyse fonctionnelle" est presque terminée, je me lance après sur la section " Analyse organique ".

>  18h30
>  
Section "Analyse fonctionnelle" terminée ! J'ai pratiquement terminé la section " Analyse organique ".

### Bilan de la journée
J'ai super bien avancé le manuel technique pour le coup, je suis heureux.

## S3 : Lundi 15 Mai 2023

### Étape du projet
Faire la documentation

### Objectifs
Finir la documentation technique, finir la documentation manuelle avec l'intégration à l'application.

### Déroulement de la journée
>  9h00
>  
Je me lance sur la finalisation de la documentation technique.

>  10h30
>  
Il me reste plus que la conclusion et les annexes à faire. Puis je me lance sur le manuel utilisateur.

>  15h30
>  
Manuel technique fini et le manuel utilisateur. Je me lance sur l'intégration sur l'application avec un bouton fixer en bas à droite de l'application pour accéder au manuel en PDF.

>  18h30
>  
Tout a été fait !  
J'ai effectué entre temps à la correction de mon application, car j'ai vu que j'ai oublié certaines exigences et retiré ce qui était inutile à l'application au final.  
Bien évidemment il me manque la relecture de mes documents pour corriger de probables fautes d'orthographe et de syntaxe.  
S'assurer que tout est bon ainsi qu'un dernier check up sur l'application.
Le dernier document à réaliser est le résumé du rapport du TPI.

### Bilan de la journée
Je suis tellement heureux de voir le bout,  
j'ai encore pas mal de boulot pour demain, mais je le sens bien et je suis super de ce que j'ai produit.

## S3 : Mardi 16 Mai 2023

### Étape du projet
Fin du projet

### Objectifs
Faire et fini le résumé du rapport de TPI, Faire la planification effective l'ajouter à documentation technique, faire l'annexe du code puis préparer les livrables pour le 17 mai.

### Déroulement de la journée
>  9h00
>  
Je me lance sur la réalisation du résumer du TPI.

>  11h00
>  
Résumer terminé, je corriger les fautes d'orthographe. J'ai eu un appel avec Kappel.

>  13h00
>  
Correction du résumer fait, j'ai fait une correction orthographique du journal de bord pour qu'il soit plus lisible.  
Puis je me lance sur la planification  et l'annexe du code.

>  17h00
>  
La planification effective terminée par contre l'annexe du code ça été juste infernal, la sortie du code en PDF vraiment simple, mais quand il s'agit de le mettre dans la documentation technique, c'est un vrai parcours du combattant.
J'essaye de faire convertir mes PDF en word, mais la mise en page, le style, etc. tout diffère par rapport à ma doc donc tout explose.
J'abandonne l'idée je cherche des solutions et je trouve qu'on peut fractionner le PDF et le mettre un à un dans le Word.
MAIS quand je souhaite mettre des niveaux de titre pour s'y retrouver tout saute. Cette manière a fonctionné, mais j'ai dû faire un jeu de saut de ligne pour avoir mes titres.  

### Bilan de la journée
J'ai terminée le TPI, j'ai enfin tout mis. Tout est propre tout est bon. Mon projet n'attend qu'une chose c'est d'être envoyé demain.
Ca été une expériance intense la réalisation de ce TPI et je suis très fier de ce que j'ai produit.
