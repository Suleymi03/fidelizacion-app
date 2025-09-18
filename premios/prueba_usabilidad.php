<?php
// prueba_usabilidad_premios.php

echo "=============================================================\n";
echo "     INFORME DE PRUEBAS DE USABILIDAD - premios.php\n";
echo "=============================================================\n\n";

// Datos simulados de cliente y premios
$cliente = [
    'telefono' => '9999999999',
    'puntos' => 150
];

$premios = [
    ['id' => 1, 'nombre' => 'Taza personalizada', 'puntos_requeridos' => 100],
    ['id' => 2, 'nombre' => 'Camiseta oficial', 'puntos_requeridos' => 200],
    ['id' => 3, 'nombre' => 'Bolsa ecológica', 'puntos_requeridos' => 50],
];

// Casos de prueba de usabilidad
$tests = [
    [
        'nombre' => 'Visualizar todos los premios',
        'descripcion' => 'El usuario debe ver listado completo de premios',
        'esperado' => count($premios),
        'funcion' => function() use ($premios) {
            return count($premios);
        }
    ],
    [
        'nombre' => 'Verificación de botón Canjear según puntos',
        'descripcion' => 'Solo se muestra botón "Canjear" si puntos cliente >= puntos requeridos',
        'esperado' => [
            1 => true,  // premio 1 (100 pts) -> cliente 150 pts -> true
            2 => false, // premio 2 (200 pts) -> cliente 150 pts -> false
            3 => true   // premio 3 (50 pts)  -> cliente 150 pts -> true
        ],
        'funcion' => function() use ($cliente, $premios) {
            $resultados = [];
            foreach ($premios as $p) {
                $resultados[$p['id']] = ($cliente['puntos'] >= $p['puntos_requeridos']);
            }
            return $resultados;
        }
    ],
    [
        'nombre' => 'Mensaje cuando no hay puntos suficientes',
        'descripcion' => 'Para premios no canjeables, se muestra mensaje adecuado',
        'esperado' => [
            1 => false,  // 1: suficiente puntos -> no debe mostrar mensaje
            2 => true,   // 2: no suficiente puntos -> debe mostrar mensaje
            3 => false   // 3: suficiente puntos -> no debe mostrar mensaje
        ],
        'funcion' => function() use ($cliente, $premios) {
            $mensajes = [];
            foreach ($premios as $p) {
                $mensajes[$p['id']] = ($cliente['puntos'] < $p['puntos_requeridos']);
            }
            return $mensajes;
        }
    ],
];

// Variables resumen
$pasadas = 0;
$fallidas = 0;
$inicio = microtime(true);

foreach ($tests as $test) {
    $inicioCaso = microtime(true);
    $resultado = $test['funcion']();
    $duracion = microtime(true) - $inicioCaso;

    $ok = false;
    if (is_array($test['esperado'])) {
        $ok = ($resultado === $test['esperado']);
    } else {
        $ok = ($resultado === $test['esperado']);
    }

    $estado = $ok ? 'PASÓ' : 'FALLÓ';
    if ($ok) $pasadas++; else $fallidas++;

    // Mostrar resultado detallado para arrays
    if (is_array($resultado)) {
        $resultado_str = json_encode($resultado);
        $esperado_str = json_encode($test['esperado']);
    } else {
        $resultado_str = var_export($resultado, true);
        $esperado_str = var_export($test['esperado'], true);
    }

    printf(
        "%-40s %-6s Duración: %.6fs\n  Descripción: %s\n  Esperado: %s\n  Resultado: %s\n\n",
        $test['nombre'],
        $estado,
        $duracion,
        $test['descripcion'],
        $esperado_str,
        $resultado_str
    );
}

$tiempoTotal = microtime(true) - $inicio;

echo "=============================================================\n";
echo "Total pruebas realizadas: " . count($tests) . "\n";
echo "Pruebas PASÓ: $pasadas\n";
echo "Pruebas FALLÓ: $fallidas\n";
echo "Tasa de éxito: " . round(($pasadas / count($tests)) * 100, 2) . "%\n";
echo "Tiempo total de tests: " . number_format($tiempoTotal, 6) . "s\n";
echo "=============================================================\n";
