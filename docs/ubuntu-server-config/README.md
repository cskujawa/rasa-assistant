# Running JARVIS on Ubuntu Server
JARVIS is intended to be run on an Ubuntu server, this guide is to help guide setting up an Ubuntu Server environment for development.
This environment is considered a bare metal system so to implement monitoring it will include creating users and applications to enable that.

## Requirements
* [Ubuntu Server 22.04.1 LTS](https://discourse.ubuntu.com/t/jammy-jellyfish-release-notes/24668)
* [Docker](https://www.docker.com/)
* [Docker-Compose](https://docs.docker.com/compose/)
* [Prometheus](https://prometheus.io/)
* [Node Exporter](https://prometheus.io/docs/guides/node-exporter/)

## Useful Guides
* [Initial Server Setup with Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/initial-server-setup-with-ubuntu-22-04)
* [How To Install and Use Docker on Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-22-04)
* [How To Install and Use Docker Compose on Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-22-04)
* [How To Install Prometheus on Ubuntu 16.04](https://www.digitalocean.com/community/tutorials/how-to-install-prometheus-on-ubuntu-16-04)

## Getting Started
### Jarvis User
The JARVIS application is currently built to be run by and live in a jarvis user's home directory, so we'll create them, and assume that identity.
```sh
sudo adduser jarvis
sudo usermod -aG sudo jarvis
su jarvis
````

Change to Jarvis’ home directory
```sh
cd ~
````

### Prometheus and Node Exporter
For system and container monitoring via Prometheus and Node Exporter we need users for each. These have to be installed on the host to access resources. Node Exporter dumps the data, Prometheus gathers it, and in the Jarvis application Grafana graphs it.
```sh
sudo useradd --no-create-home --shell /bin/false prometheus
sudo useradd --no-create-home --shell /bin/false node_exporter
````

Make the directories for prometheus
```sh
sudo mkdir /etc/prometheus 
sudo mkdir /var/lib/prometheus
sudo chown prometheus:prometheus /etc/prometheus
sudo chown prometheus:prometheus /var/lib/prometheus
````

Download and install prometheus
:warning: The versions used here are specific to Ubuntu Server 22.04.1 :warning:
:warning: The steps are not included but it is highly advised to verify sha256sum when downloading files :warning:
```sh
curl -LO https://github.com/prometheus/prometheus/releases/download/v2.38.0/prometheus-2.38.0.linux-amd64.tar.gz
tar xvf prometheus-2.38.0.linux-amd64.tar.gz
sudo cp prometheus-2.38.0.linux-amd64/prometheus /usr/local/bin/
sudo cp prometheus-2.38.0.linux-amd64/promtool /usr/local/bin/
sudo chown prometheus:prometheus /usr/local/bin/prometheus
sudo chown prometheus:prometheus /usr/local/bin/promtool
sudo cp -r prometheus-2.38.0.linux-amd64/consoles /etc/prometheus
sudo cp -r prometheus-2.38.0.linux-amd64/console_libraries /etc/prometheus
sudo chown -R prometheus:prometheus /etc/prometheus/consoles
sudo chown -R prometheus:prometheus /etc/prometheus/console_libraries
rm -rf prometheus-2.38.0.linux-amd64.tar.gz prometheus-2.38.0.linux-amd64
````

Download and install node exporter
:warning: The versions used here are specific to Ubuntu Server 22.04.1 or this project :warning:
```sh
curl -LO https://github.com/prometheus/node_exporter/releases/download/v1.4.0/node_exporter-1.4.0.linux-amd64.tar.gz
tar xvf node_exporter-1.4.0.linux-amd64.tar.gz
sudo cp node_exporter-1.4.0.linux-amd64/node_exporter /usr/local/bin/
sudo chown node_exporter:node_exporter /usr/local/bin/node_exporter
rm -rf node_exporter-1.4.0.linux-amd64.tar.gz node_exporter-1.4.0.linux-amd64
````

Now we’ll Create a custom node exporter service, the contents of the service will be pulled from the repo
```sh
curl https://raw.githubusercontent.com/cskujawa/jarvis-ai/main/system/node_exporter.service > node_exporter.service
sudo cp node_exporter.service /etc/systemd/system/node_exporter.service
rm node_exporter.service
````

Load the Node Exporter service, start it, and enable it
```sh
sudo systemctl daemon-reload
sudo systemctl start node_exporter
sudo systemctl enable node_exporter
````

Now to allow all the containers to communicate (assuming you’ve blocked network traffic in various ways), we will ensure that the docker containers can freely communicate with eachother. Please note that the range used in the command below is specifically for the network configured within the docker-compose file associated with this project.
```sh
sudo ufw allow proto tcp from 172.30.0.0/16
````

### Docker and Docker-Compose
:warning: If you already have Docker and Docker-Compose this step can be skipped :warning:
:warning: The versions used here are specific to Ubuntu Server 22.04.1 or this project :warning:
Now we need to download install and make some configurations for Docker to work
```sh
sudo apt install apt-transport-https ca-certificates curl software-properties-common -y
curl -LO https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu focal stable"
sudo apt-cache policy docker-ce
sudo apt install docker-ce -y
sudo usermod -aG docker $USER && newgrp docker
sudo ufw allow 7946/tcp
sudo ufw allow 7946/udp
sudo ufw allow 2377/tcp
sudo ufw allow 4789/udp
sudo mkdir -p ~/.docker/cli-plugins/
curl -LO https://github.com/docker/compose/releases/download/v2.11.2/docker-compose-linux-x86_64 -o ~/.docker/cli-plugins/docker-compose
sudo chmod +x ~/.docker/cli-plugins/docker-compose
sudo cp -s /home/jarvis/.docker/cli-plugins/docker-compose /usr/bin/docker-compose
````

### Get JARVIS
Get the Jarvis repo
```sh
git clone https://github.com/cskujawa/jarvis-ai
````

### JARVIS Configuration
Write down Jarvis’ ID in a notepad somewhere
```sh
id jarvis
````

### .env Files
The contents of these files are protected, for access please contact kujawabusiness@gmail.com
```sh
vim ./jarvis-ai/.env
vim ./jarvis-ai/interface/laravel/.env
````

### Modifications
You will need to edit the docker-compose.yml file and update the uid found in the services section to be the uid of Jarvis recorded earlier.
You will also need to find and replace 192.168.0.161 (the real Jarvis' current internal IP) to your Ubuntu Server's IP address

### Running JARVIS
Since JARVIS' front end is powered by Laravel and uses VUE, we'll need to make sure the Laravel container created in the build step is ready to go
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

Now you should be able to navigate to your Ubuntu Servers' address and see the login screen
Navigating to [youripaddress]/register will take you to the registration page where you can create a user to sign in