<style>
.chat-messages {
    height: 500px;
    overflow-y: auto;
    padding: 15px;
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 15px;
    clear: both;
}

.chat-messages::after {
    content: "";
    display: table;
    clear: both;
}

.chat-message {
    margin-bottom: 15px;
    padding: 10px 12px;
    border-radius: 12px;
    max-width: 75%;
    word-wrap: break-word;
    position: relative;
    clear: both;
}

.chat-message.sent {
    background-color: #fff9c4;
    color: #333;
    margin-left: auto;
    margin-right: 0;
    text-align: left;
    float: right;
    border-bottom-right-radius: 4px;
    border: 1px solid #f0e68c;
}

.chat-message.sent::after {
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

.chat-message.sent::before {
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

.chat-message.received {
    background-color: #d4edda;
    color: #333;
    margin-right: auto;
    margin-left: 0;
    text-align: left;
    float: left;
    border-bottom-left-radius: 4px;
    border: 1px solid #c3e6cb;
}

.chat-message.received::after {
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

.chat-message.received::before {
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

.chat-message-header {
    font-size: 12px;
    margin-bottom: 5px;
    opacity: 0.9;
}

.chat-message.sent .chat-message-header {
    color: #666;
}

.chat-message.received .chat-message-header {
    color: #666;
}

.chat-message-body {
    font-size: 14px;
    line-height: 1.4;
}

.chat-message.sent .chat-message-body {
    color: #333;
}

.chat-message.received .chat-message-body {
    color: #333;
}

.chat-input-area {
    padding: 15px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
}
</style>

<div class="row">
    <div class="col-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Gizmo - Chat with <?php echo htmlspecialchars($other_user->name ?? 'User'); ?>
                </h3>
                <div class="box-tools pull-right">
                    <a href="<?php echo base_url('chat/listing'); ?>" class="btn btn-default btn-sm">
                        <i class="fa fa-arrow-left"></i> Back to Conversations
                    </a>
                </div>
            </div>
            <div class="box-body">
                <div class="chat-messages" id="chat-messages">
                    <?php foreach($messages as $msg): ?>
                        <?php $isSent = ($msg->user_id == $_SESSION['user_id']); ?>
                        <div class="chat-message <?php echo $isSent ? 'sent' : 'received'; ?>">
                            <div class="chat-message-header">
                                <strong><?php 
                                    if($isSent) {
                                        echo htmlspecialchars($msg->sender_name ?? 'You');
                                    } else {
                                        echo htmlspecialchars($msg->sender_name ?? 'User');
                                    }
                                ?></strong>
                                <span> - <?php echo date('d M Y @ H:i', strtotime($msg->created_on)); ?></span>
                            </div>
                            <div class="chat-message-body">
                                <?php echo nl2br(htmlspecialchars($msg->message)); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="chat-input-area">
                    <form id="chat-form">
                        <input type="hidden" name="receiver_user_id" value="<?php echo $user_id; ?>">
                        <div class="input-group">
                            <input type="text" name="message" id="chat-message-input" class="form-control" placeholder="Type your message..." required>
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-paper-plane"></i> Send
                                </button>
                            </span>
                        </div>
                    </form>
                    <div style="text-align: center; font-size: 11px; color: #999; margin-top: 5px;">Gizmo v1.0 by Netsiteweaver</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Auto-scroll to bottom
    var chatMessages = $('#chat-messages');
    chatMessages.scrollTop(chatMessages[0].scrollHeight);
    
    // Handle form submission
    $('#chat-form').on('submit', function(e) {
        e.preventDefault();
        
        var message = $('#chat-message-input').val().trim();
        if(!message) return;
        
        var receiverUserId = $('input[name="receiver_user_id"]').val();
        
        $.ajax({
            url: base_url + 'chat/send',
            type: 'POST',
            data: {
                message: message,
                receiver_user_id: receiverUserId
            },
            dataType: 'json',
            success: function(response) {
                if(response.result) {
                    // Reload page to show new message
                    location.reload();
                } else {
                    alert('Error: ' + response.reason);
                }
            },
            error: function() {
                alert('An error occurred while sending the message.');
            }
        });
    });
    
    // Auto-refresh messages every 5 seconds
    setInterval(function() {
        var userId = $('input[name="receiver_user_id"]').val();
        $.ajax({
            url: base_url + 'chat/getMessages',
            type: 'GET',
            data: { user_id: userId },
            dataType: 'json',
            success: function(response) {
                if(response.result && response.messages) {
                    // Only reload if there are new messages
                    var currentCount = $('.chat-message').length;
                    if(response.messages.length > currentCount) {
                        location.reload();
                    }
                }
            }
        });
    }, 5000);
});
</script>

