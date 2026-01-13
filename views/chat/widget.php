<style>
#chat-widget {
    position: fixed !important;
    bottom: 20px !important;
    right: 20px !important;
    z-index: 9999 !important;
    font-family: Arial, sans-serif;
    display: block !important;
    visibility: visible !important;
}

#chat-widget-button {
    width: 60px !important;
    height: 60px !important;
    border-radius: 50% !important;
    background-color: #007bff !important;
    color: white !important;
    border: none !important;
    cursor: pointer !important;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1) !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 24px !important;
    transition: all 0.3s ease;
    visibility: visible !important;
    opacity: 1 !important;
}

#chat-widget-button:hover {
    background-color: #0056b3 !important;
    transform: scale(1.1);
}

#chat-widget-button .badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: #dc3545;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 12px;
    min-width: 20px;
    text-align: center;
}

#chat-widget-container {
    display: none;
    position: absolute;
    bottom: 70px;
    right: 0;
    width: 400px;
    height: 600px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    flex-direction: column;
}

#chat-widget-container.open {
    display: flex;
    animation: chatWidgetSlideIn 0.3s ease-out;
}

#chat-widget-container.restoring {
    display: flex;
    animation: chatWidgetSlideIn 0.8s ease-out forwards;
}

@keyframes chatWidgetSlideIn {
    from {
        opacity: 0;
        transform: translateY(20px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

#chat-widget-header {
    background-color: #007bff;
    color: white;
    padding: 15px;
    border-radius: 8px 8px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#chat-widget-header h4 {
    margin: 0;
    font-size: 16px;
}

#chat-widget-close {
    background: none;
    border: none;
    color: white;
    font-size: 20px;
    cursor: pointer;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

#chat-widget-messages {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    background-color: #f9f9f9;
    clear: both;
}

#chat-widget-messages::after {
    content: "";
    display: table;
    clear: both;
}

.chat-widget-message {
    margin-bottom: 15px;
    padding: 10px 12px;
    border-radius: 12px;
    max-width: 75%;
    word-wrap: break-word;
    font-size: 14px;
    position: relative;
    clear: both;
}

.chat-widget-message.sent {
    background-color: #fff9c4;
    color: #333;
    margin-left: auto;
    margin-right: 0;
    text-align: left;
    float: right;
    border-bottom-right-radius: 4px;
    border: 1px solid #f0e68c;
}

.chat-widget-message.sent::after {
    content: '';
    position: absolute;
    right: -8px;
    bottom: 10px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 8px 0 8px 8px;
    border-color: transparent transparent transparent #fff9c4;
}

.chat-widget-message.sent::before {
    content: '';
    position: absolute;
    right: -9px;
    bottom: 10px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 8px 0 8px 8px;
    border-color: transparent transparent transparent #f0e68c;
}

.chat-widget-message.received {
    background-color: #d4edda;
    color: #333;
    margin-right: auto;
    margin-left: 0;
    text-align: left;
    float: left;
    border-bottom-left-radius: 4px;
    border: 1px solid #c3e6cb;
}

.chat-widget-message.received::after {
    content: '';
    position: absolute;
    left: -8px;
    bottom: 10px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 8px 8px 8px 0;
    border-color: transparent #d4edda transparent transparent;
}

.chat-widget-message.received::before {
    content: '';
    position: absolute;
    left: -9px;
    bottom: 10px;
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 8px 8px 8px 0;
    border-color: transparent #c3e6cb transparent transparent;
}

.chat-widget-message-header {
    font-size: 11px;
    margin-bottom: 5px;
    opacity: 0.9;
}

.chat-widget-message.sent .chat-widget-message-header {
    color: #666;
}

.chat-widget-message.received .chat-widget-message-header {
    color: #666;
}

.chat-widget-message-body {
    line-height: 1.4;
}

.chat-widget-message.sent .chat-widget-message-body {
    color: #333;
}

.chat-widget-message.received .chat-widget-message-body {
    color: #333;
}

#chat-widget-input-area {
    padding: 15px;
    border-top: 1px solid #ddd;
    background-color: white;
    border-radius: 0 0 8px 8px;
}

#chat-widget-input-form {
    display: flex;
    gap: 10px;
}

#chat-widget-input {
    flex: 1;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

