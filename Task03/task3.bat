#!/bin/bash
chcp 65001

sqlite3 movies_rating.db < db_init.sql

echo "1. Составить список фильмов, имеющих хотя бы одну оценку. Список фильмов отсортировать по году выпуска и по названиям. В списке оставить первые 10 фильмов."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT movies.id, movies.title, movies."year", movies.genres FROM movies INNER JOIN ratings ON (ratings.movie_id = movies.id) WHERE (ratings.rating IS NOT NULL) AND (movies."year" IS NOT NULL) AND (movies.title IS NOT NULL) GROUP BY movies.id ORDER BY movies."year", movies.title LIMIT 10;"
echo " "

echo "2. Вывести список всех пользователей, фамилии (не имена!) которых начинаются на букву 'A'. Полученный список отсортировать по дате регистрации. В списке оставить первых 5 пользователей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT * FROM users WHERE SUBSTRING(name, CHARINDEX(' ', name) + 1) LIKE ('A%') ORDER BY register_date LIMIT 5;"
echo " "

echo "3. Написать запрос, возвращающий информацию о рейтингах в более читаемом формате: имя и фамилия эксперта, название фильма, год выпуска, оценка и дата оценки в формате ГГГГ-ММ-ДД. Отсортировать данные по имени эксперта, затем названию фильма и оценке. В списке оставить первые 50 записей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT users.name as expert_name, movies.title as movie_name, movies."year" as release_year, ratings.rating as rating, date(ratings."timestamp", 'unixepoch') as rating_date FROM ratings LEFT OUTER JOIN users ON (ratings.user_id = users.id) JOIN movies ON (ratings.movie_id = movies.id) ORDER BY expert_name, movie_name, rating LIMIT 50;"
echo " "

echo "4. Вывести список фильмов с указанием тегов, которые были им присвоены пользователями. Сортировать по году выпуска, затем по названию фильма, затем по тегу. В списке оставить первые 40 записей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT movies.title, group_concat(tags.tag) as all_tags FROM movies LEFT OUTER JOIN tags ON (movies.id = tags.movie_id) WHERE (movies."year" IS NOT NULL) GROUP BY movies.id HAVING (all_tags IS NOT NULL) ORDER BY movies."year", movies.title, tags.tag LIMIT 40;"
echo " "

echo "5. Вывести список самых свежих фильмов. В список должны войти все фильмы последнего года выпуска, имеющиеся в базе данных. Запрос должен быть универсальным, не зависящим от исходных данных (нужный год выпуска должен определяться в запросе, а не жестко задаваться)."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT * FROM movies WHERE (movies."year" = (SELECT MAX(movies."year") FROM movies));"
echo " "

echo "6. Найти все драмы, выпущенные после 2005 года, которые понравились женщинам (оценка не ниже 4.5). Для каждого фильма в этом списке вывести название, год выпуска и количество таких оценок. Результат отсортировать по году выпуска и названию фильма."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT movies.title, movies."year", COUNT(*) as ratings_count FROM movies LEFT OUTER JOIN ratings ON (movies.id = ratings.movie_id) INNER JOIN users ON (ratings.user_id = users.id) WHERE ((movies.genres LIKE '%drama%') AND (movies."year" > '2005') AND (users.gender = 'female') AND (ratings.rating >= 4.5)) GROUP BY movies.id, movies."year" ORDER BY movies."year", movies.title;"
echo " "

echo "7. Провести анализ востребованности ресурса - вывести количество пользователей, регистрировавшихся на сайте в каждом году. Найти, в каких годах регистрировалось больше всего и меньше всего пользователей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "SELECT users.register_date, COUNT(*) as users_count FROM users GROUP BY users.register_date ORDER BY users_count DESC;"
echo " "
sqlite3 movies_rating.db -box -echo "SELECT users.register_date as register_date, COUNT(*) as users_count FROM users GROUP BY users.register_date HAVING users_count = (SELECT MIN(users_count) FROM (SELECT COUNT(*) as users_count FROM users GROUP BY users.register_date));"
echo " "
sqlite3 movies_rating.db -box -echo "SELECT users.register_date as register_date, COUNT(*) as users_count FROM users GROUP BY users.register_date HAVING users_count = (SELECT MAX(users_count) FROM (SELECT COUNT(*) as users_count FROM users GROUP BY users.register_date));"
pause