# About Shop project
The Shop project is an online store for online trading and is created on the [Laravel](https://laravel.com/)  framework.

# Demo
Open the url in the browser: [https://shop.vi1.ru](https://shop.vi1.ru)
#### Log in:
* Email: noreply@vi1.ru
* Password: password

# Screenshots
![Screenshot of messenger.](https://vi1.ru/imgDemo/shop.gif)
![Screenshot of messenger.](https://vi1.ru/imgDemo/shop.png)

# Setup

### Deploy Docker container
This describes how to install the Shop project in a docker container.

1. Git clone, create and edit configuration files:
    ```bash
    git clone https://github.com/aluxins/shop
    cd shop
    cp .env.example .env
    ```
    Configure: 
   * Environment variables - .env
   * Compose file - docker-compose.yml
   * Server files in the folder /dockerfiles

2. Build container:
    ```bash
    docker-compose up -d --build app
    ```

3. Composer install:
    ```bash
    docker-compose run --rm composer install --optimize-autoloader --no-dev
    ```

4. Run the configuration commands:
    ```bash
    docker-compose run --rm artisan key:generate
    docker-compose run --rm artisan storage:link
    ```

5. DataBase: migrate and seed:
    ```bash
    docker-compose run --rm artisan migrate
    docker-compose run --rm artisan db:seed
   ```
   Upload demo-data and files:
    ```bash
    docker-compose run --rm artisan db:seed --class=StoreDemoSeeder
    ```

6. Optimization:
    ```bash
    docker-compose run --rm artisan config:cache
    docker-compose run --rm artisan route:cache
    docker-compose run --rm artisan view:cache
    ```

7. Build npm:
    ```bash
    docker-compose run --rm npm install
    docker-compose run --rm npm run build
    ```

8. Running the Queue Worker:
    ```bash
    docker-compose run -d queue
    ```

Next open the website [localhost:80](http://localhost:80) (or according to the .env file) in your browser.
Log in to the administrator account using the email specified in the MAIL_FROM_ADDRESS parameter of the .env file.

#### Example: 
* Email: admin@laravel.com
* Password: password

If you use HTTPS, uncomment the lines in the file dockerfiles/nginx/default.conf:
```
# fastcgi_param REQUEST_SCHEME    https;
# fastcgi_param HTTPS             On;
```

### Configure NGINX as a reverse proxy
This example configure the NGINX server as a reverse proxy.

#### Example:
```
server {
    listen 443 ssl; # For HTTPS
    # listen 80; # For HTTP
    server_name example.com www.example.com;

    # Add SSL certificates for HTTPS
    # ssl_certificate
    # ssl_certificate_key

    location / {
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Host $host;
        proxy_set_header X-Forwarded-Proto $scheme;
        proxy_pass http://127.0.0.1:80;
    }
}
```

# Feedback / Questions

If you have any questions about this project, please contact aluxins@gmail.com.

# License

The Shop project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
