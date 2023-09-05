CREATE TABLE "user" (
                        "id"	INTEGER NOT NULL UNIQUE,
                        "name"	TEXT NOT NULL,
                        "tel"	TEXT NOT NULL,
                        "email"	TEXT NOT NULL,
                        "address"	TEXT NOT NULL,
                        "account"	TEXT NOT NULL UNIQUE,
                        "password"	TEXT NOT NULL,
                        PRIMARY KEY("id" AUTOINCREMENT, "account")
)
