
## Follow the instructions below to create a development environment on Cloud9:

- Resize the workspace, set memory > 1.5GB
- (Edit composer.json, set "dolebas/*": "source")
- Run "composer install"
- Create a GitHub machine token if/when composer asks for it
- Run "bash dolebas-c9-conf.sh"
- Run Project
- Install Drupal minimal profile
- Enable the dolebas_config module
- Enable the dolebas_default_content module
- Visit /admin/config/dolebas-config and submit the form
- Mission completed
