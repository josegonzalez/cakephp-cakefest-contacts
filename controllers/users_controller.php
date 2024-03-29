<?php
class UsersController extends AppController {
	var $name = 'Users';
	var $components = array('Mail');
	var $paginate = array('contain' => false);
	var $allowedActions = array('login', 'logout', 'add');

	function afterFilter() {
		parent::afterFilter();
		$loginType = Authsome::get('loginType');
		if (!$loginType && !in_array($this->params['action'], $allowedActions)) {
			$this->Session->setFlash(__("I know you're drunk, but at least log in", true), 'flash/error');
			$this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
		}
		if ($loginType && !in_array($loginType, array('credentials', 'cookie', 'fake'))) {
			$this->Session->setFlash(__("You are logged in, but somehow you aren't cookied or credentialed properly.", true), 'flash/error');
			$this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
		}
	}

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
				$this->redirect(array('action' => 'edit', $user['User']['id']));
			} else {
				$this->redirect(array('action' => 'add'));
			}
		}
	}

	function logout() {
		$this->Authsome->logout();
		$this->Session->delete('User');
		$this->redirect(array('action' => 'login'));
	}

	function index() {
		$users = $this->User->find('all',array('contain' => array('MetaField')));
		$this->set(compact('users'));
	}

	function view($id = null) {
		$id = (!$id && !empty($this->params['named']['id'])) ? $this->params['named']['id'] : $id;
		$user = $this->_user = $this->User->find('first', array(
			'conditions' => array('User.id' => $id),
			'contain' => array('MetaField')
		));
		if (!$user) {
			$this->Session->setFlash(__('Invalid User', true), 'flash/error');
			$this->redirect(array('action' => 'index'));
		}
		$filename = $user['User']['name'];
		$this->set(compact('user','filename'));
	}
	
	function vcf($id = null) {
		$this->helpers[] = 'vcf';
		$this->view($id);
		$this->set('filename',$this->_user['User']['name']);
		$this->render('vcf','vcf');
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
		if (!empty($this->data) && $this->data['User']['password']==$this->data['User']['password_confirm']) {
			// cleanup the crazy data structure which gets us the key/value pairs as both editable
			foreach ($this->data['MetaField'] as $i => $node) {
				if (!empty($node['field']) && !empty($node['value'])) {
					$this->data['User'][($node['field'])] = trim($node['value']);
				}
			}

			unset($this->data['MetaField']);
			unset($this->data['User']['password_confirm']);
			if (!empty($this->data['User']['password'])) {
				$this->data['User']['password'] = Authsome::hash($this->data['User']['password']);
			}
			if (!Authsome::get('id') && isset($this->data['User']['id'])) unset($this->data['User']['id']);
			$this->data['User']['email'] = Authsome::get('email');
			if ($this->User->save($this->data, array('callback' => 'edit'))) {
				$user = $this->User->find('first', array(
					'conditions' => array('User.id' => $this->User->id),
					'contain' => array('MetaField')
				));
				$user['User']['loginType'] = 'credentials';
				$this->Session->write('User',$user);
				$this->Session->setFlash(__('The User has been saved', true), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved.', true), 'flash/error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->find('first', array(
				'conditions' => array('User.id' => $id),
				'contain' => array('MetaField')
			));
		}
		if (empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true), 'flash/error');
			//$this->redirect(array('action' => 'index'));
		}
		if ($this->Authsome->get('guest')) $this->render();
		if ($this->Authsome->get('loginType') == 'credentials' && !$this->RequestHandler->isAjax()) {
			$this->redirect(array('controller' => 'pages', 'action' => 'display', 'split'));
		}
		$this->render();
	}

}
?>