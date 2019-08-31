-- Sqlite only support 5 actual data types (INTEGER, TEXT, BLOB, REAL and NUMERIC). Other common
-- sql types such as VARCHAR, FLOAT and DATE are aliased to these. Consequently the following
-- table definitions use the primitives available rather than the types that would otherwise be 
-- used in a more rich sql engine. See https://www.sqlite.org/draft/datatype3.html for more info.

CREATE TABLE IF NOT EXISTS Posts (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	timestamp INTEGER NOT NULL,
	username TEXT DEFAULT 'Anon',
	title TEXT NOT NULL,
	icon TEXT NOT NULL DEFAULT '💩',
	content NOT NULL
);

CREATE TABLE IF NOT EXISTS Comments (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	post_id INTEGER NOT NULL,
	timestamp INTEGER NOT NULL,
	username TEXT NOT NULL DEFAULT 'Anon',
	content TEXT NOT NULL
);