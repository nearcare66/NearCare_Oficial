<?php
require_once __DIR__ . '/../doctor/conexion.php';

$conn->set_charset("utf8mb4");

$sqlSiteCards = "CREATE TABLE IF NOT EXISTS site_cards (
    id_card INT AUTO_INCREMENT PRIMARY KEY,
    page_key VARCHAR(50) NOT NULL,
    section_key VARCHAR(50) NOT NULL,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    image_src VARCHAR(255) NOT NULL,
    image_alt VARCHAR(180) DEFAULT '',
    link_url VARCHAR(255) DEFAULT NULL,
    link_text VARCHAR(120) DEFAULT NULL,
    display_order INT NOT NULL DEFAULT 0,
    active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_site_cards (page_key, section_key, active, display_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

$conn->query($sqlSiteCards);

function siteCardSeedSection(mysqli $conn, string $pageKey, string $sectionKey, array $cards): void {
    $stmtCount = $conn->prepare("SELECT COUNT(*) AS total FROM site_cards WHERE page_key = ? AND section_key = ?");
    $stmtCount->bind_param("ss", $pageKey, $sectionKey);
    $stmtCount->execute();
    $total = (int)$stmtCount->get_result()->fetch_assoc()['total'];
    $stmtCount->close();

    if ($total > 0) {
        return;
    }

    $stmt = $conn->prepare(
        "INSERT INTO site_cards
            (page_key, section_key, title, description, image_src, image_alt, link_url, link_text, display_order)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );

    foreach ($cards as $index => $card) {
        $order = $index + 1;
        $linkUrl = $card['link_url'] ?? null;
        $linkText = $card['link_text'] ?? null;

        $stmt->bind_param(
            "ssssssssi",
            $pageKey,
            $sectionKey,
            $card['title'],
            $card['description'],
            $card['image_src'],
            $card['image_alt'],
            $linkUrl,
            $linkText,
            $order
        );
        $stmt->execute();
    }

    $stmt->close();
}

siteCardSeedSection($conn, 'index', 'problems', [
    [
        'title' => 'Distancia',
        'description' => 'La distancia física es un obstáculo para el cuidado y la atención constante de tus familiares.',
        'image_src' => 'img/Designer (19).png?v=2',
        'image_alt' => 'Icono de distancia',
    ],
    [
        'title' => 'Falta de tiempo',
        'description' => 'La rutina diaria puede dificultar encontrar tiempo para monitorear la salud.',
        'image_src' => 'img/Designer (20).png?v=2',
        'image_alt' => 'Icono de falta de tiempo',
    ],
    [
        'title' => 'Falta de información',
        'description' => 'La falta de información clara puede generar preocupación e incertidumbre.',
        'image_src' => 'img/Designer (21).png?v=2',
        'image_alt' => 'Ícono de falta de información',
    ],
]);

siteCardSeedSection($conn, 'index', 'why', [
    [
        'title' => 'El problema',
        'description' => 'Existe dificultad para acceder a atención médica rápida y cercana.',
        'image_src' => 'img/Designer (22).png?v=2',
        'image_alt' => 'Icono del problema',
    ],
    [
        'title' => 'La solucion',
        'description' => 'NearCare conecta pacientes y profesionales para mejorar la comunicación y el seguimiento.',
        'image_src' => 'img/Designer (23).png?v=2',
        'image_alt' => 'Icono de la solucion',
    ],
]);

siteCardSeedSection($conn, 'about', 'info', [
    [
        'title' => 'Mision',
        'description' => 'Brindar una plataforma moderna y accesible que ayude a mejorar la comunicación médica, facilitando el cuidado y bienestar de las familias.',
        'image_src' => 'img/Designer (24).png',
        'image_alt' => 'Icono de mision',
    ],
    [
        'title' => 'Vision',
        'description' => 'Convertirnos en una plataforma líder en salud digital, ofreciendo soluciones tecnológicas innovadoras que acerquen el cuidado médico a todas las personas.',
        'image_src' => 'img/Designer (25).png',
        'image_alt' => 'Icono de vision',
    ],
    [
        'title' => 'Correo',
        'description' => 'Contáctanos para soporte, dudas o información.',
        'image_src' => 'img/Designer (26).png',
        'image_alt' => 'Icono de correo',
        'link_url' => 'https://mail.google.com/mail/?view=cm&fs=1&to=nearcare6@gmail.com',
        'link_text' => 'nearcare@gmail.com',
    ],
    [
        'title' => 'Instagram',
        'description' => 'Síguenos para conocer noticias, actualizaciones y contenido sobre NearCare.',
        'image_src' => 'img/Desugner (27).png',
        'image_alt' => 'Icono de Instagram',
        'link_url' => 'https://www.instagram.com/nearcare_?igsh=MTQyOHA0MTc0anZ0dw==',
        'link_text' => '@NearCare',
    ],
]);

function getSiteCards(string $pageKey, string $sectionKey): array {
    global $conn;

    $sql = "SELECT title, description, image_src, image_alt, link_url, link_text
            FROM site_cards
            WHERE page_key = ? AND section_key = ? AND active = 1
            ORDER BY display_order ASC, id_card ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $pageKey, $sectionKey);
    $stmt->execute();
    $result = $stmt->get_result();
    $cards = [];

    while ($row = $result->fetch_assoc()) {
        $cards[] = $row;
    }

    $stmt->close();

    return $cards;
}

function siteCardE($value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
