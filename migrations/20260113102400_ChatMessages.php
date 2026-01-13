<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ChatMessages extends CI_Migration {

    public function up()
    { 
        $this->db->query("CREATE TABLE `chat_messages` (
                                        `id` int NOT NULL AUTO_INCREMENT,
                                        `uuid` varchar(70) NOT NULL,
                                        `user_id` int DEFAULT NULL COMMENT 'Admin/User ID from users table',
                                        `member_id` int DEFAULT NULL COMMENT 'Member ID from members table',
                                        `message` text NOT NULL,
                                        `sender_type` enum('user','admin') NOT NULL DEFAULT 'user' COMMENT 'user=from frontend user, admin=from admin panel',
                                        `status` int NOT NULL DEFAULT '1' COMMENT '1-Active, 0-deleted',
                                        `is_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-unread, 1-read',
                                        `created_on` datetime DEFAULT NULL,
                                        PRIMARY KEY (`id`),
                                        KEY `idx_user_id` (`user_id`),
                                        KEY `idx_member_id` (`member_id`),
                                        KEY `idx_created_on` (`created_on`),
                                        KEY `idx_status` (`status`)
                                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");        
    }

    public function down()
    {
        $this->db->query("DROP TABLE `chat_messages`");  
    }

}

