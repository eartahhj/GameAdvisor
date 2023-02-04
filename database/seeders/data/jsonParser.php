<?php
$file = file_get_contents('WindowsGames.json', 'r');
$json = json_decode($file);

$developers = $publishers = [];

function loadDevelopers($json)
{
    foreach ($json as $row) {
        if (!empty($row->Dev)) {
            $dev = $row->Dev;
            if (empty($developers[$dev])) {
                $developers[$dev]['name'] = $dev;
            }
        }
    }

    $newJson = fopen('developers.json', 'w+');
    fwrite($newJson, json_encode($developers));
}

function loadPublishers($json)
{
    foreach ($json as $row) {
        if (!empty($row->Publisher)) {
            $publisher = $row->Publisher;
            if (empty($publishers[$publisher])) {
                $publishers[$publisher]['name'] = $publisher;
            }
        }
    }
    $newJson = fopen('publishers.json', 'w+');
    fwrite($newJson, json_encode($publishers));
}

// loadDevelopers($json);
// loadPublishers($json);
?>
