<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Testing\Fluent\Concerns\Has;
use Laravel\Sanctum\HasApiTokens;


/**
 * Class Visiteur
 *
 * @property int $id_visiteur
 * @property int|null $id_laboratoire
 * @property int|null $id_secteur
 * @property string|null $nom_visiteur
 * @property string|null $prenom_visiteur
 * @property string|null $adresse_visiteur
 * @property string|null $cp_visiteur
 * @property string|null $ville_visiteur
 * @property Carbon|null $date_embauche
 * @property string|null $email
 * @property string|null $pwd_visiteur
 * @property string|null $type_visiteur
 * @property string|null $login_visiteur
 *
 * @property Laboratoire|null $laboratoire
 * @property Collection|Frais[] $frais
 *
 * @package App\Models
 */
class Visiteur extends Authenticatable
{
    use HasApiTokens;

    protected $table = 'visiteur';
    protected $primaryKey = 'id_visiteur';
    public $timestamps = false;

    protected $casts = [
        'id_laboratoire' => 'int',
        'id_secteur' => 'int',
        'date_embauche' => 'datetime'
    ];

    protected $fillable = [
        'id_laboratoire',
        'id_secteur',
        'nom_visiteur',
        'prenom_visiteur',
        'adresse_visiteur',
        'cp_visiteur',
        'ville_visiteur',
        'date_embauche',
        'email',
        'pwd_visiteur',
        'type_visiteur',
        'login_visiteur'
    ];

    protected $hidden = [
        'pwd_visiteur',
        'remember_token',
    ];

    public function laboratoire()
    {
        return $this->belongsTo(Laboratoire::class, 'id_laboratoire');
    }

    public function frais()
    {
        return $this->hasMany(Frais::class, 'id_visiteur');
    }

    public function getAuthPassword()
    {
        return $this->pwd_visiteur;
    }
}
