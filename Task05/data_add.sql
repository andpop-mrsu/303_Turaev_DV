INSERT INTO users (name, surname, email, gender, occupation_id) VALUES
("Данил", "Прокопенко", "prokop@gmail.com", "male", 6),
("Андрей", "Родькиин", "rodkinA@yandex.ru", "male", 6),
("Кирилл", "Рябикин", "ryabikin_kirya@mail.ru", "male", 6),
("Антон", "Тимовкин", "antony_tima@gmail.com", "male", 6),
("Денис", "Тураев", "denis.turaev@bk.ru", "male", 11);

INSERT INTO movies (title, "year") VALUES
("Три метра над уровнем неба", 2010);
INSERT INTO link_movies_genres (movie_id, genre_id)
SELECT movies.id, 6 FROM movies ORDER BY id DESC LIMIT 1;
INSERT INTO link_movies_genres (movie_id, genre_id)
SELECT movies.id, 14 FROM movies ORDER BY id DESC LIMIT 1;


INSERT INTO movies (title, "year") VALUES
("Невидимый гость", 2016);
INSERT INTO link_movies_genres (movie_id, genre_id)
SELECT movies.id, 6 FROM movies ORDER BY id DESC LIMIT 1;
INSERT INTO link_movies_genres (movie_id, genre_id)
SELECT movies.id, 9 FROM movies ORDER BY id DESC LIMIT 1;
INSERT INTO link_movies_genres (movie_id, genre_id)
SELECT movies.id, 12 FROM movies ORDER BY id DESC LIMIT 1;

INSERT INTO movies (title, "year") VALUES
("Интерстеллар", 2014);
INSERT INTO link_movies_genres (movie_id, genre_id)
SELECT movies.id, 2 FROM movies ORDER BY id DESC LIMIT 1;
INSERT INTO link_movies_genres (movie_id, genre_id)
SELECT movies.id, 4 FROM movies ORDER BY id DESC LIMIT 1;
INSERT INTO link_movies_genres (movie_id, genre_id)
SELECT movies.id, 16 FROM movies ORDER BY id DESC LIMIT 1;

INSERT INTO tags (user_id, movie_id, tag) VALUES
(948, 193610, "Трогательная драма"),
(948, 193611, "Интересная детективная история с неожиданным финалом"),
(948, 193612, "Псевдонаучный фильм");