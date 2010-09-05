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
			$this->redirect('/');
		}
	}

	function logout() {
		$this->Authsome->logout();
		$this->Session->delete('User');
		$this->redirect(array('action' => 'login'));
	}

	function profile() {
		$this->data = $this->User->find('first', array('conditions' => array('User.id' => Authsome::get('id'))));
	}

	function index() {
		$users = $this->paginate();
		$this->set(compact('users'));
	}

	function view($id = null) {
		$id = (!$id && !empty($this->params['named']['id'])) ? $this->params['named']['id'] : $id;
		$user = $this->User->find('first', array('conditions' => array('User.id' => $id)));

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
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid User', true), 'flash/error');
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->User->save($this->data, array('callback' => 'edit'))) {
				$this->Session->setFlash(__('The User has been saved', true), 'flash/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The User could not be saved.', true), 'flash/error');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->find('first', array('conditions' => array('User.id' => $id)));
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

		$this->data = $this->User->find('first', array('conditions' => array('User.id' => $id)));
		if (!$this->data) {
			$this->Session->setFlash(__('User unspecified', true), 'flash/error');
			$this->redirect(array('action' => 'index'));
		}
	}

}
?>