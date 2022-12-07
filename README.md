<div align="center">
  <p align="center">
    <a href="https://github.com/othneildrew/Best-README-Template/issues">Report Bug</a>
    ·
    <a href="https://github.com/othneildrew/Best-README-Template/issues">Request Feature</a>
  </p>
</div>

 <img src="https://github.com/cskujawa/rasa-assistant/blob/main/rasa-assistant-2.png" name="chat">
<details>
  <summary>More Examples</summary>
  <img src="https://github.com/cskujawa/rasa-assistant/blob/main/rasa-assistant-1.png" name="login">
  <img src="https://github.com/cskujawa/rasa-assistant/blob/main/rasa-assistant-3.png" name="home-assistant">
  <img src="https://github.com/cskujawa/rasa-assistant/blob/main/rasa-assistant-4.png" name="postgres-viewer">
</details>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
  </ol>
</details>


<!-- ABOUT THE PROJECT -->
## About The Project
This is a ultra-minimal implementation of a dev environment for working with Rasa's NLU and interacting with HomeAssistant.

The application uses Laravel for the front-end and an API server. In the interface you can view the chat window to interact with the Rasa chat bot, view the Postgres database Rasa logs to, and interact with the HomeAssistant interface. 

The Postgres web interface container credit goes to:
https://github.com/sosedoff/pgweb

<p align="right">(<a href="#top">back to top</a>)</p>


### Built With

* [![Laravel][Laravel.com]][Laravel-url]
* [![MySQL][Mysql.com]][Mysql-url]
* [![NGINX][NGINX.com]][Nginx-url]
* <a href="Rasa.com">Rasa.com</a>
* <a href="Home-Assistant.io">Home-Assistant.io</a>

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

This is a standalone environment that runs on Docker Compose. None of the containerized apps require any dependencies to be pre-installed or exist on the host OS. That all being said, if you have Docker Compose you should be able to clone or fork this repo, change to the project directory, fill in the .env file, and replace any instances of 192.168.0.161 with your servers URL. That should then be up and running.

### Prerequisites

* <a href="https://docs.docker.com/compose/">Docker-Compose</a>

### Installation

1. Clone the repo
   ```sh
   gh repo clone cskujawa/rasa-assistant
   ```
2. Change to project directory
   ```sh
   cd rasa-assistant
   ```
3. Copy or create the environment file
* You will need to update the variables in the /.env file and /interface/laravel/.env files
* The /.env file requires a username, UID, MySQL database, password, and password, a Postgres user and password, and a HomeAssistant token, all of which can be created or assigned from within this app itself
4. Build the project
   ```sh
   docker-compose build app –-no-cache
   ```
5. Start up the containers
   ```sh
   docker-compose up -d --force-recreate
   ```
10. Visit the site, navigate to the IP address where the server is running with /register appended to the end.
   
<p align="right">(<a href="#top">back to top</a>)</p>

### Setup/Use

1. Once you've visited your server, you should be able to register
2. You will be redirected to the login page
3. After logging in you should be taken to the Chat page, here you can interact with the basic Rasa chatbot
4. Saying something like "Turn on the bedroom lights" will attempt to interact with a corresponding device in HomeAssistant
5. If you go to the HomeAssistant option in the Tools drop-down you will be able to sign in using Admin/admin, to create a new user you can delete the contents of the home-assistant directory and restart the application, then navigate to youserverip:8123
6. After interacting with the Rasa chatbot you can view the events logged by Rasa in the Postgres Viewer under the Tools menu

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->

[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Mysql.com]: https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white
[Mysql-url]: https://mysql.com
[NGINX.com]: https://img.shields.io/badge/nginx-%23009639.svg?style=for-the-badge&logo=nginx&logoColor=white
[Nginx-url]: https://nginx.com
