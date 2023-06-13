<?php

/**
 * Used to running database query
 *
 * @param string mysql query
 *
 * return mixed
 */
function run_query(string $query) {
    // Établir une connexion à la base de données en utilisant les informations de connexion
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

    // Vérifier si la connexion a échoué
    if ($connection->connect_errno) {
        throw new Exception("Database connection failed: " . $connection->connect_error);
    }

    // Exécuter la requête SQL en utilisant la méthode query de l'objet mysqli
    if (!$result = $connection->query($query)) {
        throw new Exception("Query execution failed: " . $connection->error);
    }

    // Retourner le résultat de la requête
    return $result;
}

/**
 * Used to create an INSERT query
 *
 * @param $table table name
 * @param $datas array the data to be inserted
 *
 * return bolean
 */
function insert(string $table, array $datas) {
    $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";port=".DB_PORT, DB_USER, DB_PASSWORD);
    // Établir une connexion à la base de données en utilisant PDO

    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Définir le mode de gestion des erreurs pour PDO afin de générer des exceptions en cas d'erreur

    $columns = [];
    $values = [];
    // Créer deux tableaux vides pour stocker les noms des colonnes et les valeurs des données à insérer

    foreach ($datas as $column => $value) {
        $columns[] = $column;
        $values[] = $value;
    }
    // Parcourir le tableau $datas et extraire les noms des colonnes et les valeurs des données

    $columnNames = implode(",", $columns);
    // Concaténer les noms des colonnes séparés par des virgules pour les utiliser dans la requête SQL

    $placeholders = implode(",", array_fill(0, count($values), "?"));
    // Créer une chaîne de caractères contenant des marqueurs de paramètres de la même longueur que le nombre de valeurs à insérer

    $query = "INSERT INTO $table ($columnNames) VALUES ($placeholders)";
    // Construire la requête SQL INSERT INTO en utilisant le nom de la table, les noms des colonnes et les marqueurs de paramètres

    try {
        $statement = $connection->prepare($query);
        // Préparer la requête SQL

        $statement->execute($values);
        // Exécuter la requête SQL en passant les valeurs des données à insérer

        return $connection->lastInsertId();
        // Renvoyer l'ID généré pour la dernière insertion effectuée
    } catch (PDOException $e) {
        throw new Exception("Query execution failed: " . $e->getMessage());
        // Capturer les exceptions PDO liées à l'exécution de la requête SQL et les relancer avec un message d'erreur personnalisé
    }
}

/**
 * @param string table name
 * @param string column
 * @param array conditionsS
 *
 * return array if has some data, false otherwise
 */
function select(string $table, string $column = null, $conditions = array()) {
    if(empty($column)) {
        $column = "*";
    }

    $query = "SELECT {$column} FROM {$table}";
    if(!empty($conditions)) {
        $query .= " WHERE {$conditions[0]} {$conditions[1]} '{$conditions[2]}'";
    }

    if (!$result = run_query($query)) {
        throw new Exception('Error when looking to the data');
    } else {
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }

        return $rows;
    }
}

/**
 *
 */
function find(string $table, array $conditions) {
    $result = select($table, null, $conditions);
    return $result[0];
}
