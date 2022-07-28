DROP DATABASE IF EXISTS telkomims;
DROP USER IF EXISTS telkomims;

CREATE USER telkomims WITH PASSWORD 'telkomims';
CREATE DATABASE telkomims;
ALTER DATABASE telkomims OWNER TO telkomims;
\c telkomims;
ALTER schema public OWNER TO telkomims;
GRANT ALL PRIVILEGES ON DATABASE telkomims TO telkomims;

/* please use super user to run this script */
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

ALTER database "telkomims" SET search_path TO hexsys;
