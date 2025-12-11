<?php
include '../config/db.php';

// ------------------- ABOUT -------------------
if(isset($_POST['save_about'])){
    $fields = [
        $_POST['interests'], $_POST['inspiration'], $_POST['motto'],
        $_POST['bucket_list'], $_POST['strengths'], $_POST['weaknesses'],
        $_POST['talents'], $_POST['greatest_fear']
    ];

    $about_exist = $conn->query("SELECT COUNT(*) FROM about")->fetchColumn();
    if($about_exist){
        $stmt = $conn->prepare("UPDATE about SET interests=?, inspiration=?, motto=?, bucket_list=?, strengths=?, weaknesses=?, talents=?, greatest_fear=? WHERE id=1");
    } else {
        $stmt = $conn->prepare("INSERT INTO about (interests, inspiration, motto, bucket_list, strengths, weaknesses, talents, greatest_fear) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    }
    $stmt->execute($fields);
    header("Location: ../public/index.php"); // redirect to public site
    exit;
}

// ------------------- SKILLS -------------------
if(isset($_POST['add_skill'])){
    $stmt = $conn->prepare("INSERT INTO skills (category, skill_name, proficiency) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['category'], $_POST['skill_name'], $_POST['proficiency']]);
    header("Location: ../public/index.php");
    exit;
}

if(isset($_GET['delete_skill'])){
    $stmt = $conn->prepare("DELETE FROM skills WHERE id=?");
    $stmt->execute([$_GET['delete_skill']]);
    header("Location: ../public/index.php");
    exit;
}

// ------------------- PROJECTS -------------------
if(isset($_POST['add_project'])){
    $stmt = $conn->prepare("INSERT INTO projects (project_title, description, technologies) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['project_title'], $_POST['description'], $_POST['technologies']]);
    header("Location: ../public/index.php");
    exit;
}

if(isset($_GET['delete_project'])){
    $stmt = $conn->prepare("DELETE FROM projects WHERE id=?");
    $stmt->execute([$_GET['delete_project']]);
    header("Location: ../public/index.php");
    exit;
}

// ------------------- EDUCATION -------------------
if(isset($_POST['add_edu'])){
    $stmt = $conn->prepare("INSERT INTO education (institution, degree_program, year_graduated, research_projects, certifications) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['institution'], $_POST['degree_program'], $_POST['year_graduated'], $_POST['research_projects'], $_POST['certifications']]);
    header("Location: ../public/index.php");
    exit;
}

if(isset($_GET['delete_edu'])){
    $stmt = $conn->prepare("DELETE FROM education WHERE id=?");
    $stmt->execute([$_GET['delete_edu']]);
    header("Location: ../public/index.php");
    exit;
}

// Fetch all data
$about = $conn->query("SELECT * FROM about LIMIT 1")->fetch(PDO::FETCH_ASSOC);
$skills = $conn->query("SELECT * FROM skills")->fetchAll(PDO::FETCH_ASSOC);
$projects = $conn->query("SELECT * FROM projects")->fetchAll(PDO::FETCH_ASSOC);
$education = $conn->query("SELECT * FROM education")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
<h1 class="mb-4">Resume Admin Dashboard</h1>

<!-- Button to Public Site -->
<a href="../public/index.php" class="btn btn-success mb-4">Go to Public Site</a>

<!-- ================= ABOUT ================= -->
<div class="card mb-4">
<div class="card-header bg-primary text-white">About Yourself</div>
<div class="card-body">
<form method="post">
<div class="mb-2"><textarea class="form-control" name="interests" placeholder="Interests"><?= $about['interests'] ?? '' ?></textarea></div>
<div class="mb-2"><textarea class="form-control" name="inspiration" placeholder="Greatest Inspiration"><?= $about['inspiration'] ?? '' ?></textarea></div>
<div class="mb-2"><textarea class="form-control" name="motto" placeholder="Life Motto"><?= $about['motto'] ?? '' ?></textarea></div>
<div class="mb-2"><textarea class="form-control" name="bucket_list" placeholder="Bucket List"><?= $about['bucket_list'] ?? '' ?></textarea></div>
<div class="mb-2"><textarea class="form-control" name="strengths" placeholder="Strengths"><?= $about['strengths'] ?? '' ?></textarea></div>
<div class="mb-2"><textarea class="form-control" name="weaknesses" placeholder="Weaknesses"><?= $about['weaknesses'] ?? '' ?></textarea></div>
<div class="mb-2"><textarea class="form-control" name="talents" placeholder="Talents"><?= $about['talents'] ?? '' ?></textarea></div>
<div class="mb-2"><textarea class="form-control" name="greatest_fear" placeholder="Greatest Fear"><?= $about['greatest_fear'] ?? '' ?></textarea></div>
<button type="submit" name="save_about" class="btn btn-primary">Save About</button>
</form>
</div>
</div>

<!-- ================= SKILLS ================= -->
<div class="card mb-4">
<div class="card-header bg-warning text-dark">Technical Skills</div>
<div class="card-body">
<form method="post" class="row g-2 mb-3">
<div class="col-md-3"><input class="form-control" name="category" placeholder="Category"></div>
<div class="col-md-4"><input class="form-control" name="skill_name" placeholder="Skill Name"></div>
<div class="col-md-3"><input class="form-control" name="proficiency" placeholder="Proficiency"></div>
<div class="col-md-2"><button type="submit" name="add_skill" class="btn btn-primary w-100">Add Skill</button></div>
</form>

<table class="table table-striped">
<tr><th>Category</th><th>Skill</th><th>Proficiency</th><th>Action</th></tr>
<?php foreach($skills as $s){ ?>
<tr>
<td><?= $s['category'] ?></td>
<td><?= $s['skill_name'] ?></td>
<td><?= $s['proficiency'] ?></td>
<td><a href="?delete_skill=<?= $s['id'] ?>" class="btn btn-sm btn-danger">Delete</a></td>
</tr>
<?php } ?>
</table>
</div>
</div>

<!-- ================= PROJECTS ================= -->
<div class="card mb-4">
<div class="card-header bg-info text-white">Projects</div>
<div class="card-body">
<form method="post" class="mb-3">
<div class="mb-2"><input class="form-control" name="project_title" placeholder="Project Title"></div>
<div class="mb-2"><textarea class="form-control" name="description" placeholder="Description"></textarea></div>
<div class="mb-2"><input class="form-control" name="technologies" placeholder="Technologies Used"></div>
<button type="submit" name="add_project" class="btn btn-primary">Add Project</button>
</form>

<table class="table table-striped">
<tr><th>Title</th><th>Description</th><th>Technologies</th><th>Action</th></tr>
<?php foreach($projects as $p){ ?>
<tr>
<td><?= $p['project_title'] ?></td>
<td><?= $p['description'] ?></td>
<td><?= $p['technologies'] ?></td>
<td><a href="?delete_project=<?= $p['id'] ?>" class="btn btn-sm btn-danger">Delete</a></td>
</tr>
<?php } ?>
</table>
</div>
</div>

<!-- ================= EDUCATION ================= -->
<div class="card mb-4">
<div class="card-header bg-success text-white">Education & Certifications</div>
<div class="card-body">
<form method="post" class="mb-3">
<div class="mb-2"><input class="form-control" name="institution" placeholder="Institution"></div>
<div class="mb-2"><input class="form-control" name="degree_program" placeholder="Degree/Program"></div>
<div class="mb-2"><input class="form-control" name="year_graduated" placeholder="Year Graduated"></div>
<div class="mb-2"><textarea class="form-control" name="research_projects" placeholder="Research Projects"></textarea></div>
<div class="mb-2"><textarea class="form-control" name="certifications" placeholder="Certifications"></textarea></div>
<button type="submit" name="add_edu" class="btn btn-primary">Add Education</button>
</form>

<table class="table table-striped">
<tr><th>Institution</th><th>Degree</th><th>Year</th><th>Research Projects</th><th>Certifications</th><th>Action</th></tr>
<?php foreach($education as $e){ ?>
<tr>
<td><?= $e['institution'] ?></td>
<td><?= $e['degree_program'] ?></td>
<td><?= $e['year_graduated'] ?></td>
<td><?= $e['research_projects'] ?></td>
<td><?= $e['certifications'] ?></td>
<td><a href="?delete_edu=<?= $e['id'] ?>" class="btn btn-sm btn-danger">Delete</a></td>
</tr>
<?php } ?>
</table>
</div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
