CREATE TABLE "repositories"
(
	"id"             INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	"source"         TEXT    NOT NULL,
	"name"           TEXT    NOT NULL,
	"url"            TEXT    NOT NULL UNIQUE,
	"last_update"    TEXT    NOT NULL,
	"last_change"    TEXT    NOT NULL
);

/*----SPLIT----*/

CREATE TABLE "branches"
(
	"id"             INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	"repo_id"	     INTEGER NOT NULL,
	"name"           TEXT    NOT NULL,
	"head"           TEXT,
	"last_update"    TEXT    NOT NULL,
	"last_change"    TEXT    NOT NULL
);

/*----SPLIT----*/

CREATE TABLE "commits"
(
	"id"              INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	"branch_id"       INTEGER NOT NULL,
	"hash"            TEXT    NOT NULL,
	"author_name"     TEXT    NOT NULL,
	"author_email"    TEXT    NOT NULL,
	"committer_name"  TEXT    NOT NULL,
	"committer_email" TEXT    NOT NULL,
	"message"         TEXT    NOT NULL,
	"date"            TEXT    NOT NULL,
	"parent_commits"  TEXT    NOT NULL
);