#chat-widget-send {
    padding: 8px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

#chat-widget-send:hover {
    background-color: #0056b3;
}

#chat-widget-loading {
    text-align: center;
    padding: 20px;
    color: #666;
}

.chat-widget-conversation-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.chat-widget-conversation-item {
    padding: 12px;
    border-bottom: 1px solid #eee;
    cursor: pointer;
    transition: background-color 0.2s;
}

.chat-widget-conversation-item:hover {
    background-color: #f5f5f5;
}

.chat-widget-conversation-item.active {
    background-color: #e3f2fd;
}

.chat-widget-member-select {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    background-color: #f9f9f9;
}

.chat-widget-member-select select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

@media (max-width: 768px) {
    #chat-widget-container {
        width: calc(100vw - 40px);
        height: calc(100vh - 100px);
        right: 20px;
        left: 20px;
    }
}
</style>

<?php 
// Double check if chat is enabled before displaying widget
if(!isset($chat_enabled) || $chat_enabled != "yes") {
    return; // Don't display widget if chat is disabled
}
?>
<div id="chat-widget" style="display: block !important; visibility: visible !important;">
    <input type="hidden" id="chat-widget-current-user-id" data-current-user-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
    <button id="chat-widget-button" type="button" title="Chat with Users" style="display: flex !important; visibility: visible !important;">
        <i class="fa fa-comments" style="font-size: 24px;"></i>
        <span style="display: none;" id="chat-widget-text-fallback">💬</span>
        <span id="chat-widget-badge" class="badge" style="display: none;">0</span>
    </button>
    <div id="chat-widget-container">
        <div id="chat-widget-header">
            <h4 style="display: flex; align-items: center; gap: 8px;">
                <img src="<?php echo base_url('assets/images/Gizmo-150x48px.png'); ?>" alt="Gizmo" style="height: 24px; width: auto; object-fit: contain;" onerror="this.style.display='none';">
                <span>Chat with Users</span>
            </h4>
            <button id="chat-widget-close" type="button">&times;</button>
        </div>
        <div id="chat-widget-user-select" class="chat-widget-member-select">
            <label for="chat-widget-user-select-dropdown" style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 12px;">Select User:</label>
            <select id="chat-widget-user-select-dropdown">
                <option value="">-- Choose a user to chat with --</option>
            </select>
        </div>
        <div id="chat-widget-messages">
            <div id="chat-widget-loading">Loading conversations...</div>
        </div>
        <div id="chat-widget-input-area">
            <form id="chat-widget-input-form">
                <input type="hidden" id="chat-widget-selected-user-id" value="">
                <input type="text" id="chat-widget-input" placeholder="Type your message..." required>
                <button type="submit" id="chat-widget-send">Send</button>
            </form>
            <div style="text-align: center; font-size: 11px; color: #999; margin-top: 5px;">Gizmo v1.0 by Netsiteweaver</div>
        </div>
    </div>
</div>

