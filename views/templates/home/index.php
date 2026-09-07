<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$contact_status = null;
$contact_values = [
    'nom' => '',
    'email' => '',
    'telephone' => '',
    'interet' => '',
    'message' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form'])) {
    $contact_values['nom'] = trim((string)($_POST['nom'] ?? ''));
    $contact_values['email'] = trim((string)($_POST['email'] ?? ''));
    $contact_values['telephone'] = trim((string)($_POST['telephone'] ?? ''));
    $contact_values['interet'] = (string)($_POST['interet'] ?? '');
    $contact_values['message'] = trim((string)($_POST['message'] ?? ''));

    if (!hash_equals($_SESSION['contact_token'] ?? '', (string)($_POST['contact_token'] ?? ''))) {
        $contact_status = ['type' => 'error', 'text' => 'Votre demande a expiré. Veuillez réessayer.'];
    } elseif ($contact_values['nom'] === '' || !filter_var($contact_values['email'], FILTER_VALIDATE_EMAIL) || $contact_values['message'] === '' || !in_array($contact_values['interet'], ['do', 'pv', 'autre'], true) || empty($_POST['rgpd'])) {
        $contact_status = ['type' => 'error', 'text' => 'Veuillez compléter les champs obligatoires et accepter le traitement de vos données.'];
    } elseif (preg_match('/[\r\n]/', $contact_values['email'])) {
        $contact_status = ['type' => 'error', 'text' => 'Adresse email invalide.'];
    } else {
        $subject = 'Demande de renseignement depuis le site';
        $mail_message = "Nom : {$contact_values['nom']}\n"
            . "Email : {$contact_values['email']}\n"
            . "Téléphone : {$contact_values['telephone']}\n\n"
            . "Intérêt : " . ['do' => 'Dommage Ouvrage', 'pv' => 'Photovoltaïque', 'autre' => 'Autre'][$contact_values['interet']] . "\n\n"
            . "Message :\n{$contact_values['message']}";
        $headers = "From: contact@riobat.cc-assur.fr\r\n"
            . "Reply-To: {$contact_values['email']}\r\n"
            . "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail('admin@cc-assur.fr', $subject, $mail_message, $headers)) {
            $contact_status = ['type' => 'success', 'text' => 'Votre message a bien été envoyé. Nous vous répondrons rapidement.'];
            $contact_values = ['nom' => '', 'email' => '', 'telephone' => '', 'interet' => '', 'message' => ''];
        } else {
            $contact_status = ['type' => 'error', 'text' => 'L’envoi du message a échoué. Veuillez réessayer plus tard.'];
        }
    }
}

