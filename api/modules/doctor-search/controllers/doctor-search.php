<?php

require_once __DIR__ . '/../../../helpers/sql.php';

$mysqli = Sql_init();

$query = "
    SELECT d.*, u.first_name, u.last_name, s.name, p.file_path
    FROM doctors d
    JOIN users u ON d.doctor_id = u.user_id
    JOIN specializations s ON s.specialization_id = d.specialization_id
    JOIN pictures p ON d.photo_id = p.photo_id
    WHERE u.user_type = 'doctor'
";

$stmt = $mysqli->prepare($query);
$stmt->execute();
$result = $stmt->get_result();


include __DIR__ . '/../views/doctor-search-page.php';

?>
