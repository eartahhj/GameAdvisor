<?php
$file = file_get_contents('WindowsGames.json', 'r');
$json = json_decode($file);

$developers = $publishers = [];

function loadDevelopers($json)
{
    foreach ($json as $row) {
        if (!empty($row->Dev)) {
            $dev = trim($row->Dev);

            if (strpos($dev, ',') !== false) {
                $multipleDevelopers = explode(',', $dev);

                foreach ($multipleDevelopers as $singleDeveloper) {
                    $singleDeveloper = trim($singleDeveloper);
                    if (empty($developers[$singleDeveloper])) {
                        $developers[$singleDeveloper]['name'] = $singleDeveloper;
                    }
                }
            } else {
                $devLink = trim($row->DevLink ?? '');
                if (empty($developers[$dev])) {
                    $developers[$dev]['name'] = $dev;
                    if ($devLink) {
                        $developers[$dev]['link'] = $devLink;
                    }
                }
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
            $publisher = trim($row->Publisher);

            if (strpos($publisher, ',') !== false) {
                $multiplePublishers = explode(',', $publisher);

                foreach ($multiplePublishers as $singlePublisher) {
                    $singlePublisher = trim($singlePublisher);
                    if (empty($publishers[$singlePublisher])) {
                        $publishers[$singlePublisher]['name'] = $singlePublisher;
                    }
                }
            } else {
                $publisherLink = trim($row->PublisherLink ?? '');
                if (empty($publishers[$publisher])) {
                    $publishers[$publisher]['name'] = $publisher;
                    if ($publisherLink) {
                        $publishers[$publisher]['link'] = $publisherLink;
                    }
                }
            }

            
        }
    }
    $newJson = fopen('publishers.json', 'w+');
    fwrite($newJson, json_encode($publishers));
}

loadDevelopers($json);
loadPublishers($json);
?>
