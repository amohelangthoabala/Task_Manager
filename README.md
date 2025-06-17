# 🧾 Project Setup & API Usage Guide

This guide outlines how to set up and use the application in both development and production environments using Docker, and how to interact with the API.


## 🚀 Cloning & Setup

### 1. Clone the Repository

git clone https://github.com/amohelangthoabala/Task_Manager.git
cd Task_Manager

### 2. Prerequisites

Make sure the following are installed:

* [Docker](https://www.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/)


## ⚙️ Environment Setup

### 3. Copy Environment Configuration

cp .env.example .env

### 4. Start Docker Services

#### For Development

docker compose -f compose.dev.yaml up -d

#### For Production

docker compose -f compose.prod.yaml up -d

## 📦 Installing Dependencies

### 5. Access the Workspace Container

docker compose -f compose.dev.yaml exec workspace bash

### 6. Install Composer and NPM Dependencies

composer install
npm install
npm run dev

## 🛠️ Running Migrations

docker compose -f compose.dev.yaml exec workspace php artisan migrate

## 📘 API Documentation

* Visit: [http://localhost/docs](http://localhost/docs)
* Or use in Postman: `http://localhost/api/{endpoint}`


## 🔐 Authentication

1. Register or log in via the API.
2. Use the received token in your request headers:

Authorization: Bearer {token}

## ✅ Task Management

- Two ways to use the API, use Endpoint or API documentation
- API docs work like postman but on the browser, you just visit localhost/api

### Create a Task

* **Method:** `POST`
* **Endpoint:** `/api/tasks`
* **Required Field:** `assigned_to` – Pass a valid `user_id`

### Update Task Status

* **Method:** `PUT`
* **Endpoint:** `/api/tasks/{id}`

Update the `status` field as needed in your request body.

## If DOcker is not working Here is and alternative
## ⚙ Laravel Flow (Manual Setup)


To install **Laravel** on your local machine, make sure you have:

- [PHP 8.1 or higher](https://www.php.net/downloads/)  
- [Composer](https://getcomposer.org/) 

cd task_manager

composer install
php artisan serve
