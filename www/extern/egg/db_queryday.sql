SELECT
    [commitdate]  AS [commitdate],
    [repo_id]     AS [repo_id],
    [repo_name]   AS [repo_name],
    [source]      AS [source],
    COUNT(*)      AS count
FROM
(
    SELECT
        commits.[hash]                   AS [hash],
        min([author_email])              AS [mail1],
        min([committer_email])           AS [mail2],
        date(min([date]))                AS [commitdate],
        min(repositories.[id])           AS [repo_id],
        min(repositories.[name])         AS [repo_name],
        min(branches.[id])               AS [branch_id],
        min(branches.[name])             AS [branch_name],
        min(repositories.[source])       AS [source]

    FROM commits

    LEFT JOIN metadata     ON commits.[hash]      = metadata.[hash]
    LEFT JOIN branches     ON commits.[branch_id] = branches.[id]
    LEFT JOIN repositories ON branches.[repo_id]  = repositories.[id]

    GROUP BY commits.[hash]
    HAVING (strftime('%Y', commitdate) = :year AND (/*{IDENTITY_COND}*/))
)
GROUP BY [commitdate], [repo_id], [repo_name], [source]
ORDER BY [repo_name]