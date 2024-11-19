
<?php

function ctrlEditsongview($request, $response, $container){
    $songModel = $container->Songs();

    $song_id = $request->get(INPUT_GET, "song_id");
    $song = $songModel->getSongById($song_id);

    $response->set('song', $song);
    $response->setTemplate("editsong.php");

    return $response;
}
