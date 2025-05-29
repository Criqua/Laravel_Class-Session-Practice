# Laravel_Class-Session-Practice

A Laravel web application developed as part of a collaborative academic practice for the Web Design & E-Commerce course. It implements a MVC architecture with Eloquent ORM, Blade views, including a SMTP-based email reporting functionality. Users can create, view, update and delete **cities** and **citizens**, as well as import/export records in **CSV** and **XLS** formats and generate **PDFs**.

---

## Team & Responsibilities

- **[Cristian Gago](https://github.com/Criqua):**
  Implemented and refactored all controller logic *(CRUD, import/export, PDF)*.

- **[Daniel Osorio](https://github.com/Draxton27):**
   Added import/export logic and UI elements to existing Blade views *(file inputs, buttons, links)*.

- **[Manuel López](https://github.com/ElVatoEste):**
  Configured and tested package integrations for **maatwebsite/excel** and **barryvdh/laravel-dompdf**.
  
---

## Quick Setup

> **Requirements:** PHP 8.4.x, Composer, Node.js & NPM, and a supported database.
>
> If you're sure you fulfill those requirements, then execute the following commands in your terminal:

	git clone https://github.com/Criqua/Laravel_Class-Session-Practice.git
	cd Laravel_Class-Session-Practice
	composer install
	cp .env.example .env
	php artisan key:generate

> Additionaly, configure your `.env` to set up you email with Gmail using SMTP with your own credentials. Afterwards, continue with:

	php artisan migrate
	npm install
	npm run build
	php artisan serve

> **Note**: All Excel/PDF packages (**maatwebsite/excel** & **barryvdh/laravel-dompdf**) are already pre-configured—no extra ****vendor:publish*** or package-specific commands needed.

---

*Now you´re good to go. Enjoy!*
