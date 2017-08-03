#!/home/ubuntu
# Configuring the Cloud9 dev environment

echo "Adding vendor/bin to PATH"
export PATH="/home/ubuntu/workspace/vendor/bin:$PATH"
echo "Setting /web as web root"
sudo mv ~/workspace/001-cloud9.conf 
sudo mv ~/workspace/settings.local.php ~/workspace/web/sites/default/settings.local.php