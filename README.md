# Gizmo Chat Module

A feature-rich, real-time chat module for CodeIgniter applications with a modern floating widget interface.

![Version](https://img.shields.io/badge/version-1.0-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple.svg)

## Features

- 🎨 **Modern Floating Widget** - Beautiful, responsive chat widget that works on desktop and mobile
- 💬 **Real-time Messaging** - Send and receive messages instantly
- 🔔 **Notifications** - Browser notifications and visual alerts for new messages
- 💾 **State Persistence** - Remembers open/closed state and selected conversations
- 🎭 **Smooth Animations** - Polished slide-in animations when opening
- 📱 **Mobile Responsive** - Works seamlessly on all screen sizes
- 🔒 **Secure** - Session-based authentication and access control
- ⚡ **Lightweight** - Minimal dependencies, works with standard CodeIgniter setup

## Requirements

- CodeIgniter 3.x
- PHP 7.4 or higher
- MySQL/MariaDB
- jQuery (included in most CodeIgniter admin templates)
- Font Awesome (for icons)

## Quick Start

### 1. Installation

Copy the module files to your CodeIgniter application:

```bash
# Copy controllers
cp -r gizmo-chat-module/controllers/* application/controllers/

# Copy models
cp -r gizmo-chat-module/models/* application/models/

# Copy views
cp -r gizmo-chat-module/views/* application/views/

# Copy migrations
cp -r gizmo-chat-module/migrations/* application/migrations/
```

### 2. Database Setup

Run the migrations to create the necessary database tables:

```bash
# Via CodeIgniter migration controller (if available)
# Visit: your-domain.com/migrate

# Or manually run the SQL files in the migrations directory
```

### 3. Configure Routes

Add the chat routes to `application/config/routes.php`:

```php
// Chat routes
$route['chat'] = 'chat/index';
$route['chat/listing'] = 'chat/listing';
$route['chat/conversation/(:num)'] = 'chat/conversation/$1';
$route['chat/send'] = 'chat/send';
$route['chat/getMessages'] = 'chat/getMessages';

// Chat API routes
$route['chat/api_send'] = 'api/chat/api_send';
$route['chat/api_getMessages'] = 'api/chat/api_getMessages';
$route['chat/api_getConversations'] = 'api/chat/api_getConversations';
$route['chat/api_getAllUsers'] = 'api/chat/api_getAllUsers';
$route['chat/api_getUnreadCount'] = 'api/chat/api_getUnreadCount';
```

### 4. Enable Chat Feature

The chat module requires a configuration parameter `chat_enabled` set to `"yes"` in your system parameters/settings table.

### 5. Include Widget

Include the chat widget in your layout file (typically in your main layout or footer):

```php
<?php 
// In your layout file (e.g., application/views/layouts/default.php)
$this->load->view('chat/widget', ['chat_enabled' => 'yes']);
?>
```

## Documentation

For detailed installation instructions, configuration options, and API documentation, see:

- [INSTALL.md](INSTALL.md) - Detailed installation guide
- [API.md](docs/API.md) - API endpoint documentation
- [CONFIGURATION.md](docs/CONFIGURATION.md) - Configuration options

## Dependencies

This module requires:

1. **User Authentication System** - Your application must have:
   - A `users` table with at least: `id`, `name`, `email`
   - Session-based authentication with `$_SESSION['user_id']`
   - A `Users_model` with a `getById($id)` method

2. **Base Controller** - Your controllers should extend a base controller (e.g., `MY_Controller`) that:
   - Handles authentication
   - Loads common models
   - Sets up session data

3. **Layout System** - Your application should have a layout/view system for rendering pages

## Customization

### Changing the Logo

The widget uses a Gizmo logo image. To change it:

1. Replace the logo at: `assets/images/Gizmo-150x48px.png`
2. Or update the path in `application/views/chat/widget.php` line 315

### Styling

All styles are included inline in the widget view file. You can customize:
- Colors (header background, message bubbles, etc.)
- Widget size and position
- Animation timing
- Font sizes and spacing

### Version Display

To change the version text, edit `application/views/chat/widget.php` line 352:

```php
<div style="text-align: center; font-size: 11px; color: #999; margin-top: 5px;">
    Your Custom Text Here
</div>
```

## Security Considerations

- The module uses session-based authentication
- Access control is implemented in the model layer
- SQL injection protection via CodeIgniter's Query Builder
- XSS protection via CodeIgniter's input/output filtering

## Browser Support

- Chrome/Edge (latest)
- Firefox (latest)
- Safari (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Credits

Developed by Netsiteweaver

## Support

For issues, questions, or contributions, please open an issue on the GitHub repository.

## Changelog

### Version 1.0 (2026-01-13)
- Initial release
- Floating chat widget
- Real-time messaging
- Browser notifications
- State persistence
- Smooth animations
- Mobile responsive design

