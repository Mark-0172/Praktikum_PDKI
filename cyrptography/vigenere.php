<?php

function encrypt($text, $key) {
    $result = "";
    $key = strtolower($key);
    $keyLength = strlen($key);

    for ($i = 0, $j = 0; $i < strlen($text); $i++) {
        $char = $text[$i];

        if (ctype_alpha($char)) {
            $shift = ord($key[$j % $keyLength]) - ord('a');

            if (ctype_upper($char)) {
                $result .= chr((ord($char) - ord('A') + $shift) % 26 + ord('A'));
            } else {
                $result .= chr((ord($char) - ord('a') + $shift) % 26 + ord('a'));
            }
            $j++;
        } else {
            $result .= $char;
        }
    }
    return $result;
}

function decrypt($text, $key) {
    $result = "";
    $key = strtolower($key);
    $keyLength = strlen($key);

    for ($i = 0, $j = 0; $i < strlen($text); $i++) {
        $char = $text[$i];

        if (ctype_alpha($char)) {
            $shift = ord($key[$j % $keyLength]) - ord('a');

            if (ctype_upper($char)) {
                $result .= chr((ord($char) - ord('A') - $shift + 26) % 26 + ord('A'));
            } else {
                $result .= chr((ord($char) - ord('a') - $shift + 26) % 26 + ord('a'));
            }
            $j++;
        } else {
            $result .= $char;
        }
    }
    return $result;
}

// === MAIN PROGRAM (CMD ARGUMENT) ===

if ($argc < 5) {
    echo "Usage: php vigenere.php [e/d] input.txt output.txt key\n";
    exit;
}

$mode = $argv[1];
$inputFile = $argv[2];
$outputFile = $argv[3];
$key = $argv[4];

// cek file
if (!file_exists($inputFile)) {
    echo "File input tidak ditemukan!\n";
    exit;
}

$data = file_get_contents($inputFile);

if ($mode == "e") {
    $result = encrypt($data, $key);
    echo "Mode: ENCRYPT\n";
} elseif ($mode == "d") {
    $result = decrypt($data, $key);
    echo "Mode: DECRYPT\n";
} else {
    echo "Mode harus 'e' atau 'd'\n";
    exit;
}

file_put_contents($outputFile, $result);

echo "Selesai! Output: $outputFile\n";

?>