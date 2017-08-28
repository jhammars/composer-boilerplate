#!/home/ubuntu
# Configuring the Cloud9 dev environment

echo "Adding vendor/bin to PATH"
export PATH="/home/ubuntu/workspace/vendor/bin:$PATH"

echo "Setting /web as web root"
sudo mv ~/workspace/001-cloud9.conf /etc/apache2/sites-available/001-cloud9.conf

echo "Adding settings.local.php to /web/sites/default"
sudo mv ~/workspace/settings.local.php ~/workspace/web/sites/default/settings.local.php

echo "Adding .htaccess to /web"
cp ~/workspace/.htaccess ~/workspace/web/.htaccess

echo "Adding dev-develop.pantheonsite.io as a git remote"
git remote add dev-develop ssh://codeserver.dev.4d667388-327c-4964-9507-33e18d99b2f1@codeserver.dev.4d667388-327c-4964-9507-33e18d99b2f1.drush.in:2222/~/repository.git