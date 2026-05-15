<?php

function validatePost($titolo, $descrizione) {

    $titolo = trim($titolo);
    $descrizione = trim($descrizione);

    if (empty($titolo) || empty($descrizione)) {
        throw new Exception(
            'Titolo e descrizione obbligatori'
        );
    }

    if (strlen($titolo) > 30) {
        throw new Exception(
            'Titolo troppo lungo'
        );
    }

    return true;
}