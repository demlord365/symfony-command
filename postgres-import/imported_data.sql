-- Table: public.imported_data

-- DROP TABLE IF EXISTS public.imported_data;

CREATE TABLE IF NOT EXISTS public.imported_data
(
    uid character varying(100) COLLATE pg_catalog."default" NOT NULL,
    ctime time without time zone NOT NULL,
    event_name character varying(40) COLLATE pg_catalog."default"
    )

    TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.imported_data
    OWNER to postgres;