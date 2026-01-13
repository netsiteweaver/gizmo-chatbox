# Installation Guide - Gizmo Chat Module

This guide will walk you through installing the Gizmo Chat Module in your CodeIgniter application.

## Prerequisites

Before installing, ensure you have:

1. **CodeIgniter 3.x** installed and configured
2. **PHP 7.4+** with MySQL/MariaDB extension
3. **Database** access with CREATE TABLE permissions
4. **User Authentication System** - Your app must have:
   - A `users` table with columns: `id`, `name`, `email`
   - Session-based authentication
   - `$_SESSION['user_id']` set when user is logged in
   - A `Users_model` with `getById($id)` method

## Step-by-Step Installation

### Step 1: Copy Module Files

Copy the module files to your CodeIgniter application structure:

```bash
# From the module directory
cp controllers/Chat.php /path/to/your/application/controllers/
cp controllers/api/Chat.php /path/to/your/application/controllers/api/
cp models/Chat_model.php /path/to/your/application/models/
cp -r views/chat /path/to/your/application/views/
cp migrations/*.php /path/to/your/application/migrations/
```

### Step 2: Database Setup

#### Option A: Using Migrations (Recommended)

If your application uses CodeIgniter migrations:

1. Ensure migrations are enabled in `application/config/migration.php`:
   ```php
   $config['migration_enabled'] = TRUE;
   ```

2. Run migrations via your migration controller or CLI:
   ```bash
   php index.php migrate
   ```

#### Option B: Manual SQL Execution

Run the SQL from the migration files directly in your database:

1. Create the `chat_messages` table (from `20260113102400_ChatMessages.php`)
2. Add the `receiver_user_id` column (from `20260113110000_UpdateChatMessagesForUsers.php`)

### Step 3: Configure Routes

Add the following routes to `application/config/routes.php`:

```php
// Chat page routes
$route['chat'] = 'chat/index';
$route['chat/listing'] = 'chat/listing';
$route['chat/conversation/(:num)'] = 'chat/conversation/$1';
$route['chat/send'] = 'chat/send';
$route['chat/getMessages'] = 'chat/getMessages';

// Chat API routes (for widget)
$route['chat/api_send'] = 'api/chat/api_send';
$route['chat/api_getMessages'] = 'api/chat/api_getMessages';
$route['chat/api_getConversations'] = 'api/chat/api_getConversations';
$route['chat/api_getAllUsers'] = 'api/chat/api_getAllUsers';
$route['chat/api_getUnreadCount'] = 'api/chat/api_getUnreadCount';
```

### Step 4: Update Controllers

#### Update Your Base Controller (if needed)

The Chat controller extends `MY_Controller`. Ensure your base controller:
- Sets up session data
- Loads common models
- Handles authentication

If your base controller is different, update `Chat.php` to extend your base controller.

#### Update Chat Controller Dependencies

The Chat controller expects:
- `system_model->getParam("chat_enabled")` - to check if chat is enabled
- `users_model->getById($id)` - to get user information

Adjust these if your models are different.

### Step 5: Enable Chat Feature

Create a system parameter/setting to enable the chat:

**Option A: Using a params table**
```sql
INSERT INTO params (title, value, status) VALUES ('chat_enabled', 'yes', 1);
```

**Option B: Direct code modification**
If you don't use a params table, modify `Chat.php` controller to remove the check:
```php
// Remove or comment out these lines in the constructor:
$chat_enabled = $this->system_model->getParam("chat_enabled");
if($chat_enabled != "yes") {
    show_error("Chat feature is currently disabled.", 403, "Chat Disabled");
    return;
}
```

### Step 6: Include Widget in Layout

Add the chat widget to your main layout file (e.g., `application/views/layouts/default.php`):

**Before `</body>` tag:**
```php
<?php 
// Load chat widget if enabled
$chat_enabled = isset($chat_enabled) ? $chat_enabled : 'yes';
$this->load->view('chat/widget', ['chat_enabled' => $chat_enabled]);
?>
```

Or if your layout uses a different structure:
```php
<?php $this->load->view('chat/widget'); ?>
```

### Step 7: Add Assets (Optional)

If you want to customize the Gizmo logo:
1. Add your logo to `assets/images/Gizmo-150x48px.png`
2. Or update the image path in `application/views/chat/widget.php` line 315

### Step 8: Configure Notification Sound (Optional)

The widget plays a notification sound. Ensure you have:
- Audio file at: `assets/audio/notify-bell.wav`
- Or update the path in `application/views/chat/widget.php`

### Step 9: Test Installation

1. **Check Database Tables:**
   ```sql
   SHOW TABLES LIKE 'chat_messages';
   DESCRIBE chat_messages;
   ```

2. **Access Chat Pages:**
   - Visit: `your-domain.com/chat/listing`
   - You should see the chat conversations page

3. **Test Widget:**
   - The widget should appear in the bottom-right corner
   - Click it to open
   - Try selecting a user and sending a message

## Troubleshooting

### Widget Not Appearing

- Check browser console for JavaScript errors
- Ensure jQuery is loaded before the widget script
- Verify `base_url` is defined in your JavaScript
- Check that `chat_enabled` parameter is set to 'yes'

### Messages Not Sending

- Check browser console for AJAX errors
- Verify routes are correctly configured
- Check session authentication is working
- Verify database table exists and has correct structure

### Database Errors

- Ensure migrations ran successfully
- Check database user has CREATE/ALTER permissions
- Verify table structure matches migration files

### Permission/Access Issues

- Verify user is logged in (`$_SESSION['user_id']` is set)
- Check access control in your base controller
- Verify user has necessary permissions

## Post-Installation Configuration

### Customization Options

1. **Widget Position**: Edit CSS in `widget.php` to change position
2. **Colors**: Modify CSS variables/colors in the widget view
3. **Animations**: Adjust animation timing in CSS
4. **Version Text**: Edit version display text in widget.php

### Security Recommendations

1. Implement rate limiting for API endpoints
2. Add CSRF protection if not already in place
3. Validate user permissions before allowing chat access
4. Consider adding message moderation features

## Upgrading

To upgrade to a new version:

1. Backup your database
2. Review changelog for breaking changes
3. Copy new files over existing ones
4. Run any new migrations
5. Test thoroughly

## Uninstallation

To remove the module:

1. Remove route configurations
2. Remove widget include from layout
3. (Optional) Drop database tables:
   ```sql
   DROP TABLE IF EXISTS chat_messages;
   ```
4. Delete module files

## Support

For installation issues or questions:
- Check the [README.md](README.md) for common issues
- Review the [API Documentation](docs/API.md)
- Open an issue on GitHub


