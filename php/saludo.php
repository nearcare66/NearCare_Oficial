<?php
function nearcare_normalizar_texto($texto) {
    $texto = strtolower(trim((string)$texto));
    $texto = strtr($texto, [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
        'Á' => 'a', 'É' => 'e', 'Í' => 'i', 'Ó' => 'o', 'Ú' => 'u',
        'ñ' => 'n', 'Ñ' => 'n',
    ]);
    return $texto;
}

function nearcare_saludo($nombre = '', $genero = '') {
    $genero = nearcare_normalizar_texto($genero);

    if (in_array($genero, ['f', 'femenino', 'mujer', 'female'], true)) {
        return 'Bienvenida';
    }

    if (in_array($genero, ['m', 'masculino', 'hombre', 'male'], true)) {
        return 'Bienvenido';
    }

    $primerNombre = nearcare_normalizar_texto(explode(' ', trim((string)$nombre))[0] ?? '');
    $nombresMujer = [
        'daniela', 'maria', 'ana', 'sofia', 'valeria', 'camila', 'gabriela',
        'alejandra', 'nataly', 'natalia', 'dayana', 'cruz', 'fernanda',
        'paola', 'karla', 'carla', 'lucia', 'laura', 'diana', 'elena',
        'rosa', 'marcela', 'patricia', 'claudia', 'isabel', 'jennifer',
    ];

    if (in_array($primerNombre, $nombresMujer, true) || preg_match('/a$/', $primerNombre)) {
        return 'Bienvenida';
    }

    return 'Bienvenido';
}
?>