$_SESSION['contact_token'] = bin2hex(random_bytes(32));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CC Assur — Dommage Ouvrage &amp; Assurance Photovoltaïque</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: .7; }
        }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fade-in-up-delay { animation: fadeInUp 0.8s ease-out 0.3s forwards; opacity: 0; }
        .animate-fade-in-up-delay2 { animation: fadeInUp 0.8s ease-out 0.6s forwards; opacity: 0; }
        .animate-pulse-slow { animation: pulse-slow 3s ease-in-out infinite; }
        footer .grid > p:nth-child(3) { display: none; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-screen-xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="#" class="flex items-center gap-3">
                <img src="img/cc-assur.jpeg" alt="CC Assur" class="h-16 rounded" />
                <span class="text-2xl font-bold text-gray-900">CC <span class="text-blue-600">Assur</span></span>
            </a>
            <nav class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-600">
                <a href="#do" class="hover:text-blue-600 transition-colors">Dommage Ouvrage</a>
                <a href="#pv" class="hover:text-amber-600 transition-colors">Photovoltaïque</a>
                <a href="#parcours" class="hover:text-gray-900 transition-colors">Parcours digital</a>
            </nav>
            <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                04 66 65 79 79
            </div>
        </div>
    </header>

    <!-- Hero -->
    <main class="flex-1">
        <section class="relative overflow-hidden">
            <!-- Background gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800"></div>
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

            <div class="relative max-w-screen-xl mx-auto px-6 py-24 md:py-32 text-center">
                <div class="animate-fade-in-up">
                    <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white text-sm font-medium px-4 py-1.5 rounded-full mb-6">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse-slow"></span>
                        Site en cours de construction
                    </span>
                </div>

                <h1 class="animate-fade-in-up text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                    Votre cabinet d'assurance<br>
                    <span class="text-blue-200">de confiance</span>
                </h1>

                <p class="animate-fade-in-up-delay text-lg md:text-xl text-blue-100 max-w-2xl mx-auto mb-10 leading-relaxed">
                    CC Assur vous accompagne dans la protection de vos projets, avec deux expertises complémentaires :
                    <strong class="text-white">l'assurance Dommage Ouvrage</strong> pour vos chantiers de construction et
                    <strong class="text-amber-300">l'assurance photovoltaïque</strong> pour vos centrales productrices d'énergie.
                </p>

                <div class="animate-fade-in-up-delay2 flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="#do" class="inline-flex items-center justify-center gap-2 bg-white text-blue-700 font-semibold px-8 py-3.5 rounded-lg shadow-lg hover:shadow-xl hover:bg-gray-50 transition-all">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Dommage Ouvrage
                    </a>
                    <a href="#pv" class="inline-flex items-center justify-center gap-2 bg-amber-400 text-amber-950 font-semibold px-8 py-3.5 rounded-lg shadow-lg hover:shadow-xl hover:bg-amber-300 transition-all">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Photovoltaïque
                    </a>
                </div>
            </div>

            <!-- Wave separator -->
            <div class="absolute bottom-0 left-0 right-0">
                <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 50L60 45.7C120 41.3 240 32.7 360 30.8C480 29 600 34 720 41.2C840 48.3 960 57.7 1080 55.8C1200 54 1320 41 1380 34.5L1440 28V100H1380C1320 100 1200 100 1080 100C960 100 840 100 720 100C600 100 480 100 360 100C240 100 120 100 60 100H0V50Z" fill="#F9FAFB"/>
                </svg>
            </div>
        </section>

        <!-- Nos deux activités -->
        <section class="max-w-screen-xl mx-auto px-6 py-16">
            <h2 class="text-center text-3xl font-bold text-gray-900 mb-4">Nos deux domaines d'expertise</h2>
            <p class="text-center text-gray-500 mb-14 max-w-xl mx-auto">Une double activité d'assurance construction, chacune avec des garanties dédiées.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-8 border-t-4 border-blue-600 text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-blue-700 mb-3">Assurance Dommage Ouvrage</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Garantie obligatoire qui protège le maître d'ouvrage et permet une réparation rapide des désordres décennaux affectant la construction.</p>
                </div>

                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-8 border-t-4 border-amber-400 text-center">
                    <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-5">
                        <svg class="w-7 h-7 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-amber-600 mb-3">Assurance Photovoltaïque</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Protégez votre installation, sécurisez votre production et pérennisez vos revenus de producteur d'énergie.</p>
                </div>
            </div>
        </section>

        <!-- Activité Dommage Ouvrage (bleu) -->
        <section id="do" class="bg-blue-50 border-y border-blue-100">
            <div class="max-w-screen-xl mx-auto px-6 py-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <span class="inline-flex items-center gap-2 bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full mb-4">DOMMAGE OUVRAGE</span>
                        <h2 class="text-3xl font-bold text-blue-900 mb-6">Vous recherchez une assurance Dommages Ouvrage ?</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Assurance obligatoire depuis la loi Spinetta du 4 janvier 1978, l'assurance Dommage Ouvrage protège pendant 10 ans
                            le maître d'ouvrage contre les désordres de nature décennale venant affecter l'ouvrage construit.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Son principal avantage est d'indemniser rapidement le propriétaire afin que les réparations puissent commencer
                            sans attendre la résolution des litiges entre les constructeurs, artisans, bureaux d'études ou architectes.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            L'assureur Dommages-Ouvrage se retourne ensuite contre les responsables et leurs assureurs décennaux :
                            les réparations peuvent débuter au plus vite, en toute sérénité.
                        </p>

                        <h3 class="text-lg font-bold text-blue-900 mt-8 mb-3">Une large palette de garanties</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-sm font-medium text-blue-900 bg-white rounded-lg px-4 py-2 border border-blue-100">
                                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Dommages Ouvrage
                            </li>
                            <li class="flex items-center gap-2 text-sm font-medium text-blue-900 bg-white rounded-lg px-4 py-2 border border-blue-100">
                                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Bon Fonctionnement, RCMO, TRC
                            </li>
                            <li class="flex items-center gap-2 text-sm font-medium text-blue-900 bg-white rounded-lg px-4 py-2 border border-blue-100">
                                <svg class="w-4 h-4 text-blue-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Constructeur Non Réalisateur
                            </li>
                        </ul>

                        <a href="https://riobat.cc-assur.fr/index.php?page=step0" class="inline-flex items-center justify-center gap-2 mt-8 bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-blue-800 transition-all">
                            Obtenir une assurance Dommage Ouvrage
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="Plaquette DO.png" download="Plaquette DO.png" class="inline-flex items-center justify-center gap-2 mt-3 text-blue-700 font-semibold hover:text-blue-900 hover:underline transition-colors">
                            Télécharger notre plaquette Dommage Ouvrage
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l4-4m-4 4l-4-4m-5 8h18"/></svg>
                        </a>
                    </div>

                    <div class="bg-white rounded-xl shadow-md border border-blue-100 p-8">
                        <h3 class="text-lg font-bold text-blue-900 mb-5">Pourquoi choisir CC Assur ?</h3>
                        <p class="text-sm text-gray-500 mb-6">Une maîtrise de l'assurance construction</p>
                        <div class="space-y-5">
                            <div class="flex gap-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-sm flex-shrink-0">1</span>
                                <p class="text-sm text-gray-700"><strong class="text-gray-900">Des capacités de placement importantes</strong> : de la maison individuelle au bâtiment industriel, de la rénovation à la construction.</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-sm flex-shrink-0">2</span>
                                <p class="text-sm text-gray-700"><strong class="text-gray-900">Des partenaires de premier ordre.</strong></p>
                            </div>
                            <div class="flex gap-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-sm flex-shrink-0">3</span>
                                <p class="text-sm text-gray-700"><strong class="text-gray-900">Des tarifs très compétitifs</strong> : nous connaissons les assureurs qui pratiquent les tarifs les plus bas sur le marché. Notre offre est, dans plus de 90% des cas, la plus économique.</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-sm flex-shrink-0">4</span>
                                <p class="text-sm text-gray-700"><strong class="text-gray-900">Plateforme digitale</strong> : notre plateforme permet de constituer le dossier en quelques clics, terminés les échanges de mails interminables.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Activité Photovoltaïque (jaune) -->
        <section id="pv" class="bg-amber-50 border-b border-amber-100">
            <div class="max-w-screen-xl mx-auto px-6 py-20">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="order-2 lg:order-1 bg-white rounded-xl shadow-md border border-amber-100 p-8">
                        <h3 class="text-lg font-bold text-amber-700 mb-5">Pourquoi choisir CC Assur ?</h3>
                        <p class="text-sm text-gray-500 mb-6">Une maîtrise de l'assurance photovoltaïque</p>
                        <div class="space-y-5">
                            <div class="flex gap-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-400 text-amber-950 font-bold text-sm flex-shrink-0">1</span>
                                <p class="text-sm text-gray-700"><strong class="text-gray-900">Des garanties spécifiques</strong>, adaptées aux installations photovoltaïques et aux obligations des producteurs d'énergie.</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-400 text-amber-950 font-bold text-sm flex-shrink-0">2</span>
                                <p class="text-sm text-gray-700"><strong class="text-gray-900">Des assureurs spécialisés</strong> et des partenaires de confiance.</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-400 text-amber-950 font-bold text-sm flex-shrink-0">3</span>
                                <p class="text-sm text-gray-700"><strong class="text-gray-900">Des tarifs très compétitifs</strong> : nous connaissons les assureurs qui pratiquent les tarifs les plus bas sur le marché. Notre offre est, dans plus de 90% des cas, la plus économique.</p>
                            </div>
                            <div class="flex gap-4">
                                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-400 text-amber-950 font-bold text-sm flex-shrink-0">4</span>
                                <p class="text-sm text-gray-700"><strong class="text-gray-900">Plateforme digitale</strong> : notre plateforme permet de constituer le dossier en quelques clics, terminés les échanges de mails interminables.</p>
                            </div>
                        </div>
                    </div>

                    <div class="order-1 lg:order-2">
                        <span class="inline-flex items-center gap-2 bg-amber-400 text-amber-950 text-xs font-semibold px-3 py-1 rounded-full mb-4">PHOTOVOLTAÏQUE — PRODUCTEUR D'ÉNERGIE</span>
                        <h2 class="text-3xl font-bold text-amber-800 mb-6">Pourquoi souscrire une assurance photovoltaïque ?</h2>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Vos installations photovoltaïques sont exposées à de nombreux risques pouvant impacter votre production et vos revenus.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Elle couvre les dommages matériels affectant l'installation et son équipement, et indemnise les pertes d'exploitation
                            en cas d'arrêt de production.
                        </p>
                        <p class="text-gray-700 leading-relaxed">
                            Elle vous protège contre les recours de tiers et la responsabilité civile, et vous accompagne pour assurer
                            la continuité de votre activité et la sécurité de votre projet.
                        </p>

                        <h3 class="text-lg font-bold text-amber-800 mt-8 mb-3">Une large palette de garanties</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-sm font-medium text-amber-900 bg-white rounded-lg px-4 py-2 border border-amber-100">
                                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Dommages aux biens &amp; matériels
                            </li>
                            <li class="flex items-center gap-2 text-sm font-medium text-amber-900 bg-white rounded-lg px-4 py-2 border border-amber-100">
                                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Perte d'exploitation
                            </li>
                            <li class="flex items-center gap-2 text-sm font-medium text-amber-900 bg-white rounded-lg px-4 py-2 border border-amber-100">
                                <svg class="w-4 h-4 text-amber-500 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Responsabilité civile
                            </li>
                        </ul>

                        <a href="https://riobat.cc-assur.fr/index.php?page=step0&amp;type_demande=pv" class="inline-flex items-center justify-center gap-2 mt-8 bg-amber-400 text-amber-950 font-semibold px-6 py-3 rounded-lg shadow hover:bg-amber-300 transition-all">
                            Obtenir une assurance Photovoltaïque
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="Plaquette PPV.png" download="Plaquette PPV.png" class="inline-flex items-center justify-center gap-2 mt-3 text-amber-700 font-semibold hover:text-amber-900 hover:underline transition-colors">
                            Télécharger notre plaquette Photovoltaïque
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l4-4m-4 4l-4-4m-5 8h18"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Parcours digital (commun) -->
        <section id="parcours" class="max-w-screen-xl mx-auto px-6 py-20">
            <h2 class="text-center text-3xl font-bold text-gray-900 mb-4">Un process rapide et simplifié</h2>
            <p class="text-center text-gray-500 mb-14 max-w-2xl mx-auto">Le même parcours digital de constitution de dossier, que votre demande concerne le Dommage Ouvrage ou le photovoltaïque.</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Résolument digital</h3>
                    <p class="text-sm text-gray-500">Tout le processus est digitalisé grâce à notre plateforme. Transparence et fluidité sont au rendez-vous.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Constitution rapide du dossier</h3>
                    <p class="text-sm text-gray-500">Vous êtes guidé pas à pas, à votre rythme. Vous déposez les pièces en ligne et nous enregistrons les entreprises et intervenants techniques.</p>
                </div>
                <div class="text-center">
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-2">Suivi en ligne</h3>
                    <p class="text-sm text-gray-500">À tout moment, suivez l'évolution de votre dossier et la conformité des pièces déposées.</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-gray-100 p-8">
                <h3 class="text-center font-bold text-gray-900 mb-8">Un parcours digital de constitution du dossier</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                    <div class="flex items-start gap-4">
                        <span class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-600 text-white font-bold flex-shrink-0">1</span>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Création du compte</h4>
                            <p class="text-sm text-gray-500">Accès sécurisé et personnalisé à notre plateforme.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-600 text-white font-bold flex-shrink-0">2</span>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Saisie &amp; dépôt des pièces</h4>
                            <p class="text-sm text-gray-500">Remplissez le formulaire et déposez vos pièces justificatives en quelques clics.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <span class="flex items-center justify-center w-9 h-9 rounded-full bg-blue-600 text-white font-bold flex-shrink-0">3</span>
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-1">Analyse &amp; tarification</h4>
                            <p class="text-sm text-gray-500">Nos experts analysent votre dossier et vous proposent la meilleure offre du marché.</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center text-sm border-t border-gray-100 pt-6">
                    <div class="flex items-center gap-2 text-gray-600"><svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Gain de temps</div>
                    <div class="flex items-center gap-2 text-gray-600"><svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Simplicité</div>
                    <div class="flex items-center gap-2 text-gray-600"><svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> Transparence</div>
                    <div class="flex items-center gap-2 text-gray-600"><svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Disponibilité 24/7</div>
                </div>
                <p class="text-center text-sm text-gray-500 mt-6">
                    Créez votre compte particulier, collectivité ou entreprise sur
                    <a href="https://cc-assur.fr" class="text-blue-600 font-medium hover:underline">cc-assur.fr</a>
                </p>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="bg-white border-y border-gray-200">
            <div class="max-w-3xl mx-auto px-6 py-20">
                <div class="text-center mb-10">
                    <span class="inline-flex items-center gap-2 bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full mb-4">CONTACT</span>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Besoin d'un renseignement classique ?</h2>
                    <p class="text-gray-500">Envoyez-nous votre demande, notre équipe vous répondra dans les meilleurs délais.</p>
                </div>

                <?php if ($contact_status): ?>
                    <div class="mb-6 rounded-lg px-4 py-3 text-sm <?= $contact_status['type'] === 'success' ? 'bg-green-50 text-green-800 border border-green-200' : 'bg-red-50 text-red-800 border border-red-200'; ?>" role="status">
                        <?= htmlspecialchars($contact_status['text'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="#contact" class="space-y-5">
                    <input type="hidden" name="contact_form" value="1">
                    <input type="hidden" name="contact_token" value="<?= htmlspecialchars($_SESSION['contact_token'], ENT_QUOTES, 'UTF-8'); ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="contact-nom" class="block mb-2 text-sm font-medium text-gray-900">Nom *</label>
                            <input type="text" id="contact-nom" name="nom" value="<?= htmlspecialchars($contact_values['nom'], ENT_QUOTES, 'UTF-8'); ?>" required maxlength="120" autocomplete="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Votre nom">
                        </div>
                        <div>
                            <label for="contact-email" class="block mb-2 text-sm font-medium text-gray-900">Email *</label>
                            <input type="email" id="contact-email" name="email" value="<?= htmlspecialchars($contact_values['email'], ENT_QUOTES, 'UTF-8'); ?>" required maxlength="254" autocomplete="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="vous@exemple.fr">
                        </div>
                    </div>
                    <div>
                        <label for="contact-telephone" class="block mb-2 text-sm font-medium text-gray-900">Téléphone</label>
                        <input type="tel" id="contact-telephone" name="telephone" value="<?= htmlspecialchars($contact_values['telephone'], ENT_QUOTES, 'UTF-8'); ?>" maxlength="30" autocomplete="tel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Votre numéro de téléphone">
                    </div>
                    <div>
                        <label for="contact-interet" class="block mb-2 text-sm font-medium text-gray-900">Votre besoin *</label>
                        <select id="contact-interet" name="interet" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3">
                            <option value="">Sélectionnez une option</option>
                            <option value="do" <?= $contact_values['interet'] === 'do' ? 'selected' : ''; ?>>Dommage Ouvrage</option>
                            <option value="pv" <?= $contact_values['interet'] === 'pv' ? 'selected' : ''; ?>>Photovoltaïque</option>
                            <option value="autre" <?= $contact_values['interet'] === 'autre' ? 'selected' : ''; ?>>Autre</option>
                        </select>
                    </div>
                    <div>
                        <label for="contact-message" class="block mb-2 text-sm font-medium text-gray-900">Message *</label>
                        <textarea id="contact-message" name="message" rows="6" required maxlength="5000" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3" placeholder="Comment pouvons-nous vous renseigner ?"><?= htmlspecialchars($contact_values['message'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                    <div class="flex items-start gap-3">
                        <input type="checkbox" id="contact-rgpd" name="rgpd" value="1" required class="mt-1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="contact-rgpd" class="text-sm text-gray-600">J'accepte que mes données soient utilisées pour répondre à ma demande. *</label>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg shadow hover:bg-blue-800 transition-all">
                        Envoyer ma demande
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </button>
                </form>
            </div>
        </section>

        <!-- Coming soon banner -->
        <section class="bg-gray-900 text-white">
            <div class="max-w-screen-xl mx-auto px-6 py-16 text-center">
                <div class="inline-flex items-center gap-2 bg-blue-600/20 text-blue-300 text-sm font-medium px-4 py-1.5 rounded-full mb-6">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Bientôt disponible
                </div>
                <h2 class="text-3xl font-bold mb-4">Notre nouveau site arrive très bientôt</h2>
                <p class="text-gray-400 max-w-xl mx-auto mb-8">
                    Nous travaillons activement sur notre plateforme en ligne pour vous offrir une expérience simplifiée
                    de gestion de vos contrats Dommage Ouvrage et Photovoltaïque.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center text-sm">
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Souscription en ligne
                    </div>
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Suivi des dossiers DO &amp; PV
                    </div>
                    <div class="flex items-center gap-2 text-gray-300">
                        <svg class="w-5 h-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Dépôt de pièces sécurisé
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-screen-xl mx-auto px-6 py-10">
            <div class="flex flex-col md:flex-row items-start justify-between gap-8 mb-8">
                <div class="flex items-center gap-3">
                    <img src="img/cc-assur.jpeg" alt="CC Assur" class="h-10 rounded" />
                    <span class="font-bold text-gray-900">CC Assur — Solutions / Conseils</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-10 gap-y-2 text-sm text-gray-500">
                    <p class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> 5, Boulevard du Soubeyran — 48000 Mende</p>
                    <p class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> 04 66 65 79 79</p>
                    <p class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> cabinetcotton@outlook.fr</p>
                    <p class="flex items-center gap-2"><svg class="w-4 h-4 text-blue-600 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg> EI Alexandre Cotton — N° ORIAS 18 00 2947</p>
                </div>
            </div>
            <p class="text-xs text-gray-400 leading-relaxed border-t border-gray-100 pt-6">
                SIRET 840 357 743 — RCS Mende — N° ORIAS 18002947 (www.orias.fr) en qualité d'agent général/courtier d'assurances,
                travaillant avec un nombre restreint de fournisseurs (liste transmise sur simple demande). Le cabinet est rémunéré par
                le fournisseur choisi sous forme de commissions en pourcentage de la prime payée. Le cabinet a souscrit une garantie
                financière et une responsabilité civile conformément au code des assurances. Il est soumis au contrôle de l'ACPR —
                4 Place de Budapest, CS 92459, 75436 Paris Cedex 09. En cas de réclamation, vous pouvez écrire à l'adresse du cabinet
                ou via le formulaire de contact ; en cas de différend persistant, vous pouvez saisir le médiateur de l'assurance :
                TSA 50110, 75441 Paris Cedex 09.
            </p>
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6">
                <p class="text-sm text-gray-500">&copy; 2026 CC Assur — Cabinet d'assurance. Tous droits réservés.</p>
                <div class="flex gap-4 text-gray-400">
                    <a href="#contact" class="hover:text-blue-600 transition-colors" title="Formulaire de contact">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </a>
                    <a href="tel:0466657979" class="hover:text-blue-600 transition-colors" title="Téléphone">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
