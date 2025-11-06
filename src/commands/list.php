<?php

use Alfred\Workflows\Workflow;

require 'vendor/autoload.php';

$workflow = new Workflow();

$file = getenv('file');

foreach (getLines($file) as $key => $line) {
    if ($key === 0 || $key === 1 || empty($line)) {
        continue;
    }

    $workflow->result()
        ->uid(preg_replace("#[^a-zA-z ]#", "", (iconv('UTF-8', 'ASCII//IGNORE//TRANSLIT', "$line[1]-$line[2]"))))
        ->title('🇺🇸️' .$line[2])
        ->subtitle('🇲🇴️' .$line[1])
        ->arg($line[1])
        ->cmd("Show the shit above in big letters if you can't see clearly 🖕🏽️", $line[2])
        ->largetype($line[2])
        ->valid(true);
}

$term = trim($argv[1]);

$workflow->filterResults(preg_replace("#[^a-zA-z ]#", "", (iconv('UTF-8', 'ASCII//IGNORE//TRANSLIT', $term))), 'uid');;

if (empty(json_decode($workflow->output(), true)['items'])) {
    $workflow->result()
        ->title("Nothing to see 🖕🏼️")
        ->subtitle('dick');
}

echo $workflow->output();

/**
 * Functions
 */

function getLines($file)
{
    $handle = fopen($file, 'rb');

    if (!$handle) {
        throw new Exception();
    }

    while (!feof($handle)) {
        yield fgetcsv($handle, 0, '|', escape: '');
    }

    fclose($handle);
}
