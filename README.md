# Symfony Test - S'ence Group 

Hi folks! 

There are some way to try and install my application on you PC, then
carry on in reading!

### Minimum requirements:

| Software | Version |
| -------- | --------|
| Database MariaDB (you can use also XAMPP or MAMP and just start the Database service) | 10.1.31 |
| PHP7 | 7.0.0 |
| Composer | 1.6.3 |

### Installation

Download the repository wherever you want;

**Create a database** on you local PC;
 
Open your terminal(shell)
and **go inside of root directory's project** and digit as a follow:

```sh
$ cp .env.dist .env
```
or duplicate the file '.env.dist' and rename it '.env'

- Open the file **.env**

- Find this line
```sh
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
```
and set your database configuration parameters, an example below:
```sh
DATABASE_URL=mysql://root:''@127.0.0.1:3306/sence_test_db
```

Re-open the terminal in root project's directory and lunch these command.

```sh
$ composer install
$ composer require server --dev
$ php bin/console doctrine:migrations:migrate
$ php bin/console server:run
```

If is it totaly ok, you could see in shell

```sh
[OK] Server listening on http://127.0.0.1:8000  
```
the number **:8000** could be different

now open your web browser at link and enjoy! I wish 
