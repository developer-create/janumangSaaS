# 🔴 GOOGLE CALENDAR SYNC - CRITICAL FIX GUIDE

## Current Status: ❌ NOT WORKING (0/610 events synced)

### Issues Found:
1. **CRITICAL**: Google API PHP Client library **NOT INSTALLED**
2. **CRITICAL**: Admin user has **NOT connected** to Google Calendar  
3. **RESULT**: Events cannot sync to Google Calendar

---

## ⚠️ OPTION A: Install Google API Library (Recommended)

### Method 1: Using Composer (Automatic)

Go to project directory and run:

```bash
cd d:\xammp82\htdocs\janumang
composer update
```

If you have **network/SSL issues**, use:

```bash
composer config -g process-timeout 2000
composer install --ignore-platform-reqs
```

### Method 2: Manual Installation (If Composer Fails)

**Step 1:** Download from GitHub  
Go to: `https://github.com/googleapis/google-api-php-client/releases`  
Download: `v2.19.1` (latest stable)

**Step 2:** Extract to correct location  
Extract contents to:  
```
d:\xammp82\htdocs\janumang\application\third_party\google-api-php-client\
```

**Step 3:** Download Dependencies  
You also need these packages (copy `vendor` folder from working Composer installation or GitHub releases):
- firebase/php-jwt
- google/auth
- google/apiclient-services  
- guzzlehttp/*
- psr/*
- Others (see composer.json)

---

## ✅ OPTION B: Admin User Connection (REQUIRED After Library Installation)

Once Google API library is installed:

### Step 1: Log In as Admin
- Username: **System Administrator** (userId: 1)
- Go to **Events Module**

### Step 2: Click "Connect Google Calendar" Button
- Look for blue button in Events section
- Click it

### Step 3: Complete Google Authorization
- You'll be redirected to Google login
- Select the Google account you want to use
- Click "Allow" to authorize
- Redirect back to your site

### Step 4: Verify Connection
Open `check_gcal_status.php`  
- Admin should now show: `Enabled: YES | Token: SET`

---

## 🛠️ QUICK TEST AFTER SETUP

1. **Open verification tool:**
   ```
   http://localhost/janumang/check_gcal_status.php
   ```

2. **Create a new event:**
   - Go to Events > Add New Event
   - Fill details and Save

3. **Check feedback:**
   - Should see ✅ "Google Calendar synchronized successfully..."
   - Event should appear in Google Calendar

---

## 📋 Alternative: Manual Vendor Folder Setup

If you have access to another working installation with vendor folder:

1. Copy entire `vendor` folder from working installation
2. Paste to:  
   ```
   d:\xammp82\htdocs\janumang\vendor\
   ```
3. Done! (No need for composer)

---

## 🔍 Troubleshooting Composer Install

If `composer require google/apiclient` hangs or times out:

### Fix 1: Increase Timeout
```bash
composer config process-timeout 600
composer require google/apiclient
```

### Fix 2: Use GitHub Raw Content
```bash
composer config repositories.google vcs https://github.com/googleapis/google-api-php-client.git
composer require google/apiclient:^2.19
```

### Fix 3: Check Internet Connection
```bash
ping github.com
```

If no response, you may have network issues.

### Fix 4: Use Pre-downloaded Packages
If you have the `vendor` folder from another installation, just copy it instead of using composer.

---

## 📝 Database Verification

After setting up, confirm installation then run:

```bash
php check_gcal_debug.php
```

Look for:
- ✅ Autoload file found
- ✅ Users admin has: `Enabled: YES | Token: SET`
- ✅ Sync Rate: > 0%

---

## 🚀 Complete Workflow

```
1. Fix Google API Library
   ↓
2. Admin Connects to Google Calendar
   ↓
3. Create Test Event
   ↓
4. See Green Success Message
   ↓
5. Check Google Calendar - Event Appears!
```

---

## ❌ "Cannot find library" Error?

**If you see:** `Google API PHP Client library not found`

**It means:**  
- Library not installed OR
- autoload.php not in correct path

**Solution:**
1. Verify path: `application/third_party/google-api-php-client/vendor/autoload.php` exists
2. If missing, install using one of methods above
3. Restart application (clear sessions)

---

## 📞 Need Help?

**Check these files:**
- Configuration: `application/config/google_calendar.php`
- Library: `application/libraries/GoogleCalendar.php`
- Debug: `check_gcal_debug.php`
- Logs: `application/logs/log-*.php`

**Run diagnostic:**
```bash
php check_gcal_debug.php
```

This will immediately show what's wrong.

---

## Summary of Changes Made to Your System

✅ Modified [Events.php](application/controllers/Events.php) - Better sync tracking  
✅ Modified [events/index.php](application/views/events/index.php) - Added sync status indicators  
✅ Updated [check_gcal_status.php](check_gcal_status.php) - Interactive verification dashboard  
✅ Created [check_gcal_debug.php](check_gcal_debug.php) - Instant diagnostics  
✅ Created [GOOGLE_CALENDAR_SYNC_VERIFICATION.md](GOOGLE_CALENDAR_SYNC_VERIFICATION.md) - Complete guide

---

**Current Date**: March 29, 2026  
**Sync Status**: ❌ Awaiting Library Installation & Admin Connection  
**Events Ready**: 610 events waiting to sync
