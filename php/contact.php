<?php
	//区分部分和完整请求
	$isPartial = empty($_POST['partial']) ? false : true;
	$messages = array(
		'required' => 'The field %s is required',
		'invalid' => 'The field %s is invalid',
		'errors' => 'Please fix the errors in the form to continue',
		'generic' => 'An error has occurred and your message has not been delivered. Try later %s',
		'short' => 'The value of the field %s is too short. It must have at least %d characters',
		'incorrect' => 'The value of the field %s is incorrect. It must have %d characters',
		'success' => 'Thank you for your message %s. It has been successfully sent'
	);

	$result = array(
		'status' => '',
		'message' => '',
		'info' => []
	);

	//验证name
	if (!$isPartial && $_POST['name'] === '') {
		$result['info'][] = array(
			'field' => 'name',
			'message' => sprintf($messages['required'], 'Your name')
		);
	}
	else if ((!$isPartial || isset($_POST['name'])) && strlen($_POST['name']) <= 3) {
		$result['info'][] = array(
			 'field' => 'name',
			 'message' => sprintf($messages['short'], 'Your name', 4)
		);
	}

	//验证email
	if (!$isPartial && $_POST['email'] === '') {
		$result['info'][] = array(
			'field' => 'email',
			'message' => sprintf($messages['required'], 'Your Email')
		);
	}
	else if ((!$isPartial || isset($_POST['email'])) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$result['info'][] = array(
			 'field' => 'email',
			 'message' => sprintf($messages['invalid'], 'Your Email')
		);
	}

	//验证phone
	if (!$isPartial && $_POST['name'] === '') {
		$result['info'][] = array(
			'field' => 'phone',
			'message' => sprintf($messages['required'], 'Your telephone')
		);
	}
	else if ((!$isPartial || isset($_POST['phone'])) && strlen($_POST['phone']) !== 11) {
		$result['info'][] = array(
			 'field' => 'phone',
			 'message' => sprintf($messages['incorrect'], 'Your telephone', 11)
		);
	}

	//验证message
	if (!$isPartial && $_POST['message'] === '') {
		$result['info'][] = array(
			'field' => 'message',
			'message' => sprintf($messages['required'], 'Message')
		);
	}
	else if ((!$isPartial || isset($_POST['message'])) && strlen($_POST['message']) <= 3) {
		$result['info'][] = array(
			 'field' => 'message',
			 'message' => sprintf($messages['short'], 'Message', 4)
		);
	}

	if (!empty($result['info'])) {
		$result['status'] = 'error';
		$result['message'] = $messages['errors'];
	}
	else {
		if (true) {
			$result['status'] = 'success';
			if ($isPartial) {
				$result['message'] = '';
			}
			else {
				$result['message'] = sprintf($messages['success'], htmlentities($_POST['name']));
			}
		}
		else {
			$result['status'] = 'error';
			$result['message'] = sprintf($messages['generic'], htmlentities($_POST['name']));
		}
	}

	echo json_encode($result);