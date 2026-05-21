@echo off
REM Start MongoDB, Backend, and Frontend

echo.
echo ========================================
echo Starting JanUmang SaaS Project
echo ========================================
echo.

REM Start MongoDB in a new window
echo [1/3] Starting MongoDB...
start "MongoDB" mongod

REM Wait for MongoDB to start
timeout /t 3 /nobreak

REM Start Backend Server in a new window
echo [2/3] Starting Backend Server...
cd Server
start "Backend Server" cmd /k npm start
cd ..

REM Wait for Backend to start
timeout /t 3 /nobreak

REM Start Frontend in a new window
echo [3/3] Starting Frontend...
cd adminlte-3-react-main
start "Frontend" cmd /k npm run dev
cd ..

echo.
echo ========================================
echo All services started!
echo ========================================
echo.
echo Frontend:  http://localhost:3001
echo Backend:   http://localhost:5000
echo MongoDB:   localhost:27017
echo.
echo MongoDB Compass: mongodb://localhost:27017
echo.
pause
