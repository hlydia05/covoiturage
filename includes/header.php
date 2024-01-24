
   <style>
  #header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f0f0f0;
    padding: 10px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
  }

  #user_icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
  }

  #user_infos {
    display: none;
    position: absolute;
    top: 70px;
    right: 10px;
    border: 1px solid black;
    background-color: white;
    padding: 10px;
  }

  #connect_as_driver {
    background-color: green;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
  }

  #logout {
    background-color: red;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
  }

  #upper_part {
      margin-top: auto;
    }

   </style>
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
