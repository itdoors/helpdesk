CREATE TABLE tendercategory (id BIGSERIAL, name VARCHAR(200) NOT NULL, PRIMARY KEY(id));
CREATE TABLE tenderkeywords (id BIGSERIAL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id));
CREATE TABLE tenderlinks (id BIGSERIAL, name VARCHAR(200) NOT NULL, tendercategory_id BIGINT, PRIMARY KEY(id));

ALTER TABLE tenderlinks ADD CONSTRAINT tenderlinks_tendercategory_id_tendercategory_id FOREIGN KEY (tendercategory_id) REFERENCES tendercategory(id) NOT DEFERRABLE INITIALLY IMMEDIATE;