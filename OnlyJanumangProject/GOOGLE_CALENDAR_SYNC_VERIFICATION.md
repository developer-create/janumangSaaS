# Google Calendar Sync Verification Guide

## Overview
This document describes the enhanced Google Calendar sync verification system that was added to address the issue of not being able to verify whether Google Calendar is syncing when adding events.

## What Changed

### 1. **Enhanced Sync Status Tracking**
The `syncToGoogleCalendar()` method in `Events.php` now returns a detailed status array instead of just a boolean:

```php
$syncResult = [
    'success' => bool,           // Was sync attempt successful?
    'verified' => bool,          // Was sync verified/confirmed?
    'googleEventId' => string,   // Google Event ID if synced
    'status' => string,          // Status code (SYNCED, NOT_SYNCED, NO_CALENDAR_CONFIGURED, etc.)
    'message' => string          // Human-readable message
];
```

### 2. **User Feedback Messages**
When adding or editing events, users now see flash messages:
- ✅ **Success**: "Google Calendar synchronized successfully for event: [Event Name]"
- ⚠️ **Warning**: "Event created but Google Calendar sync could not be verified."

These messages appear at the top of the Events page after the action completes.

### 3. **Events Table Sync Status Column**
The Events list table now includes a "Google Calendar Status" column showing:
- **🟢 Synced** - Event has a Google Event ID and is synced
- **🟡 Not Synced** - Event was created but sync hasn't occurred yet

### 4. **Comprehensive Verification Tool**
Open `check_gcal_status.php` in your browser for a complete verification dashboard with three tabs:

#### **📋 Users Status Tab**
Shows all users and their Google Calendar configuration:
- Lists users with calendar enabled status
- Shows if refresh token is set
- Displays admin count with calendar access
- Warnings if no admin has calendar connected

#### **📅 Events Sync Check Tab**
Shows recent events and their sync status:
- Lists last 20 events
- Shows sync percentage (Synced / Total)
- Displays Google Event IDs
- Quick link to verify each event

#### **✓ Verify Event Tab**
Detailed verification for a specific event:
- Event details (name, date, creator)
- Google Event ID (if synced)
- Calendar user assigned to event
- Configuration status (Enabled, Token Set)
- Troubleshooting recommendations

## How to Use

### For Users Adding Events

1. **Create Event** - Fill out the event form and click Save
2. **Check Feedback** - Notice the green or yellow message at the top:
   - Green = Successfully synced to Google Calendar ✅
   - Yellow = Could not sync, check with admin ⚠️
3. **Verify Sync** - In the events list, check the "Google Calendar Status" column

### For Admins Troubleshooting

1. **Open Verification Tool**:
   ```
   http://localhost/janumang/check_gcal_status.php
   ```

2. **Check Users Status**:
   - Ensure at least one Admin has Google Calendar enabled
   - Look for the badge "Admin: 1" in the summary box
   - If it shows "No Admin Connection", an admin must connect first

3. **Review Events Sync**:
   - Click "Events Sync Check" tab
   - See what percentage of events are synced
   - Click "Details" on any event to see why it's not syncing

4. **Verify Specific Event**:
   - Find the event ID from the Events page
   - Go to "Verify Event" tab
   - Enter event ID to see detailed status and recommendations

## Status Codes Explained

| Status Code | Meaning | Solution |
|---|---|---|
| `SYNCED` | ✅ Event is synced to Google Calendar | No action needed |
| `NOT_SYNCED` | No Google Event ID created yet | Check if calendar is configured |
| `NO_CALENDAR_CONFIGURED` | No user has calendar enabled | Admin must connect to Google Calendar |
| `TOKEN_REFRESH_FAILED` | Could not refresh Google token | User needs to reconnect to Google Calendar |
| `CREATE_FAILED` | API call to create event failed | Check Google API credentials |
| `ERROR` | Exception occurred during sync | Check application logs |
| `DELETED` | Event was deleted from Google Calendar | Normal deletion process |

## Troubleshooting

### Problem: All events show "Not Synced"

**Check these in order:**
1. Open `check_gcal_status.php`
2. Go to "Users Status" tab
3. Look for Admin with:
   - ✅ Google Calendar Enabled: YES
   - ✅ Token Status: SET

**Solution:**
- If Admin doesn't have calendar enabled, they need to click "Connect Google Calendar" button in Events module
- Admin must complete the OAuth authorization flow

### Problem: Event shows "Not Synced" but calendar is enabled

**Possible causes:**
1. User doesn't have necessary Google API permissions
2. Google Calendar API not enabled in Google Cloud Console
3. Refresh token expired and can't be refreshed

