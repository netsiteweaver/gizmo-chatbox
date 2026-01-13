# API Documentation - Gizmo Chat Module

This document describes the API endpoints provided by the Gizmo Chat Module.

## Base URL

All API endpoints are relative to your CodeIgniter base URL.

## Authentication

All endpoints require session-based authentication. The user must be logged in and have `$_SESSION['user_id']` set.

## Endpoints

### Page Routes

#### GET `/chat/listing`
Display the conversations listing page.

**Response:** HTML page with list of conversations

---

#### GET `/chat/conversation/{user_id}`
Display conversation page with a specific user.

**Parameters:**
- `user_id` (path, required) - ID of the user to chat with

**Response:** HTML page with conversation view

---

#### POST `/chat/send`
Send a message (used by conversation page).

**Request Body (form-data or JSON):**
```json
{
  "message": "Hello, how are you?",
  "receiver_user_id": 123
}
```

**Response:**
```json
{
  "result": true,
  "reason": "Message sent successfully"
}
```

**Error Response:**
```json
{
  "result": false,
  "reason": "Error message here"
}
```

---

#### GET `/chat/getMessages`
Get messages for a conversation (used by conversation page).

**Query Parameters:**
- `user_id` (required) - ID of the user to get messages with

**Response:**
```json
{
  "result": true,
  "messages": [
    {
      "id": 1,
      "user_id": 123,
      "receiver_user_id": 456,
      "message": "Hello!",
      "sender_name": "John Doe",
      "sender_email": "john@example.com",
      "created_on": "2026-01-13 10:30:00",
      "is_read": 1
    }
  ]
}
```

---

### Widget API Routes

These endpoints are used by the floating chat widget and return JSON.

#### POST `/chat/api_send`
Send a message via the widget API.

**Request Body (JSON):**
```json
{
  "message": "Hello!",
  "receiver_user_id": 123
}
```

**Response:**
```json
{
  "result": true
}
```

**Error Response:**
```json
{
  "result": false,
  "reason": "Error message"
}
```

---

#### GET `/chat/api_getMessages`
Get messages for the widget.

**Query Parameters:**
- `user_id` (required) - ID of the user to get messages with

**Response:**
```json
{
  "result": true,
  "messages": [
    {
      "id": 1,
      "user_id": 123,
      "receiver_user_id": 456,
      "message": "Hello!",
      "sender_name": "John Doe",
      "created_on": "2026-01-13 10:30:00",
      "is_read": 1
    }
  ],
  "unread_count": 5
}
```

---

#### GET `/chat/api_getConversations`
Get list of conversations for the widget.

**Response:**
```json
{
  "result": true,
  "conversations": [
    {
      "other_user_id": 123,
      "other_user_name": "John Doe",
      "other_user_email": "john@example.com",
      "last_message": "Hello!",
      "last_message_time": "2026-01-13 10:30:00",
      "unread_count": 3
    }
  ]
}
```

---

#### GET `/chat/api_getAllUsers`
Get all users for the user dropdown in the widget.

**Response:**
```json
{
  "result": true,
  "users": [
    {
      "id": 123,
      "name": "John Doe",
      "email": "john@example.com"
    }
  ]
}
```

---

#### GET `/chat/api_getUnreadCount`
Get unread message count and details.

**Response:**
```json
{
  "result": true,
  "count": 5,
  "unread_by_sender": [
    {
      "sender_id": 123,
      "sender_name": "John Doe",
      "unread_count": 3,
      "last_message": "Hello!"
    }
  ]
}
```

---

## Error Handling

All API endpoints return JSON responses with a `result` field indicating success (`true`) or failure (`false`).

On error, a `reason` field is included with the error message.

## Rate Limiting

Currently, there is no built-in rate limiting. It's recommended to implement rate limiting in your application for production use.

## CORS

If you need to access the API from a different domain, you'll need to configure CORS headers in your CodeIgniter application.

## Security Notes

- All endpoints require authentication
- User IDs are validated to prevent unauthorized access
- SQL injection protection is provided by CodeIgniter's Query Builder
- Input validation should be added based on your requirements

