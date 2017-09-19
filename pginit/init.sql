CREATE TABLE public.currencies
(
    code CHAR(3) PRIMARY KEY NOT NULL,
    name VARCHAR(50) NOT NULL
);
CREATE UNIQUE INDEX currencies_code_uindex ON public.currencies (code);

CREATE TABLE public.products
(
    id SERIAL PRIMARY KEY NOT NULL,
    title VARCHAR(200) NOT NULL,
    price FLOAT DEFAULT 0.00,
    currency CHAR(3) NOT NULL,

    CONSTRAINT products_currencies_code_fk
    FOREIGN KEY (currency) REFERENCES currencies (code)
);
CREATE UNIQUE INDEX products_id_uindex ON public.products (id);

INSERT INTO public.currencies (code, name) VALUES ('USD', 'United States Dollar');

INSERT INTO public.products (title, price, currency) VALUES ('Fallout',        1.99, 'USD');
INSERT INTO public.products (title, price, currency) VALUES ('Don''t Starve',  2.99, 'USD');
INSERT INTO public.products (title, price, currency) VALUES ('Baldur''s Gate', 3.99, 'USD');
INSERT INTO public.products (title, price, currency) VALUES ('Icewind Dale',   4.99, 'USD');
INSERT INTO public.products (title, price, currency) VALUES ('Bloodborne',     5.99, 'USD');