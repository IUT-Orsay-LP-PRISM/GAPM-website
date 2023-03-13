@echo off
SETLOCAL EnableDelayedExpansion

set DOWNLOAD_DIR=%USERPROFILE%\Downloads

echo Telechargement de Composer...
powershell -command "(New-Object System.Net.WebClient).DownloadFile('https://getcomposer.org/Composer-Setup.exe', '%DOWNLOAD_DIR%\Composer-Setup.exe')"
echo Installation de Composer...
"%DOWNLOAD_DIR%\Composer-Setup.exe" /S 


set "NODEJS_PATH=C:\Program Files\nodejs"

dir /b "%NODEJS_PATH%" | find "node.exe" > nul

if errorlevel 1 (
    echo Node.js n'est pas installe dans "%NODEJS_PATH%"
    goto installNode
) else (
    echo Node.js est deja installe dans "%NODEJS_PATH%"
    goto installNVM
)


:installNVM
set /p PROMPT_INSTALL_NVM="Voulez vous installer le gestionnaire de versions de Node.js (NVM) ? (y/n) : "
if /i "%PROMPT_INSTALL_NVM%"=="y" (
  echo Vous avez choisi d'installer NVM.
  echo Téléchargement de NVM...
    powershell -command "(New-Object System.Net.WebClient).DownloadFile('https://github.com/coreybutler/nvm-windows/releases/download/1.1.10/nvm-setup.exe', '%DOWNLOAD_DIR%\nvm-setup.exe')"
    echo Installation de NVM...
    "%DOWNLOAD_DIR%\nvm-setup.exe" /S
    goto del
) else (
  echo Vous avez choisi de ne pas installer NVM.
  echo ATTENTION : La version 14.21.1 de Node.js est necessaire pour le bon fonctionnement de l'application.
  goto del
)


:installNode
echo Telechargement de Node.js (v14.21.1)...
powershell -command "(New-Object System.Net.WebClient).DownloadFile('https://nodejs.org/download/release/v14.21.1/node-v14.21.1-x64.msi', '%DOWNLOAD_DIR%\node-v14.21.1-x64.msi')"
echo Installation de Node.js...
msiexec /i "%DOWNLOAD_DIR%\node-v14.21.1-x64.msi"
goto del


:del
echo Nettoyage des fichiers temporaires...
del "%DOWNLOAD_DIR%\Composer-Setup.exe"
del "%DOWNLOAD_DIR%\node-v14.21.1-x64.msi"
del "%DOWNLOAD_DIR%\nvm-setup.exe"
echo ------------------------------------------------
echo Installation terminee.
echo Merci de redemarrer votre ordinateur. !!
echo ------------------------------------------------
echo Une fois redemarre, si vous avez installe NVM,
echo vous pouvez installer la version 14.21.1 de Node.js 
echo Avec la commande suivante : nvm install 14.21.1
echo ------------------------------------------------
pause

