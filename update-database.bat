@echo off
chcp 65001 > nul
setlocal enabledelayedexpansion
set "MYSQL_BIN_PATH=C:\wamp64\bin\mysql\mysql5.7.36\bin"
set "MYSQL_HOST=localhost"
set "MYSQL_PORT=3306"
set "MYSQL_USER=root"
set "MYSQL_PASSWORD="
set "DATABASE_NAME=gapm"
set "SQL_FILE_DB_VILLE=db_ville.sql"
set "SQL_FILE_DB_GAPM=db_gapm.sql"

echo ========================================
echo Exécution des fichiers SQL...

echo ^> Fichier %SQL_FILE_DB_VILLE% en cours...
"%MYSQL_BIN_PATH%\mysql.exe" -h "%MYSQL_HOST%" -P "%MYSQL_PORT%" -u "%MYSQL_USER%" -e "source %SQL_FILE_DB_VILLE%"
echo ^> Fichier %SQL_FILE_DB_VILLE% exécuté avec succès !

echo ^> Fichier %SQL_FILE_DB_GAPM% en cours...
"%MYSQL_BIN_PATH%\mysql.exe" -h "%MYSQL_HOST%" -P "%MYSQL_PORT%" -u "%MYSQL_USER%" -D "%DATABASE_NAME%" -e "source %SQL_FILE_DB_GAPM%"
echo ^> Fichier %SQL_FILE_DB_GAPM% exécuté avec succès !

echo ----------------------------------------
echo Fin de l'exécution des fichiers SQL.
echo Base de données mise à jour avec succès.
echo ========================================