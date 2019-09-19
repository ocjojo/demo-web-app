# Thesis

This repository contains the project I created for my bachelor's thesis "Secure and simple online authentication: Evaluating modern authentication schemes in a web application"

## Setup

1. clone the repo
2. run [`docker-compose up`](https://docs.docker.com/compose/)
3. Login to docker: `docker-compose exec -uthesis web bash`
   1. run `npm install`
   2. run `npm run dev`
4. edit `/etc/hosts` to contain `127.0.0.7 thesis.local`
5. visit [http://thesis.local/](http://thesis.local/)


## Project

For the password login user "devs" with password "demo" is predefined.

Google Sign-In is done with live credentials, not with test accounts.


----

This project is based on the [symfony/website-skeleton](https://github.com/symfony/website-skeleton).
