# Setting up Development Environment

The environment setup below is run on a virtualised ubuntu18.04 server 64bit version with a setup additional non root user with sudo privileges. This documentation assumes that the VM is already set up and running and has a connected network. The source code is going to be placed in the following directory `/var/data/TheReview`. To make sync easier add your ssh key to authorized_keys file. 

## Steps
### Step 1
Install docker
```cmd
$ sudo curl -sS https://get.docker.com/ | sh
```

### Step 2
Start docker on system start
```cmd
$ sudo systemctl enable docker
```

### Step 3
Add Docker group and add your user to docker group
```cmd
$ sudo groupadd docker
$ sudo usermod -aG docker $USER
```

### Step 4
Install Docker Compose
```
$ sudo -i
$ curl -L https://github.com/docker/compose/releases/download/1.25.5/docker-compose-Linux-x86_64-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
$ chmod +x /usr/local/bin/docker-compose
```

### Step 5
Configure Docker Compose
create a folder called scripts and dev scripts using the following command
Before running the command make sure you are running as your user 
```cmd
$ ctrl + d
$ mkdir -p ~/scripts/devScripts; cd scripts/devScripts;
```
Now place the `docker-compose.yml` file in here located in this repository `Documents/Development/docker-compose.yml`

### Step 6
Create the following folder and give it ownership to your user. Make sure you are logged in with your user and not root (unless you are working as root).
```cmd
$ sudo mkdir /var/data
$ sudo chown $USER:$USER /var/data/
$ mkdir /var/data/mariaDBData
```

### Step 7
Clone the source from the repository to /var/data/TheReview
```cmd
$ git clone git@github.com:theReview/TheReviewApi.git TheReview
```

### Step 8
Run Docker Compose
```cmd
$ docker-compose up -d
```