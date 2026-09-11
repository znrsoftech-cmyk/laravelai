# 🚀 Laravel 13 AI Agent with Gemini API

A complete Laravel 13 AI Agent project using Gemini API, Laravel AI SDK, Tools, Memory, Streaming Chat, Product Search, and Docker setup.

---

## ✨ Features

- Laravel 13 AI SDK
- Gemini API Integration
- AI Agent with Tools
- Product Search from Database
- Conversation Memory
- Streaming Chat
- Follow-up Question Memory Fix
- Docker Support
- MySQL Database
- Nginx Setup

---

## 🛠 Tech Stack

- Laravel 13
- PHP
- MySQL
- Laravel AI SDK
- Gemini API
- Docker
- Docker Compose
- Nginx

---

## 📦 Installation

You can run this project in two ways:

1. Using Docker
2. Manual Laravel setup

---

# 🐳 Run with Docker

## 1. Clone the Repository

```bash
git clone https://github.com/ajayyadavexpo/laravel-13-ai-agent.git
cd your-repository
````

## 2. Setup Environment File

```bash
cp .env.docker .env
```

Update your Gemini API key inside `.env`:

```env
GEMINI_API_KEY=your_gemini_api_key_here
```

## 3. Start Docker Containers

```bash
docker-compose up -d
```

## 4. Run Migrations and Seeders

```bash
docker-compose exec app php artisan migrate --seed
```

## 5. Generate App Key

```bash
docker-compose exec app php artisan key:generate
```

## 6. Clear Config Cache

```bash
docker-compose exec app php artisan config:clear
```

---

# ⚙️ Useful Docker Commands

## Stop Containers

```bash
docker-compose down
```

## Rebuild Containers

```bash
docker-compose up -d --build
```

## View Logs

```bash
docker-compose logs -f
```

## Enter App Container

```bash
docker-compose exec app bash
```

## Run Artisan Command

```bash
docker-compose exec app php artisan
```

---

# 🧑‍💻 Manual Setup

## 1. Install PHP Dependencies

```bash
composer install
```

## 2. Setup Environment

```bash
cp .env.example .env
```

Add your Gemini API key:

```env
GEMINI_API_KEY=your_gemini_api_key_here
```

## 3. Generate App Key

```bash
php artisan key:generate
```

## 4. Run Migrations and Seeders

```bash
php artisan migrate --seed
```

## 5. Start Laravel Server

```bash
php artisan serve
```

---

# 🤖 AI Agent

This project includes a Product AI Agent that can understand user queries and search products from the database.

Example prompts:

```txt
Show me laptops
```

```txt
Show phones under 50000
```

```txt
Which one is cheapest?
```

---

# 🔧 AI Tool

The project includes a `SearchProducts` tool.

The tool can:

* Search products by name
* Search by category
* Filter by price
* Check stock
* Return real database results

---

# 🧠 Conversation Memory

The AI Agent remembers previous conversation context.

Example:

User:

```txt
Show me laptops
```

Agent returns laptop products.

User:

```txt
Which one is cheapest?
```

Agent understands the previous laptop list and returns the cheapest laptop.

---

# ⚡ Streaming Chat

This project supports real-time streaming chat responses, giving a ChatGPT-like experience inside Laravel.

---

# 🛑 Streaming Memory Fix

In streaming chat, follow-up questions can lose context if the conversation ID is not reused.

This project fixes that by:

* Storing conversation ID in session
* Reusing previous conversation
* Continuing the same AI conversation
* Preserving context for follow-up questions

---

# 📁 Project Structure

```txt
app/
 ├── Ai/
 │   ├── Agents/
 │   │   └── ProductAgent.php
 │   └── Tools/
 │       └── SearchProducts.php
 │
 ├── Models/
 │   └── Product.php

database/
 ├── migrations/
 └── seeders/

nginx/
Dockerfile
docker-compose.yml
docker-entrypoint.sh
.env.docker
```

---

# 🎥 YouTube Tutorial

A complete Hindi tutorial is available for this project.

Video includes:

* Laravel 13 AI SDK setup
* Gemini API setup
* AI Agent creation
* Tool creation
* Product search
* Conversation memory
* Streaming chat
* Docker setup

Add your video link here:

```txt
https://youtu.be/guw7_jNN4VA
```

---

# 🚀 Real Use Cases

You can use this project as a base for:

* E-commerce AI Assistant
* Product Recommendation Bot
* Customer Support AI
* Inventory Assistant
* CRM AI Agent
* Order Tracking Bot
* Admin Dashboard AI

---

# 📌 Common Commands

```bash
docker-compose up -d
```

```bash
docker-compose exec app php artisan migrate --seed
```

```bash
docker-compose exec app php artisan config:clear
```

```bash
docker-compose down
```

---

# 🤝 Contributing

Pull requests are welcome.

If you want to improve this project, fork the repository and submit a pull request.

---

# ⭐ Support

If this project helped you:

* Star this repository
* Like the YouTube video
* Subscribe to the channel

---

# 📄 License

This project is open-source and available under the MIT License.

---

# 🙌 Credits

Built with ❤️ using Laravel 13, Laravel AI SDK, Gemini API, and Docker.

```
