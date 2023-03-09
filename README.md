# links

## Установка локально (dev)

**Клонировать:**
```bash
git clone git@github.com:ats/links.git
```

**Перейти в директорию:**
```bash
cd ./links
```

**Установить зависимости:**
```bash
 docker run --rm  -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php81-composer:latest composer install --no-cache
```

**Можно создать алиас для sail:**
```bash
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

**Скопировать .env.example **
```bash
cp .env.example .env
```

**Поднять докер контейнеры:**
```bash
./vendor/bin/sail up -d
```

**Выполнить миграции**
```bash
./vendor/bin/sail artisan migrate --seed
```

**Во время разработки можно выполнять тесты**
```bash
./vendor/bin/sail test
```

**API будет доступно по адресу [localhost:81](http://localhost:81)**

**Для выполнения команд Laravel внутри контейнера можно использовать laravel/sail**
```bash
./vendor/bin/sail composer install
./vendor/bin/sail composer require ...
./vendor/bin/sail artisan ...
```
**Документация по sail https://laravel.com/docs/8.x/sail**

## Установка на сервер (test, stage, prod)

**Клонировать:**
```bash
git clone git@github.com:hashkeeperok/links.git
```

**Перейти в директорию:**
```bash
cd ./links
```

**Установить зависимости:**
```bash
composer install --no-dev
```

**Скопировать .env файл из примера:**
```bash
cp .env.example .env
```

**Прописать актуальные подключения к БД и другие параметры в .env**

**Сконфигурировать Apache или Nginx:**
Directory root: ./public
пример конфигурации для nginx
```
charset utf-8;
location / {
  if (!-e $request_filename){
    rewrite ^(.*)$ /index.php break;
  }
}
```
