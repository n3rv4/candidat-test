# BT Blog

## Introduction

The purpose of this repo is to provide a simple blog of typical candidat test
project based on PHP and Symfony.

We use Auto Certificate server web server (Caddy). In order for you environment
to trust this certificate, we use mkcert to generate certificates locally.

## Requirements

- [Docker](https://www.docker.com)
- Make
- Mkcert

## Version used

- Caddy: latest
- php-fpm:
    - Php 8.2
      - Apcu
      - Opcache
      - Intl, Zip, mcrypt, mbstring, xdebug PHP Extension
- Symfony: 6.2

You can add PHP extension in `devops/php/Dockerfile`

## Install

Change `SERVER_NAME` in .env file according to your needs.

Add SERVER_NAME value in `/etc/hosts` in order to match your docker daemon
machine IP or use a tool like `dnsmasq` to map the daemon to a local tld
(e.g. `.docker`).

Juste run the following command: `make install`
