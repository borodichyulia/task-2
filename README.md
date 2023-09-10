# Template

This is the template repository for bitbucket hosting which helps us to set up a working repository for trainees.

Jira board with a list of tasks is [here](https://innowise-group.atlassian.net/jira/software/c/projects/PHPT/boards/364).

---

## Set up new repository

### Set repository files

* Clone the template repository:
```shell
git clone git@bitbucket.org:innowise-group/php_interns_template.git
```
* Create a new repository for your trainee (it has probably already been created).

* Change existing .git settings for another:
```shell
rm -r .git & git init
git add .
git commit -m "Init commit"
git remote add origin git@bitbucket.org:{project}/{trainee-name}.git
git push -u origin master
```

### Set repository settings

* Add restriction to master branch:
	* Repository settings -> Branch restrictions -> Branch permissions (.bin/branch-restrictions-1.png)
	* Repository settings -> Branch restrictions -> Merge settings (.bin/branch-restrictions-2.png)
* Add yourself as default reviewers:
	* Repository settings -> Default reviewers (.bin/default reviewers-1.png)
* I also recommend to set a merge strategies to `squash`. Navigate to Repository settings -> Merge strategies.
* Don't forget to add you trainee's access key if it wasn't added by bitbucket keeper :)

### Set repository pipelines

* Go to Repository settings -> Pipelines -> Enable pipelines
* Make sure you have tasks branck as your feature flow. Navigate to Repository settings -> Branching model -> Branch prefixes -> change `/feature` to `/tasks`

_Note: Pipelines will work only after pull request from `tasks` branch_

## Composer

* Install packages:
```shell
composer install
```

* Composer commands:
	* ``` composer phpcs // execute php_code_sniffer ```
	* ``` composer phpstan // execute phpstan (level 9) ```
	* ``` composer tests // execute tests (Windows) ```
	* ``` composer tests-pipe // execute tests (Linux) ```
