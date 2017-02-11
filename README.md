# CCNYHack
CONTRIBUTORS:<br>
Xuewei Fan, email: Josephxwf@gmail.com <br>
Irina, email:IrinaKalashnikova@gmail.com <br>
Jonathan, email:j.mastermind1010@gmail.com <br>
Maidi, email: maididai@gmail.com <br>
Eshawn, email eshawn.karim@gmail.com <br>



To check the database tables:
1.open terminal
2.cd to project repository
3.heroku login
4."You could run "heroku pg:psql" to fire up a Postgres console,
type "\d" to see all tables,
type "\d tablename" to see details for a particular table."
type "SELECT * FROM tablename;" to view the table contents.

delete a table:
DROP TABLE UserForAssistance_table

composer is the Dependency Manager for PHP
After you add dependency in composer.json, you need run command "composer update"
need add gd dependency to composer.json to use ImageManipulator
check errors:heroku logs
run terminal:heroku run bash

edit database in terminal:
heroku pg:psql
psql (9.3.2, server 9.3.3)
SSL connection (cipher: DHE-RSA-AES256-SHA, bits: 256)
Type "help" for help.
=> create table test_table (id integer, name text);
CREATE TABLE
=> insert into test_table values (1, 'hello database');
INSERT 0 1
=> \q
