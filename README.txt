Този архив съдържа следната структура:

-README.txt - този файл
-Web_Archive папка - съдържа кода на приложението
	-views:
		-archives.php
		-changeUserRole.php
		-createArchive.php
		-deleteArchive.php
		-index.php
		-login.php
		-register.php
		-search.php
	-js:
		-archive.js
		-changeUserRole.js
		-createArchive.js
		-login.js
		-register.js
		-search.js
		-slider.js - плъзгащите се снимки в началната страница
		-fileGenerator.js - скрипт за работа с PhantomJS
	-css:
		-style.css
	-controllers:
		-archives.php
		-changeUserRole.php
		-createArchive.php
		-database.php - основните характеристики на базата
		-deleteArchive.php
		-initializeDb.php - създаване и популиране на базата
		-loadArchive.php - зареждане на архив при натискане върху линка му
		-login.php
		-logout.php - излизане на потребител от профила му в системата
		-register.php
		-search.php
		-useDatabase.php - използване на базата в останалите контролери
	-database - съдържа складираните архиви
	-data - съдържа примерните архиви от началната страница
	-images - съдържа снимките на примерните архиви от началната страница
	-phantomjs-2.1.1-windows - съдържа инструментите PhantomJS и wget

-62332_62363_project_final.docx - документация на проекта

За да стартирате приложението пуснете XAMPP. Стартирайте Apache и MySql. След това навигирайте до линка: localhost/Web_Archive/controllers/initializeDb.php - така ще създадете базата и популирате с примерните потребители.


Договорени изисквания: създаване на уеб архив като html, pdf, png, използване на различни инструменти - wget, PhantomJS, др., разглеждане на създадените архиви като календар или списък, публични и скрити архиви, споделяне на архиви

Изпълнени изисквания: всичко без споденяне на архиви


------ Направени поправки по кода:

-Изнесен SQL-а за създаване на базата и популиране на таблиците в отделен SQL файл.
-Променени имената на константите, така че да вървят на по-стара версия на PHP.
-controllers/initializeDb.php не redirect-ва при грешка, а остава на страницата и изписва грешката