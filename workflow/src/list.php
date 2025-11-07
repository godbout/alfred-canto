<?php

require 'vendor/autoload.php';

use Godbout\Alfred\Workflow\ScriptFilter;
use Godbout\Alfred\Workflow\Item;
use Godbout\Alfred\Workflow\Mods\Cmd;

$file = getenv('file');

foreach (getLines($file) as $key => $line) {
    if ($key === 0 || $key === 1 || empty($line)) {
        continue;
    }

    ScriptFilter::add(
        Item::create()
            ->title('🇺🇸️' . $line[2])
            ->subtitle('🇨🇳' . $line[1])
            ->arg($line[1])
            ->valid()
            ->match($line[1] . $line[2])
            ->mod(
                Cmd::create()
                    ->subtitle("Show the shit above in big letters if you can't see clearly 🖕🏽️")
            )
            ->largetype($line[2])
    );
}

$output = ScriptFilter::output();

if (empty(json_decode($output, true)['items'])) {
    ScriptFilter::add(
        Item::create()
            ->title("Nothing to see 🖕🏼️")
            ->subtitle('dick')
    );

    $output = ScriptFilter::output();
}

echo $output;

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
