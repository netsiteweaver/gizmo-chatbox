<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MY_Controller
{
    public $data;

    public function __construct()
    {
        parent::__construct();
        
        // Check if chat is enabled
        $chat_enabled = $this->system_model->getParam("chat_enabled");
        if($chat_enabled != "yes") {
            show_error("Chat feature is currently disabled.", 403, "Chat Disabled");
            return;
        }
        
        $this->load->model("chat_model");
        $this->load->model("users_model");
    }

    public function index()
    {
        $this->data['page_title'] = "Chat Messages";
        $this->data['conversations'] = $this->chat_model->getConversations();
        $this->data['content'] = $this->load->view("chat/listing", $this->data, true);
        $this->load->view("layouts/default", $this->data);
    }

    public function listing()
    {
        $this->data['page_title'] = "Chat Messages";
        $this->data['conversations'] = $this->chat_model->getConversations();
        $this->data['content'] = $this->load->view("chat/listing", $this->data, true);
        $this->load->view("layouts/default", $this->data);
    }

    public function conversation($user_id = null)
    {
        if(empty($user_id)) {
            redirect("chat/listing");
        }
        
        $this->data['page_title'] = "Chat Conversation";
        $this->data['user_id'] = $user_id;
        $this->data['other_user'] = $this->users_model->getById($user_id);
        $this->data['messages'] = $this->chat_model->getMessages($user_id);
        
        // Mark messages as read
        $this->chat_model->markAsRead($user_id);
        
        $this->data['content'] = $this->load->view("chat/conversation", $this->data, true);
        $this->load->view("layouts/default", $this->data);
    }

    public function send()
    {
        $data = $this->input->post();
        
        if(empty($data['message']) || empty($data['receiver_user_id'])) {
            echo json_encode(array(
                'result' => false,
                'reason' => 'Message and receiver user ID are required'
            ));
            return;
        }
        
        $message_data = array(
            'message' => $data['message'],
            'receiver_user_id' => $data['receiver_user_id'],
            'user_id' => $_SESSION['user_id'],
            'sender_type' => 'admin'
        );
        
        $result = $this->chat_model->insert($message_data);
        
        if($result['result']) {
            echo json_encode(array(
                'result' => true,
                'message' => $result['data']
            ));
        } else {
            echo json_encode(array(
                'result' => false,
                'reason' => $result['reason']
            ));
        }
    }

    public function getMessages()
    {
        $user_id = $this->input->get('user_id');
        
        if(empty($user_id)) {
            echo json_encode(array(
                'result' => false,
                'reason' => 'User ID is required'
            ));
            return;
        }
        
        $messages = $this->chat_model->getMessages($user_id);
        
        echo json_encode(array(
            'result' => true,
            'messages' => $messages
        ));
    }

    public function getUnreadCount()
    {
        // Access control: Non-root users only see their own unread count
        $count = $this->chat_model->getUnreadCount();
        
        echo json_encode(array(
            'result' => true,
            'count' => $count
        ));
    }

    // API endpoints for admin users (using PHP session)
    public function api_send()
    {
        // Check if user is logged in via session
        if(empty($_SESSION['user_id'])) {
            echo json_encode(array(
                'result' => false,
                'reason' => 'Not authenticated'
            ));
            return;
        }

        $data = json_decode(file_get_contents('php://input'), TRUE);
        
        if(empty($data['message']) || empty($data['receiver_user_id'])) {
            echo json_encode(array(
                'result' => false,
                'reason' => 'Message and receiver user ID are required'
            ));
            return;
        }
        
        $message_data = array(
            'message' => $data['message'],
            'receiver_user_id' => $data['receiver_user_id'],
            'user_id' => $_SESSION['user_id'],
            'sender_type' => 'admin'
        );
        
        $result = $this->chat_model->insert($message_data);
        
        if($result['result']) {
            echo json_encode(array(
                'result' => true,
                'message' => $result['data']
            ));
        } else {
            echo json_encode(array(
                'result' => false,
                'reason' => $result['reason']
            ));
        }
    }

    public function api_getMessages()
    {
        // Check if user is logged in via session
        if(empty($_SESSION['user_id'])) {
            echo json_encode(array(
                'result' => false,
                'reason' => 'Not authenticated'
            ));
            return;
        }

        $user_id = $this->input->get('user_id');
        
        if(empty($user_id)) {
            echo json_encode(array(
                'result' => false,
                'reason' => 'User ID is required'
            ));
            return;
        }
        
        $messages = $this->chat_model->getMessages($user_id);
        
        // Mark messages as read when viewing
        $this->chat_model->markAsRead($user_id);
        
        // Get unread count for this conversation
        $unread_count = $this->chat_model->getUnreadCount($user_id);
        
        echo json_encode(array(
            'result' => true,
            'messages' => $messages,
            'unread_count' => $unread_count
        ));
    }

    public function api_getUnreadCount()
    {
        // Check if user is logged in via session
        if(empty($_SESSION['user_id'])) {
            echo json_encode(array(
                'result' => false,
                'reason' => 'Not authenticated'
            ));
            return;
        }

        $count = $this->chat_model->getUnreadCount();
        $unread_by_sender = $this->chat_model->getUnreadBySender();
        
        echo json_encode(array(
            'result' => true,
            'count' => $count,
            'unread_by_sender' => $unread_by_sender
        ));
    }

    public function api_getConversations()
    {
        // Check if user is logged in via session
        if(empty($_SESSION['user_id'])) {
            header('Content-Type: application/json');
            echo json_encode(array(
                'result' => false,
                'reason' => 'Not authenticated'
            ));
            return;
        }

        try {
            $conversations = $this->chat_model->getConversations(20);
            
            // Ensure conversations is an array
            if(!is_array($conversations)) {
                $conversations = array();
            }
            
            header('Content-Type: application/json');
            echo json_encode(array(
                'result' => true,
                'conversations' => $conversations
            ));
        } catch(Exception $e) {
            log_message('error', 'Error in api_getConversations: ' . $e->getMessage());
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode(array(
                'result' => false,
                'reason' => 'Internal server error',
                'error' => $e->getMessage()
            ));
        }
    }

    public function api_getAllUsers()
    {
        // Check if user is logged in via session
        if(empty($_SESSION['user_id'])) {
            echo json_encode(array(
                'result' => false,
                'reason' => 'Not authenticated'
            ));
            return;
        }

        // Get all users (excluding current user)
        $users = $this->users_model->get();
        $filtered_users = array();
        
        foreach($users as $user) {
            if($user->id != $_SESSION['user_id']) {
                $filtered_users[] = $user;
            }
        }
        
        echo json_encode(array(
            'result' => true,
            'users' => $filtered_users
        ));
    }
}

