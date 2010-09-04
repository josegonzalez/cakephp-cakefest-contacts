<?php
class UsersController extends AppController {
	var $name = 'Users';
	var $components = array('Mail');
	var $paginate = array('contain' => false);

	function login() {
		if (empty($this->data)) {
			return;
		}
		$user = Authsome::login($this->data['User']);
		if (!$user) {
			$this->Session->setFlash(__('Unknown user or Wrong Password', true), 'flash/error');
			return;
		}
		$remember = (!empty($this->data['User']['remember']));
		if ($remember) {
			Authsome::persist('2 weeks');
		}
		if ($user) {
			$this->Session->setFlash(__('You have been logged in', true), 'flash/success');
			if (!empty($user['User']['id'])) {
				$this->redirect('/users/edit/'.$user['User']['id']);
			} else {
				$this->redirect('/users/add');
			}
		}
	}

	function logout() {
		$this->Authsome->logout();
		$this->Session->delete('User');
		$this->redirect(array('action' => 'login'));
	}

	function forgot_password() {
		if (!empty($this->data) && isset($this->data['User']['email'])) {
			if ($this->data['User']['email'] == '') {
				$this->Session->setFlash(__('Invalid email address', true), 'flash/error');
				$this->redirect(array('action' => 'forgot_password'));
			}

			$user = $this->User->find('forgot_password', $this->data['User']['email']);
			if (!$user) {
				$this->Session->setFlash(__('No user found for this email address', true), 'flash/error');
				$this->redirect(array('action' => 'forgot_password'));
			}

			$activationKey = $this->User->changeActivationKey($user['User']['id']);

			try {
				if ($this->Mail->send(array(
					'to' => $user['User']['email'],
					'mailer' => 'swift',
					'subject' => '[' . Configure::read('Settings.SiteTitle') .'] ' . __('Reset Password', true),
					'variables' => compact('user', 'activationKey')))) {
						$this->Session->setFlash(__('An email has been sent with instructions for resetting your password', true), 'flash/success');
						$this->redirect(array('action' => 'login'));
				} else {
					$this->Session->setFlash(__('An error occurred', true), 'flash/error');
					$this->log("Error sending email");
				}
			} catch (Exception $e) {
				$this->Session->setFlash(__('An error occurred', true), 'flash/error');
				$this->log("Failed to send email: " . $e->getMessage());
			}
		}
	}

	function reset_password($username = null, $key = null) {
		if ($username == null || $key == null) {
			$this->Session->setFlash(__('An error occurred', true), 'flash/error');
			$this->redirect(array('action' => 'login'));
		}

		$user = $this->User->find('reset_password', array('username' => $username, 'key' => $key));
		if (!isset($user)) {
			$this->Session->setFlash(__('An error occurred', true), 'flash/error');
			$this->redirect(array('action' => 'login'));
		}

		if (!empty($this->data) && isset($this->data['User']['password'])) {
			if ($this->User->save($this->data, array('fields' => array('id', 'password', 'activation_key'), 'callback' => 'reset_password', 'user_id' => $user['User']['id']))) {
				$this->Session->setFlash(__('Your password has been reset successfully', true), 'flash/success');
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('An error occurred please try again', true), 'flash/error');
			}
		}

		$this->set(compact('user', 'username', 'key'));
	}

	function change_password() {
		if (!empty($this->data)) {
			if ($this->User->save($this->data, array('fieldList' => array('id', 'password'), 'callback' => 'change_password'))) {
				$this->Session->setFlash(__('Your password has been successfully changed', true), 'flash/success');
				$this->redirect(array('action' => 'dashboard'));
			} else {
				$this->Session->setFlash(__('Your password could not be changed', true), 'flash/error');
			}
		}
	}

	function profile() {
		$this->data = $this->User->find('profile');
	}

	function index() {
		$users = $this->paginate();
		$this->set(compact('users'));
	}

	function view($id = null) {
		$id = (!$id && !empty($this->params['named']['id'])) ? $this->params['named']['id'] : $id;
		$user = $this->User->find('view', $id);

		if (!$user) {
			$this->Session->setFlash(__('Invalid User', true), 'flash/error');
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('user'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data, array('callback' => 'add'))) {
				$this->Session->setFlash(__('The User has been saved', true), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved.', true), 'flash/error');
			}
		} else {
			$this->data['User']['id'] = $this->Authsome->get('id');
			$this->data['User']['email'] = $this->Authsome->get('email');
		}
		$this->render('edit');
	}

	function edit($id = null) {
		$id = $this->Authsome->get('id');
		if (!empty($this->data)) {
			// cleanup the crazy data structure which gets us the key/value pairs as both editable
			foreach ($this->data['MetaField'] as $i => $node) {
				if (!empty($node['field'])) {
					$this->data['User'][($node['field'])] = trim($node['value']);
				}
			}
			if ($this->User->save($this->data, array('callback' => 'edit'))) {
				$this->Session->setFlash(__('The User has been saved', true), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved.', true), 'flash/error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->find('edit', $id);
		}
		if (empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true), 'flash/error');
			$this->redirect(array('action' => 'index'));
		}
	}

	function delete($id = null) {
		if (!empty($this->data['User']['id'])) {
			if ($this->User->delete($this->data['User']['id'])) {
				$this->Session->setFlash(__('User deleted', true), 'flash/success');
				$this->redirect(array('action'=>'index'));
			}
			$this->Session->setFlash(__('User was not deleted', true), 'flash/error');
			$id = $this->data['User']['id'];
		}

		$this->data = $this->User->find('delete', $id);
		if (!$this->data) {
			$this->Session->setFlash(__('User unspecified', true), 'flash/error');
			$this->redirect(array('action' => 'index'));
		}
	}

}
?>