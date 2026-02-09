# Migration: Ajout des champs de profil professionnel

## Description
Cette migration ajoute les colonnes manquantes à la table `utilisateur` pour stocker les informations professionnelles :
- `siret` : Numéro SIRET de l'entreprise
- `adresse` : Adresse professionnelle
- `code_postal` : Code postal
- `commune` : Commune
- `profession` : Profession/Métier
- `telephone` : Numéro de téléphone

## Comment appliquer la migration

### Méthode 1 : Via PhpMyAdmin
1. Ouvrir **PhpMyAdmin** : `http://localhost/phpmyadmin`
2. Sélectionner la base de données `ruki5964_riobat`
3. Cliquer sur l'onglet **SQL**
4. Copier-coller le contenu du fichier `migrations/add_user_profile_fields.sql`
5. Cliquer sur **Exécuter**

### Méthode 2 : Via ligne de commande MySQL
```bash
mysql -u ruki5964_riobat -p ruki5964_riobat < migrations/add_user_profile_fields.sql
```

## Fonctionnalités après migration

### Profil utilisateur (`/index.php?page=profil`)
- Les utilisateurs peuvent maintenant remplir leurs informations professionnelles
- Les champs sont optionnels (valeur par défaut : NULL)

### Pré-remplissage automatique (step1)
- Quand un utilisateur connecté accède à `step1`, les coordonnées du souscripteur sont pré-remplies avec ses informations de profil
- Cela évite la double saisie et améliore l'expérience utilisateur

## Fichiers modifiés
- `views/templates/user/profil.view.php` — Ajout des champs dans le formulaire de profil
- `models/user.model.php` — Fonction `update_user_profile()` pour mettre à jour les infos
- `controllers/user.controller.php` — Traitement de la mise à jour du profil
- `controllers/do.controller.php` — Pré-remplissage automatique de step1
