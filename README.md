🏡 Real Estate CMS where agencies can manage their property listings. It currently in its early stages; not production ready.

Current progress can be seen at https://trello.com/b/W0JvYAlr/yerin

## Requirements

- php >= 8.1
- mysql

## Installation

1. Clone the repo

```
> git clone https://github.com/brainbarett/yerin
```

2. Install Composer (see http://getcomposer.org/download)

3. Enter the project's directory and install all the dependencies

```
> cd yerin
> composer install
```

4. Make a copy of the `.env.example` file and name it `.env`. Update the values in `.env` to reflect your environment(mostly database credentials)

5. Run the database migrations

```
> php artisan migrate
```

6. Run the server

```
> php artisan serve
```
