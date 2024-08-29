insert into user_types (user_type_name) values ('Admin');
insert into user_types (user_type_name) values ('Client');

--admin test
insert into users (first_name, second_name, last_names, age, email, password, fk_id_user_type)
values ('Sergio', 'Augusto', 'Pérez Sánchez', 35, 'sergioaugustopz@gmail.com', 'lapvr4553', 'dbb2cf39-7ca6-46c3-839b-9d96c99d984d');

--client test
insert into users (first_name, second_name, last_names, age, email, password, fk_id_user_type)
values ('Josue', 'Antonio', 'Ek Canche', 27, 'josueantonioec@gmail.com', 'kfscf8788', '319fc478-7452-4049-b9ef-ce52350a22ca');