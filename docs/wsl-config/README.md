# Running JARVIS on WSL
#### :warning: Running this server on a WSL system is by no means refined, but it does work. :warning:

## Requirements
* Windows 10
* WSL2
* Docker for Windows Desktop
* Ubuntu for WSL

## WSL2 Setup
If you don’t have WSL installed, open a Windows PowerShell console as admin
```sh
wsl --install
````

Update WSL to ensure it’s WSL2
```sh
wsl --update
wsl --shutdown
````

## Ubuntu for WSL
Go to the Microsoft Store and install Ubuntu, the version we’re looking for should have no Ubuntu version number. Once installed, open it. Now we need to enable systemd, inside the Ubuntu window execute
```sh
sudo nano /etc/wsl.conf
````

If you’ve never made configuration changes it should be a blank file, in it add the below two lines
```sh
[boot]
systemd=true
````

Save the file
Go back to the Windows PowerShell admin window and run
```sh
wsl.exe --shutdown
````

Re-open Ubuntu through the Microsoft store

## Docker for Windows Desktop
To use Docker and Docker-Compose within WSL follow this guide:
https://docs.docker.com/desktop/windows/wsl/
There's an additional option available in Docker Desktop for Windows that allows docker-compose functionality, you'll need to check that box too.

## Initial Setup
### Changes for Jarvis on Ubuntu WSL
Create a user for Jarvis
```sh
sudo adduser jarvis
sudo usermod -aG sudo jarvis
````

Change to Jarvis’s home directory
```sh
cd ~
````

Get the Jarvis repo
```sh
git clone https://github.com/cskujawa/jarvis-ai
````

Write down Jarvis’ ID in a notepad somewhere
```sh
id jarvis
````

## Setup Script
```sh
chmod +x ./jarvis-ai/docs/wsl-config/setup.sh
./jarvis-ai/docs/wsl-config/setup.sh
````

### .env Files
The contents of these files are protected, for access please contact kujawabusiness@gmail.com
```sh
vim ./jarvis-ai/.env
vim ./jarvis-ai/interface/laravel/.env
````

### Modifications
You will need to edit the docker-compose.yml file and update the uid found in the services section to be the uid of Jarvis recorded earlier.
You will also need to find and replace 192.168.0.161 (the real Jarvis' current internal IP) to your localhost 127.0.0.1

## Running JARVIS
```sh
cd jarvis-ai
docker-compose build app –-no-cache
docker-compose up -d --force-recreate
docker-compose exec app rm -rf vendor composer.lock
docker-compose exec app composer install
docker-compose exec app php artisan telescope:install
docker-compose exec app php artisan key:generate
docker-compose exec app npm i --save-dev laravel-mix@latest
docker-compose exec app npm clean-install
docker-compose exec app npm run build
docker-compose exec app php artisan migrate:fresh
````

Now you should be able to navigate to 127.0.0.1 and see the login screen
Navigatng to 127.0.0.1/register will take you to the registration page
