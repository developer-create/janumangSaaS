# Start all services for JanUmang SaaS Project

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Starting JanUmang SaaS Project" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Function to start a process in a new window
function Start-ProcessInWindow {
    param(
        [string]$Title,
        [string]$Command,
        [string]$WorkingDirectory
    )
    
    Write-Host "[*] Starting $Title..." -ForegroundColor Yellow
    
    $pinfo = New-Object System.Diagnostics.ProcessStartInfo
    $pinfo.FileName = "powershell.exe"
    $pinfo.Arguments = "-NoExit -Command `"cd '$WorkingDirectory'; $Command`""
    $pinfo.UseShellExecute = $true
    $pinfo.CreateNoWindow = $false
    $pinfo.WindowStyle = [System.Diagnostics.ProcessWindowStyle]::Normal
    
    $p = [System.Diagnostics.Process]::Start($pinfo)
    
    Write-Host "    ✓ $Title started (PID: $($p.Id))" -ForegroundColor Green
    Start-Sleep -Seconds 2
}

# Get project root directory
$projectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path

# Start MongoDB
Start-ProcessInWindow -Title "MongoDB" -Command "mongod" -WorkingDirectory $projectRoot

# Start Backend
Start-ProcessInWindow -Title "Backend Server" -Command "npm start" -WorkingDirectory "$projectRoot\Server"

# Start Frontend
Start-ProcessInWindow -Title "Frontend" -Command "npm run dev" -WorkingDirectory "$projectRoot\adminlte-3-react-main"

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "All services started!" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Frontend:  http://localhost:3001" -ForegroundColor Green
Write-Host "Backend:   http://localhost:5000" -ForegroundColor Green
Write-Host "MongoDB:   localhost:27017" -ForegroundColor Green
Write-Host ""
Write-Host "MongoDB Compass: mongodb://localhost:27017" -ForegroundColor Green
Write-Host ""
Write-Host "Press Ctrl+C to stop all services" -ForegroundColor Yellow
