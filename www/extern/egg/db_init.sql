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
	"hash"            TEXT    NOT NULL
);

/*----SPLIT----*/

CREATE TABLE "metadata"
(
	"hash"            TEXT    NOT NULL PRIMARY KEY UNIQUE,
	"author_name"     TEXT    NOT NULL,
	"author_email"    TEXT    NOT NULL,
	"committer_name"  TEXT    NOT NULL,
	"committer_email" TEXT    NOT NULL,
	"message"         TEXT    NOT NULL,
	"date"            TEXT    NOT NULL,
	"parent_commits"  TEXT    NOT NULL
);

/*----SPLIT----*/

CREATE VIEW alldata AS
	SELECT
		metadata.[date], commits.hash,
		metadata.author_name, metadata.author_email, metadata.committer_name, metadata.committer_email, metadata.message, metadata.parent_commits,
		repositories.source, repositories.name AS repository,
		branches.name AS branch,
		repositories.url,
		repositories.last_update, repositories.last_change
	FROM commits
	LEFT JOIN metadata     ON commits.hash      = metadata.hash
	LEFT JOIN branches     ON commits.branch_id = branches.id
	LEFT JOIN repositories ON branches.repo_id  = repositories.id;

/*----SPLIT----*/

CREATE VIEW allbranches AS
	SELECT
		repositories.source, repositories.name AS repository,
		branches.name AS branch,
		repositories.url,
		repositories.last_update, repositories.last_change,
		(SELECT COUNT(*) FROM commits WHERE branch_id = branches.id) AS commit_count
	FROM branches
	LEFT JOIN repositories ON branches.repo_id  = repositories.id;

/*----SPLIT----*/

CREATE INDEX "branches_repo_id" ON "branches" ("repo_id");

/*----SPLIT----*/

CREATE INDEX "commits_branch_id" ON "commits" ("branch_id");

/*----SPLIT----*/

CREATE INDEX "commits_hash" ON "commits" ("hash");
