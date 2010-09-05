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
		$users = $this->User->find('all');
		$this->set(compact('users'));
	}

	function view($id = null) {
		$id = (!$id && !empty($this->params['named']['id'])) ? $this->params['named']['id'] : $id;
		$user = $this->User->find('first', array(
			'conditions' => array('User.id' => $id),
			'contain' => array('MetaField')
		));

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
		if (!empty($this->data) && $this->data['User']['password']==$this->data['User']['password_confirm']) {
			// cleanup the crazy data structure which gets us the key/value pairs as both editable
			foreach ($this->data['MetaField'] as $i => $node) {
				if (!empty($node['field'])) {
					$this->data['User'][($node['field'])] = trim($node['value']);
				}
			}
			unset($this->data['MetaField']);
			unset($this->data['User']['password_confirm']);
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
	}

}
?>