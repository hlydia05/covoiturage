<?php

@include 'config.php';

session_start();

// Récupération des informations de l'utilisateur connecté
if (isset($_SESSION['mat_etd'])) {
  $mat_etd = $_SESSION['mat_etd'];
  $sql = "SELECT * FROM utilisateur WHERE mat_etd = '$mat_etd'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nom = $row['nom'];
    $prenom = $row['prenom'];
    $num_tel = $row['num_tel'];
    $email = $row['email'];
    $mdp = $row['mdp'];
    $type = $row['type'];
  } else {
    echo "Utilisateur introuvable";
    exit();
  }
} else {
  header("Location: login_form.php");
  exit();
}

$sql = "SELECT * FROM utilisateur WHERE mat_etd = '$mat_etd'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $nom = $row['nom'];
  $prenom = $row['prenom'];
  $num_tel = $row['num_tel'];
  $email = $row['email'];
  $mdp = $row['mdp'];
} else {
  echo "Erreur : utilisateur introuvable";
}

// Fonction pour afficher les informations de l'utilisateur
function show_user_infos() {
  global $nom, $prenom, $num_tel, $email, $mdp;
  echo "<div id='user_infos'>";
  echo "<p>Nom : $nom</p>";
  echo "<p>Prénom : $prenom</p>";
  echo "<p>Numéro de téléphone : $num_tel</p>";
  echo "<p>Email : $email</p>";
  echo "</div>";
}

// Fonction pour afficher les trajets suggérés ou recherchés
function show_trajets($depart, $destination, $date_dep, $heure_dep) {
  global $conn;
  echo "<div id='trajets'>";
  echo "<h3>Trajets disponibles</h3>";
  echo "<table>";
  echo "<tr>";
  echo "<th>Départ</th>";
  echo "<th>Destination</th>";
  echo "<th>Date de départ</th>";
  echo "<th>Heure de départ</th>";
  echo "<th>Conducteur</th>";
  echo "<th>Numéro de téléphone</th>";
  echo "<th>Prix</th>";
  echo "<th>Réserver</th>";
  echo "</tr>";

  // Si les paramètres de recherche sont vides, on affiche les trajets suggérés
  if (empty($depart) && empty($destination) && empty($date_dep) && empty($heure_dep)) {
    $sql = "SELECT * FROM trajet ORDER BY date_dep, heure_dep LIMIT 10";
  } else {
    // Sinon, on affiche les trajets correspondant aux critères de recherche
    $sql = "SELECT * FROM trajet WHERE depart LIKE '%$depart%' AND destination LIKE '%$destination%' AND date_dep LIKE '%$date_dep%' AND heure_dep LIKE '%$heure_dep%' ORDER BY date_dep, heure_dep";
  }

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $depart = $row['depart'];
      $destination = $row['destination'];
      $date_dep = $row['date_dep'];
      $heure_dep = $row['heure_dep'];
      $conducteur = $row['conducteur'];
      $nb_passagers = $row['nb_passagers'];
      $latitude = $row['latitude'];
      $longitude = $row['longitude'];
      $id_trajet = $row['id_trajet'];
      $prix = $row['prix'];

      // Récupération du nom et du numéro de téléphone du conducteur
      $sql2 = "SELECT nom, num_tel FROM utilisateur WHERE mat_etd = '$conducteur'";
      $result2 = $conn->query($sql2);

      if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        $nom_conducteur = $row2['nom'];
        $num_tel_conducteur = $row2['num_tel'];
      } else {
        echo "Erreur : conducteur introuvable";
      }

      // Affichage des informations du trajet
      echo "<tr>";
      echo "<td>$depart</td>";
      echo "<td>$destination</td>";
      echo "<td>$date_dep</td>";
      echo "<td>$heure_dep</td>";
      echo "<td>$nom_conducteur</td>";
      echo "<td>$num_tel_conducteur</td>";
      echo "<td>$prix</td>";
      echo "<td><a href='reservation.php?id_trajet=$id_trajet'>Réserver</a></td>";
      echo "</tr>";
    }
  } else {
    echo "Aucun trajet trouvé";
  }
  echo "</table>";
  echo "</div>";
}

