
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

ALTER TABLE users
ADD CONSTRAINT unique_phone UNIQUE (phone);

CREATE TABLE discount_coupons (
    id_coupon UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    coupon_name VARCHAR(50) NOT NULL,
    applicable_cases TEXT NOT NULL,
    expiry_date DATE NOT NULL,
    fk_client_id UUID NOT NULL,
    FOREIGN KEY (fk_client_id) REFERENCES client_details(id_client)
);

CREATE TABLE service_requests (
    id_service_request UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    service_type VARCHAR(100) NOT NULL,
    actions_taken TEXT,
    total_cost DECIMAL(10, 2) NOT NULL,
    service_date DATE NOT NULL,
    delivery_date DATE,
    fk_client_id UUID NOT NULL,
    FOREIGN KEY (fk_client_id) REFERENCES client_details(id_client)
);

ALTER TABLE service_requests
ALTER COLUMN actions_taken TYPE JSON USING actions_taken::JSON;

ALTER TABLE service_requests
ADD COLUMN partial_payment DECIMAL(10, 2) DEFAULT 0.00,
ADD COLUMN total_paid DECIMAL(10, 2) DEFAULT 0.00;

--admin test
insert into users (first_name, second_name, last_names, age, email, password, fk_id_user_type)
values ('Erick', 'Adriel', 'Moo Calan', 35, 'erick.moo.isc', '$2y$10$cSv/UmUg3bIC4GVS7BPmGOy4U9iHTZOc1uhg39YR9katA2UD3XCLm', '643dce86-c777-41c1-837e-53a6831f3d85');

insert into admin_details (admin_role, fk_id_user) values ('Main Administrator', '36054c8e-672d-426f-acfd-7bf6117e6ebd');


--client test
insert into users (first_name, second_name, last_names, age, email, password, fk_id_user_type)
values ('Josue', 'Antonio', 'Ek Canche', 27, 'josueantonioec@gmail.com', 'kfscf8788', '319fc478-7452-4049-b9ef-ce52350a22ca');