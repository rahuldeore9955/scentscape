@echo off
setlocal

set "PHP_BIN=C:\php85\php.exe"
set "MYSQL_START=C:\xampp\mysql_start.bat"

if not exist "%PHP_BIN%" (
    echo PHP 8.5 was not found at "%PHP_BIN%".
    echo Update PHP_BIN inside serve.bat to the correct php.exe path.
    exit /b 1
)

powershell -NoProfile -Command "if (-not (Test-NetConnection 127.0.0.1 -Port 3306 -InformationLevel Quiet)) { Start-Process -FilePath '%MYSQL_START%' -WindowStyle Hidden; Start-Sleep -Seconds 3 }" >nul

"%PHP_BIN%" artisan serve --host=127.0.0.1 --port=8000
