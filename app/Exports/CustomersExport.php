<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $data;
    public function __construct($data){
        $this->data = $data;
    }
    
    public function collection(){
        return $this->data;
    }

    public function headings(): array
    {
        return ['id','first_name','last_name','email','country_code','mobile_number','created_at'];
    }
}