**Solution:**
1. Verify in `check_gcal_status.php` that user's token is SET
2. If token is set but sync still fails, try:
   - User disconnects and reconnects Google Calendar
   - Check application logs at `application/logs/` for error details

### Problem: "Google event creation failed" error

**Possible causes:**
1. Calendar credentials not configured in `application/config/google_calendar.php`
2. Invalid calendar email in config
3. Google API quota exceeded

**Solution:**
1. Check `application/config/google_calendar.php`:
   ```php
   $config['google_client_id'] = '...'; // Should not be empty
   $config['google_client_secret'] = '...'; // Should not be empty
   ```
2. Verify Google Cloud Console has Calendar API enabled
3. Check logs in `application/logs/` for detailed error messages

## Database Fields

Two key database fields track sync status:

```sql
-- In events table
google_event_id VARCHAR(255) NULL  -- Stores Google's event ID when synced

-- In tbl_users table
google_calendar_enabled TINYINT(1)  -- Set to 1 when user connects
google_refresh_token TEXT NULL      -- OAuth refresh token for offline access
```

Check these fields are present:
```sql
DESCRIBE events;  -- Should show google_event_id column
DESCRIBE tbl_users;  -- Should show google_calendar_enabled and google_refresh_token
```

## API Endpoints

### Verify Event Sync Status
```
GET /events/verify_sync?eventId=123
```

Returns JSON:
```json
{
  "eventId": 123,
  "eventName": "Board Meeting",
  "googleEventId": "abc123def456...",
  "isSynced": true,
  "calendarUser": "Admin Name",
  "calendarEmail": "admin@example.com",
  "calendarEnabled": true,
  "tokenSet": true
}
```

## Log Files

Check `application/logs/` for detailed sync information:

```
[2026-03-29 10:15:32] [INFO] [default] Google Calendar sync starting: eventId=123, action=create, calendarUserId=1
[2026-03-29 10:15:33] [INFO] [default] Google Calendar sync success: created event, eventId=123, googleEventId=abc123def456
```

Look for these log patterns:
- `sync starting` - Sync process initiated
- `sync success` - Event synced successfully
- `sync failed` - Sync failed with error
- `sync skipped` - Sync not attempted (check reason)
- `sync error` - Exception occurred

## For Developers

### Extending Sync Verification

The sync verification system can be extended with custom logic. Modify the `syncToGoogleCalendar()` method in `Events.php`:

```php
private function syncToGoogleCalendar($eventId, $eventData, $action = 'create') {
    $syncResult = [
        'success' => false,
        'verified' => false,
        'googleEventId' => null,
        'status' => 'NOT_SYNCED',
        'message' => '',
        'custom_field' => null  // Add custom fields as needed
    ];
    
    // ... existing code ...
    
    return $syncResult;
}
```

### Manual Sync Check Query

Run this SQL to see sync statistics:
```sql
-- Total events and sync percentage
SELECT 
    COUNT(*) as total_events,
    SUM(CASE WHEN google_event_id IS NOT NULL AND google_event_id != '' THEN 1 ELSE 0 END) as synced_events,
    ROUND(100 * SUM(CASE WHEN google_event_id IS NOT NULL AND google_event_id != '' THEN 1 ELSE 0 END) / COUNT(*), 2) as sync_percentage
FROM events;

-- Events without Google Event IDs
SELECT id, name, date, created_by 
FROM events 
WHERE google_event_id IS NULL OR google_event_id = ''
ORDER BY date DESC
LIMIT 20;

-- Users with calendar enabled
SELECT userId, name, email, google_calendar_enabled, 
       CASE WHEN google_refresh_token IS NOT NULL THEN 'SET' ELSE 'NOT SET' END as token_status
FROM tbl_users 
WHERE isDeleted = 0 AND google_calendar_enabled = 1;
```

## Performance Considerations

- **Verification Tool**: Runs queries but caches results per page load
- **Sync Operations**: Async but may take 1-2 seconds per event
- **Token Refresh**: Happens on-demand when sync is needed

For high volume operations, consider:
1. Running sync in background queue (not implemented by default)
2. Caching sync results for 5 minutes
3. Batch syncing events during off-peak hours

## Security Notes

- `google_refresh_token` is stored in database - ensure database is secure
- Don't expose `google_event_id` to untrusted sources
- Always validate event ownership before showing sync details
- Log sync operations for audit trail

## Support & Questions

For issues:
1. Check `check_gcal_status.php` first - usually shows the root cause
2. Review application logs in `application/logs/`
3. Enable debug logging by setting `$config['log_threshold'] = 4` in `application/config/config.php`
4. Share logs when reporting issues

---

**Last Updated**: March 29, 2026  
**Version**: 1.0
