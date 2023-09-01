# Yerin

🏡 Real Estate CMS for agencies to manage their property listings. It currently in its early stages; not production ready.

Current progress can be seen at https://trello.com/b/W0JvYAlr/yerin

> 📝 NOTE: Incremental migrations will start when v1.0.0 is released. Until then migration files will be modified.

| Screenshots |
| ----------- |
| <img src="./public/github/creating a property.png" alt="drawing" />|

## Table of contents

- [Requirements](#requirements)
- [Installation](#installation)

## Requirements

- php >= 8.1
- mysql
- composer (see http://getcomposer.org/download)

## Installation

1. Clone the repo

```
> git clone https://github.com/brainbarett/yerin
```

2. Install the project's dependencies(make sure you're in the project's directory when running the command)

```
> composer install
```

3. Create a `.env` file(based on `.env.example`) that reflects your environment(mostly the database credentials)

4. Run the database migrations and seeds

> ⚠️ WARNING: running this command will drop all tables from the specified database

```
> php artisan migrate:fresh --seed
```

5. Run the server

```
> php artisan serve
```

You can log in with email `admin@test.com` and password `password`
