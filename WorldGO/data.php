<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "lilisheng5ie";
$pass = "";
$db   = "my_lilisheng5ie";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connessione fallita: " . $conn->connect_error]));
}

$sql = "SELECT Titolo, Data_inizio, Durata FROM WorldGO_GANTT_TASK";
$result = $conn->query($sql);

$data = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $start = $row['Data_inizio'];
        $end = date('Y-m-d', strtotime($start . ' + ' . $row['Durata'] . ' days'));
        $data[] = [
            'title' => $row['Titolo'],
            'start' => $start,
            'end'   => $end
        ];
    }
} else {
    $data = ["message" => "Nessun dato trovato"];
}

$conn->close();

echo json_encode($data);
?>
