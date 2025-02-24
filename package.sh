#!/bin/bash

echo "Packaging..."

if [[ -f "tinyshop_package.tar.gz" ]]; then
    echo "Notice: removing existing package"
    rm -f "tinyshop_package.tar.gz"
fi

mkdir ../.packaging
mkdir ../.packaging/dctinyshop
cp -r * ../.packaging/dctinyshop
cp -r package_assets/* ../.packaging/

rm ../.packaging/dctinyshop/package.sh
rm ../.packaging/dctinyshop/tinyshop-mgmt.sh
rm -r ../.packaging/dctinyshop/package_assets

tar -czf tinyshop_package.tar.gz --directory=../.packaging/ .
rm -r ../.packaging

echo "Done"

echo "Upload the archive to /var/www/html/tinyshop on the dcPlayground server"
