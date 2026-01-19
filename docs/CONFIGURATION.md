# Configuration Guide - Gizmo Chat Module

This guide explains all configuration options and customization possibilities for the Gizmo Chat Module.

## System Parameters

### chat_enabled

Controls whether the chat feature is enabled.

**Type:** String  
**Values:** `"yes"` or `"no"`  
**Default:** Not set (chat disabled)

**Setting:**
```sql
INSERT INTO params (title, value, status) VALUES ('chat_enabled', 'yes', 1);
```

Or via your settings interface if available.

---

## Database Configuration

### Table: `chat_messages`

The module uses a single table for all chat messages. The table structure is:

```sql
CREATE TABLE `chat_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uuid` varchar(70) NOT NULL,
  `user_id` int DEFAULT NULL COMMENT 'Admin/User ID from users table',
  `receiver_user_id` int DEFAULT NULL COMMENT 'Receiver user ID from users table',
  `member_id` int DEFAULT NULL COMMENT 'Member ID from members table',
  `message` text NOT NULL,
  `sender_type` enum('user','admin') NOT NULL DEFAULT 'user',
  `status` int NOT NULL DEFAULT '1' COMMENT '1-Active, 0-deleted',
  `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-unread, 1-read',
  `created_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_receiver_user_id` (`receiver_user_id`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_created_on` (`created_on`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## Widget Configuration

### Widget Position

To change the widget position, edit CSS in `application/modules/chat/views/chat/widget.php`:

```css
#chat-widget {
    position: fixed !important;
    bottom: 20px !important;  /* Change bottom position */
    right: 20px !important;   /* Change right position */
    /* Change to left: 20px; for left side */
}
```

### Widget Size

Modify widget dimensions:

```css
#chat-widget-container {
    width: 400px;   /* Change width */
    height: 600px;  /* Change height */
}
```

### Colors

Customize widget colors:

**Header Background:**
```css
#chat-widget-header {
    background-color: #007bff;  /* Change header color */
}
```

**Sent Messages:**
```css
.chat-widget-message.sent {
    background-color: #fff9c4;  /* Change sent message color */
    border: 1px solid #f0e68c;
}
```

**Received Messages:**
```css
.chat-widget-message.received {
    background-color: #d4edda;  /* Change received message color */
    border: 1px solid #c3e6cb;
}
```

**Button Color:**
```css
#chat-widget-button {
    background-color: #007bff;  /* Change button color */
}
```

### Animation Timing

Adjust animation duration:

```css
#chat-widget-container.restoring {
    animation: chatWidgetSlideIn 0.8s ease-out forwards;  /* Change duration */
}
```

### Logo

Change the logo image:

1. Replace `assets/images/Gizmo-150x48px.png` with your logo
2. Or update the path in `widget.php` line 315:
   ```php
   <img src="<?php echo base_url('assets/images/your-logo.png'); ?>" ...>
   ```

### Version Text

Customize the version text at the bottom:

Edit `application/modules/chat/views/chat/widget.php` line 352:
```php
<div style="text-align: center; font-size: 11px; color: #999; margin-top: 5px;">
    Your Custom Text Here
</div>
```

---

## Notification Configuration

### Sound Notification

Change the notification sound file:

1. Replace `assets/audio/notify-bell.wav` with your sound file
2. Or update the path in `widget.php` (search for `notify-bell.wav`)

### Browser Notifications

Browser notifications require user permission. The widget automatically requests permission when needed.

To customize notification settings, edit the `showNotification` function in `widget.php`.

---

## State Persistence

The widget uses `localStorage` to remember:
- Open/closed state
- Selected user ID

**Storage Key:** `chat-widget-state`

To clear state (for testing):
```javascript
localStorage.removeItem('chat-widget-state');
```

---

## Auto-refresh Settings

The widget automatically refreshes messages and checks for new messages.

**Refresh Intervals:**
- Messages refresh: Every 5 seconds (when widget is open)
- Unread count check: Every 3 seconds

To change intervals, edit `startAutoRefresh` function in `widget.php`:
```javascript
this.refreshInterval = setInterval(function() {
    // Refresh messages
}, 5000);  // Change interval (milliseconds)

this.notificationCheckInterval = setInterval(function() {
    // Check unread count
}, 3000);  // Change interval (milliseconds)
```

---

## Integration with Your Application

### Base Controller

The Chat controller extends `MY_Controller`. If your base controller is different:

1. Update `application/modules/chat/controllers/Chat.php`:
   ```php
   class Chat extends YourBaseController  // Change this
   ```

2. Ensure your base controller:
   - Handles authentication
   - Loads common models
   - Sets up session data
   - Extends `MX_Controller` (or a controller that does)

### User Model

The module expects a `Users_model` with:
- `getById($id)` method returning user object with `id`, `name`, `email`

If your user model is different, update:
- `application/modules/chat/controllers/Chat.php`
- `application/modules/chat/models/Chat_model.php`

### System Model

The module uses `system_model->getParam("chat_enabled")` to check if chat is enabled.

If you don't use a params system:
1. Remove the check from `Chat.php` constructor
2. Or implement the `getParam` method in your system model

---

## Security Configuration

### Access Control

Access control is implemented in `Chat_model.php`. Users can only see messages where they are the sender or receiver.

To modify access control, edit the `getMessages` method in `Chat_model.php`.

### CSRF Protection

CodeIgniter's CSRF protection is enabled by default. If you need to disable it for API endpoints, configure in `application/config/config.php`.

### Rate Limiting

Currently not implemented. Consider adding:
- Request throttling
- Message sending limits
- API rate limits

---

## Performance Optimization

### Database Indexes

The migrations create indexes on:
- `user_id`
- `receiver_user_id`
- `member_id`
- `created_on`
- `status`

Ensure indexes are created for optimal performance.

### Message Limits

Messages are loaded with a limit of 50 per request. To change:

Edit `Chat_model.php` `getMessages` method default parameter:
```php
public function getMessages($receiver_user_id = null, $sender_user_id = null, $limit = 50, $offset = 0)
```

### Caching

Consider implementing caching for:
- User lists
- Conversation lists
- Unread counts

---

## Mobile Configuration

The widget is responsive by default. Mobile styles are defined in:

```css
@media (max-width: 768px) {
    #chat-widget-container {
        width: calc(100vw - 40px);
        height: calc(100vh - 100px);
        right: 20px;
        left: 20px;
    }
}
```

Customize breakpoints and sizes as needed.

---

## Multi-language Support

To add multi-language support:

1. Create language files in `application/language/{language}/chat_lang.php`
2. Update view files to use `$this->lang->line('key')`
3. Load language in controller:
   ```php
   $this->lang->load('chat');
   ```

---

## Troubleshooting

### Widget Not Showing

- Check `chat_enabled` parameter is set to "yes"
- Verify widget is included in layout
- Check browser console for JavaScript errors
- Ensure jQuery is loaded

### Messages Not Appearing

- Verify database table exists
- Check user IDs are correct
- Review access control logic
- Check browser console for AJAX errors

### Performance Issues

- Check database indexes are created
- Review query performance
- Consider implementing caching
- Reduce auto-refresh intervals if needed


