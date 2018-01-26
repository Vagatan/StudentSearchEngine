Students Search Engine
======================

Symfony project. Simple students search engine.

Symfony 3.2.2
PHP 7.1

Setting up
---------------

Using SSH
```git clone git@github.com:Vagatan/StudentSearchEngine.git```

Using HTTPS
```git clone https://github.com/Vagatan/StudentSearchEngine.git```

```cd students_search_engine```

Create app/config/paramaters.yml from app/config/parameters.yml.dist file

Run ```docker-compose up -d```

Enter container running ```docker exec -it student-search bash```

In container run ```composer update```

Run ```bin/console server:run 0.0.0.0:8000```

Populate database with data from students_search_engine.sql

Accessing the app
----------------

   http://localhost:8000/app_dev.php/

Accessing the phpMyAdmin
----------------

   http://localhost:9000/
