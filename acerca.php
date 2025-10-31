<php>

</php>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Futcol</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* ====== Header ====== */
    header {
      background: #411BE3;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      font-size: 22px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    nav a:hover {
      color: #facc15;
    }

    /* ====== Contenido principal ====== */
    main {
      flex: 1;
      padding: 40px;
      background: #FFFFFF;
    }

    main h2 {
      margin-bottom: 15px;
    }

    /* ====== Footer ====== */
    footer {
      background: #83418A;
      color: white;
      text-align: center;
      padding: 15px 0;
    }
  </style>
</head>
<body> 

  <!-- Header con menú -->
 <?php include("menu.php"); ?>

  <main>
    <h2>Bienvenidos a mi mundo web</h2>
    <p>Esta es nuestra tienda virtual de ventas de camisas deportivas de futbol.</p>
  </main>

  <footer>
    <p>© 2025 realizado por Marcos Sanchez Valencia</p>
  </footer>
</body>
</html>

