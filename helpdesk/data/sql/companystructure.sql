CREATE TABLE companystructure (id BIGSERIAL, parent_id BIGINT, name VARCHAR(255) NOT NULL, mpk VARCHAR(10) NOT NULL UNIQUE, address VARCHAR(255), phone VARCHAR(12), stuff_id BIGINT, PRIMARY KEY(id));
CREATE TABLE companystructure_region (companystructure_id BIGINT, region_id BIGINT, PRIMARY KEY(companystructure_id, region_id));
ALTER TABLE companystructure ADD CONSTRAINT companystructure_parent_id_stuff_id FOREIGN KEY (parent_id) REFERENCES stuff(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE companystructure ADD CONSTRAINT companystructure_parent_id_companystructure_id FOREIGN KEY (parent_id) REFERENCES companystructure(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE companystructure_region ADD CONSTRAINT companystructure_region_region_id_region_id FOREIGN KEY (region_id) REFERENCES region(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE companystructure_region ADD CONSTRAINT companystructure_region_companystructure_id_companystructure_id FOREIGN KEY (companystructure_id) REFERENCES companystructure(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE stuff ADD CONSTRAINT stuff_companystructure_id_companystructure_id FOREIGN KEY (companystructure_id) REFERENCES companystructure(id) NOT DEFERRABLE INITIALLY IMMEDIATE;



CREATE UNIQUE INDEX companystructure_mpk_key ON companystructure USING btree (mpk)
CREATE UNIQUE INDEX companystructure_pkey ON companystructure USING btree (id)