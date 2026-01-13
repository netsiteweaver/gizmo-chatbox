<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        // Check if chat is enabled
        $this->load->model("system_model");
        $chat_enabled = $this->system_model->getParam("chat_enabled");
        if($chat_enabled != "yes") {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(403)
                ->set_output(json_encode(array(
                    'result' => false,
                    'reason' => 'Chat feature is currently disabled'
                )));
            exit;
        }
        
        $this->load->model("chat_model");
        $this->load->model("token_model");
        $this->load->model("members_model");

        $allowed_origins = [
            "https://mauritiantreasures.com"
        ];
    
        if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
            header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
        }
    
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, Accept-Encoding");
    
        // Handle preflight (OPTIONS request)
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 200 OK");
            exit;
        }
    }

    public function send()
    {
        $tokenValid = $this->token_model->validateToken();
        
        if($tokenValid['valid'] === false) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'result' => false,
                    'reason' => 'Invalid or expired token'
                )));
            return;
        }

        $data = json_decode(file_get_contents('php://input'), TRUE);
        
        if(empty($data['message'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'result' => false,
                    'reason' => 'Message is required'
                )));
            return;
        }

        $member_id = $tokenValid['user_id']; // user_id from token validation is actually member_id
        
        $message_data = array(
            'message' => $data['message'],
            'member_id' => $member_id,
            'sender_type' => 'user'
        );
        
        $result = $this->chat_model->insert($message_data);
        
        if($result['result']) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'result' => true,
                    'message' => $result['data']
                )));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'result' => false,
                    'reason' => $result['reason']
                )));
        }
    }

    public function getMessages()
    {
        $tokenValid = $this->token_model->validateToken();
        
        if($tokenValid['valid'] === false) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'result' => false,
                    'reason' => 'Invalid or expired token'
                )));
            return;
        }

        $member_id = $tokenValid['user_id']; // user_id from token validation is actually member_id
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
        $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        
        $messages = $this->chat_model->getMessages($member_id, null, $limit, $offset);
        
        // Mark messages as read
        $this->chat_model->markAsRead($member_id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'result' => true,
                'messages' => $messages
            )));
    }

    public function getUnreadCount()
    {
        $tokenValid = $this->token_model->validateToken();
        
        if($tokenValid['valid'] === false) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array(
                    'result' => false,
                    'reason' => 'Invalid or expired token'
                )));
            return;
        }

        $member_id = $tokenValid['user_id']; // user_id from token validation is actually member_id
        $count = $this->chat_model->getUnreadCount($member_id);
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'result' => true,
                'count' => $count
            )));
    }
}

