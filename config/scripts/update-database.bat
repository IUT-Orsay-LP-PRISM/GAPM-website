@echo off
chcp 65001 > nul
setlocal enabledelayedexpansion

if "%1"=="-d" (
  set "DOCKER=true"
) else if "%1"=="-w" (
  set "DOCKER=false"
) else (
  echo Choisissez l'option correspondant à votre environnement :
  echo 1. Docker
  echo 2. Wamp

  set /p choice="Votre choix : "

  if "!choice!"=="1" (
    set "DOCKER=true"
  ) else if "!choice!"=="2" (
    set "DOCKER=false"
  ) else (
    echo Option invalide.
    exit /b
  )
)

if %DOCKER%==true (
  set "CONTAINER_NAME=gapm-website-mariadb-1"
  set "MYSQL_BIN_PATH=/usr/bin/mysql"
  set "MYSQL_USER=root"
  set "MYSQL_PASSWORD=root"
) else (
  set "MYSQL_BIN_PATH=C:\wamp64\bin\mysql\mysql5.7.36\bin"
  set "MYSQL_HOST=localhost"
  set "MYSQL_PORT=3306"
  set "MYSQL_USER=root"
  set "MYSQL_PASSWORD="
)

set "SQL_FILE_DB_VILLE=../database/db_ville.sql"
set "SQL_FILE_DB_GAPM=../database/db_gapm.sql"
set "DATABASE_NAME=gapm"

echo ========================================
echo Exécution des fichiers SQL...

if %DOCKER%==true (
  REM Copier les fichiers SQL dans le conteneur
  echo Copie des fichiers SQL dans le conteneur...
    echo ^> Fichier %SQL_FILE_DB_VILLE% en cours...
  docker cp "%SQL_FILE_DB_VILLE%" "%CONTAINER_NAME%:/"
    echo ^> Fichier %SQL_FILE_DB_VILLE% copié avec succès !
    echo ^> Fichier %SQL_FILE_DB_GAPM% en cours...
  docker cp "%SQL_FILE_DB_GAPM%" "%CONTAINER_NAME%:/"
    echo ^> Fichier %SQL_FILE_DB_GAPM% copié avec succès !

  REM Exécuter le script SQL dans le conteneur
  echo Exécution des fichiers SQL dans le conteneur...
    echo ^> Fichier %SQL_FILE_DB_VILLE% en cours...
  docker exec -it "%CONTAINER_NAME%" sh -c "%MYSQL_BIN_PATH% -u %MYSQL_USER% -p%MYSQL_PASSWORD% < %SQL_FILE_DB_VILLE%"
    echo ^> Fichier %SQL_FILE_DB_VILLE% exécuté avec succès !

    echo ^> Fichier %SQL_FILE_DB_GAPM% en cours...
  docker exec -it "%CONTAINER_NAME%" sh -c "%MYSQL_BIN_PATH% -u %MYSQL_USER% -p%MYSQL_PASSWORD% -D %DATABASE_NAME% < %SQL_FILE_DB_GAPM%"
    echo ^> Fichier %SQL_FILE_DB_GAPM% exécuté avec succès !

) else (
  echo ^> Fichier %SQL_FILE_DB_VILLE% en cours...
  "%MYSQL_BIN_PATH%\mysql.exe" -h "%MYSQL_HOST%" -P "%MYSQL_PORT%" -u "%MYSQL_USER%" -e "source %SQL_FILE_DB_VILLE%"
  echo ^> Fichier %SQL_FILE_DB_VILLE% exécuté avec succès !

  echo ^> Fichier %SQL_FILE_DB_GAPM% en cours...
  "%MYSQL_BIN_PATH%\mysql.exe" -h "%MYSQL_HOST%" -P "%MYSQL_PORT%" -u "%MYSQL_USER%" -D "%DATABASE_NAME%" -e "source %SQL_FILE_DB_GAPM%"
  echo ^> Fichier %SQL_FILE_DB_GAPM% exécuté avec succès !
)

echo ----------------------------------------
echo Fin de l'exécution des fichiers SQL.
echo Base de données mise à jour avec succès.
echo ========================================

