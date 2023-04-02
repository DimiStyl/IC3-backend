BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "account" (
	"account_id"	INTEGER NOT NULL,
	"username"	TEXT NOT NULL,
	"password"	TEXT NOT NULL,
	"email"	varchar NOT NULL,
	"user_type"	boolean NOT NULL,
	"status"	varchar NOT NULL,
	"name"	TEXT,
	PRIMARY KEY("account_id" AUTOINCREMENT)
);
INSERT INTO "account" VALUES (1,'admin','admin123','admin@gmail.com',1,'approved','admin');
INSERT INTO "account" VALUES (2,'dom','password123','doms@gmail.com',0,'pending',NULL);
COMMIT;
