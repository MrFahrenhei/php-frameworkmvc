<?php
use App\Core\Application;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<main>
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
            <span class="fs-4">Simple header</span>
        </a>
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="/" class="nav-link <?= $_SERVER['REQUEST_URI'] == '/' ? 'active' : '' ?>"" aria-current="page">Home</a></li>
            <li class="nav-item"><a href="/contact" class="nav-link <?= $_SERVER['REQUEST_URI'] == '/contact' ? 'active' : '' ?>"">Contact</a></li>
            <li class="nav-item"><a href="/register" class="nav-link <?= $_SERVER['REQUEST_URI'] == '/register' ? 'active' : '' ?>"">Register</a></li>
            <li class="nav-item"><a href="/login" class="nav-link <?= $_SERVER['REQUEST_URI'] == '/login' ? 'active' : '' ?>"">login</a></li>
        </ul>
    </header>
    <div class="container">
        <?php if(Application::$app->session->getFlash('success')): ?>
            <div class="alert alert-success">
                <?= Application::$app->session->getFlash('success'); ?>
            </div>
        <?php endif; ?>
        {{content}}
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>