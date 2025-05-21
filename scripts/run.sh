#!/bin/bash
cd "$(dirname "$0")/.." || exit
bash "scripts/$1/$2.sh" "${@:3}"
