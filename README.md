Perfect — here's the full **Markdown** content only, ready for you to paste into your existing README or another doc:

````markdown
# 🧾 Project Setup & API Usage Guide

This guide outlines how to set up and use the application in both development and production environments using Docker, and how to interact with the API.

---

## 🚀 Cloning & Setup

### 1. Clone the Repository

```bash
git clone https://your-repo-url.git
cd your-repo-directory
````

### 2. Prerequisites

Make sure the following are installed:

* [Docker](https://www.docker.com/)
* [Docker Compose](https://docs.docker.com/compose/)

---

## ⚙️ Environment Setup

### 3. Copy Environment Configuration

```bash
cp .env.example .env
```

### 4. Start Docker Services

#### For Development

```bash
docker compose -f compose.dev.yaml up -d
```

#### For Production

```bash
docker compose -f compose.prod.yaml up -d
```

---

## 📦 Installing Dependencies

### 5. Access the Workspace Container

```bash
docker compose -f compose.dev.yaml exec workspace bash
```

### 6. Install Composer and NPM Dependencies

```bash
composer install
npm install
npm run dev
```

---

## 🛠️ Running Migrations

```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```

---

## 📘 API Documentation

* Visit: [http://localhost/docs](http://localhost/docs)
* Or use in Postman: `http://localhost/api/{endpoint}`

---

## 🔐 Authentication

1. Register or log in via the API.
2. Use the received token in your request headers:

```
Authorization: Bearer {token}
```

---

## ✅ Task Management

### Create a Task

* **Method:** `POST`
* **Endpoint:** `/api/tasks`
* **Required Field:** `assigned_to` – Pass a valid `user_id`

### Update Task Status

* **Method:** `PUT`
* **Endpoint:** `/api/tasks/{id}`

Update the `status` field as needed in your request body.

```

Let me know if you also want a badge section (e.g., Laravel version, PHP version, etc.) or install instructions without Docker for alternative environments.
```
