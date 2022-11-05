#!/bin/bash
chcp 65001

sqlite3 movies_rating.db < db_init.sql

echo 1. Найти все пары пользователей, оценивших один и тот же фильм. Устранить дубликаты, проверить отсутствие пар с самим собой. Для каждой пары должны быть указаны имена пользователей и название фильма, который они ценили.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT users1.name, users2.name, movies.title FROM ratings ratings1, ratings ratings2, users users1, users users2, movies WHERE ratings1.movie_id=ratings2.movie_id AND ratings1.user_id < ratings2.user_id AND ratings1.movie_id=movies.id AND users1.id=ratings1.user_id AND users2.id=ratings2.user_id GROUP BY ratings1.user_id, ratings2.user_id;"
echo " "

echo 2. Найти 10 самых старых оценок от разных пользователей, вывести названия фильмов, имена пользователей, оценку, дату отзыва в формате ГГГГ-ММ-ДД.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT movies.title, users.name, ratings.rating, inter_table.tmstp as 'timestamp' FROM movies, ratings, users, (SELECT DISTINCT FIRST_VALUE(ratings.movie_id) OVER(PARTITION BY ratings.user_id ORDER BY ratings."timestamp") AS movie_id, ratings.user_id, FIRST_VALUE(date(ratings.'timestamp', 'unixepoch')) OVER(PARTITION BY ratings.user_id ORDER BY ratings."timestamp") AS tmstp FROM ratings ORDER BY ratings.'timestamp' LIMIT 10) AS inter_table WHERE ratings.movie_id=inter_table.movie_id AND ratings.user_id=inter_table.user_id AND movies.id=ratings.movie_id AND users.id=ratings.user_id;"
echo " "

echo 3. Вывести в одном списке все фильмы с максимальным средним рейтингом и все фильмы с минимальным средним рейтингом. Общий список отсортировать по году выпуска и названию фильма. В зависимости от рейтинга в колонке "Рекомендуем" для фильмов должно быть написано "Да" или "Нет".
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT movies.title, movies.year, AVG(ratings.rating) rating_avg1, 'yes' recommend FROM movies, ratings WHERE movies.id=ratings.movie_id AND movies.year IS NOT NULL GROUP BY movies.title HAVING rating_avg1=(SELECT MAX(rating_avg) FROM (SELECT movies.title, AVG(ratings.rating) rating_avg FROM movies, ratings WHERE (movies.id=ratings.movie_id) GROUP BY movies.title)) UNION ALL SELECT movies.title, movies.year, AVG(ratings.rating) rating_avg1, 'no' recommend FROM movies, ratings WHERE movies.id=ratings.movie_id AND movies.year IS NOT NULL GROUP BY movies.title HAVING rating_avg1=(SELECT MIN(rating_avg) FROM (SELECT movies.title, AVG(ratings.rating) rating_avg FROM movies, ratings WHERE (movies.id=ratings.movie_id) GROUP BY movies.title)) ORDER BY movies.year, movies.title;"
echo " "

echo 4. Вычислить количество оценок и среднюю оценку, которую дали фильмам пользователи-мужчины в период с 2011 по 2014 год.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT COUNT(*) 'count of ratings', AVG(ratings.rating) 'average rating' FROM ratings, users WHERE ratings.user_id=users.id AND users.gender='male' AND DATE(ratings.timestamp, 'unixepoch') >= '2011-00-00' AND DATE(ratings.timestamp, 'unixepoch') <= '2014-12-31';"
echo " "

echo 5. Составить список фильмов с указанием средней оценки и количества пользователей, которые их оценили. Полученный список отсортировать по году выпуска и названиям фильмов. В списке оставить первые 20 записей.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT movies.id, movies.title, movies.year, AVG(ratings.rating) rating_avg, COUNT(movies.id) as ratings_quantity FROM movies JOIN ratings ON movies.id=ratings.movie_id WHERE movies.year IS NOT NULL GROUP BY movies.id ORDER BY movies.year, movies.title LIMIT 20;"
echo " "

echo 6. Определить самый распространенный жанр фильма и количество фильмов в этом жанре. Отдельную таблицу для жанров не использовать, жанры нужно извлекать из таблицы movies.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "WITH RECURSIVE split(content, last, rest) AS (VALUES('', '', (SELECT group_concat(movies.genres, '|') FROM movies)) UNION ALL SELECT CASE WHEN last = '|' THEN substr(rest, 1, 1) ELSE content || substr(rest, 1, 1) END, substr(rest, 1, 1), substr(rest, 2) FROM split WHERE rest <> '') SELECT REPLACE(content, '|','') AS 'genre', COUNT(*) as films_count FROM split WHERE last = '|' OR rest = '' GROUP BY genre ORDER BY films_count DESC LIMIT 1;"
echo " "

echo 7. Вывести список из 10 последних зарегистрированных пользователей в формате "Фамилия Имя|Дата регистрации" (сначала фамилия, потом имя).
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT substr(users.name, instr(users.name, ' ') + 1) || ' ' || substr(users.name, 0, instr(users.name, ' ')) || ' | ' || users.register_date AS 'users info' FROM users ORDER BY users.register_date DESC LIMIT 10;"
echo " "

echo 8. С помощью рекурсивного CTE определить, на какие дни недели приходился ваш день рождения в каждом году.
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "WITH RECURSIVE rec(birthday, day_of_week) AS (SELECT '2001-12-26', STRFTIME('%w', '2001-12-26') UNION ALL SELECT DATE(rec.birthday, '+1 year'), STRFTIME('%w', DATE(rec.birthday, '+1 year')) from rec WHERE rec.birthday <= DATE('now', '-1 year')) SELECT * FROM rec;"