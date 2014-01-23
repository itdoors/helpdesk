CREATE TABLE groupclaim (id BIGSERIAL, name VARCHAR(150) NOT NULL, claimtype_id BIGINT NOT NULL, groupclaimwork_id BIGINT NOT NULL, formula TEXT, client_id BIGINT NOT NULL, contract_importance_id BIGINT NOT NULL, message TEXT, PRIMARY KEY(id));
CREATE TABLE groupclaim_departments (groupclaim_id BIGINT, departments_id BIGINT, PRIMARY KEY(groupclaim_id, departments_id));
CREATE TABLE groupclaimwork (id BIGSERIAL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id));
CREATE TABLE groupclaimperiod (id BIGSERIAL, groupclaim_id BIGINT NOT NULL, period_day VARCHAR(10) NOT NULL, period_month VARCHAR(10) NOT NULL, period_year VARCHAR(10) NOT NULL, PRIMARY KEY(id));

CREATE TABLE groupclaim_claim (id BIGSERIAL, claim_id BIGINT NOT NULL, groupclaim_id BIGINT NOT NULL, createdatetime TIMESTAMP NOT NULL, PRIMARY KEY(id));

ALTER TABLE groupclaim ADD CONSTRAINT groupclaim_groupclaimwork_id_groupclaimwork_id FOREIGN KEY (groupclaimwork_id) REFERENCES groupclaimwork(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE groupclaim_departments ADD CONSTRAINT groupclaim_departments_groupclaim_id_groupclaim_id FOREIGN KEY (groupclaim_id) REFERENCES groupclaim(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE groupclaim_departments ADD CONSTRAINT groupclaim_departments_departments_id_departments_id FOREIGN KEY (departments_id) REFERENCES departments(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE groupclaim ADD CONSTRAINT groupclaim_client_id_client_id FOREIGN KEY (client_id) REFERENCES client(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE groupclaim ADD CONSTRAINT groupclaim_contract_importance_id_contract_importance_id FOREIGN KEY (contract_importance_id) REFERENCES contract_importance(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE groupclaim ADD CONSTRAINT groupclaim_claimtype_id_claimtype_id FOREIGN KEY (claimtype_id) REFERENCES claimtype(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE groupclaim_claim ADD CONSTRAINT groupclaim_claim_groupclaim_id_groupclaim_id FOREIGN KEY (groupclaim_id) REFERENCES groupclaim(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE groupclaim_claim ADD CONSTRAINT groupclaim_claim_claim_id_claim_id FOREIGN KEY (claim_id) REFERENCES claim(id) NOT DEFERRABLE INITIALLY IMMEDIATE;

ALTER TABLE groupclaimperiod ADD CONSTRAINT groupclaimperiod_groupclaim_id_groupclaim_id FOREIGN KEY (groupclaim_id) REFERENCES groupclaim(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
