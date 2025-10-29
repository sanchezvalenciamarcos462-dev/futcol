<?php
include("db/conexion.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitización de datos
    $nombre   = htmlspecialchars(trim($_POST['nombre'] ?? ''));
    $correo   = htmlspecialchars(trim($_POST['email'] ?? ''));
    $telefono = htmlspecialchars(trim($_POST['telefono'] ?? ''));
    $asunto   = htmlspecialchars(trim($_POST['asunto'] ?? ''));
    $mensaje  = htmlspecialchars(trim($_POST['mensaje'] ?? ''));

    if ($conn) {
        $stmt = $conn->prepare("INSERT INTO formulario (nombre, correo, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)");

        if ($stmt) {
            $stmt->bind_param("sssss", $nombre, $correo, $telefono, $asunto, $mensaje);

            if ($stmt->execute()) {
                $msg = "✅ Tu mensaje se envió correctamente.";
            } else {
                $msg = "❌ Error al enviar el mensaje: " . htmlspecialchars($stmt->error);
            }

            $stmt->close();
        } else {
            $msg = "❌ Error al preparar la consulta: " . htmlspecialchars($conn->error);
        }

        $conn->close();
    } else {
        $msg = "❌ Error de conexión con la base de datos.";
    }

    // Mostrar mensaje con JavaScript y redirección
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            var m = " . json_encode($msg) . ";
            var d = document.createElement('div');
            d.textContent = m;
            Object.assign(d.style, {
                position:'fixed', left:'50%', top:'20px', transform:'translateX(-50%)',
                background:m.startsWith('✅') ? '#1f2937' : '#7f1d1d',
                color:'#fff', padding:'12px 18px', borderRadius:'6px',
                zIndex:9999, fontSize:'16px', boxShadow:'0 2px 10px rgba(0,0,0,0.2)'
            });
            document.body.appendChild(d);

            setTimeout(function(){
                if (window.opener) {
                    window.close();
                } else {
                    window.location = 'Inicio.php';
                }
            }, 3000);
        });
    </script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="ruta/a/tu/favicon.ico" type="image/x-icon">
  <title>Futcol</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
    body { display: flex; flex-direction: column; min-height: 100vh; }
    header { background: #1e3a8a; color: white; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
    header h1 { font-size: 22px; }
    nav ul { list-style: none; display: flex; gap: 20px; }
    nav a { color: white; text-decoration: none; font-weight: bold; transition: 0.3s; }
    nav a:hover { color: #facc15; }
    main { flex: 1; padding: 40px; background: #f3f4f6; }
    footer { background: #F54928; color: white; text-align: center; padding: 15px 0; }
    .contact-container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .form-group { margin-bottom: 15px; display: flex; flex-direction: column; }
    label { font-weight: bold; margin-bottom: 5px; }
    input, textarea { padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
    .action { display: flex; justify-content: space-between; margin-top: 10px; }
    .btn { padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
    .btn-primary { background: #1e3a8a; color: #fff; }
    .btn-secondary { background: #6b7280; color: #fff; }
  </style>
</head>
<body>

  <?php include("menu.php"); ?>

  <main>
    <div class="contact-container">
      <h2>Contacto</h2>

      <form class="contact-form" action="contacto.php" method="post" novalidate>
        <div class="form-group">
          <label for="nombre">Nombre completo</label>
          <input id="nombre" name="nombre" type="text" placeholder="Tu nombre" required>
        </div>

        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <input id="email" name="email" type="email" placeholder="tucorreo@ejemplo.com" required>
        </div>

        <div class="form-group">
          <label for="telefono">Teléfono (opcional)</label>
          <input id="telefono" name="telefono" type="text" placeholder="+34 600 000 000">
        </div>

        <div class="form-group">
          <label for="asunto">Asunto</label>
          <input id="asunto" name="asunto" type="text" placeholder="Breve resumen" required>
        </div>

        <div class="form-group">
          <label for="mensaje">Mensaje</label>
          <textarea id="mensaje" name="mensaje" placeholder="Escribe tu mensaje..." maxlength="2000" required></textarea>
          <div id="counter" class="hint">0 / 2000</div>
        </div>

        <div class="action">
          <button type="reset" class="btn btn-secondary" id="resetBtn">Limpiar</button>
          <button type="submit" class="btn btn-primary" id="submitBtn">Enviar mensaje</button>
        </div>
      </form>
    </div>
  </main>

  <footer>
    <p>© 2025 Realizado por Marcos Sánchez Valencia</p>
  </footer>

  <script>
    (function() {
      const mensaje = document.getElementById('mensaje');
      const counter = document.getElementById('counter');
      const form = document.querySelector('.contact-form');
      const submit = document.getElementById('submitBtn');

      function updateCount() {
        const len = mensaje.value.length;
        counter.textContent = len + ' / ' + (mensaje.maxLength || 2000);
        counter.style.color = len > mensaje.maxLength - 20 ? '#b45309' : '';
      }

      mensaje.addEventListener('input', updateCount);
      updateCount();

      form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
          e.preventDefault();
          const firstInvalid = form.querySelector(':invalid');
          if (firstInvalid) firstInvalid.focus();
          submit.textContent = 'Corrige los campos';
          setTimeout(() => submit.textContent = 'Enviar mensaje', 1800);
        } else {
          submit.disabled = true;
          submit.style.opacity = '.7';
          setTimeout(() => { submit.disabled = false; submit.style.opacity = ''; }, 3000);
        }
      });

      document.getElementById('resetBtn').addEventListener('click', () => {
        setTimeout(updateCount, 10);
      });
    })();
  </script>
</body>
</html>
