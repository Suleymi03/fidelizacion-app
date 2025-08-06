<?php
// caja_blanca_login.php

echo "=============================================================\n";
echo "    INFORME DE PRUEBAS DE LOGIN (CAJA BLANCA SIMULADA)\n";
echo "=============================================================\n\n";

$tests = [
    [
        'nombre' => 'Credenciales válidas',
        'usuario' => 'admin',
        'password' => '12345',
        'esperado' => true
    ],
    [
        'nombre' => 'Usuario vacío',
        'usuario' => '',
        'password' => '12345',
        'esperado' => false
    ],
    [
        'nombre' => 'Contraseña vacía',
        'usuario' => 'admin',
        'password' => '',
        'esperado' => false
    ],
    [
        'nombre' => 'Usuario y contraseña incorrectos',
        'usuario' => 'otro',
        'password' => 'otro',
        'esperado' => false
    ]
];

// Simulamos tu lógica interna de login (puedes ajustar esto)
function login($usuario, $password) {
    // Aquí se simula la lógica que podrías tener en login.php
    $usuario_valido = 'admin';
    $password_valida = '12345';

    if (empty($usuario) || empty($password)) {
        return false;
    }

    if ($usuario === $usuario_valido && $password === $password_valida) {
        return true;
    }

    return false;
}

// Variables para el resumen
$pasadas = 0;
$fallidas = 0;
$inicio = microtime(true);

// Proceso de pruebas
foreach ($tests as $test) {
    $inicioCaso = microtime(true);
    $resultado = login($test['usuario'], $test['password']);
    $duracion = microtime(true) - $inicioCaso;

    $estado = ($resultado === $test['esperado']) ? 'PASÓ' : 'FALLÓ';
    if ($estado === 'PASÓ') {
        $pasadas++;
    } else {
        $fallidas++;
    }

    $texto = ($resultado) ? 'sí' : 'no';

    printf(
        "%-30s %-8s %-10s %-6s %.6f   %s\n",
        $test['nombre'],
        $test['esperado'] ? 'true' : 'false',
        $resultado ? 'true' : 'false',
        $texto,
        $duracion,
        $estado
    );
}

$tiempoTotal = microtime(true) - $inicio;

echo "\n=============================================================\n";
echo "Total pruebas realizadas: " . count($tests) . "\n";
echo "Pruebas PASÓ: $pasadas\n";
echo "Pruebas FALLÓ: $fallidas\n";
echo "Tasa de éxito: " . round(($pasadas / count($tests)) * 100, 2) . "%\n";
echo "Tiempo total de tests: " . number_format($tiempoTotal, 6) . "s\n";
echo "=============================================================\n";
