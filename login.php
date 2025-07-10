<?php
include "includes/db.php";
session_start();

$clienteValidado = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $telefono = $_POST['telefono'];
    $pass = $_POST['contrasena'];

    $sql = "SELECT * FROM clientes WHERE telefono = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $telefono);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $cliente = $result->fetch_assoc();
        if (password_verify($pass, $cliente['contrasena'])) {
            $_SESSION['telefono'] = $telefono;
            $clienteValidado = true;
        } else {
            $mensaje = "❌ Contraseña incorrecta.";
        }
    } else {
        $mensaje = "❌ Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio de Sesión</title>
  <style>
    body {
      background: #000;
      color: #FFD700;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .form-box {
      background: #111;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px #FFD700;
      width: 300px;
      text-align: center;
    }

    input, button {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: none;
    }

    input {
      background: #000;
      color: #FFD700;
      border: 2px solid #FFD700;
    }

    button {
      background: #FFD700;
      color: #000;
      font-weight: bold;
      cursor: pointer;
    }

    #voiceModal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.9);
      color: #fff;
      z-index: 999;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    #voiceModal .box {
      background: #111;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #FFD700;
      text-align: center;
    }

    #mensajeVoz {
      margin-top: 10px;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2>Iniciar Sesión</h2>
  <form method="POST">
    <input type="text" name="telefono" placeholder="Teléfono" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit">Entrar</button>
  </form>
  <?php if (!empty($mensaje)) echo "<p style='color: red;'>$mensaje</p>"; ?>
</div>

<!-- Modal para la verificación por voz -->
<?php if ($clienteValidado): ?>
<div id="voiceModal" style="display: flex;">
  <div class="box">
    <h2>Verificación por Voz</h2>
    <p>Repite la siguiente palabra:</p>
    <h3 id="palabraMostrar" style="color:#FFD700;"></h3>
    <button onclick="reconocerVoz()">Activar micrófono</button>
    <p id="mensajeVoz"></p>
  </div>
</div>
<?php endif; ?>

<script>
window.onload = function() {
  const palabraMostrar = document.getElementById("palabraMostrar");
  const mensajeVoz = document.getElementById("mensajeVoz");
  const palabras = ["León", "Sol", "Estrella", "Tigre", "Mango", "Luz", "Código", "Ventana", "Playa", "Tecnología", "Koala" ];
  
  if (palabraMostrar) {
    const palabraCorrecta = palabras[Math.floor(Math.random() * palabras.length)];
    palabraMostrar.textContent = palabraCorrecta;

    window.reconocerVoz = function() {
      const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
      recognition.lang = 'es-MX';
      recognition.interimResults = false;
      recognition.maxAlternatives = 1;

      recognition.onresult = function(event) {
        const texto = event.results[0][0].transcript.toLowerCase().trim();
        console.log("Reconocido:", texto);
        const esperado = palabraCorrecta.toLowerCase().trim();

        if (texto === esperado) {
          mensajeVoz.textContent = "Verificación exitosa. Redirigiendo...";
          setTimeout(() => window.location.href = "dashboard_user.php", 1500);
        } else {
          mensajeVoz.textContent = "Palabra incorrecta. Intenta de nuevo.";
        }
      };

      recognition.onerror = function(event) {
        mensajeVoz.textContent = "Error de reconocimiento: " + event.error;
        console.error("Error:", event.error);
      };

      recognition.start();
    };
  }
};
</script>

</body>
</html>
