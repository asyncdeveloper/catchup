<?php

	class Session{
		
		private $logged_in =false;
		public $user_id;
        public $username;
		public $message;
		
		function __construct(){
			session_start();
			$this->check_login();
			$this->check_message();
		}
		
		public function message($msg=""){
			if(!empty($msg)){
				$_SESSION['message'] =$msg;
			}
			else{
				return $this->message;
			}
		}
		
		private function check_message(){
			//Is there a message in a session?
			if(isset($_SESSION['message'])){
				$this->message = $_SESSION['message'];
				unset($_SESSION['message']);
			}else{
				$this->message = "";
			}					
		}
		
		public function is_logged_in(){
			return $this->logged_in;
		}
		
		private function check_login(){
            if (isset($_SESSION['user_id']) ||  isset($_COOKIE['user_id'])){
               $_SESSION['user_id'] = $_COOKIE['user_id'];
               $this->user_id = $_SESSION['user_id'];
               $this->username = $_COOKIE['username'];
               $this->logged_in =true;
            }else{
                unset($this->user_id);
                unset($this->username);
                $this->logged_in =false;
            }
		}

		public function login($user){
			if($user){
                $token = $this->generate_ID();
                $this->user_id = $_SESSION['user_id'] = $token ;
                $this->username = $_SESSION['username'] = $user->username ;
                setcookie('user_id', $this->user_id, time() + (60 * 60 * 24 * 30),true);    // expires in 30 days
                setcookie('username', $this->username , time() + (60 * 60 * 24 * 30),true);  // expires in 30 days
                $this->logged_in =true;
			}
		}

		public function generate_ID(){
		    global $user;
            $salt = 'CatchUpNg';
            $token_string =  $user->username. $user->password.$salt;
            $token = sha1($token_string);
            return $token;
        }

		public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['username']);
            unset($this->user_id);
            unset($this->username);
            $this->logged_in =false;

              if (isset($_SESSION['user_id'])) {
                // Delete the session vars by clearing the $_SESSION array
                $_SESSION = array();

                // Delete the session cookie by setting its expiration to an hour ago (3600)
                if (isset($_COOKIE[session_name()])) {
                    setcookie(session_name(), '', time() - 3600);
                }

                // Destroy the session
                session_destroy();
              }

              // Delete the user ID and username cookies by setting their expirations to an hour ago (3600)
              setcookie('user_id', '', time() - 3600);
              setcookie('username', '', time() - 3600);
		    }

	}

	$session = new Session();
	$message = $session->message();
	
?>