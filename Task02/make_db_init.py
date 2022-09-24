import datetime
import sqlite3
import csv
from sqlite3 import Error


def create_connection(path):
    try:
        return sqlite3.connect(path)
    except Error as e:
        print(e)

    return None


tableNames = ["movies", "ratings", "tags", "users"]
f2 = open("db_init.sql", 'w', encoding='utf-8')
for tableName in tableNames:
    f2.write("DROP TABLE IF EXISTS " + tableName + ";\n")
f2.write("\n")

# Создаем необходимые таблицы
f2.write("""CREATE TABLE movies (
         id INT(8) PRIMARY KEY,
         title VARCHAR(255),
         year DATE,
         genres VARCHAR(255));""")
f2.write("\n\n")

f2.write("""CREATE TABLE ratings (
	id INT(8) PRIMARY KEY,
	user_id INT(8),
	movie_id INT(8),
	rating REAL,
	'timestamp' TIMESTAMP);""")
f2.write("\n\n")

f2.write("""CREATE TABLE tags (
         id INT(8) PRIMARY KEY,
         user_id INT(8),
         movie_id INT(8),
         tag VARCHAR(255),
         'timestamp' TIMESTAMP);""")
f2.write("\n\n")

f2.write("""CREATE TABLE users (
         id INT(8) PRIMARY KEY,
         name VARCHAR(255),
         email VARCHAR(255),
         gender VARCHAR(255),
         register_date DATE,
         occupation VARCHAR(255));""")
f2.write("\n\n")

# Создаем запрос INSERT на заполнение таблицы movies
insertStr = ""
with open("dataset/movies.csv", encoding='utf-8') as file:
    csvfilereader = csv.reader(file, delimiter=",")
    i = 0
    for r in csvfilereader:
        if i > 0:
            id = r[0].strip()
            r[1] = r[1].strip()
            year = r[1][-6:]
            year = year[1:-1]
            try:
                date = datetime.datetime.strptime(year, '%Y')
                title = r[1][:-7]
            except Exception:
                year = 'NULL'
                title = r[1]
            title = title.replace('"', '""')
            genres = r[2].strip()
            if genres == '(no genres listed)':
                genres = 'NULL'
                insertStr += f'({id}, \"{title}\", {year}, {genres}),\n'
            else:
                insertStr += f'({id}, \"{title}\", {year}, \"{genres}\"),\n'
        else:
            insertStr += "INSERT INTO movies VALUES \n"
            i += 1
insertStr = insertStr[:-2]
insertStr += ";"
f2.write(insertStr + "\n\n")
insertStr = ""

# Создаем запрос INSERT на заполнение таблицы ratings
with open("dataset/ratings.csv", encoding='utf-8') as file:
    csvfilereader = csv.reader(file, delimiter=",")
    i = 0
    for r in csvfilereader:
        if i > 0:
            user_id = r[0].strip()
            movie_id = r[1].strip()
            rating = r[2].strip()
            timestamp = r[3].strip()
            insertStr += f'({i}, {user_id}, {movie_id}, {rating}, {timestamp}),\n'
            i += 1
        else:
            insertStr = "INSERT INTO ratings VALUES \n"
            i += 1
insertStr = insertStr[:-2]
insertStr += ";"
f2.write(insertStr + "\n\n")

# Создаем запрос INSERT на заполнение таблицы tags
insertStr = ""
with open("dataset/tags.csv", encoding='utf-8') as file:
    csvfilereader = csv.reader(file, delimiter=",")
    i = 0
    for r in csvfilereader:
        if i > 0:
            user_id = r[0].strip()
            movie_id = r[1].strip()
            tag = r[2].strip().replace('"', '')
            timestamp = r[3].strip()
            insertStr += f'({i}, {user_id}, {movie_id}, \"{tag}\", {timestamp}),\n'
            i += 1
        else:
            insertStr = "INSERT INTO tags VALUES \n"
            i += 1
insertStr = insertStr[:-2]
insertStr += ";"
f2.write(insertStr + "\n\n")

# Создаем запрос INSERT на заполнение таблицы users
insertStr = ""
with open("dataset/users.txt", encoding='utf-8') as file:
    csvfilereader = csv.reader(file, delimiter="|")
    i = 0
    insertStr = "INSERT INTO users VALUES \n"
    for r in csvfilereader:
        id = r[0].strip()
        name = r[1].strip()
        email = r[2].strip()
        gender = r[3].strip()
        register_date = r[4].strip()
        occupation = r[5].strip()
        if occupation == 'none':
            occupation = 'NULL'
            insertStr += f'({id}, \"{name}\", \"{email}\", \"{gender}\", {register_date}, {occupation}),\n'
        else:
            insertStr += f'({id}, \"{name}\", \"{email}\", \"{gender}\", {register_date}, \"{occupation}\"),\n'

insertStr = insertStr[:-2]
insertStr += ";"
f2.write(insertStr)

f2.close()
