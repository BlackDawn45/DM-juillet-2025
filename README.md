Projet IHM Web de Gestion d'Adresses Logiques (BTS CIEL P – Juillet 2025)
Contexte et Objectifs du Projet
Ce projet consiste à réaliser une interface web (IHM) pour gérer les adresses logiques dans une salle informatique (salle i). Une adresse logique fait référence ici à une adresse IP, tandis que l’adresse physique correspond à l’adresse MAC de l’appareil. L’application doit répondre aux besoins suivants :
Visualiser en temps réel les adresses IP disponibles (libres) ou attribuées (occupées) sur le réseau de la salle.
Afficher pour chaque adresse IP attribuée l’adresse physique (MAC) du client qui l’occupe et la durée de détention de cette adresse (depuis combien de temps elle est louée).
Exporter les données des adresses (libres et/ou attribuées) au format YAML avec les adresses logiques et leurs informations associées.
Le projet couvre plusieurs domaines : les réseaux (DHCP, scanner réseau), la programmation (scripts, IHM web en PHP/HTML/CSS/JS), les bases de données (stockage des informations d’adresses) et la sécurité (configuration sûre du système et de l’IHM). Contraintes techniques :libre de choisir les solutions précises pour chaque composant, mais l’interface web doit être développée en PHP/HTML. On va utiliser les éléments suivants dans votre environnement :
Un serveur DHCP accessible en CLI pour distribuer les adresses IP.
Un serveur web (Apache + MariaDB) avec PHP (et éventuellement phpMyAdmin ou MySQL Workbench pour gérer la base de données facilement).
Un outil de scan réseau (utilisable en ligne de commande ou via API) pour détecter les machines actives sur le réseau.
Un éditeur de texte pour écrire le code des pages web (PHP/HTML/CSS/JS) et des scripts nécessaires.
