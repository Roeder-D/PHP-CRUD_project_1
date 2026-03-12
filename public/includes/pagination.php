<?php
require_once __DIR__ . '/db.php';

// search and pagination logic
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchParam = "%$search%";

    // configure pagination
$limit = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

    // count total rows for pagination
$countStmt = $pdo->prepare('SELECT COUNT(*) FROM person WHERE name LIKE :search OR surname LIKE :search OR email LIKE :search');
$countStmt->execute([':search' => $searchParam]);
$totalRows = $countStmt->fetchColumn();
$totalPages = ceil($totalRows / $limit);

    // fetch current page of results
$stmt = $pdo->prepare('SELECT * FROM person 
                       WHERE name LIKE :search OR surname LIKE :search OR email LIKE :search ORDER BY surname ASC 
                       LIMIT :limit OFFSET :offset');
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':search', $searchParam, PDO::PARAM_STR);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

?>