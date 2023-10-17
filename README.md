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

# Applicant test

## Purpose

Test candidate aptitute for a job.

## Needs

Computer with Git, Docker, Make and Mkcert installed.

## How to run

- Ask git administrator to add your alias to the repository.
- Clone this repository git@github.com:n3rv4/candidat-test.git and follow Readme.

## Test

Once you have the project running, you will have to complete the following tasks:

- Create a new branch from master.
- Create a entity comments with following fields:
    - id: int
    - content: text
    - created_at: datetime
- Create a comments controller
- Create a CRUD controller in easy admin and set correct field type
- Add a comments menu in admin dashboard
- Remove new comment button in comments list
- Link user entity to comments with a relation
- Create a comment form type
- Add comment form to article show page

- Extra option: Add tests

## Rules

- Create a first PR in draft with nothing
- Commits must be atomic and have a clear message
- One PR per task
