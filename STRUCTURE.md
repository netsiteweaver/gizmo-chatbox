# Module Structure

This document describes the file structure of the Gizmo Chat Module.

```
gizmo-chat-module/
│
├── README.md                    # Main documentation
├── LICENSE                      # MIT License
├── INSTALL.md                   # Installation guide
├── CHANGELOG.md                 # Version history
├── STRUCTURE.md                 # This file
├── .gitignore                   # Git ignore rules
│
├── controllers/                 # CodeIgniter Controllers
│   ├── Chat.php                 # Main chat controller (listing, conversation pages)
│   └── api/
│       └── Chat.php             # API controller (widget endpoints)
│
├── models/                      # CodeIgniter Models
│   └── Chat_model.php           # Chat database model
│
├── views/                       # View Templates
│   └── chat/
│       ├── widget.php           # Floating chat widget (main UI)
│       ├── listing.php          # Conversations listing page
│       └── conversation.php     # Full conversation view page
│
├── migrations/                  # Database Migrations
│   ├── 20260113102400_ChatMessages.php              # Creates chat_messages table
│   └── 20260113110000_UpdateChatMessagesForUsers.php # Adds receiver_user_id column
│
└── docs/                        # Documentation
    ├── API.md                   # API endpoint documentation
    └── CONFIGURATION.md         # Configuration guide

```

## File Descriptions

### Controllers

- **Chat.php**: Handles page views (listing, conversation) and form submissions
- **api/Chat.php**: Provides JSON API endpoints for the widget (AJAX calls)

### Models

- **Chat_model.php**: Database operations for chat messages, conversations, and user queries

### Views

- **widget.php**: The floating chat widget with JavaScript functionality
- **listing.php**: Admin page showing all conversations
- **conversation.php**: Full-page conversation view

### Migrations

- **20260113102400_ChatMessages.php**: Creates the initial `chat_messages` table
- **20260113110000_UpdateChatMessagesForUsers.php**: Adds user-to-user messaging support

### Documentation

- **README.md**: Overview, features, quick start
- **INSTALL.md**: Detailed installation instructions
- **API.md**: Complete API documentation
- **CONFIGURATION.md**: Configuration options and customization
- **CHANGELOG.md**: Version history and changes

## Installation Location

After installation, files should be placed in your CodeIgniter application:

```
your-codeigniter-app/
├── application/
│   ├── controllers/
│   │   ├── Chat.php
│   │   └── api/
│   │       └── Chat.php
│   ├── models/
│   │   └── Chat_model.php
│   ├── views/
│   │   └── chat/
│   │       ├── widget.php
│   │       ├── listing.php
│   │       └── conversation.php
│   └── migrations/
│       ├── 20260113102400_ChatMessages.php
│       └── 20260113110000_UpdateChatMessagesForUsers.php
```

## Dependencies

The module requires these external components (not included):

- CodeIgniter 3.x framework
- jQuery library
- Font Awesome icons
- User authentication system (your application)
- Database (MySQL/MariaDB)


