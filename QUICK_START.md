# Quick Start Guide

Get the Gizmo Chat Module up and running in 5 minutes!

## Prerequisites Check

Before starting, ensure you have:
- ✅ CodeIgniter 3.x application
- ✅ User authentication system with `users` table
- ✅ Database access
- ✅ PHP 7.4+

## Installation Steps

### 1. Copy Files (2 minutes)

```bash
# Navigate to your CodeIgniter application root
cd /path/to/your/codeigniter-app

# Copy module files
cp -r gizmo-chat-module/controllers/* application/controllers/
cp -r gizmo-chat-module/models/* application/models/
cp -r gizmo-chat-module/views/* application/views/
cp gizmo-chat-module/migrations/*.php application/migrations/
```

### 2. Run Migrations (1 minute)

**Option A: Via Migration Controller**
```
Visit: http://your-domain.com/migrate
```

**Option B: Manual SQL**
Run the SQL from migration files in your database.

### 3. Add Routes (1 minute)

Add to `application/config/routes.php`:

```php
// Chat routes
$route['chat'] = 'chat/index';
$route['chat/listing'] = 'chat/listing';
$route['chat/conversation/(:num)'] = 'chat/conversation/$1';
$route['chat/send'] = 'chat/send';
$route['chat/getMessages'] = 'chat/getMessages';
$route['chat/api_send'] = 'api/chat/api_send';
$route['chat/api_getMessages'] = 'api/chat/api_getMessages';
$route['chat/api_getConversations'] = 'api/chat/api_getConversations';
$route['chat/api_getAllUsers'] = 'api/chat/api_getAllUsers';
$route['chat/api_getUnreadCount'] = 'api/chat/api_getUnreadCount';
```

### 4. Enable Chat (30 seconds)

Add to your settings/params table:
```sql
INSERT INTO params (title, value, status) VALUES ('chat_enabled', 'yes', 1);
```

### 5. Include Widget (30 seconds)

Add to your layout file (before `</body>`):

```php
<?php $this->load->view('chat/widget', ['chat_enabled' => 'yes']); ?>
```

## Test Installation

1. **Visit**: `http://your-domain.com/chat/listing`
2. **Check**: Widget appears in bottom-right corner
3. **Click**: Widget button to open
4. **Select**: A user from dropdown
5. **Send**: A test message

## Troubleshooting

### Widget Not Showing?
- Check `chat_enabled` parameter is "yes"
- Verify widget is included in layout
- Check browser console for errors

### Database Errors?
- Verify migrations ran successfully
- Check table structure matches migrations
- Ensure database user has permissions

### Messages Not Sending?
- Check routes are configured
- Verify session authentication works
- Check browser console for AJAX errors

## Next Steps

- 📖 Read [INSTALL.md](INSTALL.md) for detailed instructions
- 📚 Check [CONFIGURATION.md](docs/CONFIGURATION.md) for customization
- 🔌 Review [API.md](docs/API.md) for API usage
- 🎨 Customize colors and styling

## Need Help?

- Check [README.md](README.md) for overview
- Review [INSTALL.md](INSTALL.md) for detailed setup
- Open an issue on GitHub
- Check existing issues for solutions

---

**That's it!** Your chat module should now be working. Enjoy! 🎉

