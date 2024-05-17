<?php

namespace App\Imports;

use App\Models\UserImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    protected $category;
    protected $userid;

    public function __construct($category, $userid)
    {
        $this->category = $category;
        $this->userid = $userid;
        // Ensure $userid is treated as an array
        
    }

    public function model(array $row)
    {
        $row = array_merge($row, $this->category);
       

        if (UserImport::where(['email' => $row['email'], 'category' => $row['category']])->exists()) {
            return null;
        }

        $data = [
            'name'         => $row['name'],
            'email'        => $row['email'],
            'phone'        => $row['phone'],
            'address'      => $row['address'],
            'organization' => $row['organization'],
            'category'     => $row['category'],
            'notes'     => $row['notes'],
            'created_by'   => $this->userid
        ];

        return new UserImport($data);
    }
}
