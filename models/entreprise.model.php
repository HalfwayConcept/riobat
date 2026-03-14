<?php
require_once __DIR__ . '/connect.db.php';
require_once __DIR__ . '/../controllers/LogController.php';

        function coordFormDisplay($type, $entreprise_id){
                        // Affichage du bloc debug uniquement si DEBUG est défini et vrai
                        if (defined('DEBUG') && DEBUG) {
                            echo '<div style="background: #ffe; color: #a00; padding: 8px; margin-bottom: 8px; border: 1px solid #a00;">';
                            echo '<strong>Debug coordFormDisplay</strong><br>ID transmis : ' . htmlspecialchars($entreprise_id);
                            $session_key = $type . '_entreprise_id';
                            $session_val = isset($_SESSION['info_travaux_annexes'][$session_key]) ? $_SESSION['info_travaux_annexes'][$session_key] : '(non défini)';
                            echo '<br>Session[info_travaux_annexes]["' . $session_key . '"] = ' . htmlspecialchars($session_val);
                            if (!empty($entreprise_id)) {
                                $debug_entreprise = loadEntreprise($entreprise_id);
                                echo '<br>Résultat loadEntreprise : <pre>' . htmlspecialchars(print_r($debug_entreprise, true)) . '</pre>';
                            }
                            echo '</div>';
                        }
            $ID = $raison_social = $nom = $prenom = $code_postal = $adresse = $commune = $numero_siret = "";
            if(!empty($entreprise_id)){
                $entreprise = loadEntreprise($entreprise_id);
                if ($entreprise && is_array($entreprise)) {
                    $ID = $entreprise_id;
                    $raison_social = isset($entreprise["raison_sociale"]) ? (string)$entreprise["raison_sociale"] : "";
                    $nom = isset($entreprise["nom"]) ? (string)$entreprise["nom"] : "";
                    $prenom = isset($entreprise["prenom"]) ? (string)$entreprise["prenom"] : "";
                    $code_postal = isset($entreprise["code_postal"]) ? (string)$entreprise["code_postal"] : "";
                    $adresse = isset($entreprise["adresse"]) ? (string)$entreprise["adresse"] : "";
                    $commune = isset($entreprise["commune"]) ? (string)$entreprise["commune"] : "";
                    $numero_siret = isset($entreprise["numero_siret"]) ? (string)$entreprise["numero_siret"] : "";
                }
            }

            $coordform = file_get_contents('views/templates/form/form-entreprise.template.html');                
            $prefix_key = $type.'_entreprise_';
            //on ajoute la variable dans le résultat HTML généré
            $coordform = str_replace('##type##'                                 , $type, $coordform);
            $coordform = str_replace('##valeur_entreprise_id##'                 , $ID,$coordform);    
            $coordform = str_replace('##valeur_entreprise_raison_sociale##'     , $raison_social,$coordform);
            $coordform = str_replace('##valeur_entreprise_nom##'                , $nom,$coordform);
            $coordform = str_replace('##valeur_entreprise_prenom##'             , $prenom,$coordform);
            $coordform = str_replace('##valeur_entreprise_code_postal##'        , $code_postal,$coordform);
            $coordform = str_replace('##valeur_entreprise_adresse##'            , $adresse,$coordform);
            $coordform = str_replace('##valeur_entreprise_commune##'            , $commune,$coordform);            
            $coordform = str_replace('##valeur_entreprise_numero_siret##'       , $numero_siret,$coordform);

            switch ($type) {
                case 'sol':
                case 'cnr':
                case 'ctt':
                case 'boi':
                case 'phv':                    
                    $icon = "<img class='h-10 m-2' src='public/pictures/icons/$type.png'";
                    break;
                default: $icon = "";   break;
            }
            $coordform = str_replace('##icon##', $icon,$coordform);
            return $coordform;
        }

        function viewEntreprise($entreprise_id){
            $array_entreprise = loadEntreprise($entreprise_id);
            $type = $array_entreprise["type"];    

            $arrType = [
                'sol' => 'Société de sol',
                'cnr' => 'Constructeur non réalisateur',
                'ctt' => 'Contrôleur technique',
                'boi' => 'Construction bois',
                'phv' => 'Pose de photovoltaïque',
                'geo' => 'Entreprise de géothermie',
            ];
            $title_type = $arrType;
            $label_type = isset($title_type[$type]) ? $title_type[$type] : htmlspecialchars($type);
            $echo = '<fieldset class="grid md:grid-cols-2 md:gap-6 border-2 border-gray-400 p-4">
                            <legend class="mx-2 p-2 text-sm">
                                <img class="h-6" src="public/pictures/icons/'.$type.'.png">&nbsp; <h4 class="text-l font-bold text-gray-800">'.$label_type.' #'.$entreprise_id.'</h4>
                            </legend>';
                        
                        $echo .= '<div class="relative z-0 w-full mb-5 group">
                                    <label class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Nom entreprise ou raison sociale
                                        <strong class="pl-4">'.$array_entreprise["raison_sociale"].'</strong>
                                    </label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">                                
                                    <label class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Siret n°
                                        <strong class="pl-4">'.$array_entreprise["numero_siret"].'</strong>
                                    </label>
                                </div>';

                                $echo .= '<div class="relative z-0 w-full mb-5 group">
                                    <label class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Nom
                                        <strong class="pl-4">'.$array_entreprise["nom"].'</strong>
                                    </label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">                                
                                    <label class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Prénom 
                                        <strong class="pl-4">'.$array_entreprise["prenom"].'</strong>
                                    </label>
                                </div>';

                                $echo .= '<div class="relative z-0 w-full mb-5 group">
                                    <label class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Adresse
                                        <strong class="pl-4">'.$array_entreprise["adresse"].'</strong>
                                    </label>
                                </div>
                                <div class="relative z-0 w-full mb-5 group">                                
                                    <label class="peer-focus:font-medium absolute text-xl text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">
                                        Code Postal Ville 
                                        <strong class="pl-4">'.$array_entreprise["code_postal"]."&nbsp;".$array_entreprise["commune"].'</strong>
                                    </label>
                                </div>';
               
            return $echo;
        }

        function loadEntreprise($entreprise_id){
            $pdo = $GLOBALS['pdo'] ?? null;
            $stmt = $pdo->prepare('SELECT * FROM entreprise WHERE ID = :id LIMIT 1');
            $stmt->execute([':id' => $entreprise_id]);
            $user_id = $_SESSION['user_id'] ?? null;
            logQuery($entreprise_id, 'entreprise', $stmt->queryString, [':id' => $entreprise_id], $user_id, 'réussi');
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        function getEntreprises($doid){
            $pdo = $GLOBALS['pdo'] ?? null;
            $stmt = $pdo->prepare("SELECT TA.DOID, boi_entreprise_id, phv_entreprise_id, geo_entreprise_id, cnr_entreprise_id, ctt_entreprise_id, sol_entreprise_id, moe_entreprise_id
                                   FROM travaux_annexes TA
                                   JOIN situation S ON TA.DOID = S.DOID
                                   JOIN dommage_ouvrage DO ON TA.DOID = DO.DOID
                                   WHERE TA.DOID = :doid LIMIT 1");
            $stmt->execute([':doid' => $doid]);
            $user_id = $_SESSION['user_id'] ?? null;
            logQuery($doid, 'travaux_annexes', $stmt->queryString, [':doid' => $doid], $user_id, 'réussi');
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
    
        function insertEntreprise($array_entreprise){
            $pdo = $GLOBALS['pdo'] ?? null;
            $type = $array_entreprise['type'] ?? '';
            $stmt = $pdo->prepare('INSERT INTO entreprise (raison_sociale, nom, prenom, adresse, code_postal, commune, numero_siret, type, nat_juri, num_contrat) VALUES (:raison_sociale, :nom, :prenom, :adresse, :code_postal, :commune, :numero_siret, :type, "", "")');
            try {
                $stmt->execute([
                    ':raison_sociale' => $array_entreprise['raison_sociale'] ?? null,
                    ':nom' => $array_entreprise['nom'] ?? null,
                    ':prenom' => $array_entreprise['prenom'] ?? null,
                    ':adresse' => $array_entreprise['adresse'] ?? null,
                    ':code_postal' => $array_entreprise['code_postal'] ?? null,
                    ':commune' => $array_entreprise['commune'] ?? null,
                    ':numero_siret' => $array_entreprise['numero_siret'] ?? null,
                    ':type' => $type,
                ]);

                $id_entreprise_new = (int)$pdo->lastInsertId();
                
                $user_id = $_SESSION['user_id'] ?? null;
                logQuery(null, 'entreprise', $stmt->queryString, [
                    ':raison_sociale' => $array_entreprise['raison_sociale'] ?? null,
                    ':nom' => $array_entreprise['nom'] ?? null,
                    ':prenom' => $array_entreprise['prenom'] ?? null,
                    ':adresse' => $array_entreprise['adresse'] ?? null,
                    ':code_postal' => $array_entreprise['code_postal'] ?? null,
                    ':commune' => $array_entreprise['commune'] ?? null,
                    ':numero_siret' => $array_entreprise['numero_siret'] ?? null,
                    ':type' => $type,
                ], $user_id, 'réussi');
                
                return $id_entreprise_new;
            } catch (PDOException $e) {
                if (defined('DEBUG') && DEBUG) throw $e;
                return false;
            }
        };

        function updateEntrepriseID($entreprise_id, $type, $DOID){
            $pdo = $GLOBALS['pdo'] ?? null;
            $type_entreprise_id = $type . "_entreprise_id";
            $allowed_types = ['sol', 'cnr', 'ctt', 'boi', 'phv', 'geo', 'moe'];
            if (!in_array($type, $allowed_types)) return false;

            $table = match($type) {
                'sol' => 'situation',
                'moe' => 'dommage_ouvrage',
                default => 'travaux_annexes',
            };

            $pdo = $GLOBALS['pdo'] ?? null;
            $sql = "UPDATE $table SET $type_entreprise_id = :entreprise_id WHERE DOID = :doid";
            $stmt = $pdo->prepare($sql);
            $res = $stmt->execute([':entreprise_id' => $entreprise_id, ':doid' => $DOID]);
            $user_id = $_SESSION['user_id'] ?? null;
            logQuery($DOID, $table, $stmt->queryString, [':entreprise_id' => $entreprise_id, ':doid' => $DOID], $user_id, $res ? 'réussi' : 'échec');
            return $res;
        }

        function updateEntreprise($entreprise_id, $array_entreprise){
            $pdo = $GLOBALS['pdo'] ?? null;
            $type = $array_entreprise['type'] ?? '';

            $pdo = $GLOBALS['pdo'] ?? null;
            $stmt = $pdo->prepare('UPDATE entreprise SET raison_sociale = :raison_sociale, nom = :nom, prenom = :prenom, adresse = :adresse, code_postal = :code_postal, commune = :commune, numero_siret = :numero_siret WHERE ID = :id');
            try {
                $stmt->execute([
                    ':raison_sociale' => $array_entreprise['raison_sociale'] ?? null,
                    ':nom' => $array_entreprise['nom'] ?? null,
                    ':prenom' => $array_entreprise['prenom'] ?? null,
                    ':adresse' => $array_entreprise['adresse'] ?? null,
                    ':code_postal' => $array_entreprise['code_postal'] ?? null,
                    ':commune' => $array_entreprise['commune'] ?? null,
                    ':numero_siret' => $array_entreprise['numero_siret'] ?? null,
                    ':id' => $entreprise_id,
                ]);
                $user_id = $_SESSION['user_id'] ?? null;
                logQuery($entreprise_id, 'entreprise', $stmt->queryString, [
                    ':raison_sociale' => $array_entreprise['raison_sociale'] ?? null,
                    ':nom' => $array_entreprise['nom'] ?? null,
                    ':prenom' => $array_entreprise['prenom'] ?? null,
                    ':adresse' => $array_entreprise['adresse'] ?? null,
                    ':code_postal' => $array_entreprise['code_postal'] ?? null,
                    ':commune' => $array_entreprise['commune'] ?? null,
                    ':numero_siret' => $array_entreprise['numero_siret'] ?? null,
                    ':id' => $entreprise_id,
                ], $user_id, 'réussi');
                return $entreprise_id;
            } catch (PDOException $e) {
                if (defined('DEBUG') && DEBUG) throw $e;
                return false;
            }
        };