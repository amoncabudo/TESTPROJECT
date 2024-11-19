<?php

function ctrlEditSong($request, $response, $container){
   
    $song_id = $request->get(INPUT_POST, "song_id");
    $song_name = $request->get(INPUT_POST, "song_name");
    $artist = $request->get(INPUT_POST, "artist");
    $song_path = $request->get(INPUT_POST, "song_path");

    $songModel = $container->Songs();
    $currentSong = $songModel->getSongById($song_id);

    if($currentSong){
      $response->redirect("Location: index.php");
    }

    $unique_id = uniqid();
    $songDir = "uploads/songs/";
    $file_name = $unique_id . "_" . basename($song_path['name']);
    $file_path = $songDir . $file_name;

    move_uploaded_file($song_path['tmp_name'], $file_path);

    $updateSuccess = $songModel->updateSong($song_id, $song_name, $artist, $file_path);

    if($updateSuccess){
        $response->redirect("Location: index.php");
    }else{
        echo "Error updating song";
    }
}

