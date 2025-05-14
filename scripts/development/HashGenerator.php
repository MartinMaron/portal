<?php

use Illuminate\Support\Facades\Hash;

$password = "nnnnnnnn";
$hashedPassword = Hash::make($password);

echo "Original password: " . $password . "\n";
echo "Hashed password: " . $hashedPassword . "\n";

if (Hash::check($password, $hashedPassword)) {
    echo "Hash verification successful!\n";
}
