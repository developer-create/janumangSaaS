# 🚀 JanUmang SaaS - Startup Guide

## Quick Start

### Option 1: Batch Script (Easiest)
```bash
# Double-click this file:
start-all.bat
```

This will automatically start:
- ✅ MongoDB (Port 27017)
- ✅ Backend Server (Port 5000)
- ✅ Frontend (Port 3001)

---

### Option 2: PowerShell Script
```powershell
# Run in PowerShell:
.\start-all.ps1
```

---

### Option 3: Manual Start (3 separate terminals)

**Terminal 1 - MongoDB:**
```bash
mongod
```

**Terminal 2 - Backend:**
```bash
cd Server
npm start
```

**Terminal 3 - Frontend:**
```bash
cd adminlte-3-react-main
npm run dev
```

---

## 📍 Access URLs

| Service | URL | Port |
|---------|-----|------|
| Frontend | http://localhost:3001 | 3001 |
| Backend API | http://localhost:5000 | 5000 |
| MongoDB | mongodb://localhost:27017 | 27017 |

---

## 🗄️ MongoDB Compass

Connect to MongoDB using Compass:
```
Connection String: mongodb://localhost:27017
```

---

## ✅ Verification

### Check if services are running:

**Frontend:**
```bash
curl http://localhost:3001
```

**Backend:**
```bash
curl http://localhost:5000
```

**MongoDB:**
```bash
mongosh
```

---

## 🔧 Troubleshooting

### MongoDB won't start
```bash
# Check if port 27017 is in use
netstat -ano | findstr :27017

# If in use, kill the process
taskkill /PID <PID> /F

# Then try again
mongod
```

### Backend connection error
- Make sure MongoDB is running first
- Check `.env` file for correct `MONGO_URI`
- Default: `mongodb://localhost:27017/janumang_dev`

### Frontend won't load
- Check if port 3001 is available
- Clear browser cache (Ctrl+Shift+Delete)
- Hard refresh (Ctrl+Shift+R)

---

## 📝 Environment Variables

Backend `.env` file:
```
MONGO_URI=mongodb://localhost:27017/janumang_dev
PORT=5000
FRONTEND_URL=http://localhost:3001
```

Frontend `.env.local` file:
```
NEXT_PUBLIC_API_URL=http://localhost:5000
```

---

## 🎯 Next Steps

1. Open http://localhost:3001 in browser
2. Login to application
3. Navigate to "Member List" or "MP Vidhan Sabha Member"
4. Test the new forms

---

**Happy Coding! 🎉**
