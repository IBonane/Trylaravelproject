DROP TABLE IF EXISTS Articles;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Categories;

CREATE TABLE Users(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pseudo VARCHAR(255) UNIQUE NOT NULL,
    lastname VARCHAR(255),
    firstname VARCHAR(255),
    email VARCHAR(255) UNIQUE NOT NULL,
    passwordHash VARCHAR(255) NOT NULL,
    token VARCHAR(255) 
);

CREATE TABLE Categories(
    nameCat VARCHAR(255) PRIMARY KEY
);

CREATE TABLE Articles(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    price REAL NOT NULL,
    id_cat VARCHAR(255) NOT NULL,
    id_user VARCHAR(255) NOT NULL,
    path_image VARCHAR(255),
    FOREIGN KEY(id_cat) REFERENCES Categories(nameCat),
    FOREIGN KEY(id_user) REFERENCES Users(id)
);

INSERT INTO Categories(nameCat)
    VALUES
            ("Media"),
            ("Press"),
            ("Internet");
    