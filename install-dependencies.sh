#!/bin/bash

# Check all required CLIs are available
dependencies=( wget unzip )
for dependency in "${dependencies[@]}"; do
  command -v $dependency >/dev/null 2>&1 || { echo >&2 "‘$dependency’ command is required but it’s not installed. Aborting."; exit 1; }
done

# Get required proprietary fonts for theme
wget --retry-connrefused --waitretry=1 --read-timeout=60 --timeout=60 -O df.zip "http://chrisswithinbank.net/wp-content/uploads/2016/06/1407-HRGQJV.zip"
if [[ -f "df.zip" ]]; then
  unzip df.zip -d font/
  rm df.zip
else
  echo "Can’t find file: df.zip. Fatal error…"
  exit 1
fi
