# ⚡ 3-STEP FIX - GOOGLE CALENDAR SYNC

**Problem**: Events not appearing in Google Calendar (0/610 synced)  
**Cause**: Missing library + Admin not connected  
**Fix Time**: 20 minutes total

---

## STEP 1️⃣: Install Google API Library (5 min)

Open PowerShell and run:

```powershell
cd d:\xammp82\htdocs\janumang
composer install
```

**If it times out**, run this instead:
```powershell
composer config process-timeout 2000
composer install
```

**Verify success**: Open browser to:
```
http://localhost/janumang/check_gcal_debug.php
```

Look for line starting with "4. GOOGLE API LIBRARY:"  
- If you see: ✓ then go to STEP 2
- If you see: ❌ then ask for help

---

## STEP 2️⃣: Connect Admin to Google Calendar (5 min)

1. **Log in** as admin user
   - Username: Admin account (User ID: 1)

2. **Go to**: Events Module

3. **Find**: Blue button that says "Connect Google Calendar"

4. **Click** it

5. **Complete** the Google authorization
   - Select your Google account
   - Click "Allow/Authorize"  
   - You'll come back to Events page

✓ **Done!** Button should now say "Disconnect Google Calendar"

---

## STEP 3️⃣: Test It Works (5 min)

1. **Create** a test event:
   - Events → Add New Event
   - Fill in details
   - Click Save

2. **Check result**:
   - You should see one of these messages:
     - 🟢 Green: "Google Calendar synchronized successfully!" ✓ WORKING
     - 🟡 Yellow: "Could not verify..." ⚠ Still has issues

3. **Verify** in Google Calendar:
   ```
   https://calendar.google.com
   ```
   - Refresh page
   - Your test event should appear!

4. **Verify** in system:
   - Open: `http://localhost/janumang/check_gcal_status.php`
   - Should show ~100% synced

---

## ✅ Success Checklist

- [ ] Composer install completed without errors
- [ ] Message at Step 1: "✓ Library found"
- [ ] Admin can click "Connect Google Calendar"
- [ ] Green message when creating test event
- [ ] Test event appears in Google Calendar
- [ ] `check_gcal_status.php` shows 100% sync

---

## ❌ Stuck? Quick Troubleshooting

### Composer hangs/times out?
```powershell
# Kill it (Ctrl+C), then try:
composer update -v
```

### Still see "Library not found" after install?
```powershell
cd d:\xammp82\htdocs\janumang
dir vendor  # Should list: google, guzzle, etc.
```

### Admin button not showing?
- Reload page
- Clear browser cache (Ctrl+Shift+Delete)
- Try different browser

### Green message but event not in Google Calendar?
- Wait 2-3 seconds and refresh Google Calendar
- Check if event might be in a different calendar

### Still stuck?
Run diagnostic:
```
http://localhost/janumang/check_gcal_debug.php
```

Look for red ❌ marks and follow the suggested fix.

---

## Need More Help?

- **Full guide**: [GOOGLE_CALENDAR_SYNC_VERIFICATION.md](GOOGLE_CALENDAR_SYNC_VERIFICATION.md)
- **Root cause**: [ROOT_CAUSE_ANALYSIS.md](ROOT_CAUSE_ANALYSIS.md)  
- **Quick ref**: [GCAL_QUICK_REFERENCE.md](GCAL_QUICK_REFERENCE.md)

---

**That's it! Should take 20 minutes total.**
