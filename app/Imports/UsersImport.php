<?php

namespace App\Imports;

use App\User;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
class UsersImport implements ToModel, WithValidation, SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    use Importable, SkipsFailures;

    public function __construct($college_id, $role_id)
    {
        $this->college_id = $college_id; 
        $this->role_id = $role_id; 
    }

    public function model(array $row)
    {

        return new User([
            //
            'name' => $row[0],
            'email' => $row[1],
            'username' => $row[2],
            'contact_number' => $row[3],
            'password' => \Hash::make($row[4]),
            'role_id' => $this->role_id,
            'college_id' => $this->college_id,
        ]);
    }

    public function rules(): array
    {
        return [
            '1' => ['required', 'unique:users,email'],
            '3' => ['required', 'unique:users,contact_number'],
        ];
    }
}
