<?php
include '../config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Resume</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">My Resume</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#skills">Skills</a></li>
        <li class="nav-item"><a class="nav-link" href="#projects">Projects</a></li>
        <li class="nav-item"><a class="nav-link" href="#education">Education</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">

<!-- Button to Admin Dashboard -->
<div class="mb-4">
  <a href="../admin/dashboard.php" class="btn btn-primary">Go to Admin Dashboard</a>
</div>

<!-- ================= ABOUT ================= -->
<section id="about" class="mb-5">
<h2 class="mb-3">About Me</h2>
<?php
$about = $conn->query("SELECT * FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
if($about){
    echo '<ul class="list-group">';
    echo '<li class="list-group-item"><strong>Interests:</strong> '.$about['interests'].'</li>';
    echo '<li class="list-group-item"><strong>Greatest Inspiration:</strong> '.$about['inspiration'].'</li>';
    echo '<li class="list-group-item"><strong>Life Motto:</strong> '.$about['motto'].'</li>';
    echo '<li class="list-group-item"><strong>Bucket List:</strong> '.$about['bucket_list'].'</li>';
    echo '<li class="list-group-item"><strong>Strengths:</strong> '.$about['strengths'].'</li>';
    echo '<li class="list-group-item"><strong>Weaknesses:</strong> '.$about['weaknesses'].'</li>';
    echo '<li class="list-group-item"><strong>Talents:</strong> '.$about['talents'].'</li>';
    echo '<li class="list-group-item"><strong>Greatest Fear:</strong> '.$about['greatest_fear'].'</li>';
    echo '</ul>';
} else {
    echo '<p>No About Me content yet.</p>';
}
?>
</section>

<!-- ================= SKILLS ================= -->
<section id="skills" class="mb-5">
<h2 class="mb-3">Technical Skills</h2>
<?php
$skills = $conn->query("SELECT * FROM skills")->fetchAll(PDO::FETCH_ASSOC);
if($skills){
    echo '<table class="table table-striped">';
    echo '<tr><th>Category</th><th>Skill</th><th>Proficiency</th></tr>';
    foreach($skills as $s){
        echo "<tr><td>{$s['category']}</td><td>{$s['skill_name']}</td><td>{$s['proficiency']}</td></tr>";
    }
    echo '</table>';
} else {
    echo '<p>No skills added yet.</p>';
}
?>
</section>

<!-- ================= PROJECTS ================= -->
<section id="projects" class="mb-5">
<h2 class="mb-3">Projects</h2>
<?php
$projects = $conn->query("SELECT * FROM projects")->fetchAll(PDO::FETCH_ASSOC);
if($projects){
    foreach($projects as $p){
        echo '<div class="card mb-3">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$p['project_title'].'</h5>';
        echo '<p class="card-text">'.$p['description'].'</p>';
        echo '<p><strong>Technologies:</strong> '.$p['technologies'].'</p>';
        echo '</div></div>';
    }
} else {
    echo '<p>No projects added yet.</p>';
}
?>
</section>

<!-- ================= EDUCATION ================= -->
<section id="education" class="mb-5">
<h2 class="mb-3">Education & Certifications</h2>
<?php
$education = $conn->query("SELECT * FROM education")->fetchAll(PDO::FETCH_ASSOC);
if($education){
    foreach($education as $edu){
        echo '<div class="card mb-3">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$edu['degree_program'].' at '.$edu['institution'].' ('.$edu['year_graduated'].')</h5>';
        echo '<p><strong>Research Projects:</strong> '.$edu['research_projects'].'</p>';
        echo '<p><strong>Certifications:</strong> '.$edu['certifications'].'</p>';
        echo '</div></div>';
    }
} else {
    echo '<p>No education added yet.</p>';
}
?>
</section>

</div> <!-- container -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
