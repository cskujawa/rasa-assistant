#Check if we're jarvis
if [ $(whoami) = 'jarvis' ]; then
        echo "We are JARVIS..."
        echo "Proceeding..."
else
        echo "We need to be JARVIS su to jarvis before running this script again..."
        echo "Exiting script..."
        exit
fi

#For system and container monitoring via Prometheus and NodeExporter we need users for each. These have to be installed on the host to access resources. NodeExporter dumps the data, Prometheus gathers it, and in the Jarvis guide, Grafan>echo "Creating friends..."
sudo useradd --no-create-home --shell /bin/false prometheus
sudo useradd --no-create-home --shell /bin/false node_exporter

#Make the directories for prometheus
echo "Building homes for friends..."
sudo mkdir /etc/prometheus
sudo mkdir /var/lib/prometheus
sudo chown prometheus:prometheus /etc/prometheus
sudo chown prometheus:prometheus /var/lib/prometheus

#Download and install prometheus
#Check version, OS, and architectures in the download links to ensure they are the ones you need.
echo "Importing friends..."
curl -LO https://github.com/prometheus/prometheus/releases/download/v2.38.0/prometheus-2.38.0.linux-amd64.tar.gz
tar xvf ./prometheus-2.38.0.linux-amd64.tar.gz
sudo cp prometheus-2.38.0.linux-amd64/prometheus /usr/local/bin/
sudo cp prometheus-2.38.0.linux-amd64/promtool /usr/local/bin/
sudo chown prometheus:prometheus /usr/local/bin/prometheus
sudo chown prometheus:prometheus /usr/local/bin/promtool
sudo cp -r prometheus-2.38.0.linux-amd64/consoles /etc/prometheus
sudo cp -r prometheus-2.38.0.linux-amd64/console_libraries /etc/prometheus
sudo chown -R prometheus:prometheus /etc/prometheus/consoles
sudo chown -R prometheus:prometheus /etc/prometheus/console_libraries
rm -rf prometheus-2.38.0.linux-amd64.tar.gz prometheus-2.38.0.linux-amd64

#Download and install node exporter
echo "Importing friends..."
curl -LO https://github.com/prometheus/node_exporter/releases/download/v1.4.0/node_exporter-1.4.0.linux-amd64.tar.gz
tar xvf node_exporter-1.4.0.linux-amd64.tar.gz
sudo cp node_exporter-1.4.0.linux-amd64/node_exporter /usr/local/bin/
sudo chown node_exporter:node_exporter /usr/local/bin/node_exporter
rm -rf node_exporter-1.4.0.linux-amd64.tar.gz node_exporter-1.4.0.linux-amd64

#Now we’ll Create a custom node exporter service, the contents of the service will be pulled from the repo
echo "Configuring friends..."
curl https://raw.githubusercontent.com/cskujawa/jarvis-ai/main/system/node_exporter.service > node_exporter.service
sudo cp node_exporter.service /etc/systemd/system/node_exporter.service
rm node_exporter.service

#Now to allow all the containers to communicate (assuming you’ve blocked network traffic in various ways), we will ensure that the docker containers can freely communicate with eachother. Please note that the range used in the command b>echo "Permitting friend communication..."
sudo ufw allow proto tcp from 172.30.0.0/16

#Now we need to ensure docker communications is possible
echo "Enabling control..."
sudo ufw allow 7946/tcp
sudo ufw allow 7946/udp
sudo ufw allow 2377/tcp
sudo ufw allow 4789/udp
