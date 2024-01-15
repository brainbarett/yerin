# Yerin

🏡 Real Estate CMS for agencies to manage their property listings. It's currently in its early stages; not production ready.

> 📝 NOTE: Incremental migrations will start when v1.0.0 is released. Until then migration files will be modified.

| Screenshots                                                         |
| ------------------------------------------------------------------- |
| <img src="./public/github/creating a property.png" alt="drawing" /> |

## Table of contents

-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Tests](#tests)
-   [Roadmap](#roadmap)

## Requirements

-   php >= 8.1
-   mysql >= 5.7
-   composer (see http://getcomposer.org/download)

## Installation

1. Clone the repo

```
> git clone https://github.com/brainbarett/yerin
```

2. Install the project's dependencies(make sure you're in the project's directory when running the command)

```
> composer install
```

3. Modify the auto-generated `.env` file to reflect your environment(mostly the database credentials)

4. Run the database migrations and seeds

> ⚠️ WARNING: running this command will drop all tables from the specified database

```
> php artisan migrate:fresh --seed --seeder=DemoSeeder
```

5. Run the server

```
> php artisan serve
```

You can log in with email `admin@test.com` and password `password`

## Tests

Update your `phpunit.xml` file and set the `DB_DATABASE` value to your testing database

You can then run all the tests with

```
> vendor\bin\phpunit
```

## Roadmap

-   v1.0.0

    -   ✅ Account management

        -   ✅ Create and modify accounts
        -   ✅ Authentication
        -   ✅ Manage and assign roles & permissions

    -   ✅ Property management

        -   ✅ Create and modify properties
        -   ✅ Manage and assign property amenities
        -   ✅ Images
        -   ✅ Geographical locations

    -   ✅ UI translations

    -   ⬜️ Live demo

-   Backlog

    -   ⬜️ Account management

        -   ⬜️ Manage and assign tasks

    -   ⬜️ Property management

        -   ⬜️ Manage and use dynamic property types
        -   Manage and use dynamic property fields
        -   ⬜️ Manage and schedule tours
        -   ⬜️ Make use of the tasks system
        -   ⬜️ Manage and add notes
        -   ⬜️ Manage and upload attachments
