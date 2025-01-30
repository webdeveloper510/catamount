<?php

namespace App\Imports;

use App\Models\UserImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $category;
    protected $userid;
    public $existingEmails = [];
    public $newEmails = [];

    public function __construct($category, $userid)
    {
        $this->category = $category;
        $this->userid = $userid;
        // Ensure $userid is treated as an array

    }

    public function model(array $row)
    {
        // Merge additional category data
        $row = array_merge($row, $this->category);

        // Check if the email already exists in the database
        if (UserImport::where(['email' => $row['email'], 'category' => $row['category']])->exists()) {
            $this->existingEmails[] = $row['email']; // Store existing emails
            return null;
        }

        $this->newEmails[] = $row['email']; // Store new emails

        return new UserImport([
            'name'         => $row['name'],
            'email'        => $row['email'],
            'phone'        => $row['phone'],
            'address'      => $row['address'],
            'organization' => $row['organization'],
            'category'     => $row['category'],
            'notes'        => $row['notes'],
            'created_by'   => $this->userid
        ]);
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string',
            'email'        => 'required|email|unique:import_users,email',
            'phone'        => 'nullable|numeric',
            'address'      => 'nullable|string',
            'organization' => 'nullable|string',
            'category'     => 'nullable|string',
            'notes'        => 'nullable|string',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required'       => 'The name field is required.',
            'email.required'      => 'The email field is required.',
            'email.required'         => 'The email must be a valid email address.',
            'phone.numeric'       => 'The phone number must be numeric.',
            'category.nullable'   => 'The category field is required.',
        ];
    }
}
