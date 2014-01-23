CREATE TABLE fc_costsn (id BIGSERIAL, finance_claim_id BIGINT NOT NULL, fc_costsn_types_id BIGINT NOT NULL, value FLOAT NOT NULL, PRIMARY KEY(id));
CREATE TABLE fc_costsntypes (id BIGSERIAL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id));
ALTER TABLE fc_costsn ADD CONSTRAINT fc_costsn_finance_claim_id_finance_claim_id FOREIGN KEY (finance_claim_id) REFERENCES finance_claim(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE fc_costsn ADD CONSTRAINT fc_costsn_fc_costsn_types_id_fc_costsntypes_id FOREIGN KEY (fc_costsn_types_id) REFERENCES fc_costsntypes(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
