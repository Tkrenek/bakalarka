<?php
/**
 * Nazev souboru: Admin.php
 * Model pro Admina
 * @author Tomas Krenek(xkrene15)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'surname',
        'birth_date',
        'email',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password', 'rememberToken'
    ];
}
