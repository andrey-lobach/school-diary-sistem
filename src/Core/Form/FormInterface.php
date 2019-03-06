<?php
/**
 * Created by PhpStorm.
 * User: andrei
 * Date: 30.1.19
 * Time: 16.37
 */

namespace Core\Form;

use Core\Request\Request;

interface FormInterface
{
    /**
     * @param Request $request
     */
    public function handleRequest(Request $request);

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return array
     */
    public function getViolations(): array;

    /**
     * @return bool
     */
    public function isValid(): bool;
}