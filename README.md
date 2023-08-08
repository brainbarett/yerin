🏡 Real Estate CMS where agencies can manage their property listings. It currently in its early stages; not production ready.

Current progress can be seen at https://trello.com/b/W0JvYAlr/yerin

## Requirements

- php >= 8.1
- mysql
- composer (see http://getcomposer.org/download)

## Installation

1. Clone the repo

```
> git clone https://github.com/brainbarett/yerin
```

2. Install all the dependencies(make sure you're in the project's directory when running the command)

```
> composer install
```

3. Create a `.env` file(based on `.env.example`) that reflects your environment(mostly the database credentials)

4. Run the database migrations

```
> php artisan migrate
```

5. Run the server

```
> php artisan serve
```
