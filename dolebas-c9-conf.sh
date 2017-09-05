#!/home/ubuntu
# Configuring the Cloud9 dev environment

echo "Adding vendor/bin to PATH"
export PATH="/home/ubuntu/workspace/vendor/bin:$PATH"

echo "Setting /web as web root"
sudo mv ~/workspace/001-cloud9.conf /etc/apache2/sites-available/001-cloud9.conf

echo "Adding settings.local.php to /web/sites/default"
sudo mv ~/workspace/settings.local.php ~/workspace/web/sites/default/settings.local.php

echo "Adding development.services.yml to /web/sites"
sudo mv ~/workspace/development.services.yml ~/workspace/web/sites/development.services.yml

echo "Adding .htaccess to /web"
cp ~/workspace/.htaccess ~/workspace/web/.htaccess

echo "Adding dev-develop.pantheonsite.io as a git remote"
git remote add dev-develop ssh://codeserver.dev.4d667388-327c-4964-9507-33e18d99b2f1@codeserver.dev.4d667388-327c-4964-9507-33e18d99b2f1.drush.in:2222/~/repository.git

# composer dolebas-am-push dolebas_config && composer dolebas-am-push dolebas_default_content && composer dolebas-am-push dolebas_payments && composer dolebas-am-push dolebas_player && composer dolebas-am-push dolebas_publisher && composer dolebas-am-push dolebas_uploader && composer dolebas-am-push dolebas_user && composer dolebas-am-push dolebas_subtheme
