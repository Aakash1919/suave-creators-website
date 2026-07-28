@echo off
cd /d "%~dp0"
echo.
echo  Suave Creators local server
echo  Open: http://localhost:8000
echo.
echo  IMPORTANT: Keep this window open.
echo  Always start with this file (uses router.php).
echo  Press Ctrl+C to stop.
echo.
php -S localhost:8000 router.php
if errorlevel 1 (
  echo.
  echo PHP failed to start. Is PHP installed and on PATH?
  pause
)
