CREATE TABLE contactinfo (id BIGSERIAL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)); 
CREATE TABLE user_contactinfo (id BIGSERIAL, contactinfo_id BIGINT NOT NULL, user_id BIGINT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id));

ALTER TABLE user_contactinfo ADD CONSTRAINT user_contactinfo_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE user_contactinfo ADD CONSTRAINT user_contactinfo_contactinfo_id_contactinfo_id FOREIGN KEY (contactinfo_id) REFERENCES contactinfo(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
