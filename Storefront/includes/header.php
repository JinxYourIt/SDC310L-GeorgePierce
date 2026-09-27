<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="../layout/bootstrap.min.css">
    </head>
    <body class="bg-light text-dark">
        <main class="container py-4 py-md-5">
            <header class="bg-dark text-white rounded-3 p-4 p-md-5 mb-4 border-bottom border-5 border-warning shadow-sm">
                <p class="text-warning text-uppercase fw-bold small mb-3">Ol' George's Market / The everyday essentials shop</p>
                <h1 class="display-5 fw-bold mb-3"><?php echo $title; ?></h1>
                <p class="text-white-50 mb-0">Supporting Communities Since 2001</p>
            </header>
            <?php if ($error != ''): ?>
                <p class="alert alert-danger"><?php echo $error; ?></p>
            <?php endif; ?>
