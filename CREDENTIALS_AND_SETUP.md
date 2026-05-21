# 🎉 JAN UMANG SAAS - LOCAL SETUP COMPLETE

## ✅ SETUP STATUS

- ✅ Frontend Server: Running on **http://localhost:3001**
- ✅ Backend Server: Running on **http://localhost:5000**
- ✅ MongoDB: Running locally on **mongodb://localhost:27017/janumang_dev**
- ✅ Permissions: 175 permissions seeded
- ✅ Roles: 3 roles created (Superadmin, Admin, User)
- ✅ Users: 3 test users created
- ✅ Master Data: States, Divisions, Districts, Parliaments, Assemblies, Blocks, Booths seeded

---

## 🔐 LOGIN CREDENTIALS

### 1️⃣ SUPERADMIN (Full System Access)
```
Email:    superadmin@janumang.com
Password: Admin@123456
Role:     System Super Administrator
Access:   All modules & features across all tenants
Level:    system_admin
```

### 2️⃣ ADMIN (Tenant Administrator)
```
Email:    admin@janumang.com
Password: Admin@123456
Role:     Administrator
Access:   All modules & features for default tenant
Level:    tenant_admin
Tenant:   JanUmang Default
```

### 3️⃣ TEST USER (Limited Access)
```
Email:    user@janumang.com
Password: User@123456
Role:     Regular User
Access:   View-only permissions
Level:    regularUser
Tenant:   JanUmang Default
```

---

## 🌐 URLS

| Service | URL | Status |
|---------|-----|--------|
| Frontend | http://localhost:3001 | ✅ Running |
| Backend API | http://localhost:5000/api | ✅ Running |
| MongoDB | mongodb://localhost:27017/janumang_dev | ✅ Running |

---

## 📊 DATABASE INFORMATION

### Database Name
```
janumang_dev
```

### Collections Created
- Users (3 test users)
- Roles (3 roles)
- Permissions (175 permissions)
- Tenants (1 default tenant)
- States (1 - Madhya Pradesh)
- Divisions (1 - Indore Division)
- Districts (1 - Indore)
- Parliaments (1 - Indore)
- Assemblies (1 - Indore-1)
- Blocks (1 - Indore Urban)
- Booths (Multiple)

### Default Tenant
```
Name:     JanUmang Default
Slug:     default
Plan:     enterprise
Status:   active
Modules:  All 40+ modules enabled
```

---

## 🔧 BACKEND CONFIGURATION

### Environment Variables (.env)
```
MONGO_URI=mongodb://localhost:27017/janumang_dev
PORT=5000
JWT_SECRET=24d7cb50994666009e9d57a470e153dcad25a6d59eafde07391e213d14cd8c74
JWT_REFRESH_SECRET=b7a2a73438a681269cd8e391597ba1a163ff25e395c8dd1b43077151755a8e4b
FRONTEND_URL=http://localhost:3001
```

### External Services Configured
- ✅ Google OAuth (for authentication)
- ✅ Gmail SMTP (for email)
- ✅ Razorpay (for payments - test mode)
- ✅ Google Calendar API
- ✅ Sentry (error tracking)

---

## 📱 FRONTEND CONFIGURATION

### Environment Variables (.env.local)
```
NEXT_PUBLIC_GOOGLE_CLIENT_ID=987526161520-h547amgat5igok1sm5rfof81c4a8v5lq.apps.googleusercontent.com
API_BASE_URL=http://localhost:5000/api
NEXT_PUBLIC_API_URL=http://localhost:5000/api
```

---

## 🚀 QUICK START

### 1. Access Frontend
```
Open browser: http://localhost:3001
```

### 2. Login with any of the 3 accounts
```
Use credentials from above
```

### 3. Explore Features
- Dashboard
- User Management
- Role Management
- Permissions
- Master Data (States, Districts, etc.)
- And 40+ other modules

---

## 📦 AVAILABLE MODULES

### Administrative
- Dashboard
- Users
- Roles
- Permissions
- User Count
- Tenants

### Political Structure
- Parliaments
- Vidhan Sabha (Assemblies)
- Samiti (Committees)
- Panchayat
- Villages
- Blocks
- Booths
- Districts
- Divisions
- States

### Operations
- Member List
- MP Public Problems
- Assembly Issues
- Call Management
- Dispatch Register
- Inward Register
- In Docs (Outgoing Documents)
- Activity Management
- Visitors
- Voters

### Other
- Phone Directory
- Events
- Projects
- Worktype
- Sub Type of Work
- Party
- Department

---

## 🔄 RUNNING SERVERS

### Frontend (Next.js)
```bash
cd adminlte-3-react-main
npm run dev
# Runs on http://localhost:3001
```

### Backend (Express.js)
```bash
cd Server
npm run dev
# Runs on http://localhost:5000
```

### MongoDB
```bash
mongod
# Runs on mongodb://localhost:27017
```

---

## 🛠️ USEFUL COMMANDS

### Backend Commands
```bash
cd Server

# Development mode
npm run dev

# Production mode
npm start

# Run tests
npm test

# Seed permissions
npm run seed

# Seed plans
node scripts/seedPlansInDb.js

# Seed master data
node scripts/seedMasterDataHierarchy.js

# Seed roles and admin
node scripts/seedRolesAndAdmin.js
```

### Frontend Commands
```bash
cd adminlte-3-react-main

# Development mode
npm run dev

# Build for production
npm run build

# Run production build
npm start

# Lint code
npm run lint

# Format code
npm run format

# Run tests
npm test

# Run Cypress tests
npm run cypress:open
```

---

## 🔐 SECURITY NOTES

⚠️ **Important:**
- These are test credentials for development only
- Never use these in production
- Change all passwords before deploying to production
- Rotate JWT secrets in production
- Use environment-specific .env files
- Enable HTTPS in production
- Set up proper CORS policies
- Use secure session management

---

## 📝 NOTES

1. **Local Database**: All data is stored locally in MongoDB. No data is synced with production.
2. **Test Data**: All seeded data is for testing purposes only.
3. **Email**: Emails are configured to use Gmail SMTP. Check spam folder if testing email features.
4. **Payments**: Razorpay is in test mode. Use test card numbers for testing.
5. **Google OAuth**: Configured for development. Update credentials for production.

---

## 🆘 TROUBLESHOOTING

### MongoDB Connection Error
```bash
# Make sure MongoDB is running
mongod

# Check connection
mongo mongodb://localhost:27017/janumang_dev
```

### Backend Won't Start
```bash
# Clear node_modules and reinstall
cd Server
rm -r node_modules
npm install
npm run dev
```

### Frontend Won't Start
```bash
# Clear node_modules and reinstall
cd adminlte-3-react-main
rm -r node_modules
npm install
npm run dev
```

### Port Already in Use
```bash
# Kill process on port 3001 (Frontend)
lsof -ti:3001 | xargs kill -9

# Kill process on port 5000 (Backend)
lsof -ti:5000 | xargs kill -9

# Kill process on port 27017 (MongoDB)
lsof -ti:27017 | xargs kill -9
```

---

## 📞 SUPPORT

For issues or questions:
1. Check the logs in the terminal
2. Review the .env configuration
3. Ensure all services are running
4. Check MongoDB connection
5. Verify API endpoints are accessible

---

**Last Updated:** May 8, 2026
**Setup Type:** Local Development
**Database:** MongoDB Local
**Status:** ✅ Ready for Development
