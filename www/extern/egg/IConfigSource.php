<?php

interface IConfigSource
{
    public function getFetchLimitCommits(): int;
    public function getFetchLimitBranches(): int;
    public function getFetchLimitRepos(): int;
    public function getFetchLimitOrgs(): int;
}
