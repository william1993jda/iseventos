<?php

namespace App\Rules;

use App\Models\Employee;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueEmailEmployeeRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $id = is_numeric(end($uri)) ? end($uri) : null;

        $user = User::where('email', $value);

        if (!empty($id)) {
            $employee = Employee::find($id);

            $user = $user->where('id', '!=', $employee->user_id);
        }

        $user = $user->first();

        if (!empty($user)) {
            $fail('O e-mail informado já está em uso.');
        }
    }
}
