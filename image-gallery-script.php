 <?php

    require_once('database.php');

    $db = $conn;
    $tableName = Database::TABLE;

    $fetchImage = fetch_image($tableName);

    // fetching padination data
    function fetch_image($tableName)
    {
        global $db;
        $tableName = trim($tableName);
        if (!empty($tableName)) {
            $query = "SELECT * FROM " . $tableName . " ORDER BY id DESC";
            $result = $db->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_all(MYSQLI_ASSOC);
                debug_to_console($row, 'Fetched Image');
                return $row;
            } else {

                info_to_console("No Image is stored in the database");
            }
        } else {
            echo "you must declare table name to fetch Image";
        }
    }