// Fonction pour afficher la carte avec le départ et la destination
function show_map($depart, $destination) {
  echo "<div id='map'>";
  echo "<h3>Carte du trajet</h3>";
  // Utilisation de l'API OpenStreetMap pour afficher la carte
  echo "<iframe width='100%' height='450' frameborder='0' scrolling='no' marginheight='0' marginwidth='0' src='https://www.openstreetmap.org/export/embed.html?bbox=2.3771,48.8566,2.3851,48.8625&layer=mapnik' style='border: 1px solid black'></iframe>";
    /*<?php show_map("", "");?>*/
  echo "</div>";
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Page utilisateur</title>
  <link rel="stylesheet" href="css/style2.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
  <script>
    // Définition du script JavaScript
    

    // Fonction pour récupérer la position de l'utilisateur et la mettre comme valeur par défaut du champ départ
    function get_user_position() {
      var depart = document.getElementById("depart");
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var lat = position.coords.latitude;
          var lon = position.coords.longitude;
          // Utilisation de l'API OpenStreetMap pour obtenir le nom du lieu à partir des coordonnées
          var url = "https://nominatim.openstreetmap.org/reverse?format=json&lat=" + lat + "&lon=" + lon;
          var xhr = new XMLHttpRequest();
          xhr.open("GET", url, true);
          xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
              var response = JSON.parse(xhr.responseText);
              var display_name = response.display_name;
              depart.value = display_name;
            }
          };
          xhr.send();
        });
      } else {
        alert("La géolocalisation n'est pas disponible");
      }
    }

       // Autocompletion 
       function autocomplete() { 
          var input = event.target; 
          var datalist = input.list; 
          fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + input.value) 
          .then(response => response.json()) 
          .then(data => { 
            // Clear existing options 
            datalist.innerHTML = ''; 
            // Add options from API response 
            data.forEach(result => { 
              var option = document.createElement('option'); 
              option.value = result.display_name; 
              datalist.appendChild(option); 
            }); 
          }); 
        } 
        
        // Add markers when fields are filled 
        function addMarkers() { 
          var depart = document.getElementById("depart").value; 
          var destination = document.getElementById("destination").value; 
          if (depart && destination) { 
            // Remove existing markers 
            if (marker1) { map.removeLayer(marker1); } 
            if (marker2) { map.removeLayer(marker2); } 
            // Add new markers 
            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + depart) 
            .then(response => response.json()) 
            .then(data => { 
              var lat = data[0].lat; 
              var lon = data[0].lon; 
              marker1 = L.marker([lat, lon]).addTo(map); 
            }); 
            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + destination) 
            .then(response => response.json()) 
            .then(data => { 
              var lat = data[0].lat; 
              var lon = data[0].lon; 
              marker2 = L.marker([lat, lon]).addTo(map); 
            }); 
          } 
        } 


        document.getElementById("depart").addEventListener("input", autocomplete);  
        document.getElementById("destination").addEventListener("input", autocomplete);
        // Call addMarkers when fields change 
        document.getElementById("depart").addEventListener("change", addMarkers); 
        document.getElementById("destination").addEventListener("change", addMarkers);

    // Fonction pour soumettre le formulaire de recherche et afficher les trajets correspondants
    function submit_form() {
      var depart = document.getElementById("depart").value;
      var destination = document.getElementById("destination").value;
      var date_dep = document.getElementById("date_dep").value;
      var heure_dep = document.getElementById("heure_dep").value;
      // Appel de la fonction PHP show_trajets avec les paramètres de recherche
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "show_trajets.php?depart=" + depart + "&destination=" + destination + "&date_dep=" + date_dep + "&heure_dep=" + heure_dep, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          var response = xhr.responseText;
          // Remplacement du contenu de la div trajets par la réponse
          var trajets = document.getElementById("trajets");
          trajets.innerHTML = response;
        }
      };
      xhr.send();
    }
    
  </script>
</head>
<body>
  <div id="header">
    <a href="modify_user_info.php"><img id="user_icon" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAgxJREFUSEvFloFNAzEMRdNJgEmATWASYBLoJMAksAn0ifunX/fnLj0JNVJVKef429/fiXftQmt3Idy2Bfi6tXbXWuP/ewqc/49zkhgFBuShtfa04FzgLxZQ13wE+HkFsDongP1hk3ObgMnydaJVDqDz80Dz25QVNiyov51YkS0B3Pey72WMwy8LF8DHAQo5RzkoC6sL3gN+t0ypWaVNjgEiKBdW1QPgN5XzBAy9clxBE/34TIy4NigNjM2rAjvFOKNGvn5WVO019SDJGuCZmQrs2eLEKfQMYIIsWN5miSFp5SjrCowRkZ5Qc1Ct6p5qpoATS/GcA9MSGLGgRRmJXQWVxOZM1WRghO+smUU3cgNUqOuwAic2FFRiw3UzJ9QDTmpPNQao7tfWc+CZLQdwByljMldmSdyxXydDdUPM2GtcFS0gbLiZ+PeFqMgmvVBewggcKen0LcD89CJVPfixyKRT7Q2f2gJnAuRB8AWwHo8aa1R8FZFH53T3rsoKUh8FL9/iBeJ0Syz1pWK/Uus1d3AX45Fg19qGKDXqkF26PNivL5JEpoBOziXgpReoPhpL9dS34WdRGXB9asLoXaMV2GvKt25vL81cgFZwHGmYg04FRq9ehdHnZABQpGvD3sh0mVq9p4XZdg1YhiMBaLrUINi5e/62R4E9AF0k0oLa618G+sXot3w8N+MtGPHML602mh+PBzzCAAAAAElFTkSuQmCC"/></a>
    <?php
    // Affichage du bouton pour se connecter en tant que conducteur selon le type de l'utilisateur
    if ($type == "driver") {
      echo "<a href='driver_page.php'><button id='connect_as_driver'>Connect as driver</button></a>";
    } else {
      echo "<a href='driver_registration_form.php'><button id='connect_as_driver'>Become a driver</button></a>";
    }
    ?>
    <a href='logout.php'><button id='logout'>Logout</button></a>
  </div>
  <div id="upper_part">
    <div id="search_form">
      <h3>Rechercher un trajet</h3>
      <form>
        <div>
        <label for="depart">Départ :</label>
        <input type="text" id="depart" name="depart" list="depart_list" oninput="autocomplete()" onclick="get_user_position()">
        <datalist id="depart_list"></datalist>
        </div>
        <div>
        <label for="destination">Destination :</label>
        <input type="text" id="destination" name="destination" list="destination_list" oninput="autocomplete()">
        <datalist id="destination_list"></datalist>
        </div>
        <div>
        <label for="date_dep">Date de départ :</label>
        <input type="date" id="date_dep" name="date_dep">
        </div>
        <div>
        <label for="heure_dep">Heure de départ :</label>
        <input type="time" id="heure_dep" name="heure_dep">
        </div>
        <div>
        <button type="button" onclick="submit_form()">Rechercher</button>
        </div>
      </form>
    </div>
    <?php show_trajets("", "", "", ""); ?>
  </div>
  <div class="map">
    <h3>Carte du trajet</h3>
    <div id="map"></div>
  </div>
  
</body>
<script>
  var map = L.map('map').setView([51.505, -0.09], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
</script>
</html>