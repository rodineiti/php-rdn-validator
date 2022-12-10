<?php

namespace Unit;

use PHPUnit\Framework\TestCase;

use RdnValidator\Validator\Validator;

class ValidatorTest extends TestCase
{
    /**
     * @return void
     */
    public function testValidateFail(): void
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
            'cnpj' => ['required', 'cnpj'],
        ];

        $this->assertTrue(Validator::passes($form, $rules)->fails());
    }

    /**
     * @return void
     */
    public function testValidateRequiredWithErrors(): void
    {
        $form = ['username' => ''];

        $rules = [
            'username' => ['required'],
        ];

        $validator = Validator::passes($form, $rules);

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->getErrors());
    }

    /**
     * @return void
     */
    public function testValidateRequiredWithoutErrors(): void
    {
        $form = ['username' => 'test username'];

        $rules = [
            'username' => ['required'],
        ];

        $validator = Validator::passes($form, $rules);

        $this->assertFalse($validator->fails());
        $this->assertCount(0, $validator->getErrors());
    }

    /**
     * @return void
     */
    public function testValidateEmailWithErrors(): void
    {
        $form = ['email' => ''];

        $rules = [
            'email' => ['email'],
        ];

        $validator = Validator::passes($form, $rules);

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->getErrors());
    }

    /**
     * @return void
     */
    public function testValidateEmailWithoutErrors(): void
    {
        $form = ['email' => 'rodinei@teste.com'];

        $rules = [
            'email' => ['email'],
        ];

        $validator = Validator::passes($form, $rules);

        $this->assertFalse($validator->fails());
        $this->assertCount(0, $validator->getErrors());
    }

    /**
     * @return void
     */
    public function testValidateCpfWithErrors(): void
    {
        $form = ['cpf' => ''];

        $rules = [
            'cpf' => ['cpf'],
        ];

        $validator = Validator::passes($form, $rules);

        $this->assertTrue($validator->fails());

        $this->assertCount(1, $validator->getErrors());
    }

    /**
     * @return void
     */
    public function testValidateCpfWithoutErrors(): void
    {
        $form = ['cpf' => '12345678909'];

        $rules = [
            'cpf' => ['cpf'],
        ];

        $validator = Validator::passes($form, $rules);

        $this->assertFalse($validator->fails());
        $this->assertCount(0, $validator->getErrors());
    }

    /**
     * @return void
     */
    public function testValidateCnpjWithErrors(): void
    {
        $form = ['cnpj' => ''];

        $rules = [
            'cnpj' => ['cnpj'],
        ];

        $validator = Validator::passes($form, $rules);

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->getErrors());
    }

    /**
     * @return void
     */
    public function testValidateCnpjWithoutErrors(): void
    {
        $form = ['cnpj' => '90942778000102'];

        $rules = [
            'cnpj' => ['cnpj'],
        ];

        $validator = Validator::passes($form, $rules);

        $this->assertFalse($validator->fails());
        $this->assertCount(0, $validator->getErrors());
    }
}