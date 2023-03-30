<?php

namespace App\Rules;

use App\Models\Freelancer;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueEmailFreelancerRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        $id = is_numeric(end($uri)) ? end($uri) : null;

        $user = User::where('email', $value);

        if (!empty($id)) {
            $freelancer = Freelancer::find($id);

            $user = $user->where('id', '!=', $freelancer->user_id);
        }

        $user = $user->first();

        if (!empty($user)) {
            $fail('O e-mail informado já está em uso.');
        }
    }
}
