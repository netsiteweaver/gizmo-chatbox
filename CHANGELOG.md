# Changelog

All notable changes to the Gizmo Chat Module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Composer package metadata for HMVC module installs
- Documentation updates for Composer/HMVC installation paths

## [1.0.0] - 2026-01-13

### Added
- Initial release of Gizmo Chat Module
- Floating chat widget with modern UI
- Real-time messaging functionality
- Browser notifications for new messages
- Visual toast notifications
- State persistence (remembers open/closed state and selected conversations)
- Smooth slide-in animations
- Mobile responsive design
- Conversation listing page
- Full conversation view page
- User-to-user chat functionality
- Unread message count tracking
- Auto-refresh for messages and notifications
- Widget API endpoints
- Session-based authentication
- Access control for message visibility
- Version display in widget footer

### Features
- **Widget Interface:**
  - Floating button with badge for unread count
  - Expandable chat container
  - User selection dropdown
  - Conversation list view
  - Message thread view
  - Send message functionality
  - Auto-scroll to latest messages

- **Notifications:**
  - Browser notification API support
  - Sound notifications
  - Visual toast notifications
  - Unread count badges

- **State Management:**
  - localStorage for widget state
  - Remembers selected user
  - Remembers open/closed status
  - Smooth state restoration

- **Styling:**
  - Modern, clean design
  - Color-coded message bubbles (sent/received)
  - Responsive layout
  - Smooth animations
  - Customizable colors and styling

- **Database:**
  - `chat_messages` table with proper indexes
  - Support for user-to-user messaging
  - Message status tracking (read/unread)
  - Soft delete support (status field)

### Technical Details
- Built for CodeIgniter 3.x
- Requires PHP 7.4+
- Uses jQuery for widget functionality
- Session-based authentication
- MySQL/MariaDB database
- Font Awesome icons (for UI elements)

### Dependencies
- CodeIgniter 3.x
- jQuery
- Font Awesome (for icons)
- User authentication system
- Database with proper user tables


