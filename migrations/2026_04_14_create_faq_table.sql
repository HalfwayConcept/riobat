-- Migration: create FAQ table
-- Date: 2026-04-14

CREATE TABLE IF NOT EXISTS faq (
    faq_id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(500) NOT NULL,
    reponse TEXT NOT NULL,
    ordre INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Initial FAQ entries
INSERT INTO faq (question, reponse, ordre, is_active) VALUES
(
    'Qu''est-ce qu''une DO (Dommage Ouvrage) ?',
    'L''assurance Dommage Ouvrage (DO) est une assurance obligatoire pour tout maître d''ouvrage (particulier, entreprise, promoteur) qui fait réaliser des travaux de construction. Elle est prévue par l''article L.242-1 du Code des assurances.\n\nElle permet d''être indemnisé rapidement en cas de sinistre lié à la construction, sans attendre qu''un tribunal détermine les responsabilités. Elle couvre les dommages qui compromettent la solidité de l''ouvrage ou le rendent impropre à sa destination, pendant 10 ans après la réception des travaux.\n\nConcrètement, si vous faites construire une maison, un bâtiment ou réalisez des travaux importants, la DO vous protège en cas de malfaçon grave.',
    1,
    1
),
(
    'Comment créer ma première demande de Dommage Ouvrage ?',
    'Pour créer votre première demande de DO, suivez ces étapes :\n\n1. **Créez un compte** en cliquant sur \"Inscription / connexion\" puis \"Créer un compte\".\n2. **Connectez-vous** avec vos identifiants.\n3. **Cliquez sur \"Dommage Ouvrage\"** dans le menu principal ou sur le bouton \"Obtenir une assurance Dommage ouvrage\" sur la page d''accueil.\n4. **Remplissez le formulaire étape par étape** :\n   - **Étape 1** : Coordonnées du souscripteur\n   - **Étape 2** : Informations sur le maître d''ouvrage\n   - **Étape 3** : Nature de l''opération de construction\n   - **Étape 4** : Situation du bien et travaux annexes\n   - **Étape 5** : Maîtrise d''œuvre et garanties\n5. **Validez votre demande** à la dernière étape.\n\nVous pouvez sauvegarder et reprendre votre saisie à tout moment depuis votre tableau de bord.',
    2,
    1
),
(
    'Ma DO a été validée, comment transmettre mes documents RCD ?',
    'Une fois votre Dommage Ouvrage validée, vous devez fournir les documents RCD (Relevé de Compte de Dépenses) pour chaque lot de travaux. Voici comment :\n\n1. **Accédez à votre tableau de bord** (\"Mes dommages ouvrages\").\n2. **Cliquez sur votre dossier DO** concerné.\n3. **Rendez-vous dans la section RCD** pour voir la liste des lots attendus.\n4. **Uploadez vos documents** au format PDF pour chaque lot.\n\nVous pouvez aussi recevoir un **lien d''upload par email** de la part de votre gestionnaire, qui vous permet de déposer vos documents directement sans vous connecter.\n\nSi un lot est manquant, vous recevrez une relance par email.',
    3,
    1
),
(
    'Quels sont mes droits RGPD en tant qu''utilisateur ?',
    'Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez des droits suivants :\n\n- **Droit d''accès** : vous pouvez demander quelles données personnelles sont détenues à votre sujet.\n- **Droit de rectification** : vous pouvez faire corriger des données inexactes.\n- **Droit de suppression** : vous pouvez demander l''effacement de vos données (sous réserve des obligations légales de conservation).\n- **Droit de portabilité** : vous pouvez récupérer vos données dans un format structuré.\n- **Droit de limitation** : vous pouvez demander la restriction du traitement.\n- **Droit d''opposition** : vous pouvez vous opposer au traitement de vos données.\n\nPour exercer ces droits, adressez votre demande :\n- **Par courrier** : 5 bd, rue Soubeyran - 48000 MENDE\n- **Par email** : cabinetcotton@outlook.fr\n\nVos demandes seront traitées dans un délai maximum d''un mois.',
    4,
    1
),
(
    'J''ai reçu un email pour un document manquant, que dois-je faire ?',
    'Si vous avez reçu un email vous informant d''un document manquant, cela signifie qu''un ou plusieurs documents RCD n''ont pas encore été déposés pour votre dossier DO.\n\n**Que faire :**\n1. **Cliquez sur le lien** présent dans l''email. Il vous redirige directement vers la page de dépôt de documents.\n2. **Sélectionnez le fichier** correspondant au lot indiqué (format PDF recommandé).\n3. **Validez l''envoi.**\n\nCe lien est **sécurisé et temporaire** (valable 7 jours). Si le lien a expiré, connectez-vous à votre espace personnel ou contactez votre gestionnaire pour en obtenir un nouveau.\n\n**Important** : tant que tous les documents ne sont pas fournis, le traitement de votre dossier ne peut pas aboutir.',
    5,
    1
);
