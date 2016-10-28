<html lang="sv">
  <head>
    <title> Filmregistrering </title>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="styles/addMovies.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  </head>
  <body>
    <header>
      <h1>Registrera filmer</h1>
    </header>

    <form method="post" action="<?php echo htmlspecialchars('./modules/addMovies.php');?>" class="form">
      <div class="form-group">
        <label for="titel">Titel:</label>
        <input type="text" class="form-control" id="titel" name="titel" placeholder="Titel">
      </div>
      <div class="form-group">
        <label for="pris">Pris:</label>
        <input type="text" class="form-control" id="pris" name="pris" placeholder="Pris">
      </div>
      <div class="form-group">
        <label for="langd">Längd:</label>
        <input type="text" class="form-control" id="langd" name="langd" placeholder="Längd">
      </div>
      <div class="form-group">
        <label for="ar">År:</label>
        <input type="text" class="form-control" id="ar" name="ar" placeholder="År">
      </div>
      <div class="form-group">
        <label for="regissorer">Regissörer:</label>
        <input type="text" class="form-control" id="regissorer" name="regissorer" placeholder="Regissörer">
      </div>
      <div class="form-group">
        <label for="producenter">Producenter:</label>
        <input type="text" class="form-control" id="producenter" name="producenter" placeholder="Producenter">
      </div>
      <div class="form-group">
        <label for="genrer">Genrer:</label>
        <input type="text" class="form-control" id="genrer" name="genrer" placeholder="Genrer">
      </div>
      <button type="submit" class="btn btn-default">Lägg Till</button>
    </form>

    <!-- <div id="table"></div> -->

    <footer> </footer>
    <!-- <script src="scripts/addMovies.js"></script> -->
  </body>
</html>
