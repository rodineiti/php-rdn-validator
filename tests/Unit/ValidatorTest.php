<?php

namespace Unit;

use PHPUnit\Framework\TestCase;

use Src\Validator\Validator;

class ValidatorTest extends TestCase
{
    /**
     * @var Validator
     */
    protected $validator;

    /**
     * @return void
     */
    public function testValidateFail()
    {
        $form = [
            'username' => '',
            'email' => '',
            'cpf' => '',
            'cnpj' => '',
        ];

        $rules = [
            'username' => ['required'],
            'email' => 'required|email',
            'cpf' => 'required|cpf',
            'cnpj' => ['required','cnpj'],
        ];

        $this->validator = new Validator($form, $rules);

        $hasError = $this->validator->passes()->fails();

        $this->assertTrue($hasError);
    }

    /**
     * @return void
     */
    public function testValidateRequiredWithErrors()
    {
        $form = ['username' => ''];

        $rules = [
            'username' => ['required'],
        ];

        $this->validator = new Validator($form, $rules);

        $hasError = $this->validator->passes()->fails();

        $errors = $this->validator->getErrors();

        $this->assertTrue($hasError);

        $this->assertCount(1, $errors);
    }

    /**
     * @return void
     */
    public function testValidateRequiredWithoutErrors()
    {
        $form = ['username' => 'test username'];

        $rules = [
            'username' => ['required'],
        ];

        $this->validator = new Validator($form, $rules);

        $hasError = $this->validator->passes()->fails();

        $errors = $this->validator->getErrors();

        $this->assertFalse($hasError);

        $this->assertCount(0, $errors);
    }

    /**
     * @return void
     */
    public function testValidateEmailWithErrors()
    {
        $form = ['email' => ''];

        $rules = [
            'email' => ['email'],
        ];

        $this->validator = new Validator($form, $rules);

        $hasError = $this->validator->passes()->fails();

        $errors = $this->validator->getErrors();

        $this->assertTrue($hasError);

        $this->assertCount(1, $errors);
    }

    /**
     * @return void
     */
    public function testValidateEmailWithoutErrors()
    {
        $form = ['email' => 'rodinei@teste.com'];

        $rules = [
            'email' => ['email'],
        ];

        $this->validator = new Validator($form, $rules);

        $hasError = $this->validator->passes()->fails();

        $errors = $this->validator->getErrors();

        $this->assertFalse($hasError);

        $this->assertCount(0, $errors);
    }

    /**
     * @return void
     */
    public function testValidateCpfWithErrors()
    {
        $form = ['cpf' => ''];

        $rules = [
            'cpf' => ['cpf'],
        ];

        $this->validator = new Validator($form, $rules);

        $hasError = $this->validator->passes()->fails();

        $errors = $this->validator->getErrors();

        $this->assertTrue($hasError);

        $this->assertCount(1, $errors);
    }

    /**
     * @return void
     */
    public function testValidateCpfWithoutErrors()
    {
        $form = ['cpf' => '12345678909'];

        $rules = [
            'cpf' => ['cpf'],
        ];

        $this->validator = new Validator($form, $rules);

        $hasError = $this->validator->passes()->fails();

        $errors = $this->validator->getErrors();

        $this->assertFalse($hasError);

        $this->assertCount(0, $errors);
    }

    /**
     * @return void
     */
    public function testValidateCnpjWithErrors()
    {
        $form = ['cnpj' => ''];

        $rules = [
            'cnpj' => ['cnpj'],
        ];

        $this->validator = new Validator($form, $rules);

        $hasError = $this->validator->passes()->fails();

        $errors = $this->validator->getErrors();

        $this->assertTrue($hasError);

        $this->assertCount(1, $errors);
    }

    /**
     * @return void
     */
    public function testValidateCnpjWithoutErrors()
    {
        $form = ['cnpj' => '90942778000102'];

        $rules = [
            'cnpj' => ['cnpj'],
        ];

        $this->validator = new Validator($form, $rules);

        $hasError = $this->validator->passes()->fails();

        $errors = $this->validator->getErrors();

        $this->assertFalse($hasError);

        $this->assertCount(0, $errors);
    }
}