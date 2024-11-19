<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="/css/datatables.css" rel="stylesheet" crossorigin="anonymous">
  <link href="/css/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
<?php include_once("navbar.php"); ?>

  
    <div class="container mt-5">
        <h2>Usuarios</h2>
        <div class="table-responsive mt-4 rounded">
            <table class="table table-striped">
                <thead class="table-light">
                    <tr style="text-align: center;">
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr style="text-align: center;">
                                <td><?= $user['id_user'] ?></td>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No hay usuarios disponibles</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Archivos necesarios para Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/js/datatables.js"></script>
    <script src="/js/main.js"></script>
</body>

</html>