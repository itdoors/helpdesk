ALTER TABLE claim ADD CONSTRAINT claim_smeta_status_id_status_id FOREIGN KEY (smeta_status_id) REFERENCES status(id) NOT DEFERRABLE INITIALLY IMMEDIATE;