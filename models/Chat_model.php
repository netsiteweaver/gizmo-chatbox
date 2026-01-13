<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model{

    public function getMessages($receiver_user_id = null, $sender_user_id = null, $limit = 50, $offset = 0)
    {
        $current_user_id = $_SESSION['user_id'];
        
        $this->db->select("cm.*, 
                          sender.name as sender_name, 
                          sender.email as sender_email,
                          receiver.name as receiver_name, 
                          receiver.email as receiver_email");
        $this->db->from("chat_messages cm");
        $this->db->join("users sender", "cm.user_id = sender.id", "left");
        $this->db->join("users receiver", "cm.receiver_user_id = receiver.id", "left");
        $this->db->where("cm.status", 1);
        
        // Access control: Users can only see messages where they are sender or receiver
        if(isset($_SESSION['user_level']) && $_SESSION['user_level'] !== 'Root') {
            $this->db->group_start();
            $this->db->where("cm.user_id", $current_user_id); // Messages they sent
            $this->db->or_where("cm.receiver_user_id", $current_user_id); // Messages they received
            $this->db->group_end();
        }
        
        // Get conversation between two specific users
        if($receiver_user_id !== null && $sender_user_id !== null) {
            $this->db->group_start();
            $this->db->group_start();
            $this->db->where("cm.user_id", $sender_user_id);
            $this->db->where("cm.receiver_user_id", $receiver_user_id);
            $this->db->group_end();
            $this->db->or_group_start();
            $this->db->where("cm.user_id", $receiver_user_id);
            $this->db->where("cm.receiver_user_id", $sender_user_id);
            $this->db->group_end();
            $this->db->group_end();
        } elseif($receiver_user_id !== null) {
            // Get all messages with a specific user (current user chatting with receiver_user_id)
            $this->db->group_start();
            $this->db->group_start();
            $this->db->where("cm.user_id", $current_user_id);
            $this->db->where("cm.receiver_user_id", $receiver_user_id);
            $this->db->group_end();
            $this->db->or_group_start();
            $this->db->where("cm.user_id", $receiver_user_id);
            $this->db->where("cm.receiver_user_id", $current_user_id);
            $this->db->group_end();
            $this->db->group_end();
        }
        
        $this->db->order_by("cm.created_on", "ASC");
        $this->db->limit($limit, $offset);
        
        return $this->db->get()->result();
    }

    public function getUnreadCount($receiver_user_id = null)
    {
        $current_user_id = $_SESSION['user_id'];
        
        $this->db->select("COUNT(*) as count");
        $this->db->from("chat_messages");
        $this->db->where("status", 1);
        $this->db->where("is_read", 0);
        
        // Only count messages received by current user (not sent by them)
        $this->db->where("receiver_user_id", $current_user_id);
        
        // Access control: Non-root users only see their own unread messages
        if(isset($_SESSION['user_level']) && $_SESSION['user_level'] !== 'Root') {
            // Already filtered by receiver_user_id above
        }
        
        if($receiver_user_id !== null) {
            // Count unread from specific sender
            $this->db->where("user_id", $receiver_user_id);
        }
        
        $result = $this->db->get()->row();
        return $result ? (int)$result->count : 0;
    }

    public function getUnreadBySender()
    {
        $current_user_id = $_SESSION['user_id'];
        
        // Get unread messages grouped by sender with sender info
        $this->db->select("
            cm.user_id as sender_id,
            COUNT(*) as unread_count,
            MAX(cm.created_on) as last_message_time,
            MAX(cm.message) as last_message,
            u.name as sender_name,
            u.email as sender_email
        ");
        $this->db->from("chat_messages cm");
        $this->db->join("users u", "cm.user_id = u.id", "left");
        $this->db->where("cm.status", 1);
        $this->db->where("cm.is_read", 0);
        $this->db->where("cm.receiver_user_id", $current_user_id);
        
        $this->db->group_by("cm.user_id");
        $this->db->order_by("last_message_time", "DESC");
        
        return $this->db->get()->result();
    }

    public function insert($data)
    {
        if(!isset($data['message']) || empty($data['message'])){
            return array('result'=>false,'reason'=>'Message is required');
        }
        
        $data['uuid'] = gen_uuid();
        $data['created_on'] = date('Y-m-d H:i:s');
        $data['status'] = isset($data['status']) ? $data['status'] : 1;
        $data['is_read'] = isset($data['is_read']) ? $data['is_read'] : 0;
        
        $this->db->insert("chat_messages", $data);
        $data['id'] = $this->db->insert_id();
        
        return array('result'=>true,'data'=>$data);
    }

    public function markAsRead($sender_user_id = null)
    {
        $current_user_id = $_SESSION['user_id'];
        
        $this->db->where("status", 1);
        $this->db->where("is_read", 0);
        $this->db->where("receiver_user_id", $current_user_id); // Only mark messages received by current user
        
        // Access control: Non-root users can only mark their own received messages as read
        if(isset($_SESSION['user_level']) && $_SESSION['user_level'] !== 'Root') {
            // Already filtered by receiver_user_id above
        }
        
        if($sender_user_id !== null) {
            // Mark as read messages from specific sender
            $this->db->where("user_id", $sender_user_id);
        }
        
        return $this->db->update("chat_messages", array('is_read' => 1));
    }

    public function getById($id)
    {
        $this->db->where("id", $id);
        $this->db->where("status", 1);
        return $this->db->get("chat_messages")->row();
    }

    public function delete($id)
    {
        $this->db->where("id", $id);
        return $this->db->update("chat_messages", array('status' => 0));
    }

    public function getConversations($limit = 20)
    {
        if(empty($_SESSION['user_id'])) {
            return array();
        }
        
        $current_user_id = (int)$_SESSION['user_id'];
        
        // Use raw SQL to avoid CodeIgniter escaping issues with CASE in GROUP BY
        // Get unique conversations by using IF() function which is simpler for MySQL
        $sql = "
            SELECT 
                IF(cm.user_id = ?, cm.receiver_user_id, cm.user_id) as other_user_id,
                MAX(cm.created_on) as last_message_time,
                COUNT(CASE WHEN cm.is_read = 0 AND cm.receiver_user_id = ? THEN 1 END) as unread_count
            FROM chat_messages cm
            WHERE cm.status = 1 
                AND (cm.user_id = ? OR cm.receiver_user_id = ?)
            GROUP BY IF(cm.user_id = ?, cm.receiver_user_id, cm.user_id)
            ORDER BY MAX(cm.created_on) DESC
            LIMIT ?
        ";
        
        $query = $this->db->query($sql, array(
            $current_user_id,
            $current_user_id,
            $current_user_id,
            $current_user_id,
            $current_user_id,
            $limit
        ));
        
        // Check for database errors
        $error = $this->db->error();
        if($error['code'] != 0) {
            log_message('error', 'Database error in getConversations: ' . $error['message']);
            return array();
        }
        
        $conversations = $query->result();
        
        // Now get user details for each conversation
        foreach($conversations as $conv) {
            if($conv->other_user_id) {
                $user = $this->db->select('name, email')
                                ->from('users')
                                ->where('id', $conv->other_user_id)
                                ->get()
                                ->row();
                if($user) {
                    $conv->other_user_name = $user->name;
                    $conv->other_user_email = $user->email;
                }
            }
        }
        
        return $conversations;
    }
}

