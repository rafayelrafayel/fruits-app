# Fruits Web Application
This is a web application built with Symfony 6 and Vue.js for managing fruits.

# Installation
1. Clone the repository: git clone https://github.com/rafayelrafayel/fruits-app.git
2. Install backend dependencies: composer install
3. Install frontend dependencies: npm install
4. Create a MySQL database with name fruits_db
5. Update the DATABASE_URL with your MySQL credentials in  .env
6. Run database migrations: php bin/console doctrine:migrations:migrate
7. Run the following command to install the Messenger bundle configuration:
  php  bin/console messenger:setup-transports
8. Run the following command to create the Messenger table:
  php bin/console messenger:setup-transports
9. Start the development server: symfony server:start
10. Run Webpack Encore to compile the assets: npm run watch
11. Access the web application at http://localhost:8000
# Features
1. Fetch fruits from external API and save them to the local database
2. Filter and paginate fruits
3. Add fruits to favorites (up to 10 fruits)
4. Display the sum of nutrition facts of all favorite fruits
5. Send email notification after fruits are saved to the database
# Commands
php bin/console fruits:fetch - fetches fruits from external API and saves them to the local database
# API Endpoints
GET /api/fruits - retrieves fruits with pagination and filtering

# Technologies Used
Symfony 6 \
Vue.js \
MySQL 


