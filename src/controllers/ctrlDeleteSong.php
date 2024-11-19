<?php

function ctrlDeleteSong($request, $response, $container) {
    $song_id = $request->get(INPUT_GET, 'id');

    if ($song_id) {
        $songModel = $container->Songs();
        $deleteSuccess = $songModel->deleteSong($song_id);

        if ($deleteSuccess) {
            $response->redirect("Location: index.php?msg=cancion_eliminada");
        } else {
            $response->redirect("Location: index.php?msg=error_eliminando_cancion");
        }
    } else {
        $response->redirect("Location: index.php?msg=id_no_proporcionado");
    }

    return $response;
} 