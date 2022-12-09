<?php

require __DIR__ . '/vendor/autoload.php';

use RdnValidator\Validator\Validator;

if (isset($_POST['submit'])) {
	$rules = [
		'username' => ['required'],
		'email' => 'required|email',
        'cpf' => 'required|cpf',
        'cnpj' => ['required','cnpj'],
	];

    $messages = [
        'required' => 'This field is required',
        'email' => 'This email is invalid',
        'cpf' => 'This CPF is inválid',
        'cnpj' => 'This CNPJ is invalid'
    ];

	$validator = (new Validator($_POST, $rules, $messages))->passes();

	$errors = $validator->fails() ? $validator->getErrors() : [];
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PHP OOP Form Validation</title>
	<style type="text/css">
		body {
			background: #222222;
			font-family: verdana;
			color: #fff;
		}

		.container {
			background: #fff;
			padding: 20px 40px;
			max-width: 300px;
			margin: 0 auto;
		}

		h2 {
			color: #555;
		}

		label, input {
			display: block;
			margin: 18px 0;
		}

		label {
			color: #777;
		}

		input[type='text'], input[type='email'] {
			border: 1px solid #ddd;
			padding: 10px;
			border-radius: 10px;
			width: 100%;
		}
		input[type='submit'] {
			margin: 24px auto;
			font-size: 18px;
			background: coral;
			color: #fff;
			padding: 6px 16px;
			border: none;
			border-radius: 10px;
		}
		.error {
			color: red;
		}
	</style>
</head>
<body>
	<div class="container">
		<h2>Create user</h2>

		<form method="POST" action="<?=$_SERVER['PHP_SELF']?>">
			<label for="username">Username</label>
			<input type="text" name="username" value="<?=isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''?>" />

			<span class="error">
				<?=$errors['username'][0] ?? ''?>
			</span>

			<label for="name">Email</label>
			<input type="text" name="email" value="<?=isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''?>" />

			<span class="error">
				<?=$errors['email'][0] ?? ''?>
			</span>

            <label for="cpf">Cpf</label>
            <input type="text" name="cpf" value="<?=isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : ''?>" />

            <span class="error">
				<?=$errors['cpf'][0] ?? ''?>
			</span>

            <label for="cnpj">Cnpj</label>
            <input type="text" name="cnpj" value="<?=isset($_POST['cnpj']) ? htmlspecialchars($_POST['cnpj']) : ''?>" />

            <span class="error">
				<?=$errors['cnpj'][0] ?? ''?>
			</span>

			<input type="submit" name="submit" />
		</form>
	</div>
</body>
</html>