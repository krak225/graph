<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{
    use HasFactory;
	
	protected $table = 'tdbdeclaration';
	protected $primaryKey = 'TDBDECLARATIONID';
	public $timestamps = false;
	
}
