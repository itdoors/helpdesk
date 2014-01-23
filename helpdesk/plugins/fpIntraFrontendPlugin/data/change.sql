CREATE TABLE doc_document (id BIGSERIAL, name VARCHAR(100) NOT NULL, description VARCHAR(255), createdatetime TIMESTAMP, tags VARCHAR(255), user_id BIGINT NOT NULL, category_id BIGINT NOT NULL, isdeleted BOOLEAN DEFAULT 'false', PRIMARY KEY(id));
CREATE TABLE doc_document_group (id BIGSERIAL, name VARCHAR(100) NOT NULL UNIQUE, description VARCHAR(255), createdatetime TIMESTAMP, level BIGINT, user_id BIGINT NOT NULL, parent_id BIGINT, isdeleted BOOLEAN DEFAULT 'false', PRIMARY KEY(id)); 
CREATE TABLE doc_document_group_sf_users (sfguarduser_id BIGINT, docdocumentgroup_id BIGINT, actionkey VARCHAR(255), PRIMARY KEY(sfguarduser_id, docdocumentgroup_id, actionkey));
CREATE TABLE doc_document_group_sf_groups (sfguardgroup_id BIGINT, docdocumentgroup_id BIGINT, actionkey VARCHAR(255), PRIMARY KEY(sfguardgroup_id, docdocumentgroup_id, actionkey));
CREATE TABLE doc_document_version (id BIGSERIAL, name VARCHAR(100) NOT NULL, filepath VARCHAR(255) NOT NULL, mime_type VARCHAR(50), createdatetime TIMESTAMP, user_id BIGINT NOT NULL, document_id BIGINT NOT NULL, isdeleted BOOLEAN DEFAULT 'false', PRIMARY KEY(id));
CREATE TABLE log_intranet (id BIGSERIAL, user_id BIGINT NOT NULL, obj_id BIGINT NOT NULL, createdatetime TIMESTAMP, description VARCHAR(255), logkey VARCHAR(255), logtype VARCHAR(255), PRIMARY KEY(id));

ALTER TABLE doc_document ADD CONSTRAINT doc_document_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE doc_document ADD CONSTRAINT doc_document_category_id_doc_document_group_id FOREIGN KEY (category_id) REFERENCES doc_document_group(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE doc_document_group ADD CONSTRAINT doc_document_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE doc_document_group ADD CONSTRAINT doc_document_group_parent_id_doc_document_group_id FOREIGN KEY (parent_id) REFERENCES doc_document_group(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE doc_document_group_sf_users ADD CONSTRAINT doc_document_group_sf_users_sfguarduser_id_sf_guard_user_id FOREIGN KEY (sfguarduser_id) REFERENCES sf_guard_user(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE doc_document_group_sf_users ADD CONSTRAINT dddi FOREIGN KEY (docdocumentgroup_id) REFERENCES doc_document_group(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE doc_document_group_sf_groups ADD CONSTRAINT doc_document_group_sf_groups_sfguardgroup_id_sf_guard_group_id FOREIGN KEY (sfguardgroup_id) REFERENCES sf_guard_group(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE doc_document_group_sf_groups ADD CONSTRAINT dddi FOREIGN KEY (docdocumentgroup_id) REFERENCES doc_document_group(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE doc_document_version ADD CONSTRAINT doc_document_version_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE doc_document_version ADD CONSTRAINT doc_document_version_document_id_doc_document_id FOREIGN KEY (document_id) REFERENCES doc_document(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
