# Event_Management_System

An event management system to invite people for different events/parties through phpmailer and show a message in the website if the user has registered in the system.

>PHPMailer used for sending invites.
>
>[PhpMailer-Github](https://github.com/PHPMailer/PHPMailer)

## Creating the database

>MYSql is used through phpmyadmin(localhost).

### Creating resgister table 

```
CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  username varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(100) NOT NULL
);
```

### Creating events table

```
CREATE TABLE events (
  event_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  event varchar NOT NULL,
  place varchar NOT NULL,
  date date NOT NULL,
  time time NOT NULL,
  username varchar NOT NULL
);
```

### Creating invite table

```
CREATE TABLE invite (
    username varchar NOT NULL,
    event_id int NOT NULL,
    invites varchar,
    FOREIGN KEY (event_id) REFERENCES events(event_id)
);
```
 