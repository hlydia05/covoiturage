<?php 
    
    @include 'config.php';
    
    session_start(); 
    
    // Page content
  
        ?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Page</title>
  
  <!-- Style with CSS -->
<style>
/* style.css */

.sidebar {
  background: #333;
  color: #fff;
  height: 100vh;
  width: 200px;
  position: fixed;
  top: 0;
  left: 0;
}

.sidebar a {
  display: block;
  color: #fff;
  padding: 10px;
  text-decoration: none;
}

.sidebar a:hover {
  background: #555;
}

.content {
  margin-left: 200px;
  padding: 20px;
}

/* Form styling */

/* User/Admin/Trajet styles */

/* Media queries for responsiveness */ 
</style>
</head>

<body>

  <div class="sidebar">
    <a href="admin.php?page=users">Gérer les utilisateurs</a>
    <a href="admin.php?page=admins">Gérer les administrateurs</a>  
    <a href="admin.php?page=trajets">Gérer les trajets</a>
    <a href="profile.php">Modifier profile</a> 
    <a href="logout.php">Logout</a>
  </div>

  <div class="content">

   

    <form id="searchForm">
      <input type="text" name="search" placeholder="Search...">
      <button type="submit">Search</button> 
    </form>

  </div>

</body>

<script>
// JavaScript code for search form
const form = document.getElementById('searchForm');
form.addEventListener('submit', e => {
  e.preventDefault();
  const search = form.elements['search'].value;
  window.location = `admin.php?page=${page}&search=${search}`;
});
</script>

</html>

