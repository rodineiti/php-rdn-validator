# Validator Library forms request

This library has the function of validate yours forms. Doing this in an uncomplicated way is essential for any system.

To install the library, run the following command:

```sh
composer require rodineiti/php-rdn-validator
```

To use the library, simply require the composer to autoload, invoke the class and call the method:

```php
<?php

require __DIR__ . '/vendor/autoload.php';

use RdnValidator\Validator\Validator;

if (isset($_POST['submit'])) {
	$rules = [
	    'username' => 'required',
	    'email' => 'required|email',
	    'cpf' => 'required|cpf',
	    'cnpj' => ['required','cnpj'],
	];
	$messages = [
	    'required' => 'This :field is required',
	    'email' => 'This email is invalid',
	    'cpf' => 'This CPF is inválid',
	    'cnpj' => 'This CNPJ is invalid'
	];

	$validator = Validator::passes($_POST, $rules, $messages);

	$errors = $validator->fails() ? $validator->getErrors() : [];
	
	var_dump($errors);
	var_dump($validator->getError('username')) // This username is required
}
```

### Validations present at the moment:

- [x] Required
- [x] Email
- [x] Cpf
- [x] Cnpj

### Developers

* [Rodinei Teixeira] - Developer

License
----

MIT

[//]:#

[Rodinei Teixeira]: <mailto:rodinei.developer@hotmail.com>
