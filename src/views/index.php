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

  

    <!-- Tabla de canciones -->
    <div class="container">
        <div class="table-responsive mt-4 rounded">
            <table class="table table-striped">
                <thead class="table-light">
                    <tr style="text-align: center;">
                        <th scope="col"><i class="bi bi-music-note"></i> NAME</th>
                        <th scope="col"><i class="bi bi-person"></i> ARTIST</th>
                        <th scope="col"><i class="bi bi-clock"></i> DURATION</th>
                        <th scope="col"><i class="bi bi-controller"></i> CONTROLS</th>
                        <th scope="col"><i class="bi bi-sliders"></i> OPTIONS</th>
                    </tr>
                </thead>
                <?php if (!empty($songs)): ?>
                    <?php foreach ($songs as $song): ?>
                        <!-- id_song | song_name | artist | duration | song_path -->
                        <tbody>
                            <tr data-song-id="<?= $song['id_song'] ?>" style="align-items: center; text-align: center;">
                                <td><?= $song['song_name'] ?></td>
                                <td><?= $song['artist'] ?></td>
                                <td id="durationBtn"> <span class="duration"></span></td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center justify-content-start gap-2 p-2 w-100">
                                        <!-- Contenedor del reproductor de audio -->
                                        <div class="audio-player rounded-3 shadow-sm p-2 flex-grow-1 bg-white">
                                            <audio id="myAudio" class="w-100">
                                                <source src="<?= htmlspecialchars($song['song_path']) ?>" type="audio/mpeg">
                                                Tu navegador no soporta el elemento de audio.
                                            </audio>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Controles de canción">
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSongModal-<?= $song['id_song'] ?>">
                                            <i class="bi bi-pencil"></i> Editar
                                        </button>
                                        <button class="btn btn-danger btn-sm">
                                            <a class="text-white text-decoration-none" href="index.php?r=deletesong&id=<?= $song['id_song'] ?>">
                                                <i class="bi bi-trash"></i> Eliminar
                                            </a>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>

                        <!-- Modal de edición -->
                        <div class="modal fade" id="editSongModal-<?= $song['id_song'] ?>" tabindex="-1" aria-labelledby="editSongModalLabel-<?= $song['id_song'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editSongModalLabel-<?= $song['id_song'] ?>">Editar Canción</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Formulario para editar la canción -->
                                        <form action="index.php?r=updatesong" id="editSongForm" method="post" enctype="multipart/form-data">
                                            <input type="text" hidden name="song_id" value="<?= $song['id_song'] ?>">
                                            <div class="form-floating mb-3">
                                                <input type="text" name="song_name" value="<?= $song['song_name'] ?>" class="form-control" id="song_name" placeholder="505">
                                                <label for="song_name">Nombre de la canción</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="text" name="artist" value="<?= $song['artist'] ?>" class="form-control" id="artist" placeholder="Artic Monkeys">
                                                <label for="artist">Artista</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input type="file" name="song" accept="audio/*" class="form-control" id="song">
                                                <label for="song">Seleccionar una nueva canción</label>
                                                <?php if (!empty($song['song_path'])): ?>
                                                    <small class="form-text text-muted">
                                                        Canción actual:
                                                        <a href="<?= $song['song_path'] ?>" target="_blank"><?= basename($song['song_path']) ?></a>
                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                            <button class="btn btn-primary mt-3" type="submit">Guardar Cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <tbody>
                        <tr>
                            <td colspan="4">No hay canciones disponibles</td>
                        </tr>
                    </tbody>
                <?php endif; ?>
            </table>
        </div>
    </div>
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