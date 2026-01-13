<div class="row">
    <div class="col-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Chat Conversations</h3>
            </div>
            <div class="box-body">
                <?php if(empty($conversations)): ?>
                    <p class="text-muted">No conversations yet.</p>
                <?php else: ?>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Last Message</th>
                                <th>Unread</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($conversations as $conv): ?>
                                <tr>
                                    <td>
                                        <?php if(isset($conv->other_user_id) && $conv->other_user_id): ?>
                                            <strong><?php echo htmlspecialchars($conv->other_user_name); ?></strong><br>
                                            <small class="text-muted"><?php echo htmlspecialchars($conv->other_user_email); ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">Unknown User</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($conv->last_message_time): ?>
                                            <?php echo date('d M Y @ H:i', strtotime($conv->last_message_time)); ?>
                                        <?php else: ?>
                                            <span class="text-muted">No messages</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($conv->unread_count > 0): ?>
                                            <span class="badge bg-red"><?php echo $conv->unread_count; ?></span>
                                        <?php else: ?>
                                            <span class="text-muted">0</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if(isset($conv->other_user_id) && $conv->other_user_id): ?>
                                            <a href="<?php echo base_url('chat/conversation/'.$conv->other_user_id); ?>" class="btn btn-info btn-sm">
                                                <i class="fa fa-comments"></i> View Conversation
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

