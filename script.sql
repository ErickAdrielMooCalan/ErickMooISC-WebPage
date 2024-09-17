
CREATE TABLE user_types (
    id_user_type UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    user_type_name VARCHAR(50) NOT NULL
);

CREATE TABLE users(
    id_user UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    first_name VARCHAR(50) NOT NULL,
    second_name VARCHAR(50),
    last_names VARCHAR(50) NOT NULL,
    age INT,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(10),
    profile_image VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    fk_id_user_type UUID NOT NULL,
    FOREIGN KEY (fk_id_user_type) REFERENCES user_types(id_user_type)
);


CREATE TABLE admin_details (
    id_admin UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    admin_role VARCHAR(50),
    fk_id_user UUID NOT NULL UNIQUE,
    FOREIGN KEY (fk_id_user) REFERENCES users(id_user)
);

CREATE TABLE client_details (
    id_client UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    type_service VARCHAR(50),
    company VARCHAR(100),
    fk_id_user UUID NOT NULL UNIQUE,
    FOREIGN KEY (fk_id_user) REFERENCES users(id_user)
);

CREATE TABLE company (
    id_company UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name_company VARCHAR(80) NOT NULL
);

CREATE TABLE admin_company_rel (
    id_admin_company_rel UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    start_date DATE NOT NULL,
    end_date DATE,
    fk_id_admin UUID NOT NULL,
    fk_id_company UUID NOT NULL,
    FOREIGN KEY (fk_id_admin) REFERENCES admin_details(id_admin),
    FOREIGN KEY (fk_id_company) REFERENCES company(id_company)
);

ALTER TABLE users
ADD CONSTRAINT unique_email UNIQUE (email);

CREATE TABLE password_resets (
    id_password_reset UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    reset_token VARCHAR(255) NOT NULL,
    reset_expiry TIMESTAMP NOT NULL,
    fk_email_client VARCHAR(100) NOT null,
    FOREIGN KEY (fk_email_client) REFERENCES users(email)
);

--admin test
insert into users (first_name, second_name, last_names, age, email, password, fk_id_user_type)
values ('Sergio', 'Augusto', 'Pérez Sánchez', 35, 'sergioaugustopz@gmail.com', 'lapvr4553', 'dbb2cf39-7ca6-46c3-839b-9d96c99d984d');

--client test
insert into users (first_name, second_name, last_names, age, email, password, fk_id_user_type)
values ('Josue', 'Antonio', 'Ek Canche', 27, 'josueantonioec@gmail.com', 'kfscf8788', '319fc478-7452-4049-b9ef-ce52350a22ca');