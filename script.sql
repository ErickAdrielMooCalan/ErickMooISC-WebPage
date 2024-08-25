CREATE TABLE users(
    id_user UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    first_name VARCHAR(50) NOT NULL,
    second_name VARCHAR(50),
    last_names VARCHAR(50) NOT NULL,
    age INT,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(50) NOT NULL,
    fk_id_user_type UUID NOT NULL,
    FOREIGN KEY (fk_id_user_type) REFERENCES user_types(id_user_type)
);

CREATE TABLE user_types (
    id_user_type UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    user_type_name VARCHAR(50) NOT NULL
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