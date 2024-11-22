<p align="center">
    <img src="https://avatars0.githubusercontent.com/u/8029934?v=3&s=200">
</p>

# Certificationy CLI

> This is the CLI tool to train on certifications.

**Note**: forked from https://github.com/certificationy/certificationy-cli, updated deps and switched to the maintained
questions by https://github.com/efficience-it.

## How it looks?

![Certificationy application](https://cloud.githubusercontent.com/assets/1247388/17698070/434e3944-63b9-11e6-80c6-91706dbbea50.png "Certificationy application")

## Installation and update

Clone the repository

```
$ git clone git@github.com:andrew-demb/certificationy-cli.git
$ cd certificationy-cli
```

### With Composer

```
$ composer install
$ php certificationy.php
```

### With Docker and Docker compose

#### Install the project prerequisites

The project has prerequisites:

- [Docker][docker] (1.12+)
- [Docker compose][docker compose] (2.0+)
- [GNU make][make]

To install Docker, refer to the official documentation for your operating system: https://docs.docker.com/install/.

Once Docker installed, to check its smooth running, run `docker -v`, you should get something like suit:

```
$ docker -v
Docker version 1.12.4, build 1564f02
```
> You must use the minimum version 1.12 of Docker.

To install the docker compose, please also refer to the official documentation: https://docs.docker.com/compose/install/.

Once docker compose installed (install it globally to be able and access from anywhere), to check its proper functioning, run `docker compose version`, you should get something like this:

```
$ docker compose version
Docker Compose version v2.29.7
```

> You must use the docker-compose version 2.0 minimum.

A makefile allows you to manipulate the container simply and easily.
You have to be able to run `make -v`, which you are ready to choose:

```
$ make -v
GNU Make 4.1
Built for x86_64-pc-linux-gnu
Copyright (C) 1988-2014 Free Software Foundation, Inc.
GPLv3 + license: GNU GPL version 3 or later <http://gnu.org/licenses/gpl.html>
This is free software: you are allowed to modify and redistribute.
There is NO WARRANTY, to the extent of the will of the law.
```

> **Note**: If you are using Windows, we strongly recommend that you use the Linux console included in
> Windows 10 (https://docs.microsoft.com/en-us/windows/wsl/install-win10) or to use an emulator for
> Command to be able to use `make` which will greatly facilitate the work.

#### Using the Container

You should then be able to run `make` which will show you using the Makefile:

```
$ make
start:           Start the project
bash:            Go to the bash container of the application
stop:            Stop docker containers
```

Start the application with `make start`:

```
$ make start
docker compose build
[+] Building 1.6s (15/15) FINISHED                                                                                                                                                                                     docker:default
 => [app internal] load build definition from Dockerfile                                                                                                                                                                         0.0s
 => => transferring dockerfile: 765B                                                                                                                                                                                             0.0s
 => [app internal] load metadata for docker.io/library/php:8.3-fpm-alpine                                                                                                                                                        1.5s
 => [app internal] load .dockerignore                                                                                                                                                                                            0.0s
 => => transferring context: 2B                                                                                                                                                                                                  0.0s
 => [app 1/9] FROM docker.io/library/php:8.3-fpm-alpine@sha256:17fa7702b3d48eb0c064e3410474c81f703b3bcb7a7fe8073503e6c7f157a29a                                                                                                  0.0s
 => [app internal] load build context                                                                                                                                                                                            0.0s
 => => transferring context: 56B                                                                                                                                                                                                 0.0s
 => CACHED [app 2/9] RUN apk add --no-cache --virtual .persistent-deps         bash   git   icu-libs    zlib    wget   ca-certificates   curl   libzip-dev                                                                       0.0s
 => CACHED [app 3/9] RUN set -xe  && apk add --no-cache --virtual .build-deps   autoconf   dpkg-dev dpkg   file   g++   gcc   libc-dev   make   pkgconf   re2c   icu-dev   zlib-dev  && docker-php-ext-install   intl   zip  &&  0.0s
 => CACHED [app 4/9] WORKDIR /app                                                                                                                                                                                                0.0s
 => CACHED [app 5/9] COPY php.ini /usr/local/etc/php/php.ini                                                                                                                                                                     0.0s
 => CACHED [app 6/9] RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer                                                                                                    0.0s
 => CACHED [app 7/9] RUN composer clear-cache                                                                                                                                                                                    0.0s
 => CACHED [app 8/9] COPY start.sh /usr/local/bin/docker-app-start                                                                                                                                                               0.0s
 => CACHED [app 9/9] RUN chmod +x /usr/local/bin/docker-app-start                                                                                                                                                                0.0s
 => [app] exporting to image                                                                                                                                                                                                     0.0s
 => => exporting layers                                                                                                                                                                                                          0.0s
 => => writing image sha256:1b4cb9b355aa5911d051151e259fe2961b6a41787d47ea3062bac9ee60531c6c                                                                                                                                     0.0s
 => => naming to docker.io/library/certificationy-cli-app                                                                                                                                                                        0.0s
 => [app] resolving provenance for metadata file                                                                                                                                                                                 0.0s
docker compose up -d
[+] Running 2/2
 ✔ Network certificationy-cli_default  Created                                                                                                                                                                                   0.1s 
 ✔ Container certificationy-cli-app-1  Started                                                                                                                                                                                   0.4s 
0967b159a4a3:/app# 
```

Once the procedure is complete you can already use the bash of the container.

Run Certificationy CLI;

```
$ php certificationy.php
```

To exit bash docker

```
$ exit
```

Stop the application with `make stop`:

```
$ make stop 
docker compose kill
[+] Killing 1/1
 ✔ Container certificationy-cli-app-1  Killed
```


### Runing it through docker compose

#### Start the container

Start it in daemon mode.

```bash
docker compose up -d
```

#### Run certificationy

Execute this instruction or whatever certificationy you want.

```bash
docker exec -it certificationy-cli-app-1 /bin/bash -c "php certificationy.php start --training"
```

#### Stop the container

```bash
docker compose down
```

## More run options

### Select the number of questions

```
$ php certificationy.php start --number=10
```

The default value is 20.

### List categories

```
$ php certificationy.php start --list [-l]
```

Will list all the categories available.

### Only questions from certain categories

```
$ php certificationy.php start "Automated tests" "Bundles"
```

Will only get the questions from the categories "Automated tests" and "Bundles".

Use the category list from [List categories](#list-categories).

### Hide the information that questions are/aren't multiple choice

```
$ php certificationy.php start --hide-multiple-choice
```

As default, the information will be displayed.

![Multiple choice](https://cloud.githubusercontent.com/assets/795661/3308225/721b5324-f679-11e3-8d9d-62ba32cd8e32.png "Multiple choice")

### Training mode: the solution is displayed after each question

```
$ php certificationy.php start --training
```

### Set custom configuration file

```
$ bin/certificationy start --config=../config.yml
```

Will set custom config file.

### And all combined

```
$ php certificationy.php start --number=5 --hide-multiple-choice "Automated tests" "Bundles"
```

* 5 questions
* We will hide the information that questions are/aren't multiple choice
* Only get questions from category "Automated tests" and "Bundles"

> Note: if you pass `--list [-l]` then you will ONLY get the category list, regarding your other settings.

[docker]: https://www.docker.com
[docker compose]: https://docs.docker.com/compose/install/
[make]: https://www.gnu.org/software/make/
