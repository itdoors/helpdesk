
CREATE TABLE finance_claim (id BIGSERIAL, claim_id BIGINT NOT NULL, costs_n FLOAT, costs_nds FLOAT, costs_nonnds FLOAT, income_nds FLOAT, income_nonnds FLOAT, bill_number VARCHAR(100), profitability FLOAT, nds FLOAT, obnal FLOAT, is_closed BOOLEAN DEFAULT 'false', PRIMARY KEY(id));
CREATE TABLE documents (id BIGSERIAL, name VARCHAR(100) NOT NULL, datetime TIMESTAMP, createdatetime TIMESTAMP, documentstype_id BIGINT NOT NULL, filepath VARCHAR(100) NOT NULL, user_id BIGINT NOT NULL, PRIMARY KEY(id));
CREATE TABLE documents_claim (claim_id BIGINT, documents_id BIGINT, PRIMARY KEY(claim_id, documents_id));
CREATE TABLE documentstype (id BIGSERIAL, name VARCHAR(100) NOT NULL, dockey VARCHAR(20) NOT NULL UNIQUE, PRIMARY KEY(id));
ALTER TABLE documents ADD CONSTRAINT documents_documentstype_id_documentstype_id FOREIGN KEY (documentstype_id) REFERENCES documentstype(id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE documents_claim ADD CONSTRAINT documents_claim_documents_id_documents_id FOREIGN KEY (documents_id) REFERENCES documents(id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE;
