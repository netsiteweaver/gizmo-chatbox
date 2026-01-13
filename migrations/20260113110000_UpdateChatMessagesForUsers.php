<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_UpdateChatMessagesForUsers extends CI_Migration {

    public function up()
    { 
        // Add receiver_user_id column for user-to-user chat
        $this->db->query("ALTER TABLE `chat_messages` 
                          ADD COLUMN `receiver_user_id` int DEFAULT NULL COMMENT 'Receiver user ID from users table' AFTER `user_id`,
                          ADD KEY `idx_receiver_user_id` (`receiver_user_id`)");
        
        // Update existing records: if member_id exists, we can migrate or clear it
        // For now, we'll just add the new column
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `chat_messages` 
                          DROP COLUMN `receiver_user_id`,
                          DROP KEY `idx_receiver_user_id`");
    }

}

