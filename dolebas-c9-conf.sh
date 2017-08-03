#!/home/ubuntu
# Configuring the Cloud9 dev environment

echo "Adding vendor/bin to PATH"
export PATH="/home/ubuntu/workspace/vendor/bin:$PATH"
echo "Setting /web as web root"
sudo mv ~/workspace/001-cloud9.conf /etc/apache2/sites-available/001-cloud9.conf