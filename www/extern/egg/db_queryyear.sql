SELECT commitdate AS commitdate, COUNT(*) as count FROM
	(
		SELECT
			commits.[hash] AS hash, min([author_email]) AS mail1, min([committer_email]) AS mail2, date(min([date])) AS commitdate
		FROM commits
		LEFT JOIN metadata ON commits.hash = metadata.hash
		GROUP BY commits.[hash]
		HAVING (strftime('%Y', commitdate) = :year AND (/*{INDETITY_COND}*/))
	)
GROUP BY commitdate
ORDER BY commitdate