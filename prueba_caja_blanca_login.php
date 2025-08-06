<?php
// prueba_caja_blanca_login.php
// Simulación de la lógica de login.php para pruebas de caja blanca SIN modificar login.php

// Simulamos "datos" que vendrían de la base de datos
$usuariosSimulados = [
    '5551234567' => ['contrasena' => password_hash('password123', PASSWORD_DEFAULT)],
    '9998887777' => ['contrasena' => password_hash('claveSecreta', PASSWORD_DEFAULT)],
];

// Función que simula la lógica principal de login.php
function loginCajaBlanca($telefono, $contrasena, $usuarios) {
    if (!isset($usuarios[$telefono])) {
        return ['exito' => false, 'mensaje' => '❌ Usuario no encontrado.'];
    }
    $hashContrasena = $usuarios[$telefono]['contrasena'];
    if (!password_verify($contrasena, $hashContrasena)) {
        return ['exito' => false, 'mensaje' => '❌ Contraseña incorrecta.'];
    }
    return ['exito' => true, 'mensaje' => '✔ Usuario validado correctamente.'];
}

// Casos de prueba
$tests = [
    ['Usuario válido, contraseña correcta', '5551234567', 'password123', true, '✔ Usuario validado correctamente.'],
    ['Usuario válido, contraseña incorrecta', '5551234567', 'malacontra', false, '❌ Contraseña incorrecta.'],
    ['Usuario no existente', '0000000000', 'cualquiera', false, '❌ Usuario no encontrado.'],
];

// Ejecutar pruebas
$results = [];
foreach ($tests as list($desc, $tel, $pass, $expExito, $expMsg)) {
    $res = loginCajaBlanca($tel, $pass, $usuariosSimulados);
    $paso = ($res['exito'] === $expExito) && ($res['mensaje'] === $expMsg);
    $results[] = [
        'test' => $desc,
        'esperado' => $expMsg,
        'resultado' => $res['mensaje'],
        'estado' => $paso ? 'PASÓ' : 'FALLÓ',
    ];
}

// Mostrar resultados
echo str_repeat('=', 70) . "\n";
echo str_pad("PRUEBAS DE CAJA BLANCA - login.php (Simulado)", 70, " ", STR_PAD_BOTH) . "\n";
echo str_repeat('=', 70) . "\n\n";

foreach ($results as $r) {
    echo "Test: {$r['test']}\n";
    echo "Esperado: {$r['esperado']}\n";
    echo "Resultado: {$r['resultado']}\n";
    echo "Estado: {$r['estado']}\n";
    echo str_repeat('-', 70) . "\n";
}
?>
