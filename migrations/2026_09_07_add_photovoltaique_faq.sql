-- Migration: ajout des FAQ sur l'assurance photovoltaïque
-- Date: 2026-09-07

INSERT INTO faq (question, reponse, ordre, is_active) VALUES
(
    'Quelles garanties prévoir pour une installation photovoltaïque ?',
    'Une installation photovoltaïque représente un investissement important et reste exposée à des risques comme l''incendie, la tempête, la grêle, la surtension, le vol, le vandalisme ou la panne d''équipement. Selon les garanties souscrites, l''assurance peut couvrir les panneaux, les onduleurs, les structures de fixation, le câblage et les autres équipements. Elle peut également prévoir une indemnisation de la perte d''exploitation lorsque l''installation ne produit plus à la suite d''un sinistre garanti. La responsabilité civile peut enfin couvrir les dommages causés à des tiers par l''installation ou son exploitation. Les garanties, conditions et plafonds exacts dépendent du contrat.',
    6,
    1
),
(
    'Comment assurer une installation photovoltaïque et quels documents fournir ?',
    'Une installation existante ou neuve peut être étudiée. Pour préparer votre demande, il est utile de fournir les caractéristiques de l''installation, sa puissance, son adresse, sa date de mise en service ou son calendrier prévisionnel, les factures ou devis, les contrats de maintenance, les rapports de contrôle et les mesures de prévention prévues. L''assureur peut également demander des informations sur les équipements, l''entretien et les contrôles réalisés. La liste des justificatifs varie selon la nature et la taille du projet.',
    7,
    1
),
(
    'Que faire en cas de sinistre et quelle différence avec la Dommage Ouvrage ?',
    'En cas de sinistre, sécurisez les lieux sans vous mettre en danger, faites intervenir les services d''urgence si nécessaire et prenez des photographies des dommages. Prévenez rapidement votre assureur ou votre gestionnaire, conservez les équipements endommagés lorsque cela est possible et transmettez les justificatifs demandés. N''engagez pas de réparations importantes avant l''accord de l''assureur, sauf mesure urgente de mise en sécurité.\n\nLa Dommage Ouvrage (DO) concerne les travaux de construction et couvre, pendant 10 ans après la réception, certains dommages graves qui compromettent la solidité de l''ouvrage ou le rendent impropre à son usage. Elle sert principalement à financer rapidement les réparations relevant de la garantie décennale.\n\nL''assurance photovoltaïque concerne la centrale et ses équipements : panneaux, onduleurs, structures et câblage. Selon le contrat, elle peut couvrir les dommages matériels, le vol, les événements climatiques, la perte de production et la responsabilité civile. La DO protège donc l''ouvrage de construction, tandis que l''assurance PV protège l''installation photovoltaïque et son exploitation. Ces deux assurances peuvent être complémentaires.',
    8,
    1
);
