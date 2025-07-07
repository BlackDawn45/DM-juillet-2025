🖥️ Projet IHM Web de Gestion d'Adresses Logiques
BTS CIEL P – Juillet 2025

🎯 Contexte et Objectifs du Projet
Ce projet consiste à concevoir une interface web (IHM) permettant de gérer les adresses logiques (IP) dans une salle informatique (salle i).
Une adresse logique correspond à une adresse IP, tandis que l’adresse physique fait référence à l’adresse MAC de l’équipement connecté.

✅ Fonctionnalités attendues :
🔍 Visualiser en temps réel :

Les adresses IP disponibles (libres).

Les adresses IP attribuées (occupées).

💻 Afficher pour chaque IP attribuée :

L’adresse MAC de la machine cliente.

La durée de détention de l’adresse IP (temps écoulé depuis l’attribution).

📤 Exporter les données :

Possibilité d’exporter la liste des IP libres et/ou attribuées au format YAML.

Les exports doivent inclure : adresse IP, adresse MAC, durée.

🧱 Champs du Projet
Le projet couvre plusieurs domaines de compétences :

Domaine	Éléments abordés
🌐 Réseaux	DHCP, scan réseau
💻 Programmation	Scripts, IHM en PHP/HTML/CSS/JS
🗃️ Base de données	MariaDB pour stocker les adresses et leur état
🔐 Sécurité	Sécurisation de l’accès et des données de l’IHM

🛠️ Environnement Technique
l’IHM Web est développée en PHP/HTML.

🧰 Éléments à mettre en place :
🔧 Serveur DHCP

Doit être accessible en ligne de commande (CLI).

Distribue les adresses IP dans la salle.

🌐 Serveur Web (LAMP)

Apache + PHP

MariaDB comme SGBD

Outils d’administration possibles :

phpMyAdmin

🕵️‍♂️ Scanner réseau

Doit permettre de détecter les machines actives sur le réseau.

Utilisable en CLI ou via API.

📝 Éditeur de texte

Pour développer les pages PHP, HTML, CSS, JS et les scripts.

Exemples : VS Code, Sublime Text, nano, etc.

