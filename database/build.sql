DROP TABLE IF EXISTS Favoris;
DROP TABLE IF EXISTS Articles_pages;
DROP TABLE IF EXISTS Articles;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS pages;
DROP TABLE IF EXISTS Type_pages;


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

CREATE TABLE Type_pages(
    nameType VARCHAR(255) PRIMARY KEY
);

CREATE TABLE Pages(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    namePage VARCHAR(255) NOT NULL,
    id_type VARCHAR(255) NOT NULL,
    FOREIGN KEY(id_type) REFERENCES Type_pages(nameType)
);

CREATE TABLE Articles(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    price REAL NOT NULL,
    id_cat VARCHAR(255) NOT NULL,
    id_user VARCHAR(255) NOT NULL,
    etape_desc TEXT NOT NULL,
    path_image VARCHAR(255),
    FOREIGN KEY(id_cat) REFERENCES Categories(nameCat),
    FOREIGN KEY(id_user) REFERENCES Users(id)
);

CREATE TABLE Articles_pages(
    id_page INTEGER(15) NOT NULL,
    id_article INTEGER(15) NOT NULL,
    PRIMARY KEY(id_page, id_article),
    FOREIGN KEY(id_page) REFERENCES Pages(id),
    FOREIGN KEY(id_article) REFERENCES Articles(id)
);

CREATE TABLE Favoris(
    id_user_f INTEGER(15) NOT NULL,
    id_article_f INTEGER(15) NOT NULL,
    PRIMARY KEY(id_user_f, id_article_f),
    FOREIGN KEY(id_user_f) REFERENCES Users(id),
    FOREIGN KEY(id_article_f) REFERENCES Articles(id)
);

-- CREATE TABLE Etapes(
--     id INTEGER PRIMARY KEY AUTOINCREMENT,
--     id_article INTEGER NOT NULL,
--     etape_desc TEXT,
--     FOREIGN KEY(id_article) REFERENCES Articles(id)
-- );

INSERT INTO Categories(nameCat)
    VALUES
            ("Media"),
            ("Press"),
            ("Internet");

INSERT INTO Type_pages(nameType)
    VALUES
            ("A4"),
            ("A5"),
            ("A6");