<script>
(function() {
    // Ensure base_url is available
    if (typeof base_url === 'undefined') {
        var base_url = window.location.origin + '/';
    }
    
    var chatWidget = {
        token: null,
        isOpen: false,
        refreshInterval: null,
        selectedUserId: null,
        isAdmin: true, // Always true for back office
        lastUnreadCount: 0,
        lastUnreadSenders: {},
        lastNotificationSender: null,
        notificationCheckInterval: null,
        
        init: function() {
            console.log('Chat widget initializing for admin user...');
            
            // Setup event listeners
            var button = document.getElementById('chat-widget-button');
            var closeBtn = document.getElementById('chat-widget-close');
            var form = document.getElementById('chat-widget-input-form');
            var userSelect = document.getElementById('chat-widget-user-select-dropdown');
            
            if(button) {
                button.addEventListener('click', this.toggle.bind(this));
            }
            if(closeBtn) {
                closeBtn.addEventListener('click', this.close.bind(this));
            }
            if(form) {
                form.addEventListener('submit', this.sendMessage.bind(this));
            }
            if(userSelect) {
                userSelect.addEventListener('change', this.onUserSelect.bind(this));
            }
            
            // Restore widget state from localStorage
            this.restoreState();
            
            // Load conversations and unread count
            // Note: If restoring with a selected user, restoreState handles loading messages directly
            this.loadConversations();
            this.checkUnreadCount();
            this.startAutoRefresh();
        },
        
        toggle: function() {
            if(this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        },
        
        open: function(userIdToSelect) {
            var container = document.getElementById('chat-widget-container');
            if(container) {
                container.classList.add('open');
                this.isOpen = true;
                
                // If a user ID is provided, set it before loading
                if(userIdToSelect) {
                    this.selectedUserId = userIdToSelect;
                    document.getElementById('chat-widget-selected-user-id').value = userIdToSelect;
                }
                
                this.loadConversations();
                
                // If a user ID is provided, select it after conversations and users load
                if(userIdToSelect) {
                    var self = this;
                    // Wait for both conversations and users to load
                    setTimeout(function() {
                        self.selectUser(userIdToSelect);
                    }, 800);
                }
                
                // Save state to localStorage
                this.saveState();
            }
        },
        
        close: function() {
            var container = document.getElementById('chat-widget-container');
            if(container) {
                container.classList.remove('open');
                this.isOpen = false;
                // Save state to localStorage
                this.saveState();
            }
        },
        
        saveState: function() {
            try {
                var state = {
                    isOpen: this.isOpen,
                    selectedUserId: this.selectedUserId
                };
                localStorage.setItem('chat-widget-state', JSON.stringify(state));
            } catch(e) {
                console.log('Could not save chat widget state:', e);
            }
        },
        
        restoreState: function() {
            try {
                var savedState = localStorage.getItem('chat-widget-state');
                if(savedState) {
                    var state = JSON.parse(savedState);
                    if(state.isOpen === true) {
                        // Restore the widget to open state with animation
                        var container = document.getElementById('chat-widget-container');
                        if(container) {
                            var self = this;
                            // Add restoring class first to trigger animation
                            container.classList.add('restoring');
                            // Force reflow to ensure animation triggers
                            container.offsetHeight;
                            // After animation, switch to open class
                            setTimeout(function() {
                                container.classList.remove('restoring');
                                container.classList.add('open');
                            }, 800); // Match animation duration
                            this.isOpen = true;
                            
                            // Restore selected user if available - do it immediately to skip conversation list
                            if(state.selectedUserId) {
                                this.selectedUserId = state.selectedUserId;
                                var hiddenInput = document.getElementById('chat-widget-selected-user-id');
                                if(hiddenInput) {
                                    hiddenInput.value = state.selectedUserId;
                                }
                                
                                // Select user immediately after a small delay to ensure DOM is ready
                                var self = this;
                                setTimeout(function() {
                                    // Load users and conversations first, then select user
                                    self.loadAllUsers();
                                    // Load messages directly instead of showing conversation list
                                    self.loadMessages(state.selectedUserId);
                                    
                                    // Also update dropdown after users load
                                    setTimeout(function() {
                                        var dropdown = document.getElementById('chat-widget-user-select-dropdown');
                                        if(dropdown) {
                                            dropdown.value = state.selectedUserId;
                                        }
                                    }, 500);
                                }, 100);
                            }
                        }
                    }
                }
            } catch(e) {
                console.log('Could not restore chat widget state:', e);
            }
        },
        
        loadConversations: function() {
            // Load all users first, then conversations
            this.loadAllUsers();
            
            var xhr = new XMLHttpRequest();
            xhr.open('GET', base_url + 'chat/api_getConversations');
            xhr.setRequestHeader('Content-Type', 'application/json');
            
            xhr.onload = function() {
                if(xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if(response.result && response.conversations) {
                        chatWidget.displayConversations(response.conversations);
                    } else {
                        chatWidget.showNoConversations();
                    }
                } else {
                    console.error('Failed to load conversations');
                    chatWidget.showNoConversations();
                }
            };
            
            xhr.onerror = function() {
                console.error('Network error loading conversations');
                chatWidget.showNoConversations();
            };
            
            xhr.send();
        },
        
        loadAllUsers: function() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', base_url + 'chat/api_getAllUsers');
            xhr.setRequestHeader('Content-Type', 'application/json');
            
            xhr.onload = function() {
                if(xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if(response.result && response.users) {
                        chatWidget.populateUserDropdown(response.users);
                    }
                }
            };
            
            xhr.onerror = function() {
                console.error('Failed to load users');
            };
            
            xhr.send();
        },
        
        populateUserDropdown: function(users) {
            var userSelect = document.getElementById('chat-widget-user-select-dropdown');
            if(!userSelect) return;
            
            // Store current selection
            var currentSelection = userSelect.value;
            
            // Clear existing options except the first one
            userSelect.innerHTML = '<option value="">-- Choose a user to chat with --</option>';
            
            // Add all users
            users.forEach(function(user) {
                var option = document.createElement('option');
                option.value = user.id;
                option.textContent = (user.name || 'User') + ' (' + (user.email || 'No email') + ')';
                userSelect.appendChild(option);
            });
            
            // Restore selection if it was set
            if(currentSelection) {
                userSelect.value = currentSelection;
            } else if(this.selectedUserId) {
                // If a user was selected, set it in dropdown
                userSelect.value = this.selectedUserId;
            }
        },
        
        displayConversations: function(conversations) {
            // If a user is already selected (e.g., when restoring state), skip displaying conversation list
            // The messages for that user are being loaded instead
            if(this.selectedUserId) {
                return;
            }
            
            var messagesContainer = document.getElementById('chat-widget-messages');
            
            messagesContainer.innerHTML = '';
            
            if(conversations.length === 0) {
                messagesContainer.innerHTML = '<div style="text-align: center; padding: 20px; color: #666;">' +
                    '<p>No conversations yet.</p>' +
                    '<p style="font-size: 12px; margin-top: 10px;">Select a user from the dropdown above to start chatting.</p>' +
                    '</div>';
                return;
            }
            
            // Show conversation list
            var list = document.createElement('ul');
            list.className = 'chat-widget-conversation-list';
            
            // Sort conversations: unread first, then by last message time
            conversations.sort(function(a, b) {
                if(a.unread_count > 0 && b.unread_count === 0) return -1;
                if(a.unread_count === 0 && b.unread_count > 0) return 1;
                return new Date(b.last_message_time) - new Date(a.last_message_time);
            });
            
            conversations.forEach(function(conv) {
                if(conv.other_user_id) {
                    var item = document.createElement('li');
                    item.className = 'chat-widget-conversation-item';
                    item.setAttribute('data-user-id', conv.other_user_id);
                    
                    // Highlight if has unread messages
                    if(conv.unread_count > 0) {
                        item.style.backgroundColor = '#fff3cd';
                        item.style.borderLeft = '3px solid #ffc107';
                    }
                    
                    if(chatWidget.selectedUserId == conv.other_user_id) {
                        item.classList.add('active');
                        item.style.backgroundColor = '#e3f2fd';
                    }
                    
                    var unreadBadge = conv.unread_count > 0 ? 
                        '<span style="background: #dc3545; color: white; padding: 2px 6px; border-radius: 10px; font-size: 11px; margin-left: 5px; font-weight: bold;">' + conv.unread_count + ' unread</span>' : '';
                    
                    item.innerHTML = '<strong>' + (conv.other_user_name || 'User #' + conv.other_user_id) + '</strong> ' + unreadBadge + '<br>' +
                                    '<small style="color: #666;">Last: ' + 
                                    (conv.last_message_time ? new Date(conv.last_message_time).toLocaleString() : 'Never') + '</small>';
                    item.onclick = function() {
                        chatWidget.selectUser(conv.other_user_id);
                    };
                    list.appendChild(item);
                }
            });
            
            messagesContainer.appendChild(list);
        },
        
        showNoConversations: function() {
            var messagesContainer = document.getElementById('chat-widget-messages');
            messagesContainer.innerHTML = '<div style="text-align: center; padding: 20px; color: #666;">' +
                '<p>No conversations yet.</p>' +
                '<p style="font-size: 12px; margin-top: 10px;">Select a user from the dropdown above to start chatting.</p>' +
                '</div>';
        },
        
        onUserSelect: function(e) {
            var userId = e.target.value;
            if(userId) {
                this.selectUser(userId);
            }
        },
        
        selectUser: function(userId) {
            this.selectedUserId = userId;
            var hiddenInput = document.getElementById('chat-widget-selected-user-id');
            if(hiddenInput) {
                hiddenInput.value = userId;
            }
            
            var dropdown = document.getElementById('chat-widget-user-select-dropdown');
            if(dropdown) {
                dropdown.value = userId;
                // Trigger change event to ensure UI updates
                var event = new Event('change', { bubbles: true });
                dropdown.dispatchEvent(event);
            }
            
            this.loadMessages(userId);
            
            // Update active state in conversation list
            var items = document.querySelectorAll('.chat-widget-conversation-item');
            items.forEach(function(item) {
                item.classList.remove('active');
                // Remove highlight
                item.style.backgroundColor = '';
                item.style.borderLeft = '';
            });
            
            // Highlight selected conversation
            items.forEach(function(item) {
                if(item.getAttribute('data-user-id') == userId) {
                    item.classList.add('active');
                    item.style.backgroundColor = '#e3f2fd';
                }
            });
            
            // Save state to localStorage
            this.saveState();
        },
        
        loadMessages: function(userId) {
            if(!userId) {
                userId = this.selectedUserId;
            }
            
            if(!userId) {
                return;
            }
            
            var xhr = new XMLHttpRequest();
            var url = base_url + 'chat/api_getMessages?user_id=' + encodeURIComponent(userId);
            xhr.open('GET', url);
            xhr.setRequestHeader('Content-Type', 'application/json');
            
            xhr.onload = function() {
                if(xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if(response.result) {
                        chatWidget.displayMessages(response.messages);
                        
                        // Update unread count after loading messages
                        if(response.unread_count !== undefined) {
                            chatWidget.lastUnreadCount = response.unread_count;
                        }
                    }
                }
            };
            
            xhr.onerror = function() {
                console.error('Failed to load messages');
            };
            
            xhr.send();
        },
        
        displayMessages: function(messages) {
            var messagesContainer = document.getElementById('chat-widget-messages');
            messagesContainer.innerHTML = '';
            
            if(messages.length === 0) {
                messagesContainer.innerHTML = '<div style="text-align: center; padding: 20px; color: #666;">' +
                    '<p>No messages yet.</p>' +
                    '<p style="font-size: 12px; margin-top: 10px;">Type a message below to start the conversation!</p>' +
                    '</div>';
                return;
            }
            
            // Get current user ID from hidden input
            var currentUserIdElement = document.getElementById('chat-widget-current-user-id');
            var currentUserId = currentUserIdElement ? currentUserIdElement.getAttribute('data-current-user-id') : null;
            
            messages.forEach(function(msg) {
                var messageDiv = document.createElement('div');
                // Determine if message is from current user (sent) or received
                // If msg.user_id matches current user ID, it's a sent message
                // Otherwise, it's a received message
                var isSent = false;
                if(currentUserId && msg.user_id) {
                    isSent = (parseInt(msg.user_id) === parseInt(currentUserId));
                }
                
                messageDiv.className = 'chat-widget-message ' + (isSent ? 'sent' : 'received');
                
                var header = document.createElement('div');
                header.className = 'chat-widget-message-header';
                var senderName = isSent ? (msg.sender_name || 'You') : (msg.sender_name || 'User');
                var timestamp = new Date(msg.created_on).toLocaleString();
                header.textContent = senderName + ' - ' + timestamp;
                
                var body = document.createElement('div');
                body.className = 'chat-widget-message-body';
                body.textContent = msg.message;
                
                messageDiv.appendChild(header);
                messageDiv.appendChild(body);
                messagesContainer.appendChild(messageDiv);
            });
            
            // Scroll to bottom
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        },
        
        sendMessage: function(e) {
            e.preventDefault();
            
            var userId = document.getElementById('chat-widget-selected-user-id').value;
            if(!userId) {
                alert('Please select a user first.');
                return;
            }
            
            var input = document.getElementById('chat-widget-input');
            var message = input.value.trim();
            
            if(!message) return;
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', base_url + 'chat/api_send');
            xhr.setRequestHeader('Content-Type', 'application/json');
            
            var payload = { 
                message: message,
                receiver_user_id: userId
            };
            
            xhr.onload = function() {
                if(xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if(response.result) {
                        input.value = '';
                        chatWidget.loadMessages(userId);
                    } else {
                        alert('Error: ' + (response.reason || 'Failed to send message'));
                    }
                } else {
                    alert('Failed to send message. Please try again.');
                }
            };
            
            xhr.onerror = function() {
                alert('Network error. Please check your connection.');
            };
            
            xhr.send(JSON.stringify(payload));
        },
        
        checkUnreadCount: function() {
            var xhr = new XMLHttpRequest();
            var url = base_url + 'chat/api_getUnreadCount';
            xhr.open('GET', url);
            xhr.setRequestHeader('Content-Type', 'application/json');
            
            var previousCount = this.lastUnreadCount || 0;
            var previousSenders = this.lastUnreadSenders || {};
            
            xhr.onload = function() {
                if(xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if(response.result) {
                        var currentCount = response.count || 0;
                        var badge = document.getElementById('chat-widget-badge');
                        
                        // Show badge if there are unread messages
                        if(currentCount > 0) {
                            badge.textContent = currentCount;
                            badge.style.display = 'block';
                            
                            // Check for new messages from specific senders
                            if(response.unread_by_sender && response.unread_by_sender.length > 0) {
                                response.unread_by_sender.forEach(function(sender) {
                                    var senderKey = 'sender_' + sender.sender_id;
                                    var previousSenderCount = previousSenders[senderKey] || 0;
                                    
                                    // If this sender has new messages, show notification
                                    if(sender.unread_count > previousSenderCount) {
                                        chatWidget.showNotification(sender.unread_count, sender);
                                    }
                                    
                                    previousSenders[senderKey] = sender.unread_count;
                                });
                            }
                            
                            // Show general notification if total count increased
                            if(currentCount > previousCount) {
                                // Get the most recent sender for notification
                                if(response.unread_by_sender && response.unread_by_sender.length > 0) {
                                    var latestSender = response.unread_by_sender[0];
                                    if(!chatWidget.lastNotificationSender || 
                                       latestSender.sender_id != chatWidget.lastNotificationSender.sender_id) {
                                        chatWidget.showNotification(currentCount, latestSender);
                                    }
                                } else {
                                    chatWidget.showNotification(currentCount);
                                }
                            }
                        } else {
                            badge.style.display = 'none';
                        }
                        
                        chatWidget.lastUnreadCount = currentCount;
                        chatWidget.lastUnreadSenders = previousSenders;
                    }
                }
            };
            
            xhr.onerror = function() {
                console.error('Failed to check unread count');
            };
            
            xhr.send();
        },
        
        showNotification: function(count, senderInfo) {
            var senderName = senderInfo ? (senderInfo.sender_name || 'Someone') : 'Someone';
            var senderId = senderInfo ? senderInfo.sender_id : null;
            var messagePreview = senderInfo && senderInfo.last_message ? 
                (senderInfo.last_message.length > 50 ? senderInfo.last_message.substring(0, 50) + '...' : senderInfo.last_message) : '';
            
            // Store sender info for notification click
            this.lastNotificationSender = senderInfo;
            
            // Request browser notification permission if not already granted
            if('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
            
            // Show browser notification if permission granted
            if('Notification' in window && Notification.permission === 'granted') {
                var notificationBody = senderInfo ? 
                    senderName + ': ' + messagePreview :
                    'You have ' + count + ' unread message' + (count > 1 ? 's' : '');
                
                var notification = new Notification('New Chat Message from ' + senderName, {
                    body: notificationBody,
                    icon: base_url + 'assets/favicon/favicon-32x32.png',
                    tag: 'chat-notification-' + (senderId || 'general'),
                    requireInteraction: false
                });
                
                // Close notification after 5 seconds
                setTimeout(function() {
                    notification.close();
                }, 5000);
                
                // Focus window and open chat with sender when notification is clicked
                notification.onclick = function() {
                    window.focus();
                    if(senderId) {
                        // Open widget and select user
                        chatWidget.open(senderId);
                    } else {
                        chatWidget.open();
                    }
                    notification.close();
                };
            }
            
            // Play sound notification
            this.playNotificationSound();
            
            // Show visual notification in widget
            this.showVisualNotification(count, senderInfo);
        },
        
        playNotificationSound: function() {
            // Try to play notification sound
            try {
                var audio = document.getElementById('notify-bell');
                if(audio) {
                    audio.play().catch(function(e) {
                        console.log('Could not play notification sound:', e);
                    });
                } else {
                    // Fallback: create audio element
                    var fallbackAudio = new Audio(base_url + 'assets/audio/notify-bell.wav');
                    fallbackAudio.play().catch(function(e) {
                        console.log('Could not play notification sound:', e);
                    });
                }
            } catch(e) {
                console.log('Notification sound error:', e);
            }
        },
        
        showVisualNotification: function(count, senderInfo) {
            // Remove existing notification if any
            var existingNotification = document.getElementById('chat-widget-toast');
            if(existingNotification) {
                existingNotification.remove();
            }
            
            var senderName = senderInfo ? (senderInfo.sender_name || 'Someone') : 'Someone';
            var senderId = senderInfo ? senderInfo.sender_id : null;
            var messagePreview = senderInfo && senderInfo.last_message ? 
                (senderInfo.last_message.length > 40 ? senderInfo.last_message.substring(0, 40) + '...' : senderInfo.last_message) : '';
            
            // Create toast notification
            var notificationDiv = document.createElement('div');
            notificationDiv.id = 'chat-widget-toast';
            notificationDiv.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #007bff; color: white; padding: 15px 20px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 10000; display: flex; align-items: center; gap: 10px; max-width: 350px; cursor: pointer;';
            notificationDiv.setAttribute('data-sender-id', senderId || '');
            
            var notificationContent = '<i class="fa fa-comments" style="font-size: 20px;"></i>' +
                                      '<div style="flex: 1;"><strong>New Message from ' + senderName + '!</strong><br>';
            
            if(messagePreview) {
                notificationContent += '<small style="opacity: 0.9;">' + messagePreview + '</small><br>';
            }
            
            notificationContent += '<small style="opacity: 0.8;">Click to open chat</small></div>' +
                                      '<button onclick="event.stopPropagation(); this.parentElement.remove();" style="background: none; border: none; color: white; font-size: 18px; cursor: pointer; margin-left: auto; padding: 0 5px;">&times;</button>';
            
            notificationDiv.innerHTML = notificationContent;
            document.body.appendChild(notificationDiv);
            
            // Auto-remove after 8 seconds
            setTimeout(function() {
                if(notificationDiv && notificationDiv.parentNode) {
                    notificationDiv.remove();
                }
            }, 8000);
            
            // Open chat with sender when clicked
            notificationDiv.onclick = function(e) {
                if(e.target.tagName !== 'BUTTON') {
                    if(senderId) {
                        // Open widget and select user
                        chatWidget.open(senderId);
                    } else {
                        chatWidget.open();
                    }
                    notificationDiv.remove();
                }
            };
        },
        
        startAutoRefresh: function() {
            var self = this;
            
            // Refresh messages if chat is open
            this.refreshInterval = setInterval(function() {
                if(self.isOpen && self.selectedUserId) {
                    self.loadMessages(self.selectedUserId);
                }
            }, 5000); // Refresh every 5 seconds
            
            // Check for new messages more frequently for notifications
            this.notificationCheckInterval = setInterval(function() {
                self.checkUnreadCount();
            }, 3000); // Check every 3 seconds for notifications
        },
        
        stopAutoRefresh: function() {
            if(this.refreshInterval) {
                clearInterval(this.refreshInterval);
            }
            if(this.notificationCheckInterval) {
                clearInterval(this.notificationCheckInterval);
            }
        }
    };
    
    // Initialize when DOM is ready
    function initChatWidget() {
        setTimeout(function() {
            var widget = document.getElementById('chat-widget');
            var button = document.getElementById('chat-widget-button');
            
            if(widget) {
                console.log('Chat widget found, initializing...');
                widget.style.display = 'block';
                widget.style.visibility = 'visible';
                
                if(button) {
                    button.style.display = 'flex';
                    button.style.visibility = 'visible';
                }
                
                chatWidget.init();
            } else {
                console.error('Chat widget element not found in DOM');
            }
        }, 100);
    }
    
    if(document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChatWidget);
    } else {
        initChatWidget();
    }
    
    // Also try jQuery ready if available
    if(typeof jQuery !== 'undefined') {
        jQuery(document).ready(function() {
            setTimeout(function() {
                if(!chatWidget.isOpen && document.getElementById('chat-widget')) {
                    chatWidget.init();
                }
            }, 200);
        });
    }
})();
</script>
